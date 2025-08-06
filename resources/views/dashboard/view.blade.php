<x-app-layout>
    <form id="form_query" method="post" autocomplete="off" onsubmit="return false">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="text-muted" id="filter_search">&nbsp;</label>
                            <div class="d-flex align-items-center position-relative">
                                <input type="text" class="form-control form-control-solid pe-14" name="search"
                                    id="filter_search" placeholder="Cari . . ." />
                                <a href="javascript:void(0)" class="svg-icon svg-icon-1 position-absolute end-0 me-6"
                                    onclick="showData()">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="list_data"></div>
            </div>
        </div>
    </form>

    <script src="{{ asset('assets/scripts/admin/dashboard.js?v=' . time()) }}"></script>
</x-app-layout>
