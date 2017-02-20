<div class="col-md-6">
    <table id="tbl-dept-akses-kary" class="table table-hover">
        <thead>
            <tr style="background-color: #26a69a; color: #FFF">
                <th><input type="checkbox" class="chk-parent" /></th>
                <th>Select Dept Karyawan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectDeptKary as $dKary): ?>
            <tr class="blue">
                <td style="width: 30px"><input name="chkDeptIDkary[]" type="checkbox" value="<?= $dKary->DeptID ?>" <?= (in_array($dKary->DeptID, $_getArrayKary)? 'checked':'')?> class="chk-child" /></td>
                <td><?= strtoupper($dKary->DeptAbbr)." - ".strtoupper($dKary->DeptName) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="col-md-6">
    <table id="tbl-dept-akses-dept" class="table table-hover">
        <thead>
            <tr style="background-color: #26a69a; color: #FFF">
                <th><input type="checkbox" class="chk-parent-boro" /></th>
                <th>Select Dept Borongan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectDeptBoro as $dBoro): ?>
            <tr class="green">
                <td style="width: 30px"><input name="chkDeptIDboro[]" type="checkbox" value="<?= $dBoro->DeptID ?>" <?= (in_array($dBoro->DeptID, $_getArrayBoro)? 'checked':'')?> class="chk-child-boro" /></td>
                <td><?= strtoupper($dBoro->DeptAbbr)." - ".strtoupper($dBoro->DeptName) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#tbl-dept-akses-kary').ready( function (){
        $('.chk-parent').click(function (){
            var th_checked = this.checked;
            if(th_checked){ $('.chk-child').prop('checked', true);}
            else{ $('.chk-child').prop('checked', false);}
        });
        $('.chk-child').click(function (){
            var get = document.getElementsByClassName('chk-child');
            var con = 0;
            for (i=0;i<get.length;i++){
                con += get[i].checked;
            }
            if(con === get.length){ $('.chk-parent').prop('checked', true);}
            else{ $('.chk-parent').prop('checked', false);}
        });
    });
    
    $('#tbl-dept-akses-dept').ready( function (){
        $('.chk-parent-boro').click(function (){
            var th_checked = this.checked;
            if(th_checked){ $('.chk-child-boro').prop('checked', true);}
            else{ $('.chk-child-boro').prop('checked', false);}
        });
        $('.chk-child-boro').click(function (){
            var get = document.getElementsByClassName('chk-child-boro');
            var con = 0;
            for (i=0;i<get.length;i++){
                con += get[i].checked;
            }
            if(con === get.length){ $('.chk-parent-boro').prop('checked', true);}
            else{ $('.chk-parent-boro').prop('checked', false);}
        });
    });
</script>