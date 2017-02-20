<?php
    $this->load->view('assets/sweetAlert');
    $this->load->view('assets/formPicker');
    $this->load->view('assets/formValidation');
    
    $rS = $_getDataSusak;
    $rM = $_getDataTenaker;
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
                        Update Surat Sakit
                    </li>
                </ol>
            </div>
            <h4 class="page-title">Surat Sakit</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-color panel-purple">
            <div class="panel-heading">
                <h3 class="panel-title">Update Surat Sakit Karyawan</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if($this->session->flashdata('_message')): ?>
                    <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                    </div>
                    <?php endif; ?>
                    <form id="form-input-susak-karyawan" class="form-horizontal" role="form" method="POST" data-parsley-validate>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-3 control-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="hidden" id="txtInputSakitID" name="txtSakitID" value="<?= $this->uri->segment(3)?>" />
                                    <input type="text" id="txtInputNIK" name="txtNIK" class="form-control input-sm" value="<?= $rS->NIK?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-9">
                                    <input id="txtInputNama" name="txtNama" type="text" required class="form-control input-sm" value="<?= $rS->Nama?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Jabatan</label>
                                <div class="col-md-9">
                                    <input id="txtInputJabatan" name="txtJabatan" type="text" required class="form-control input-sm" value="<?= $rM->JabatanName?>" readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Departemen</label>
                                <div class="col-md-9">
                                    <input id="txtInputDept" name="txtDept" type="text" required class="form-control input-sm" value="<?= $rM->DeptAbbr?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Perusahaan</label>
                                <div class="col-md-9">
                                    <input id="txtInputPT" name="txtPT" type="text" required class="form-control input-sm" value="<?= $rS->Perusahaan?>" readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Umur</label>
                                <div class="col-md-8">
                                    <input id="txtInputUmur" name="txtUmur" type="text" required class="form-control input-sm" value="<?= $rS->Umur?>" readonly="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Jenis Kelamin</label>
                                <div class="col-md-8">
                                    <select id="selInputJekel" name="selJekel" class="form-control input-sm">
                                        <option value="">Pilih...</option>
                                        <option value="L" <?= ($rS->JenisKelamin == 'L'? 'selected': '')?>>Laki-laki</option>
                                        <option value="P" <?= ($rS->JenisKelamin == 'P'? 'selected': '')?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr style="border:0;height:2px;background-image:linear-gradient(to right,rgba(107, 95, 181, 1),rgba(125, 115, 191, 1),rgba(0,0,0,0));">
                            <div class="col-md-4">
                                <div class="form-group form-ikd display-none">
                                    <label class="col-md-5 control-label">Tanggal Surat</label>
                                    <div class="col-md-7">
                                        <input id="txtInputTglSurat" name="txtTglSurat" type="text" value="<?= date('d-m-Y', strtotime($rS->TglMulaiIstirahat))?>" class="form-control input-sm hi-datepicker" readonly>
                                    </div>
                                </div>
                                <div class="form-group form-not-ikd">
                                    <label class="col-md-5 control-label">Tgl Mulai Istirahat</label>
                                    <div class="col-md-7">
                                        <input id="txtInputTglMulai" name="txtTglMulai" type="text" value="<?= date('d-m-Y', strtotime($rS->TglMulaiIstirahat))?>" required class="form-control input-sm hi-datepicker">
                                    </div>
                                </div>
                                <div class="form-group form-not-ikd">
                                    <label class="col-md-5 control-label">Lama Istirahat</label>
                                    <div class="col-md-7">
                                        <input id="txtInputDurasi" name="txtDurasi" type="text" value="<?= $rS->LamaIstirahat?>" required class="form-control input-sm">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Jenis Surat</label>
                                    <div class="col-md-7">
                                        <select id="selInputJenisSurat" name="selJenisSurat" class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <option value="all" <?= ($rS->JenisSurat == 'all'? 'selected': '')?>>Semua</option>
                                            <option value="ikd" <?= ($rS->JenisSurat == 'ikd'? 'selected': '')?>>Keterangan Dokter</option>
                                            <option value="iss" <?= ($rS->JenisSurat == 'iss'? 'selected': '')?>>Surat Sakit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Keterangan Dokter</label>
                                    <div class="col-md-7">
                                        <textarea id="txtInputKetDokter" name="txtKetDokter" <?= ($rS->JenisSurat == 'iss'? 'readonly': '')?> class="form-control" style="resize: none" rows="2"><?= $rS->KeteranganDokter?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Alasan Sakit</label>
                                    <div class="col-md-7">
                                        <select id="selInputAlasanSakit" name="selAlasanSakit" <?= ($rS->JenisSurat == 'ikd'? 'disabled': '')?> class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <?php foreach ($_selectAlasanSakit as $as): ?>
                                            <?php if($rS->AlasanID == $as->AlasanID): ?>
                                                <option value="<?= $as->AlasanID?>" selected><?= $as->Alasan?></option>
                                            <?php else: ?>
                                                <option value="<?= $as->AlasanID?>"><?= $as->Alasan?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Jenis Sakit</label>
                                    <div class="col-md-7">
                                        <div class="radio radio-success">
                                            <input type="radio" id="radioInputNonKK" value="0" name="radioJenisSakit" <?= ($rS->KecelakaanKerja == 0? 'checked': '')?> >
                                            <label for="radioInputNonKK"> Non Kecelakaan Kerja </label>
                                        </div>
                                        <div class="radio radio-danger">
                                            <input type="radio" id="radioInputKK" value="1" name="radioJenisSakit" <?= ($rS->KecelakaanKerja == 1? 'checked': '')?> >
                                            <label for="radioInputKK"> Kecelakaan Kerja </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Level</label>
                                    <div class="col-md-7">
                                        <select id="selInputLevelKK" name="selLevelKK" disabled="" class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <option value="Ringan" <?= ($rS->LevelKK == 'Ringan'? 'selected': '')?> >Ringan</option>
                                            <option value="Sedang" <?= ($rS->LevelKK == 'Sedang'? 'selected': '')?> >Sedang</option>
                                            <option value="Berat" <?= ($rS->LevelKK == 'Berat'? 'selected': '')?> >Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Kirim ke P2K3</label>
                                    <div class="col-md-7">
                                        <div class="radio radio-danger">
                                            <input type="radio" id="radioInputTdkKirim" value="0" name="radioKirimP2K3" <?= ($rS->KirimP2K3 == 0? 'checked': '')?> >
                                            <label for="radioInputTdkKirim"> Tidak </label>
                                        </div>
                                        <div class="radio radio-success">
                                            <input type="radio" id="radioInputKirim" value="1" name="radioKirimP2K3" <?= ($rS->KirimP2K3 == 1? 'checked': '')?> >
                                            <label for="radioInputKirim"> Kirim </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 ">
                            <hr style="border:0;height:2px;background-image:linear-gradient(to right,rgba(0,0,0,0),rgba(125, 115, 191, 1),rgba(107, 95, 181, 1));">
                            <div class="col-sm-6">
                                <button id="btnBack" type="button" class="btn btn-sm btn-danger waves-effect waves-light">Close</button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button id="btnSubmit" type="button" class="btn btn-sm btn-success waves-effect waves-light">Update</button>
                                <button id="btnCancel" type="reset" class="btn btn-sm btn-warning waves-effect waves-light">Cancel</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlSubmit   = '<?=  base_url()?>SuratSakit/updateSuratSakitKaryawan',
        urlCekData  = '<?=  base_url()?>SuratSakit/checkSuratSakitForUpdate',
        valJnsSrat  = '<?= $rS->JenisSurat?>';
</script>
<script type="text/javascript" src="<?= base_url()?>assets/app/klinik/surat_sakit/input_karyawan/update.js"></script>