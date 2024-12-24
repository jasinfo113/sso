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
            $where = "web = 1 AND is_deleted = 0";
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
                        'image' => (string)_diskPathUrl('central', $row->image, asset('assets/images/default.png')),
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
            if (!$request->id) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('response.no_process'),
                ]);
            }
            $row = _singleData("central", "sso_client", "id,`name`,url_auth", "id = '" . $request->integer('id') . "' AND web = 1 AND `status` = 1 AND is_deleted = 0");
            if (!$row) {
                return response()->json([
                    'status' => FALSE,
                    'message' => __('response.data_invalid'),
                ]);
            }

            $user = $request->user();
            $ip_address = $request->ip();
            $user_agent = $request->userAgent();
            $token = Str::random(64);

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
