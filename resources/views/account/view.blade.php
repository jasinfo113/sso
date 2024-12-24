<x-app-layout>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <div class="me-7 mb-4">
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                        <img src="{{ Auth::user()->photo }}" alt="Profile Picture" />
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center mb-2">
                        <a href="javascript:void(0)"
                            class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">{{ Auth::user()->nama }}</a>
                    </div>
                    <div class="d-flex flex-column fw-bold fs-6 mb-4 pe-2">
                        <a href="javascript:void(0)"
                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="fa fa-briefcase me-2"></i>{{ Auth::user()->jabatan }}
                        </a>
                        <a href="javascript:void(0)"
                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="fa fa-user-alt me-2"></i>{{ Auth::user()->penugasan }}
                        </a>
                        <a href="javascript:void(0)"
                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="fa fa-building me-2"></i>{{ Auth::user()->penempatan }}
                        </a>
                        <a href="javascript:void(0)"
                            class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                            <i class="fa fa-envelope me-2"></i>{{ Auth::user()->email }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Info Profil</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Jenis Pegawai</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->jenis_pegawai }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Nama Lengkap</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->nama }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Jenis Kelamin</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->jenis_kelamin }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Tempat, Tanggal Lahir</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->tempat_lahir }}, {{ $row->tanggal_lahir }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Jenis Kelamin</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->jenis_kelamin }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Nomor Telepon</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->no_telepon }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Alamat KTP</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->alamat_ktp }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Alamat Domisili</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->alamat_domisili }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Agama</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->agama }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Pendidikan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->pendidikan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Jurusan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->jurusan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Tinggi Badan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->tinggi }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Berat Badan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->berat }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Golongan Darah</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->golongan_darah }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Ukuran Baju</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->ukuran_baju }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Ukuran Celana</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->ukuran_celana }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Ukuran Sepatu</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->ukuran_sepatu }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-header cursor-pointer">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Info Kepegawaian</h3>
            </div>
        </div>
        <div class="card-body p-9">
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Nomor KARPEG</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->no_karpeg }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Nomor NPWP</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->no_npwp }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Jabatan</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->jabatan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Kelas Jabatan</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->kelas_jabatan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Kategori Jabatan</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->kategori_jabatan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Pangkat</label>
                <div class="col-lg-8">
                    <span class="fw-bolder fs-6 text-gray-800">{{ $row->pangkat }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Golongan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->golongan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Penugasan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->penugasan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Penempatan</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->penempatan }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Unit Kerja</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->unit_kerja }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Sub Unit Kerja</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->sub_unit_kerja }}</span>
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Lokasi Kerja</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->lokasi }}</span>
                </div>
            </div>
            @if ($row->group)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">Group</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->group }}</span>
                    </div>
                </div>
            @endif
            @if ($row->eselon)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">Eselon</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->eselon }}</span>
                    </div>
                </div>
            @endif
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Akun JAKI</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->akun_jaki }}</span>
                </div>
            </div>
            @if ($row->no_sk_cpns)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">Nomor SK CPNS</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->no_sk_cpns }}</span>
                    </div>
                </div>
            @endif
            @if ($row->no_sk_pns)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">Nomor SK PNS</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->no_sk_pns }}</span>
                    </div>
                </div>
            @endif
            @if ($row->no_sk_terakhir)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">Nomor SK Terakhir</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->no_sk_terakhir }}</span>
                    </div>
                </div>
            @endif
            @if ($row->tmt_pangkat)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">TMT Pangkat</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->tmt_pangkat }}</span>
                    </div>
                </div>
            @endif
            @if ($row->tmt_jabatan)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">TMT Jabatan</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->tmt_jabatan }}</span>
                    </div>
                </div>
            @endif
            @if ($row->tmt_eselon)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">TMT Eselon</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->tmt_eselon }}</span>
                    </div>
                </div>
            @endif
            @if ($row->tmt_cpns)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">TMT CPNS</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->tmt_cpns }}</span>
                    </div>
                </div>
            @endif
            @if ($row->tmt_pns)
                <div class="row mb-7">
                    <label class="col-lg-4 fw-bold text-muted">TMT PNS</label>
                    <div class="col-lg-8 fv-row">
                        <span class="fw-bold text-gray-800 fs-6">{{ $row->tmt_pns }}</span>
                    </div>
                </div>
            @endif
            <div class="row mb-7">
                <label class="col-lg-4 fw-bold text-muted">Masa Kerja</label>
                <div class="col-lg-8 fv-row">
                    <span class="fw-bold text-gray-800 fs-6">{{ $row->masa_kerja }}</span>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
