<?php
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
                        <a href="#">Klinik</a>
                    </li>
                    <li class="active">
                        Input Surat Sakit
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
                <h3 class="panel-title">Input Surat Sakit Karyawan</h3>
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
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button id="btn-cariNIK" type="button" class="btn btn-sm waves-effect waves-light btn-primary"><i class="fa fa-search"></i></button>
                                        </span>
                                        <input type="text" id="txtInputNIK" name="txtNIK" required class="form-control input-sm" placeholder="Search">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama</label>
                                <div class="col-md-9">
                                    <input id="txtInputNama" name="txtNama" type="text" required class="form-control input-sm txt-header" placeholder="Nama Karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Jabatan</label>
                                <div class="col-md-9">
                                    <input id="txtInputJabatan" name="txtJabatan" type="text" required class="form-control input-sm txt-header" placeholder="Jabatan Karyawan">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Departemen</label>
                                <div class="col-md-9">
                                    <input id="txtInputDept" name="txtDept" type="text" required class="form-control input-sm txt-header" placeholder="Departemen Karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Perusahaan</label>
                                <div class="col-md-9">
                                    <input id="txtInputPT" name="txtPT" type="text" required class="form-control input-sm txt-header" placeholder="Perusahaan Karyawan">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Umur</label>
                                <div class="col-md-8">
                                    <input id="txtInputUmur" name="txtUmur" type="text" required class="form-control input-sm txt-header" placeholder="Umur Karyawan">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Jenis Kelamin</label>
                                <div class="col-md-8">
                                    <select id="selInputJekel" name="selJekel" class="form-control input-sm">
                                        <option value="">Pilih...</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
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
                                        <input id="txtInputTglSurat" name="txtTglSurat" type="text" value="<?= date('d-m-Y')?>" class="form-control input-sm hi-datepicker" readonly>
                                    </div>
                                </div>
                                <div class="form-group form-not-ikd">
                                    <label class="col-md-5 control-label">Tgl Mulai Istirahat</label>
                                    <div class="col-md-7">
                                        <input id="txtInputTglMulai" name="txtTglMulai" type="text" required class="form-control input-sm hi-datepicker">
                                    </div>
                                </div>
                                <div class="form-group form-not-ikd">
                                    <label class="col-md-5 control-label">Lama Istirahat</label>
                                    <div class="col-md-7">
                                        <input id="txtInputDurasi" name="txtDurasi" type="text" required class="form-control input-sm">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Jenis Surat</label>
                                    <div class="col-md-7">
                                        <select id="selInputJenisSurat" name="selJenisSurat" class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <option value="all">Semua</option>
                                            <option value="ikd">Keterangan Dokter</option>
                                            <option value="iss">Surat Sakit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Keterangan Dokter</label>
                                    <div class="col-md-7">
                                        <textarea id="txtInputKetDokter" name="txtKetDokter" readonly="" class="form-control" style="resize: none" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Alasan Sakit</label>
                                    <div class="col-md-7">
                                        <select id="selInputAlasanSakit" name="selAlasanSakit" disabled="" class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <?php foreach ($_selectAlasanSakit as $as): ?>
                                            <option value="<?= $as->AlasanID?>"><?= $as->Alasan?></option>
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
                                            <input type="radio" id="radioInputNonKK" value="0" name="radioJenisSakit" checked="">
                                            <label for="radioInputNonKK"> Non Kecelakaan Kerja </label>
                                        </div>
                                        <div class="radio radio-danger">
                                            <input type="radio" id="radioInputKK" value="1" name="radioJenisSakit" >
                                            <label for="radioInputKK"> Kecelakaan Kerja </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Level</label>
                                    <div class="col-md-7">
                                        <select id="selInputLevelKK" name="selLevelKK" disabled="" class="form-control input-sm">
                                            <option value="">Pilih...</option>
                                            <option value="Ringan">Ringan</option>
                                            <option value="Sedang">Sedang</option>
                                            <option value="Berat">Berat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Kirim ke P2K3</label>
                                    <div class="col-md-7">
                                        <div class="radio radio-danger">
                                            <input type="radio" id="radioInputTdkKirim" value="0" name="radioKirimP2K3" checked="">
                                            <label for="radioInputTdkKirim"> Tidak </label>
                                        </div>
                                        <div class="radio radio-success">
                                            <input type="radio" id="radioInputKirim" value="1" name="radioKirimP2K3" >
                                            <label for="radioInputKirim"> Kirim </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 text-right">
                            <hr style="border:0;height:2px;background-image:linear-gradient(to right,rgba(0,0,0,0),rgba(125, 115, 191, 1),rgba(107, 95, 181, 1));">
                            <button id="btnSubmit" type="button" class="btn btn-sm btn-primary waves-effect waves-light">Simpan</button>
                            <button id="btnCancel" type="reset" class="btn btn-sm btn-warning waves-effect waves-light">Batal</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var urlSubmit   = '<?=  base_url()?>SuratSakit/simpanSuratSakitKaryawan',
        urlGetData  = '<?=  base_url()?>SuratSakit/getDataByNIK',
        urlCekData  = '<?=  base_url()?>SuratSakit/checkSuratSakit';
</script>
<script src="<?= base_url()?>assets/app/klinik/surat_sakit/input_karyawan/index.js?v=AUTO_INCREMENT_VERSION" type="text/javascript"></script>