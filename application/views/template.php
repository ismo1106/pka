<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Personalia Pulau Sambu Guntung Apps">
        <meta name="author" content="Ismo Broto">

        <link rel="shortcut icon" href="<?= base_url()?>assets/images/cp_icon.png">

        <title>Personalia App</title>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?= base_url()?>assets/plugins/morris/morris.css">
        <link rel="stylesheet" href="<?= base_url()?>assets/plugins/tooltipster/tooltipster.bundle.min.css">

        <!-- App css -->
        <link href="<?= base_url()?>assets/css/additional-style.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url()?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?= base_url()?>assets/plugins/switchery/switchery.min.css">

        <script src="<?= base_url()?>assets/js/modernizr.min.js"></script>        
        <!-- jQuery  -->
        <script src="<?= base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url()?>assets/js/detect.js"></script>
        <script src="<?= base_url()?>assets/js/dateformat.js"></script>
        <script src="<?= base_url()?>assets/js/fastclick.js"></script>
        <script src="<?= base_url()?>assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url()?>assets/js/waves.js"></script>
        <script src="<?= base_url()?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?= base_url()?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?= base_url()?>assets/plugins/switchery/switchery.min.js"></script>

        <!-- Counter js  -->
        <script src="<?= base_url()?>assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="<?= base_url()?>assets/plugins/counterup/jquery.counterup.min.js"></script>

        <!--Morris Chart-->
        <script src="<?= base_url()?>assets/plugins/morris/morris.min.js"></script>
        <script src="<?= base_url()?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?= base_url()?>assets/plugins/tooltipster/tooltipster.bundle.min.js"></script>

        <!-- Dashboard init -->
        <!--<script src="<?= base_url()?>assets/pages/jquery.dashboard.js"></script>-->

    </head>

    <body>
        <!-- Navigation Bar-->
        <header id="topnav">
            <?= $_header; ?>

            <?= $_navbar; ?>
        </header>
        <!-- End Navigation Bar-->

        <div class="wrapper">
            <div class="container">
                <!-- Content -->
                <?= $_content; ?>
                <!-- End Content -->
                
                <!-- Footer -->
                <?= $_footer; ?>
                <!-- End Footer -->
            </div>
        </div>
        
        <!-- App js -->
        <script src="<?= base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?= base_url()?>assets/js/jquery.app.js"></script>

    </body>
</html>