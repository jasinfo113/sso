$(document).ready(function () {
    $("#form_query input").keydown(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode === 13) {
            event.preventDefault();
            showData();
        }
    });
    showData();
});

function showData(_page = 0) {
    listPagination(_page, 'admin/app/data', '#form_query', '#form_query #list_data');
}

function appSignIn(str) {
    dialogConfirm(str, "Lanjutkan login ke Aplikasi?", "admin/app/login");
    if (str) {
        Swal.fire({
            icon: "question",
            title: "Konfirmasi",
            text: "Lanjutkan login ke Aplikasi?",
            cancelButtonText: "Tidak, batalkan!",
            confirmButtonText: "Ya, lanjutkan!",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger"
            }
        }).then((function (e) {
            if (e.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: site_url + "admin/app/login",
                    data: "id=" + str,
                    cache: false,
                    async: false,
                    dataType: "json",
                    beforeSend: function () {
                        swalLoading();
                    },
                    success: function (json) {
                        if (json.status) {
                            Swal.close();
                            window.open(json.url);
                        } else {
                            swalAlert("error", json.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        swalAlert("error", error);
                    }
                });
            }
        }));
    } else {
        swalAlert("warning", "No data selected!");
    }
}