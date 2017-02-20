<?php $k = $_selectKaryawan; ?>
<div class="row">
    <div class="col-md-12"><div class="row">
        <div class="col-sm-4">
            <div class="panel panel-border panel-<?= rand_color()?>">
                <div class="panel-heading">
                    <h3 class="panel-title" style="text-transform: none"><?= ($k->Sex == 'L'? 'Mr. '.ucwords(strtolower($k->NAMA)) : 'Mrs. '.ucwords(strtolower($k->NAMA)))?> [<?= $k->NIK?>]</h3>
                </div>
                <div class="panel-body text-center">
                    <img src="<?= base_url('upload/myAvatar.png')?>" alt="image" class="img-responsive img-thumbnail" width="200">
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-border panel-<?= rand_color()?>">
                <div class="panel-heading">
                    <h3 class="panel-title">Informasi Karyawan</h3>
                </div>
                <div class="panel-body">
                    <div class="text-left">
                        <p class="text-muted font-13"><strong>Perusahaan :</strong> <span class="m-l-15">PT. Pulau Sambu - Guntung</span></p>
                        <p class="text-muted font-13"><strong>Departmen :</strong> <span class="m-l-15"><?= $k->DeptAbbr.' - '.  ucwords(strtolower($k->DeptName))?></span></p>
                        <p class="text-muted font-13"><strong>Jabatan/ Bagian :</strong> <span class="m-l-15"><?= ucwords(strtolower($k->JabatanName)).(is_null($k->JabatanName)? '': '/ '.  ucwords(strtolower($k->JabatanName)))?></span></p>
                        <p class="text-muted font-13"><strong>No. KTP :</strong><span class="m-l-15"><?= $k->NoKTP?></span></p>
                        <p class="text-muted font-13"><strong>Jenis Kelamin :</strong> <span class="m-l-15"><?= ($k->Sex == 'L'? 'Laki-laki': 'Perempuan')?></span></p>
                        <p class="text-muted font-13"><strong>Alamat :</strong> <span class="m-l-15"><?= (is_null($k->ALAMATR)? $k->ALAMATS: $k->ALAMATR)?></span></p>
                        <p class="text-muted font-13"><strong>Tempat Lahir :</strong> <span class="m-l-15"><?= $k->TEMPATLHR?></span></p>
                        <p class="text-muted font-13"><strong>Tanggal Lahir :</strong> <span class="m-l-15"><?= date('F d, Y', strtotime($k->TGLLAHIR))?></span></p>
                        <p class="text-muted font-13"><strong>Usia :</strong> <span class="m-l-15"><?= $k->Usia.' Tahun'?></span></p>
                        <p class="text-muted font-13"><strong>Phone :</strong> <span class="m-l-15"><?= $k->MobilePhone?></span></p>
                        <p class="text-muted font-13"><strong>Tanggal Masuk :</strong> <span class="m-l-15"><?= date('F d, Y', strtotime($k->TGLMASUK))?></span></p>
                        <p class="text-muted font-13"><strong>Tanggal Akhir Kontrak :</strong> <span class="m-l-15"><?= date('F d, Y', strtotime($k->TglHabisKontrak))?></span></p>
                        <p class="text-muted font-13"><strong>Masa Kontrak :</strong> <span class="m-l-15"><?= $k->MASAKONTRAK?></span></p>
                        <p class="text-muted font-13"><strong>Kontrak Ke :</strong> <span class="m-l-15"><?= $k->KontrakKe?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>