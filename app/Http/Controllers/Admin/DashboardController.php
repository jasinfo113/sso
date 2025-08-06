<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    public function app_data(Request $request)
    {
        if ($request->ajax()) {
            $user = $request->user();
            $penugasan_ids[] = _singleData("central", "pegawai", "id_penugasan", "nip_nik = '" . $user->nip . "'")->id_penugasan ?? -1;
            $penugasans = _singleData("central", "pegawai_jabatan", "GROUP_CONCAT(DISTINCT id_penugasan ORDER BY id_penugasan ASC SEPARATOR ',') AS penugasan_ids", "nip_nik = '" . $user->nip . "' AND status_data = 'AKTIF' AND is_deleted = 0 AND (CURDATE() BETWEEN tanggal_mulai_menjabat AND IFNULL(tanggal_selesai_menjabat,CURDATE()))")->penugasan_ids ?? NULL;
            if ($penugasans) {
                $merge = array_merge($penugasan_ids, array_map("intval", explode(",", $penugasans)));
                $penugasan_ids = array_unique($merge);
            }
            $where = "web = 1 AND is_deleted = 0";
            $where .= " AND IF(penugasan_ids != -1, (CONCAT(',', penugasan_ids, ',') REGEXP ',(" . implode("|", $penugasan_ids) . "),'), penugasan_ids = -1)";
            $paginator = DB::connection("central")->table("sso_client")
                ->selectRaw("id,image,`name`,`status`")
                ->whereRaw($where)
                ->when($request->input('search'), function (Builder $query, string $search) {
                    if ($search) {
                        $query->whereAny([
                            'name',
                        ], 'LIKE', "%" . $search . "%");
                    }
                })
                ->orderBy('sort', 'asc')
                ->paginate($request->limit ?? 10);

            $items = [];
            foreach ($paginator->items() as $row) {
                $items[] =
                    [
                        'id' => (int)$row->id,
                        'image' => (string)_diskPathUrl('central', $row->image, config('app.placeholder.default')),
                        'name' => (string)_slash($row->name),
                        'status' => (bool)$row->status,
                    ];
            }
            $data['data'] = json_decode(json_encode($items));
            $data['info'] = json_decode(json_encode($paginator->toArray()['info']));
            $data['pagination'] = $paginator->links(null, ['funcJs' => 'showData']);
            return view('dashboard.list', $data);
        }
    }

    public function app_login(Request $request)
    {
        try {
            if (!$request->has('client_id') && !$request->has('id')) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('response.no_process'),
                ]);
            }
            $where = "web = 1 AND `status` = 1 AND is_deleted = 0";
            if ($request->has('client_id')) {
                $where .= " AND client_id = '" . $request->string('client_id') . "'";
            } else {
                $where .= " AND id = '" . $request->integer('id') . "'";
            }
            $row = _singleData("central", "sso_client", "id,`name`,url_auth", $where);
            if (!$row) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('response.data_invalid'),
                ]);
            }

            $user = $request->user();

            $exists = _singleData("default", "auth_codes", "id,token", "user_id = '" . $user->nip . "' AND client_id = '" . $row->id . "' AND revoked = 0 AND expires_at > NOW()");
            if ($exists) {
                return response()->json([
                    'status' => TRUE,
                    'message' => __('response.request_processed'),
                    'url' => $row->url_auth . "?auth_code=" . $exists->token,
                ]);
            }

            $token = Str::random(64);
            $ip_address = $request->ip();
            $user_agent = $request->userAgent();

            #==REVOKE==#
            _updateData("default", "auth_codes", ["revoked" => 1], "user_id = '" . $user->nip . "' AND client_id = '" . $row->id . "' AND revoked = 0 AND expires_at > NOW()");

            $data['user_id'] = $user->nip;
            $data['client_id'] = $row->id;
            $data['token'] = $token;
            $data['expires_at'] = now()->addMinute(5);
            _insertData("default", "auth_codes", $data);

            $d_login['user_id'] = $user->nip;
            $d_login['client_id'] = $row->id;
            $d_login['token'] = $token;
            $d_login['description'] = "User melakukan login ke " . $row->name . " via Web SSO";
            $d_login['ip_address'] = $ip_address;
            $d_login['user_agent'] = $user_agent;
            $d_login['created_from'] = "Web";
            _insertData("default", "user_activity", $d_login);

            return response()->json([
                'status' => TRUE,
                'message' => __('response.request_processed'),
                'url' => $row->url_auth . "?auth_code=" . $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => FALSE,
                'message' => $e->getMessage()
            ]);
        }
    }
}
