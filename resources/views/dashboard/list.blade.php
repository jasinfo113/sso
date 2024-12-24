@if ($info->total)
    <div class="row">
        @foreach ($data as $row)
            <div class="col-lg-4 mb-5">
                <div class="card shadow-sm" @if (!$row->status) style="filter:grayscale(1);" @endif>
                    <div class="card-body p-0">
                        <div class="text-center p-4">
                            <a href="{{ $row->image }}" class="popup-image" title="{{ $row->name }}">
                                <img class="mw-100 mh-150px card-rounded-bottom" src="{{ $row->image }}"
                                    alt="{{ $row->name }}" />
                            </a>
                            <br /><br />
                            <h3 class="card-title">{{ $row->name }}</h3>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if ($row->status)
                            <a href="javascript:void(0)" class="btn btn-lg btn-light-primary w-100"
                                onclick="appSignIn({{ $row->id }})">
                                LOGIN
                            </a>
                        @else
                            <a href="javascript:void(0)" class="btn btn-lg btn-light-primary w-100 disabled">
                                LOGIN
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="mt-10">
        <?php echo $pagination; ?>
    </div>
@else
    <div
        class="notice d-flex align-items-center bg-light-warning rounded border-warning border border-dashed min-w-lg-600px flex-shrink-0 p-6">
        <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
            <i class="fa fa-exclamation-triangle"></i>
        </span>
        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
            <div class="fs-6 text-gray-700 mb-md-0 fw-bold">Data tidak di temukan!</div>
        </div>
    </div>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        setPopupImage("#form_query #list_data .popup-image");
    });
</script>
