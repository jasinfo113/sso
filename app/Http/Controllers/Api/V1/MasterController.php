<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\ApiResponse;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends ApiResponse
{

    public function provinsi(Request $request)
    {
        $data = DB::connection("central")->table("m_area_provinsi")->selectRaw("id_provinsi AS id, nama_provinsi AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_provinsi',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function kota(Request $request)
    {
        $data = DB::connection("central")->table("m_area_kota")->selectRaw("id_kota AS id, nama_kota AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_kota',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->when($request->string('id_provinsi'), function (Builder $query, string $value) {
                if ($value) {
                    $query->where('id_provinsi', $value);
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function kecamatan(Request $request)
    {
        if (!$request->has('id_kota')) {
            return $this->sendError("Silahkan masukan ID Kota!");
        }
        $data = DB::connection("central")->table("m_area_kecamatan")->selectRaw("id_kecamatan AS id, nama_kecamatan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_kecamatan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->when($request->string('id_kota'), function (Builder $query, string $value) {
                if ($value) {
                    $query->where('id_kota', $value);
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function kelurahan(Request $request)
    {
        if (!$request->has('id_kecamatan')) {
            return $this->sendError("Silahkan masukan ID Kecamatan!");
        }
        $data = DB::connection("central")->table("m_area_kelurahan")->selectRaw("id_kelurahan AS id, nama_kelurahan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_kelurahan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->when($request->string('id_kecamatan'), function (Builder $query, string $value) {
                if ($value) {
                    $query->where('id_kecamatan', $value);
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function wilayah(Request $request)
    {
        $data = DB::connection("central")->table("m_area_wilayah")->selectRaw("id_wilayah AS id, nama_wilayah AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_wilayah',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function sektor(Request $request)
    {
        $data = DB::connection("central")->table("m_area_sektor")->selectRaw("id_sektor AS id, nama_sektor AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_sektor',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function pos(Request $request)
    {
        $data = DB::connection("central")->table("m_area_pos")->selectRaw("id_pos AS id, nama_pos AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_pos',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function lokasi(Request $request)
    {
        $data = DB::connection("central")->table("m_pegawai_lokasi")->selectRaw("id_lokasi AS id, nama_lokasi AS `name`,id_wilayah,id_sektor,id_pos,id_kelurahan,latitude,longitude")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_lokasi',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function jabatan(Request $request)
    {
        $data = DB::connection("central")->table("m_pegawai_jabatan")->selectRaw("id_jabatan AS id, nama_jabatan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_jabatan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function penugasan(Request $request)
    {
        $data = DB::connection("central")->table("m_pegawai_penugasan")->selectRaw("id_penugasan AS id, nama_penugasan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'nama_penugasan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function unit(Request $request)
    {
        $data = DB::connection("cc")->table("tbl_ref_kendaraan AS a")
            ->join("tbl_jenis_kendaraan AS b", "a.jenis_kendaraan", "b.kode_jenis_kendaraan")
            ->join("tbl_master_kategori AS c", "b.kode_kategori", "c.id")
            ->selectRaw("a.id,b.jenis_kendaraan AS jenis,c.kategori_name AS kategori,a.no_polisi,a.id_radio,a.keterangan,a.`status`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'a.no_polisi',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('no_polisi', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function unit_detail(Request $request, string $no_polisi)
    {
        $data = DB::connection("cc")->table("tbl_ref_kendaraan_detail AS a")
            ->join("tbl_jenis_perlengkapan AS b", "a.jenis_perlengkapan", "b.kode_jenis_perlengkapan")
            ->join("tbl_master_kategori AS c", "b.kode_kategori", "c.id")
            ->selectRaw("a.id,b.jenis_perlengkapan AS jenis,c.kategori_name AS kategori,a.kondisi,a.keterangan")
            ->whereRaw("a.no_polisi = '" . $no_polisi . "'")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'b.jenis_perlengkapan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('jenis', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function unit_kategori(Request $request)
    {
        $data = DB::connection("cc")->table("tbl_master_kategori")
            ->selectRaw("id,kategori_name AS `name`")
            ->whereRaw("used_for = 1")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'kategori_name',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function unit_jenis(Request $request)
    {
        $data = DB::connection("cc")->table("tbl_jenis_kendaraan")
            ->selectRaw("kode_jenis_kendaraan AS id,jenis_kendaraan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'jenis_kendaraan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function pdo_kategori(Request $request)
    {
        $data = DB::connection("cc")->table("tbl_master_kategori")
            ->selectRaw("id,kategori_name AS `name`")
            ->whereRaw("used_for = 2")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'kategori_name',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }

    public function pdo_jenis(Request $request)
    {
        $data = DB::connection("cc")->table("tbl_jenis_perlengkapan")
            ->selectRaw("kode_jenis_perlengkapan AS id,jenis_perlengkapan AS `name`")
            ->when($request->string('search'), function (Builder $query, string $value) {
                if ($value) {
                    $query->whereAny([
                        'jenis_perlengkapan',
                    ], 'LIKE', "%" . $value . "%");
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($request->limit ?? 10);
        return $this->sendResponse($data);
    }
}
