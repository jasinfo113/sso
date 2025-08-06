<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Form Registrasi Data Pegawai" />
    <meta name="author" content="JASINFO DAMKAR DKI JAKARTA" />
    <link rel="shortcut icon" href="https://pemadam.jakarta.go.id/favicon.ico" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo base_url('assets/theme-register/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/theme-register/css/style.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/sweetalert/sweetalert.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/cropperjs/dist/cropper.min.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/theme-register/css/vendors.css') ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/theme-register/css/custom.css?v=' . time()) ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/styles/cam_photo.css?v=' . time()) ?>" rel="stylesheet" />
    <style type="text/css">
        .question_title {
            text-transform: uppercase;
        }

        .img-container img {
            max-width: 100%;
        }

        #image_crop {
            width: 100%;
            height: auto;
        }

        input.form-control,
        .form-select,
        textarea.form-control {
            color: #000000;
            text-transform: uppercase;
        }

        label.container_check {
            text-transform: uppercase;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            text-transform: uppercase;
        }

        .select2-container--default .select2-results>.select2-results__options {
            text-transform: uppercase;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            text-transform: uppercase;
        }

        @media (min-width: 1280px) {
            .img-fluid {
                max-width: 300px;
            }
        }
    </style>
    <script type="text/javascript">
        var base_url = "<?php echo base_url(); ?>";
        var site_url = "<?php echo site_url(); ?>";
        var isPns = "<?php echo (strtolower($row->ref) == "pns" ? 1 : 0); ?>";
        var isPjlp = "<?php echo (strtolower($row->ref) == "pjlp" ? 1 : 0); ?>";
    </script>
</head>

<body class="bg_color_gray">
    <div id="preloader">
        <div data-loader="circle-side"></div>
    </div>
    <div id="loader_form">
        <div data-loader="circle-side-2"></div>
    </div>

    <div class="min-vh-100 d-flex flex-column">
        <header>
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-center">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                        <img src="<?php echo LOGO_DKI ?>" height="50px" width="auto" alt="Logo DKI" />
                        <img src="<?php echo LOGO_DAMKAR ?>" height="50px" width="auto" alt="Logo" />
                    </a>
                </div>
            </div>
        </header>

        <div class="container-fluid d-flex flex-column my-auto">
            <div id="wizard_container">
                <div id="top-wizard">
                    <div id="progressbar"></div>
                </div>
                <form id="form_validasi" method="post" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" name="tx_id" value="<?php echo $row->tx_id ?>" />
                    <div id="middle-wizard">
                        <!-- KEY -->
                        <div class="step" data="key">
                            <div class="question_title">
                                <h4><?php echo $row->name ?></h4>
                                <p>Kami akan melakukan verifikasi data Anda, harap masukan <?php echo $row->label ?> dengan benar.</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control required" name="key" id="key" placeholder="<?php echo $row->label ?>" required />
                                        <label for="key"><em>*</em> <?php echo $row->label ?></label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control required" name="key_confirm" id="key_confirm" placeholder="Konfirmasi <?php echo $row->label ?>" required />
                                        <label for="key_confirm"><em>*</em> Konfirmasi <?php echo $row->label ?></label>
                                    </div>
                                    <div class="mb-3 form-floating">
                                        <input type="text" class="form-control required" name="pin" id="pin" placeholder="PIN" required />
                                        <label for="pin"><em>*</em> PIN</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FORM -->
                        <div class="submit step mb-4">
                            <div class="question_title">
                                <h3><?php echo slash($row->name) ?></h3>
                                <p><?php echo slash($row->description) ?></p>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <div id="list_details"></div>
                                    <div class="m-separator m-separator--dashed m-separator--sm"></div>
                                    <div class="terms d-flex align-items-center justify-content-start">
                                        <label class="container_check font-weight-bold">Dengan ini saya menyatakan bahwa data yang saya input adalah data yang benar.</a>
                                            <input type="checkbox" name="terms" value="1" class="required" required />
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="bottom-wizard">
                            <button type="button" name="backward" class="backward btn_1">KEMBALI</button>
                            <button type="button" name="forward" class="forward btn_1">BERIKUTNYA</button>
                            <button type="submit" name="process" class="submit btn_1">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <footer>
            <div class="container-fluid text-center">
                <p>© <?php echo date('Y') ?> <?php echo WEB_TITLE ?></p>
            </div>
            <!-- /Container -->
        </footer>
    </div>

    <div class="modal fade" id="modal_photo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialo-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Penyesuaian Foto</h5>
                    <button type="button" class="close btn btn-default" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img id="image_crop" alt="Foto" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Batalkan</button>
                    <button type="button" class="btn btn-primary" onclick="cropProcess()">Simpan</button>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('assets/theme-register/js/common_scripts.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/cropperjs/dist/cropper.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/theme-register/js/common_functions.js?v=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/scripts/validasi/script.js?v=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/scripts/validasi/pegawai.js?v=' . time()) ?>"></script>
        <script src="<?php echo base_url('assets/scripts/validasi/cam_photo.js?v=' . time()) ?>"></script>
</body>

</html>