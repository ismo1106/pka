<?php
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/dataTable');
    $this->load->view('assets/formValidation');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="active">
                        Dashboard
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-hospital-building widget-one-icon"></i>
            <div class="wigdet-one-content"><?php $s = $_getStatSakit?>
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Statistics">Orang Sakit</p>
                <h2><?= $s['today']?> <small><i class="mdi <?= $s['exchange']?>"></i></small></h2>
                <p class="text-muted m-0"><b>Kemarin:</b> <?= $s['yesterday']?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-account-convert widget-one-icon"></i>
            <div class="wigdet-one-content">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User Today">User Today</p>
                <h2>895 <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                <p class="text-muted m-0"><b>Last:</b> 1250</p>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-layers widget-one-icon"></i>
            <div class="wigdet-one-content">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="User This Month">User This Month</p>
                <h2>52410 <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="text-muted m-0"><b>Last:</b> 40.33k</p>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-av-timer widget-one-icon"></i>
            <div class="wigdet-one-content">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Request Per Minute">Request Per Minute</p>
                <h2>652 <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                <p class="text-muted m-0"><b>Last:</b> 956</p>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-account-multiple widget-one-icon"></i>
            <div class="wigdet-one-content">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="Total Users">Total Users</p>
                <h2>3245 <small><i class="mdi mdi-arrow-down text-danger"></i></small></h2>
                <p class="text-muted m-0"><b>Last:</b> 20k</p>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="card-box widget-box-one">
            <i class="mdi mdi-download widget-one-icon"></i>
            <div class="wigdet-one-content">
                <p class="m-0 text-uppercase font-600 font-secondary text-overflow" title="New Downloads">New Downloads</p>
                <h2>78541 <small><i class="mdi mdi-arrow-up text-success"></i></small></h2>
                <p class="text-muted m-0"><b>Last:</b> 50k</p>
            </div>
        </div>
    </div>

</div>
<!-- end row -->
