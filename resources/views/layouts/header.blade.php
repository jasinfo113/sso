<div id="kt_header" class="header align-items-stretch">
    <div class="container-xxl d-flex align-items-stretch justify-content-between mw-100">
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
            <a href="{{ route('dashboard') }}">
                <img src="{{ config('app.placeholder.logo_side_dark') }}" class="h-20px h-lg-30px"
                    alt="{{ config('app.name', 'Logo') }}" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <div class="d-flex align-items-stretch" id="kt_header_nav">
            </div>
            <div class="d-flex align-items-stretch flex-shrink-0">
                <div class="d-flex align-items-stretch flex-shrink-0">
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <img src="{{ Auth::user()->photo }}" alt="Profile Picture" />
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <img src="{{ Auth::user()->photo }}" alt="Profile Picture" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">{{ Auth::user()->nama }}
                                        </div>
                                        <a href="javascript:void(0)"
                                            class="fw-bold text-muted text-hover-primary fs-7">{{ Auth::user()->penugasan }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
                                <a href="{{ route('account.profile') }}" class="menu-link px-5"><i
                                        class="fa fa-user-alt me-2"></i>Profil Saya</a>
                            </div>
                            <div class="menu-item px-5">
                                <a href="{{ route('logout') }}" class="menu-link px-5 text-danger"><i
                                        class="fa fa-sign-out-alt me-2 text-danger"></i>Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
