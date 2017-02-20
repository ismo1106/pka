<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Personalia Pulau Sambu Guntung Apps">
        <meta name="author" content="Ismo Broto">

        <link rel="shortcut icon" href="<?= base_url()?>assets/images/favicon.ico">

        <title>Signature Pad - Personalia App</title>

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
        <link rel="stylesheet" href="<?= base_url()?>assets/plugins/signature-pad/signature-pad.css">

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
        
        <script src="<?= base_url()?>assets/plugins/signature-pad/signature_pad.js"></script>

        <!-- Counter js  -->
        <script src="<?= base_url()?>assets/plugins/waypoints/jquery.waypoints.min.js"></script>
        <script src="<?= base_url()?>assets/plugins/counterup/jquery.counterup.min.js"></script>
    </head>
    <body onselectstart="return false">
        <?php $this->load->view('assets/sweetAlert');?>
        <div id="signature-pad" class="m-signature-pad">
            <input id="txtFileName" type="hidden" value="<?= $this->input->get('filename')?>" />
            <div class="m-signature-pad--body">
                <canvas></canvas>
            </div>
            <div class="m-signature-pad--footer">
                <div class="description">Sign above</div>
                <button type="button" class="button clear" data-action="clear">Clear</button>
                <!--<button id="btnTest" type="button" class="button clear" data-action="clear">Test</button>-->
                <button type="button" class="button save" data-action="save">Save</button>
            </div>
        </div>
        
        <script type="text/javascript">
            var urlSign = '<?= base_url() ?>Medical/signaturConvertToImg';
            var baseurl = '<?= base_url() ?>';
        </script>
        <script type="text/javascript" src="<?= base_url()?>assets/app/klinik/medical_input/signature_pad.js"></script>

    </body>
</html>
