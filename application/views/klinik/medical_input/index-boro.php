<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formValidation');
    $this->load->view('assets/formAdvance');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/styleTableInput');
?>
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group pull-right">
                <ol class="breadcrumb hide-phone p-0 m-0">
                    <li>
                        <a href="#">Klinik</a>
                    </li>
                    <li class="active">
                        Medical
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Input Medical</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Input Medical Borongan/ Harian</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    <form id="form-input-medical-boro" class="form-horizontal" role="form" method="POST" data-parsley-validate>
                        <div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Nama</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="text" id="txtInputNama" name="txtNama" required class="form-control input-sm txt-header" placeholder="Find...">
                                            <input type="hidden" id="txtInputNIK" name="txtNIK" >
                                            <input type="hidden" id="txtInputNoFix" name="txtNoFix" >
                                            <span class="input-group-btn">
                                                <button id="btn-cari-boro" type="button" class="btn btn-sm waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Dept/Bagian</label>
                                    <div class="col-md-9">
                                        <input id="txtInputDept" name="txtDept" type="text" class="form-control input-sm txt-header" placeholder="Departemen/ Bagian">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Tanggal Medical</label>
                                    <div class="col-md-9">
                                        <input id="txtInputTglMedical" name="txtTglMedical" type="text" value="<?= date('d-m-Y')?>" readonly class="form-control input-sm " placeholder="Tanggal Medical">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Umur/ Jenis Kelamin</label>
                                    <div class="col-md-4">
                                        <input id="txtInputUmur" name="txtUmur" type="text" required class="form-control input-sm txt-header" placeholder="Umur">
                                    </div>
                                    <div class="col-md-5">
                                        <input id="txtInputJekel" name="txtJekel" type="text" required class="form-control input-sm txt-header" placeholder="Jenis Kelamin">
                                        <input id="txtInputJekelAbbr" name="txtJekelAbbr" type="hidden" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Perusahaan</label>
                                    <div class="col-md-9">
                                        <input id="txtInputPerusahaan" name="txtPerusahaan" type="text" required class="form-control input-sm txt-header" placeholder="Perusahaan">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Masa Kerja</label>
                                    <div class="col-md-9">
                                        <input id="txtInputMasaKerja" name="txtMasaKerja" type="text" class="form-control input-sm txt-header" placeholder="Masa Kerja">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="col-md-12">
                                <legend class="hrLineBatas" style="color: #fff">Anamnesa</legend>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Asthma Bronchiale</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radAsma" id="radAsma1" value="1" >
                                            <label for="radAsma1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radAsma" id="radAsma0" value="0" checked="">
                                            <label for="radAsma0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Diabetes melitus (Kencing Manis)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radDiabetes" id="radDiabetes1" value="1" >
                                            <label for="radDiabetes1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radDiabetes" id="radDiabetes0" value="0" checked="">
                                            <label for="radDiabetes0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Eczeem (Eksim)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radEksim" id="radEksim1" value="1" >
                                            <label for="radEksim1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radEksim" id="radEksim0" value="0" checked="">
                                            <label for="radEksim0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Ulcus Pepticum (tukak lambung)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radUlcus" id="radUlcus1" value="1" >
                                            <label for="radUlcus1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radUlcus" id="radUlcus0" value="0" checked="">
                                            <label for="radUlcus0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">TBC Paru (sering batuk dan batuk darah)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radTBC" id="radTBC1" value="1" >
                                            <label for="radTBC1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radTBC" id="radTBC0" value="0" checked="">
                                            <label for="radTBC0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Hepatitis (sakit kuning)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radHepatitis" id="radHepatitis1" value="1" >
                                            <label for="radHepatitis1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radHepatitis" id="radHepatitis0" value="0" checked="">
                                            <label for="radHepatitis0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Hernia</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radHernia" id="radHernia1" value="1" >
                                            <label for="radHernia1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radHernia" id="radHernia0" value="0" checked="">
                                            <label for="radHernia0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Hemoroid (wasir)</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radWasir" id="radWasir1" value="1" >
                                            <label for="radWasir1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radWasir" id="radWasir0" value="0" checked="">
                                            <label for="radWasir0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Epilepsi</label>
                                    <div class="col-md-6">
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radEpilepsi" id="radEpilepsi1" value="1" >
                                            <label for="radEpilepsi1"> Ya</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" name="radEpilepsi" id="radEpilepsi0" value="0" checked="">
                                            <label for="radEpilepsi0"> Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div>
                            <div class="col-md-12">
                                <hr class="hrLineBatas" style="border:0;height:2px;">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Tekanan Darah</label>
                                    <div class="col-md-8">
                                        <input id="txtInputTekananDarah" name="txtTekananDarah" type="text" required class="form-control input-sm " placeholder="Tekanan Darah : mmHg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Denyut Nadi</label>
                                    <div class="col-md-4">
                                        <input id="txtInputDenyutNadi" name="txtDenyutNadi" type="text" required class="form-control input-sm " placeholder="x/detik">
                                    </div>
                                    <div class="col-md-4">
                                        <select id="selInputDenyutNadi" name="selDenyutNadi" class="form-control input-sm">
                                            <option value="reguler">Reguler</option>
                                            <option value="irreguler">Irreguler</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Tinggi Badang</label>
                                    <div class="col-md-8">
                                        <input id="txtInputTinggiBadan" name="txtTinggiBadan" type="text" required class="form-control input-sm " placeholder="Tinggi Badan : cm">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Berat Badan</label>
                                    <div class="col-md-8">
                                        <input id="txtInputBeratBadan" name="txtBeratBadan" type="text" required class="form-control input-sm " placeholder="Berat Badan : kg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Body Mess Index (BMI)</label>
                                    <div class="col-md-8">
                                        <input id="txtInputBMI" name="txtBMI" type="text" readonly class="form-control input-sm " placeholder="Body Mess Index : kg">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Kesimpulan</label>
                                    <div class="col-md-8">
                                        <input id="txtInputResultBMI" name="txtResultBMI" type="text" readonly="" class="form-control input-sm " placeholder="Kesimpulan">
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <div>
                            <div class="col-md-12">
                                <legend class="hrLineBatas" style="color: #fff">Pemeriksaan Fisik</legend>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Keadaan Umum</label>
                                    <div class="col-md-8">
                                        <input id="txtInputKeadaanUmum" name="txtKeadaanUmum" type="text" required class="form-control input-sm " value="Baik">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Kepala</label>
                                    <div class="col-md-8">
                                        <input id="txtInputKepala" name="txtKepala" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Mata</label>
                                    <div class="col-md-8">
                                        <input id="txtInputMata" name="txtMata" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Jarak Panndang</label>
                                    <div class="col-md-8">
                                        <input id="txtInputJarakPanndang" name="txtJarakPanndang" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Buta Warna</label>
                                    <div class="col-md-8">
                                        <input id="txtInputButaWarna" name="txtButaWarna" type="text" required class="form-control input-sm " value="Dalama batas normal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Hidung</label>
                                    <div class="col-md-8">
                                        <input id="txtInputHidung" name="txtHidung" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Gigi/Rongga Mulut</label>
                                    <div class="col-md-8">
                                        <input id="txtInputRonggaMulut" name="txtRonggaMulut" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Leher</label>
                                    <div class="col-md-8">
                                        <input id="txtInputLeher" name="txtLeher" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Paru-paru</label>
                                    <div class="col-md-8">
                                        <input id="txtInputParuparu" name="txtParuparu" type="text" required class="form-control input-sm " value="DBN, Suara nafas vesikuler">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Jantung</label>
                                    <div class="col-md-8">
                                        <input id="txtInputJantung" name="txtJantung" type="text" required class="form-control input-sm " value="DBN, Bunyi jantung normal">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Hati dan Limpa</label>
                                    <div class="col-md-8">
                                        <input id="txtInputHatiLimpa" name="txtHatiLimpa" type="text" required class="form-control input-sm " value="Tidak Teraba Membesar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Perut</label>
                                    <div class="col-md-8">
                                        <input id="txtInputPerut" name="txtPerut" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Anus dan Kelamin</label>
                                    <div class="col-md-8">
                                        <input id="txtInputAnusKelamin" name="txtAnusKelamin" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Anggota Badan</label>
                                    <div class="col-md-8">
                                        <input id="txtInputAnggotaBadan" name="txtAnggotaBadang" type="text" required class="form-control input-sm " value="Dalam batas normal">
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                        <!-- <div>
                            <div class="col-md-12">
                                <legend class="hrLineBatas" style="color: #fff">Pemeriksaan Khusus</legend>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Napza</label>
                                    <div class="col-md-9">
                                        <textarea id="txtInputNapza" name="txtNapza" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Napza"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Darah Rutin</label>
                                    <div class="col-md-9">
                                        <textarea id="txtInputDarahRutin" name="txtDarahRutin" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Darah Rutin"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Audiometri</label>
                                    <div class="col-md-9">
                                        <textarea id="txtInputAudiometri" name="txtAudiometri" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Audiometri"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Widal</label>
                                    <div class="col-md-9">
                                        <textarea id="txtInputWidal" name="txtWidal" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Widal"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <hr class="hrLineBatas" style="border:0;height:2px;">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Kesimpulan</label>
                                    <div class="col-md-10">
                                        <textarea id="txtInputKesimpulan" name="txtKesimpulan" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Kesimpulan"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Catatan/Pesan Klinik</label>
                                    <div class="col-md-10">
                                        <textarea id="txtInputCatatanKlinik" name="txtCatatanKlinik" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Catatan/Pesan Klinik"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Catatan/Pesan P2K3</label>
                                    <div class="col-md-10">
                                        <textarea id="txtInputCatatanP2K3" name="txtCatatanP2K3" maxlength="200" required class="form-control input-sm txt-maxlength" placeholder="Catatan/Pesan P2K3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                            
                        <div>
                            <div class="col-md-12">
                                <legend class="hrLineBatas" style="color: #fff">Kartu Medical Check Up</legend>
                            </div>
                            <div class="col-md-12">
                                <table class="table-input table-input-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="width: 12.5%">MDC</th>
                                            <th rowspan="2" style="width: 12.5%">WIDAL</th>
                                            <th rowspan="2" style="width: 12.5%">DARAH RUTIN</th>
                                            <th rowspan="2" style="width: 12.5%">URINE</th>
                                            <th rowspan="2" style="width: 12.5%">KET</th>
                                            <th colspan="3">KIMIA DARAH</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 12.5%">GULA</th>
                                            <th style="width: 12.5%">KOLESTEROL</th>
                                            <th style="width: 12.5%">ASAM URAT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input style="height: 30px" name="txtTglMDC" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtTglWidal" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtTglDarahRutin" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtTglUrine" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtKetMedis" class="txt-table text-center" /></td>
                                            <td><input style="height: 30px" name="txtTglGula" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtTglKolesterol" class="txt-table text-center hi-datepicker" /></td>
                                            <td><input style="height: 30px" name="txtTglAsamUrat" class="txt-table text-center hi-datepicker" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12">
                                <hr class="hrLineBatas" style="border:0;height:2px;">
                            </div>
                            <div class="col-md-12 text-right">
                                <button id="btnSignature" class="btn btn-sm btn-primary" type="button"> Signature <i class="fa fa-pencil-square-o"></i> </button>
                                <button id="btnSubmit" class="btn btn-sm btn-success" type="button"> Submit <i class="fa fa-send-o"></i> </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Select Boro Medical -->
<div id="modal-select-boro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width: 75%">
        <div class="modal-content p-0 b-0">
            <div class="panel panel-color panel-inverse">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 class="panel-title">Pilih Tenaga Kerja Borongan/Harian untuk Medical</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div id="modal-content-boro" class="col-md-12">
                            <table id="tbl-select-boro" class="table table-striped table-hover table-nowrap">
                                <thead>
                                    <tr>
                                        <th>No. Urut</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlDtbaleTKNew  = '<?= base_url() ?>Medical/getDatatableMedicalBoro',
        urlGetData      = '<?= base_url() ?>Medical/getDataBoroByNIK',
        urlSignature    = '<?= base_url() ?>Medical/signaturePadMedical',
        urlCheckSign    = '<?= base_url() ?>Medical/checkFileExist',
        urlSubmitMedic  = '<?= base_url() ?>Medical/simpanMedicalBoro';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/medical_input/boro.js"></script>