<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo SITE_NAME . ' - ' . _UserSubscriptionLevel[$this->session->userdata('position')]; ?></title>
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/plugins/select2/select2.min.css?v=2" rel="stylesheet">

    <!-- Ladda style -->
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">

    <link href="<?php echo base_url('assets/'); ?>inspinia/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/style.css?v=8" rel="stylesheet">

    <link href="<?php echo base_url('assets/'); ?>css/custom_css.css?v=1" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/common.js?v=21"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/inspinia.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!--  select2  -->
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/select2/select2.full.min.js?v=2"></script>

    <!-- Ladda -->
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/ladda/spin.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/ladda/ladda.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/ladda/ladda.jquery.min.js"></script>

    <!--  Sweet Alert  -->
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <!--  File upload Jasny  -->
    <link href="<?php echo base_url('assets/'); ?>inspinia/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>

    <!--  daterangepicker  -->
    <script src="<?php echo base_url('assets/'); ?>js/moment.min.js?v=1"></script>
    <script src="<?php echo base_url('assets/'); ?>inspinia/js/plugins/daterangepicker/daterangepicker.js?v=2"></script>
    <link href="<?php echo base_url('assets/'); ?>css/daterangepicker.css?v=1" rel="stylesheet">

    <!--  Toastr  -->
    <link href="<?php echo base_url('assets/'); ?>plugins/toastr/toastr.min.css?v=7" rel="stylesheet">
    <script src="<?php echo base_url('assets/'); ?>plugins/toastr/toastr.min.js"></script>
</head>

<body class="mini-navbar">
<script>
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
</script>
<div id="wrapper">
    <?php $this->load->view('layouts/default/sidebar'); ?>
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <?php $this->load->view('layouts/default/navbar'); ?>
        </div>
        <?php $this->load->view($page_content); ?>
        <div class="footer">
            <?php $this->load->view('layouts/default/footer'); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_content">

        </div>
    </div>
</div>


</body>

</html>
