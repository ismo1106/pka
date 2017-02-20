<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Ismo Broto">

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">
        <!-- App title -->
        <title>Login - Persolia App</title>

        <!-- App css -->
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <script src="<?= base_url() ?>assets/js/modernizr.min.js"></script>

    </head>
    <style>
        body {
            background-image: url(<?= base_url() ?>assets/images/bg-desk-sm.png);
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-color: #464646;
        }
    </style>

    <body class="bg-dark">
        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div id="form-login" class="col-sm-offset-8 col-sm-4">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages bg-white">
                                <div class="text-center account-logo-box">
                                    <h4 class="text-uppercase font-bold m-b-0 text-muted">Sign In</h4>
                                </div>
                                <div class="account-content">
                                    <form method="POST" action="<?= site_url('Login/cekLogin') ?>" class="form-horizontal" >
                                        <div class="text-center">
                                            <p class="error"><?= $_message; ?></p>
                                        </div>

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input name="txtUserID" class="form-control" type="text" required="" placeholder="Username" autocomplete="off" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input name="txtUserPW" class="form-control" type="password" required="" placeholder="Password" autocomplete="off" >
                                            </div>
                                        </div>

                                        <div class="form-group account-btn text-center m-t-10">
                                            <div class="col-xs-12">
                                                <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box-->

                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-dark"><?= date('Y') ?> &copy; Pulau Sambu Guntung - <strong>Personalia App</strong></p>
                                </div>
                            </div>

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/detect.js"></script>
        <script src="<?= base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url() ?>assets/js/waves.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.app.js"></script>

        <script type="text/javascript">
            $(window).bind('click', function (evt) {
                if (evt.target.id == "form-login")
                    return;
                //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
                if ($(evt.target).closest('#form-login').length)
                    return;
                //Do processing of click event here for every element except with id menu_content
                else
                    alert('Maff!!! Jangan sering2 ng-click sembarangan!');
            }).bind('contextmenu', function (){
                alert('Maff!!! Jangan sering2 ng-click sembarangan!');
                return false;
            });
        </script>
    </body>
</html>