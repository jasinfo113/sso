<x-general-layout>
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid position-x-center">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="javascript:void(0)" class="mb-5 pt-lg-10">
                    <img src="https://pemadam.jakarta.go.id/central_assets/logo/logo-bundle.jpg" class="h-100px mb-5" alt="{{ config('app.name', 'Logo') }}" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form method="post" class="form w-100" novalidate="novalidate" id="form_data" action="#" onsubmit="return false">
                        @csrf
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Lupa Password?</h1>
                            <div class="text-gray-400 fw-bold fs-4">Masukan email anda untuk reset password.</div>
                        </div>
                        <div class="fv-row mb-4">
                            <label class="form-label fs-6 fw-bolder text-dark" id="email">Email</label>
                            <input class="form-control form-control-lg form-control-solid" type="email" name="email" id="email" autocomplete="off" placeholder="Email" required />
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
                            <div class="mt-5">
                                <a href="{{ route('login') }}" class="link-primary fs-6 fw-bolder">Kembali ke Login</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/scripts/general.js?v=' . time()) }}"></script>
    <script src="{{ asset('assets/scripts/auth/forgot.js?v=' . time()) }}"></script>
</x-general-layout>
