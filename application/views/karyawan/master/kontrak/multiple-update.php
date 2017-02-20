<table class="table-input table-input-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Kontrak</th>
            <th>Tgl Akhir Kontrak</th>
            <th>Masa Kontrak</th>
            <th>Kontrak ke</th>
            <th>Tanggal Medical</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_selectKaryawan as $r): ?>
        <tr>
            <td class="text-center" style="width: 30px"><a href="javascript:;" ><i class="fa fa-trash-o buruk"></i></a></td>
            <td style="width: 10%"><input name="txtArrNIK[]" value="<?= $r->NIK?>" readonly class="txt-table" /></td>
            <td><?= $r->NAMA?></td>
            <td style="width: 10%"><?= date('d-m-Y', strtotime($r->TGLMASUK))?></td>
            <td style="width: 10%"><?= ($r->TglKontrak != NULL? date('d-m-Y', strtotime($r->TglKontrak)): '')?></td>
            <td style="width: 10%"><input name="txtArrTglAkhKontrak[]" value="<?= ($r->TglHabisKontrak != NULL?date('d-m-Y', strtotime($r->TglHabisKontrak)): '')?>" class="txt-table hi-datepicker" required /></td>
            <td style="width: 10%"><input name="txtArrMasaKontrak[]" value="<?= $r->MASAKONTRAK?>" class="txt-table txt-table-num" required /></td>
            <td style="width: 10%"><input name="txtArrKontrakKe[]" value="<?= $r->KontrakKe?>" class="txt-table txt-table-num" required /></td>
            <td style="width: 10%"><input name="txtArrTglMedical[]" value="<?= ($r->TanggalMedical != NULL? date('d-m-Y', strtotime($r->TanggalMedical)): '')?>" class="txt-table hi-datepicker" required /></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>