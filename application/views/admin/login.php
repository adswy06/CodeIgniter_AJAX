
<!DOCTYPE html>
<html lang="en">

    
<!-- Mirrored from themesdesign.in/stexo/layouts/vertical/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 29 Apr 2020 14:05:04 GMT -->
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Stexo - Responsive Admin & Dashboard Template | Themesdesign</title>
        <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
        <meta content="Themesdesign" name="author" />
        <link rel="shortcut icon" href="<?php echo base_url() ?>layouts/assets/images/favicon.ico">

        <link href="<?php echo base_url() ?>layouts/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>layouts/assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>layouts/assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>layouts/assets/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>layouts/plugins/sweet-alert2/sweetalert2.css">
        <link href="<?php echo base_url() ?>layouts/plugins/toastr/build/toastr.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>layouts/plugins/toastr/build/toastr.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>
        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="home-btn d-none d-sm-block">
                <a href="index.html" class="text-white"><i class="fas fa-home h2"></i></a>
            </div>
        <div class="wrapper-page">
                <div class="card card-pages shadow-none">
    
                    <div class="card-body">
                        <div class="text-center m-t-0 m-b-15">
                                <a href="index.html" class="logo logo-admin"><img src="assets/images/logo-dark.png" alt="" height="24"></a>
                        </div>
                        <h5 class="font-18 text-center">Masuk Sebagai Admin</h5>
    
                        <form id="frm-login">
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Username</label>
                                    <input class="form-control required" type="text" placeholder="Masukan Username" name="username">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                        <label>Password</label>
                                    <input class="form-control required" type="password" placeholder="Password" name="password">
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-12">
                                    <div class="checkbox checkbox-primary">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1"> Remember me</label>
                                            </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button type="button" id="btn-login" onclick="loginPengguna()" class="btn btn-primary btn-block btn-lg waves-effect waves-light">Log In</button>
                                </div>
                            </div>
    
                            <div class="form-group row m-t-30 m-b-0">
                                <div class="col-sm-7">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                                </div>
                                <div class="col-sm-5 text-right">
                                    <a href="pages-register.html" class="text-muted">Create an account</a>
                                </div>
                            </div>
                        </form>
                    </div>
    
                </div>
            </div>
        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="<?php echo base_url() ?>layouts/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>layouts/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url() ?>layouts/assets/js/metismenu.min.js"></script>
        <script src="<?php echo base_url() ?>layouts/assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url() ?>layouts/assets/js/waves.min.js"></script>
        <script src="<?php echo base_url() ?>layouts/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url() ?>layouts/assets/js/app.js"></script>
        <script src="<?php echo base_url() ?>layouts/plugins/toastr/build/toastr.min.js"></script>

        <script>
        var opsi_toastr = {
            closeButton: true,
            preventDuplicates: true,
            timeOut: 15000
        }

        var login = 0;
        function loginPengguna(){
            $('#btn-login').html("Authentikasi...");
            counter = 0;
            if(counter == 0){
                login++;
                if(login == 1){
                    $.ajax({
                        url: "<?php echo base_url() ?>api/loginPengguna",
                        type: "POST",
                        data: $('#frm-login').serialize(),
                        dataType: "JSON",
                        success: function(data){
                            if(data.Success == true){
                                $('#btn-login').html("Berhasil...");
                                toastr.success(data.Info, 'Authentikasi Berhasil', opsi_toastr);
                                window.location.href = "<?php echo base_url('beranda') ?>";
                            }else{
                                $('#btn-login').html("Gagal");
                                toastr.error(data.Info, 'Authentikasi Gagal', opsi_toastr);
                                $('#frm-login')[0].reset();
                            }
                        },
                        error: function(){
                            toastr.error("Terjadi Kesalahan Saat Pengecekan Data", "Status 500 Server Error", opsi_toastr);
                        }
                    });
                    login = 0;
                }
            }
        }
        </script>        
    </body>
</html>
<script> type="text/javascript">


// function loginAdmin(){
//     $('#btn-login').html("Autehtikasi...");
//     counter = 0;
//     if (counter == 0) {
//         login++;
//         if (login == 1) {
//             $.ajax({
//                 url: "<?php echo base_url('api/loginPengguna') ?>",
//                 type: "POST",
//                 data: $('#frm-login').serialize(),
//                 dataType: "JSON",
//                 success: function(data){
//                     if(data.Success == true){
//                         $('#btn-login').html("Berhasil");
//                         toastr.success(data.Info, 'Authentikasi', opsi_toastr);
//                         window.location.href = "<?php echo base_url('beranda') ?>";
//                     } else {
//                         toastr.error(data.Info, 'Aunthentikasi', opsi_toastr);
//                         $('#frm-logim')[0].reset();
//                     }
//                 }
//                 error: function(){
//                     toastr.error("Terjadi kesalahan saat pengecekan data", "Server Error", opsi_toastr);
//                 }
//             });
//             login = 0;
//         }
//     }
// }

</script>