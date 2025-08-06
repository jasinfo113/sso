<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Classes\ApiResponse;
use Illuminate\Validation\Rule;

class UnitController extends ApiResponse
{

    public function status(Request $request)
    {
        try {
            $user = $request->user();
            $request->validate(
                [
                    'no_polisi' => 'required|string',
                    'status' => 'required|' . Rule::in([0, 1]),
                    'keterangan' => 'nullable|string',
                ]
            );
            $where = "REPLACE(TRIM(no_polisi), ' ', '') = REPLACE(TRIM('" . $request->string('no_polisi') . "'), ' ', '')";
            $unit = _singleData("cc", "tbl_ref_kendaraan", "id,no_polisi,`status`", $where);
            if (!$unit) {
                return $this->sendError(__("Data unit tidak ditemukan!"));
            }
            $data['status'] = $request->integer('status');
            _updateData("cc", "tbl_ref_kendaraan", $data, "id = '" . $unit->id . "'");

            #==HISTORY==#
            $d_history['id_kendaraan'] = $unit->id;
            $d_history['no_polisi'] = $unit->no_polisi;
            $d_history['keterangan'] = $request->string('keterangan');
            $d_history['status'] = $request->integer('status');
            $d_history['created_at'] = now();
            $d_history['created_from'] = "E-SAROP";
            $d_history['created_by'] = $user->data->nrk;
            _insertData("cc", "tbl_ref_kendaraan_history", $d_history);

            return $this->sendResponse(NULL, __('response.data_updated'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->sendError($e->getMessage(), $e->errors());
        } catch (\Exception $e) {
            if (!app()->isProduction()) {
                return $this->sendError($e->getMessage());
            }
            return $this->sendError(__('response.failed_request'));
        }
    }
}
