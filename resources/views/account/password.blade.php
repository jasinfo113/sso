<div id="overlay"></div>
<form id="form_data" method="post" role="form" autocomplete="off" onsubmit="return false;">
    @csrf
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">{{ $title }}</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" onclick="closeModal()">
                    <i class="fa fa-times fs-3"></i>
                </button>
            </div>
            <div class="modal-body m-4">
                <div class="d-flex flex-column m-3">
                    <div class="fv-row mb-10">
                        <label class="form-label fw-bolder text-dark fs-6" id="password_current">Current
                            Password</label>
                        <input type="password" class="form-control form-control-lg form-control-solid"
                            name="password_current" id="password_current" placeholder="Password Saat Ini"
                            autocomplete="off" required />
                    </div>
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <div class="mb-1">
                            <label class="form-label fw-bolder text-dark fs-6" id="password">Password</label>
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid" type="password"
                                    name="password" id="password" placeholder="Password Baru" autocomplete="off"
                                    required />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                        <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.
                        </div>
                    </div>
                    <div class="fv-row mb-10">
                        <label class="form-label fw-bolder text-dark fs-6" id="password_confirmation">Confirm
                            Password</label>
                        <input class="form-control form-control-lg form-control-solid" type="password"
                            name="password_confirmation" id="password_confirmation"
                            placeholder="Konfirmasi Password Baru" autocomplete="off" required />
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-end gap-2">
                <button type="button" class="btn btn-light btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn btn-primary btn-submit">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...<span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        var _pass = KTPasswordMeter.getInstance(document.querySelector('[data-kt-password-meter="true"]'));
        var _passMin = 80;
        $("#form_data .btn-submit").click(function(e) {
            e.preventDefault();
            saveFormData("#form_data", "account/password-save", false, true, true);
        });
        $("#form_data input").keydown(function(e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode === 13) {
                e.preventDefault();
                if (_pass.getScore() >= _passMin) {
                    $("#form_data .btn-submit").trigger("click");
                }
            }
        });
    });
</script>
