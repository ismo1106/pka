<?php
    $this->load->view('assets/chartMorris');
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/formValidation');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Statistic</a>
                    </li>
                    <li class="active">
                        Surat Sakit
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Perbulan</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div id="pnl-mss" class="panel panel-color panel-<?= rand_color()?>" >
            <div class="panel-heading">
                <h3 class="panel-title">Statistic Surat Sakit Bulan <?= $bulan?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-filter-statistis-susak" role="form" action="<?= current_url()?>" method="POST">
                            <div class="col-md-2">
                                <input name="txtFilterPeriode" type="text" class="form-control input-sm hi-datepicker" value="<?= $this->session->userdata('f_periode')?>" placeholder="Filter by Periode">
                            </div>
                            <div class="col-md-2">
                                <select name="txtFilterTypeTK" class="form-control input-sm">
                                    <option value="">Filter by Type TK</option>
                                    <option value="ALL" <?= ($this->session->userdata('f_typetk') == 'ALL'? 'selected': '' )?>>Semua</option>
                                    <option value="K" <?= ($this->session->userdata('f_typetk') == 'K'? 'selected': '' )?>>Karyawan</option>
                                    <option value="B" <?= ($this->session->userdata('f_typetk') == 'B'? 'selected': '' )?>>Borongan</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Filter <i class="fa fa-filter"></i> </button>
                                    <a href="<?= current_url()?>" class="btn btn-info btn-sm waves-effect waves-light"> <i class="fa fa-refresh"></i> Reload</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <hr id="hrLineBatas" style="border:0;height:2px;">
                    </div>
                    <div class="col-md-12">
                        <div class="text-center">
                            <ul class="list-inline chart-detail-list">
                                <li class="list-inline-item">
                                    <h5 class="text-custom"><i class="mdi mdi-crop-square m-r-5"></i>Total Tenaga Kerja yang Sakit</h5>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="text-success"><i class="mdi mdi-details m-r-5"></i>Total Surat Sakit yang Terbit</h5>
                                </li>
                            </ul>
                        </div>
                        <div id="daily-sick" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
    $(document).ready(function () {
        var panelColor = $('.panel').children().css('background-color');
        $('#hrLineBatas').css('background-image', 'linear-gradient(to right,#fff,' + panelColor + ',#fff');
        $('.hi-datepicker').datepicker({
            autoclose: true,
            format: "01-mm-yyyy"
        });
        
        $.getJSON("<?php echo site_url('Statistic/getJsonSSDailyChart'); ?>", function (json) { 
            var dailySick = new Morris.Line({
                element: 'daily-sick',
                data: json,
                xkey: 'Tanggal',
                ykeys: ['TotalSick', 'TotalCreate', 'TotalIKD'],
                labels: ['Total Sakit', 'Total Terbit', 'Total SKD'],
                lineColors: ['#188ae2', '#4bd396', '#2f3239'],
                dateFormat: function (x) {
                    var d = new Date(x),
                        weekdays = new Array(7);
                        weekdays[0] = "Minggu";
                        weekdays[1] = "Senin";
                        weekdays[2] = "Selasa";
                        weekdays[3] = "Rabu";
                        weekdays[4] = "Kamis";
                        weekdays[5] = "Juma'at";
                        weekdays[6] = "Sabtu";

                    return weekdays[d.getDay()] + ', ' + 
                           ("0" + (d.getDate())).slice(-2) + '-'+
                           ("0" + (d.getMonth() + 1)).slice(-2) + '-'+
                           (d.getFullYear());
                },
                xLabelFormat: function (d) {
                    return ("0" + (d.getDate())).slice(-2) + '-'+
                           ("0" + (d.getMonth() + 1)).slice(-2) + '-'+
                           (d.getFullYear());
               }
            });
        });
    });
</script>