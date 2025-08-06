<x-general-layout>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid position-x-center">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="javascript:void(0)" class="mb-5 pt-lg-10">
                    <img src="https://pemadam.jakarta.go.id/central_assets/logo/logo-bundle.jpg" class="h-100px mb-5" alt="{{ config('app.name', 'Logo') }}" />
                </a>
                <h1 class="text-center fw-bolder fs-2qx mb-7">Selamat Datang di<br/>Sitem Informasi DAMKAR</h1>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form method="post" class="form w-100" novalidate="novalidate" id="form_data" action="#"
                        onsubmit="return false">
                        @csrf
                        @isset($client_id)
                            <input type="hidden" name="client_id" value="{{ $client_id }}" />
                        @endisset
                        <div class="fv-row mb-4">
                            <label id="username" class="form-label fs-6 fw-bolder text-dark">Username</label>
                            <input class="form-control form-control-lg form-control-solid" type="text"
                                name="username" id="username" autocomplete="off" placeholder="Username" required />
                        </div>
                        <div class="fv-row mb-4">
                            <label id="password" class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                            <div class="position-relative mb-3 password-visibility">
                                <input class="form-control form-control-lg form-control-solid" type="password"
                                    name="password" id="password" autocomplete="off" placeholder="Password" required />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                </span>
                            </div>
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
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-10">
                            <div class="fv-row fv-plugins-icon-container">
                                <label class="form-check form-check-custom form-check-solid form-check-inline"
                                    for="remember">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        value="1" />
                                    <span class="form-check-label fw-bold text-gray-700 fs-6"> Remember me</span>
                                </label>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <div>
                                <a href="{{ route('auth.forgot') }}" class="link-primary fs-6 fw-bolder">Forgot Password
                                    ?</a>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" id="btn_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">LOGIN</span>
                                <span class="indicator-progress">
                                    Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/scripts/general.js?v=' . time()) }}"></script>
    <script src="{{ asset('assets/scripts/auth/login.js?v=' . time()) }}"></script>
</x-general-layout>
