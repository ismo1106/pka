<?php
    $this->load->view('assets/dataTable');
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formValidation');
    $this->load->view('assets/formAdvance');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/styleTableInput');
    $r = $_getData;
    $sts = $this->uri->segment(4);
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
            <h4 class="page-title">Update Medical</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-heading bg-<?= ($sts == 'KT'? 'purple': ($sts == 'KK'? 'teal': ($sts == 'HB'? 'inverse': 'success')))?>">
                <h3 class="portlet-title">Update Medical <?= ($sts == 'KT'? 'Karyawan Tetap': ($sts == 'KK'? 'Karyawan Kontrak': ($sts == 'HB'? 'Borongan/ Harian': 'Tenaga Kerja Baru')))?></h3>
                <div class="portlet-widgets">
                    <a id="btnClose" href="javascript:;"><i class="ion-close-round"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div id="bg-primary" class="panel-collapse collapse in">
                <div class="portlet-body">
                    <div class="row">
                        <?php if($this->session->flashdata('_message')): ?>
                        <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                        </div>
                        <?php endif; ?>
                        <form id="form-input-medical-tknew" class="form-horizontal" role="form" method="POST" data-parsley-validate>
                            <div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Nama</label>
                                        <div class="col-md-9">
                                            <input type="text" id="txtInputNama" name="txtNama" value="<?= ucwords(strtolower($r->Nama))?>" readonly class="form-control input-sm txt-header" >
                                            <input type="hidden" id="txtInputMedicalID" name="txtMedicalID" value="<?= $this->uri->segment(3)?>" >
                                            <input type="hidden" id="txtInputDirectLink" name="txtDirectLink" value="<?= current_url()?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Dept/Bagian</label>
                                        <div class="col-md-9">
                                            <input id="txtInputDept" name="txtDept" type="text" value="<?= $r->Dept?>" readonly class="form-control input-sm txt-header" placeholder="Dept/Bagian" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Tanggal Medical</label>
                                        <div class="col-md-9">
                                            <input id="txtInputTglMedical" name="txtTglMedical" type="text" value="<?= date('d-m-Y', strtotime($r->TglMedical))?>" readonly class="form-control input-sm" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Umur/ Jenis Kelamin</label>
                                        <div class="col-md-4">
                                            <input id="txtInputUmur" name="txtUmur" type="text" value="<?= $r->Usia.' Tahun'?>" readonly class="form-control input-sm txt-header" placeholder="Umur">
                                        </div>
                                        <div class="col-md-5">
                                            <input id="txtInputJekel" name="txtJekel" type="text" value="<?= ($r->JenisKelamin == 'L'? 'Laki-laki': 'Perempuan')?>" readonly class="form-control input-sm txt-header" placeholder="Jenis Kelamin">
                                            <input id="txtInputJekelAbbr" name="txtJekelAbbr" type="hidden" value="<?= $r->JenisKelamin?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Perusahaan</label>
                                        <div class="col-md-9">
                                            <input id="txtInputPerusahaan" name="txtPerusahaan" type="text" value="<?= $r->Perusahaan?>" readonly class="form-control input-sm txt-header" placeholder="Perusahaan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Masa Kerja</label>
                                        <div class="col-md-9">
                                            <input id="txtInputMasaKerja" name="txtMasaKerja" type="text" value="<?= $r->MasaKerja?>" readonly class="form-control input-sm txt-header" placeholder="Masa Kerja">
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
                                                <input type="radio" name="radAsma" id="radAsma1" value="1" <?= ($r->Asma == 1? 'checked': '')?> >
                                                <label for="radAsma1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radAsma" id="radAsma0" value="0" <?= ($r->Asma == 0? 'checked': '')?> >
                                                <label for="radAsma0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Diabetes melitus (Kencing Manis)</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radDiabetes" id="radDiabetes1" value="1" <?= ($r->Diabetes == 1? 'checked': '')?> >
                                                <label for="radDiabetes1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radDiabetes" id="radDiabetes0" value="0" <?= ($r->Diabetes == 0? 'checked': '')?> >
                                                <label for="radDiabetes0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Eczeem (Eksim)</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radEksim" id="radEksim1" value="1" <?= ($r->Eksim == 1? 'checked': '')?> >
                                                <label for="radEksim1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radEksim" id="radEksim0" value="0" <?= ($r->Eksim == 0? 'checked': '')?> >
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
                                                <input type="radio" name="radUlcus" id="radUlcus1" value="1" <?= ($r->Ulcus == 1? 'checked': '')?> >
                                                <label for="radUlcus1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radUlcus" id="radUlcus0" value="0" <?= ($r->Ulcus == 0? 'checked': '')?> >
                                                <label for="radUlcus0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">TBC Paru (sering batuk dan batuk darah)</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radTBC" id="radTBC1" value="1" <?= ($r->TBC == 1? 'checked': '')?> >
                                                <label for="radTBC1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radTBC" id="radTBC0" value="0" <?= ($r->TBC == 0? 'checked': '')?> >
                                                <label for="radTBC0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hepatitis (sakit kuning)</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radHepatitis" id="radHepatitis1" value="1" <?= ($r->Hepatitis == 1? 'checked': '')?> >
                                                <label for="radHepatitis1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radHepatitis" id="radHepatitis0" value="0" <?= ($r->Hepatitis == 0? 'checked': '')?> >
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
                                                <input type="radio" name="radHernia" id="radHernia1" value="1" <?= ($r->Hernia == 1? 'checked': '')?> >
                                                <label for="radHernia1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radHernia" id="radHernia0" value="0" <?= ($r->Hernia == 0? 'checked': '')?> >
                                                <label for="radHernia0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hemoroid (wasir)</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radWasir" id="radWasir1" value="1" <?= ($r->Wasir == 1? 'checked': '')?> >
                                                <label for="radWasir1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radWasir" id="radWasir0" value="0" <?= ($r->Wasir == 0? 'checked': '')?> >
                                                <label for="radWasir0"> Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Epilepsi</label>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radEpilepsi" id="radEpilepsi1" value="1" <?= ($r->Epilepsi == 1? 'checked': '')?> >
                                                <label for="radEpilepsi1"> Ya</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" name="radEpilepsi" id="radEpilepsi0" value="0" <?= ($r->Epilepsi == 0? 'checked': '')?> >
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
                                            <input id="txtInputTekananDarah" name="txtTekananDarah" type="text" value="<?= $r->TekananDarah?>" required class="form-control input-sm " placeholder="Tekanan Darah : mmHg">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Denyut Nadi</label>
                                        <div class="col-md-4">
                                            <input id="txtInputDenyutNadi" name="txtDenyutNadi" type="text" value="<?= $r->DenyutNadi?>" required class="form-control input-sm " placeholder="x/detik">
                                        </div>
                                        <div class="col-md-4">
                                            <select id="selInputDenyutNadi" name="selDenyutNadi" class="form-control input-sm">
                                                <option value="reguler" <?= ($r->DenyutNadiSatuan =='reguler'? 'selected': '')?> >Reguler</option>
                                                <option value="irreguler" <?= ($r->DenyutNadiSatuan =='irreguler'? 'selected': '')?> >Irreguler</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Tinggi Badang</label>
                                        <div class="col-md-8">
                                            <input id="txtInputTinggiBadan" name="txtTinggiBadan" type="text" value="<?= $r->TinggiBadan?>" required class="form-control input-sm " placeholder="Tinggi Badan : cm">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Berat Badan</label>
                                        <div class="col-md-8">
                                            <input id="txtInputBeratBadan" name="txtBeratBadan" type="text" value="<?= $r->BeratBadan?>" required class="form-control input-sm " placeholder="Berat Badan : kg">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Body Mess Index (BMI)</label>
                                        <div class="col-md-8">
                                            <input id="txtInputBMI" name="txtBMI" type="text" value="<?= $r->BMI?>" readonly class="form-control input-sm " placeholder="Body Mess Index : kg">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Kesimpulan</label>
                                        <div class="col-md-8">
                                            <input id="txtInputResultBMI" name="txtResultBMI" type="text" value="<?= $r->ResultBMI?>" readonly="" class="form-control input-sm " placeholder="Kesimpulan">
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
                                            <input id="txtInputKeadaanUmum" name="txtKeadaanUmum" type="text" required class="form-control input-sm " value="<?= $r->KeadaanUmum?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Kepala</label>
                                        <div class="col-md-8">
                                            <input id="txtInputKepala" name="txtKepala" type="text" required class="form-control input-sm " value="<?= $r->Kepala?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Mata</label>
                                        <div class="col-md-8">
                                            <input id="txtInputMata" name="txtMata" type="text" required class="form-control input-sm " value="<?= $r->Mata?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Jarak Pandang</label>
                                        <div class="col-md-8">
                                            <input id="txtInputJarakPanndang" name="txtJarakPanndang" type="text" required class="form-control input-sm " value="<?= $r->JarakPandang?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Buta Warna</label>
                                        <div class="col-md-8">
                                            <input id="txtInputButaWarna" name="txtButaWarna" type="text" required class="form-control input-sm " value="<?= $r->ButaWarna?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Hidung</label>
                                        <div class="col-md-8">
                                            <input id="txtInputHidung" name="txtHidung" type="text" required class="form-control input-sm " value="<?= $r->Hidung?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Gigi/Rongga Mulut</label>
                                        <div class="col-md-8">
                                            <input id="txtInputRonggaMulut" name="txtRonggaMulut" type="text" required class="form-control input-sm " value="<?= $r->RonggaMulut?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Leher</label>
                                        <div class="col-md-8">
                                            <input id="txtInputLeher" name="txtLeher" type="text" required class="form-control input-sm " value="<?= $r->Leher?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Paru-paru</label>
                                        <div class="col-md-8">
                                            <input id="txtInputParuparu" name="txtParuparu" type="text" required class="form-control input-sm " value="<?= $r->Paruparu?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Jantung</label>
                                        <div class="col-md-8">
                                            <input id="txtInputJantung" name="txtJantung" type="text" required class="form-control input-sm " value="<?= $r->Jantung?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Hati dan Limpa</label>
                                        <div class="col-md-8">
                                            <input id="txtInputHatiLimpa" name="txtHatiLimpa" type="text" required class="form-control input-sm " value="<?= $r->HatiLimpa?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Perut</label>
                                        <div class="col-md-8">
                                            <input id="txtInputPerut" name="txtPerut" type="text" required class="form-control input-sm " value="<?= $r->Perut?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Anus dan Kelamin</label>
                                        <div class="col-md-8">
                                            <input id="txtInputAnusKelamin" name="txtAnusKelamin" type="text" required class="form-control input-sm " value="<?= $r->AnusKelamin?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Anggota Badan</label>
                                        <div class="col-md-8">
                                            <input id="txtInputAnggotaBadan" name="txtAnggotaBadang" type="text" required class="form-control input-sm " value="<?= $r->AnggotaBadan?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="col-md-12">
                                    <legend class="hrLineBatas" style="color: #fff">Pemeriksaan Khusus</legend>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Napza</label>
                                        <div class="col-md-9">
                                            <textarea id="txtInputNapza" name="txtNapza" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Napza"><?= $r->Napza?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Darah Rutin</label>
                                        <div class="col-md-9">
                                            <textarea id="txtInputDarahRutin" name="txtDarahRutin" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Darah Rutin"><?= $r->DarahRutin?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Audiometri</label>
                                        <div class="col-md-9">
                                            <textarea id="txtInputAudiometri" name="txtAudiometri" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Audiometri"><?= $r->Audiometri?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Widal</label>
                                        <div class="col-md-9">
                                            <textarea id="txtInputWidal" name="txtWidal" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Widal"><?= $r->Widal?></textarea>
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
                                            <textarea id="txtInputKesimpulan" name="txtKesimpulan" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Kesimpulan"><?= $r->Kesimpulan?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Catatan/Pesan Klinik</label>
                                        <div class="col-md-10">
                                            <textarea id="txtInputCatatanKlinik" name="txtCatatanKlinik" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Catatan/Pesan Klinik"><?= $r->CatatanKlinik?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Catatan/Pesan P2K3</label>
                                        <div class="col-md-10">
                                            <textarea id="txtInputCatatanP2K3" name="txtCatatanP2K3" maxlength="200" class="form-control input-sm txt-maxlength" placeholder="Catatan/Pesan P2K3"><?= $r->CatatanP2K3?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                                <td><input style="height: 30px" name="txtTglMDC" value="<?= ($r->TglMDC != NULL? date('d-m-Y', strtotime($r->TglMDC)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtTglWidal" value="<?= ($r->TglWidal != NULL? date('d-m-Y', strtotime($r->TglWidal)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtTglDarahRutin" value="<?= ($r->TglDarahRutin != NULL? date('d-m-Y', strtotime($r->TglDarahRutin)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtTglUrine" value="<?= ($r->TglUrine != NULL? date('d-m-Y', strtotime($r->TglUrine)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtKetMedis" value="<?= $r->KeteranganMedis?>" class="txt-table text-center" /></td>
                                                <td><input style="height: 30px" name="txtTglGula" value="<?= ($r->TglGula != NULL? date('d-m-Y', strtotime($r->TglGula)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtTglKolesterol" value="<?= ($r->TglKolesterol != NULL? date('d-m-Y', strtotime($r->TglKolesterol)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                                <td><input style="height: 30px" name="txtTglAsamUrat" value="<?= ($r->TglAsamUrat != NULL? date('d-m-Y', strtotime($r->TglAsamUrat)): '')?>" class="txt-table text-center hi-datepicker" /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-12">
                                    <hr class="hrLineBatas" style="border:0;height:2px;">
                                </div>
                                <div class="col-sm-6">
                                    <button id="btnBack" type="button" class="btn btn-sm btn-danger waves-effect waves-light">Close</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button id="btnUpdate" class="btn btn-sm btn-success waves-effect waves-light" type="button"> Update <i class="fa fa-edit"></i> </button>
                                    <button id="btnCancel" class="btn btn-sm btn-warning waves-effect waves-light" type="button"> Cancel <i class="fa fa-refresh"></i> </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>


<script type="text/javascript">
    var urlUpdateMedic  = '<?= base_url() ?>Medical/updateMedicalFromApproval';
</script>

<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/medical_input/update.js"></script>