<x-general-layout>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid position-x-center">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="javascript:void(0)" class="mb-5 pt-lg-10">
                    <img src="https://pemadam.jakarta.go.id/central_assets/logo/logo-bundle.jpg" class="h-100px mb-5" alt="{{ config('app.name', 'Logo') }}" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    @if (isset($row->is_valid) and $row->is_valid)
                        <form method="post" class="form w-100" novalidate="novalidate" id="form_data" action="#"
                            onsubmit="return false">
                            @csrf
                            <input type="hidden" name="key" value="{{ $key }}">
                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Reset Password</h1>
                                <div class="text-gray-400 fw-bold fs-4">Masukan passwrod baru anda.</div>
                            </div>
                            <div class="mb-10 fv-row" data-kt-password-meter="true">
                                <div class="mb-1">
                                    <label class="form-label fw-bolder text-dark fs-6" id="password">Password</label>
                                    <div class="position-relative mb-3">
                                        <input class="form-control form-control-lg form-control-solid" type="password"
                                            name="password" id="password" placeholder="Password Baru"
                                            autocomplete="off" required />
                                        <span
                                            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3"
                                        data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                        </div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                </div>
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp;
                                    symbols.</div>
                            </div>
                            <div class="fv-row mb-4">
                                <label class="form-label fw-bolder text-dark fs-6" id="password_confirmation">Confirm
                                    Password</label>
                                <input class="form-control form-control-lg form-control-solid" type="password"
                                    name="password_confirmation" id="password_confirmation"
                                    placeholder="Konfirmasi Password Baru" autocomplete="off" required />
                            </div>
                            <div class="fv-row mb-10 field-captcha">
                                <label id="captcha" class="form-label fs-6 fw-bolder text-dark">Captcha</label>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary d-flex align-items-center" onclick="captchaRefresh(true)">
                                        <i class="fa fa-history"></i>
                                    </a>
                                    <div id="captcha_img">{!! captcha_img() !!}</div>
                                    <input class="form-control form-control-lg form-control-solid" type="text"
                                        name="captcha" id="captcha" autocomplete="off" placeholder="Captcha" required />
                                </div>
                                @error('captcha')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="button" id="btn_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">SUBMIT</span>
                                    <span class="indicator-progress">
                                        Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <div class="mt-5 d-none">
                                    Sudah melakukan reset password?<br />
                                    <a href="{{ route('login') }}" class="link-primary fs-6 fw-bolder">Klik untuk
                                        Login</a>
                                </div>
                            </div>
                        </form>
                    @elseif (isset($row->is_expired) and $row->is_expired)
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Link Kedaluwarsa</h1>
                            <div class="text-gray-400 fw-bold fs-4">Link reset passwrod telah kedaluwarsa.</div>
                        </div>
                    @else
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Request Tidak Valid</h1>
                            <div class="text-gray-400 fw-bold fs-4">Permintaan reset password tidak valid.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (isset($row->is_valid) and $row->is_valid)
        <script src="{{ asset('assets/scripts/general.js?v=' . time()) }}"></script>
        <script src="{{ asset('assets/scripts/auth/reset.js?v=' . time()) }}"></script>
    @endif
</x-general-layout>
