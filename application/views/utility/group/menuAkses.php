<table id="tbl-menu-akses" class="table table-hover">
    <thead>
        <tr style="background-color: #26a69a; color: #FFF">
            <th><input type="checkbox" class="chk-parent" /></th>
            <th colspan="3">Select Menu</th>
        </tr>
    </thead>
    <tbody>
        <tr class="danger">
            <td style="width: 30px"><input type="checkbox" disabled="" checked /></td>
            <td colspan="3">Dashboard</td>
        </tr>
        <?php foreach ($_selectMenu1 as $r1): ?>
            <?php if ($r1->HaveChild == 1): ?>
                <tr class="danger">
                    <td style="width: 30px"><input name="chkMenuID[]" type="checkbox" value="<?= $r1->MenuID?>" <?= (in_array($r1->MenuID, $_getArray)? 'checked':'')?> class="chk-child" /></td>
                    <td colspan="3"><?= $r1->LabelMenu ?></td>
                </tr>
                <?php foreach ($_selectMenu2 as $r2): ?>
                    <?php if ($r2->HeaderMenu == $r1->MenuID): ?>
                        <?php if ($r2->HaveChild == 1): ?>
                            <tr class="success">
                                <td style="width: 30px"></td>
                                <td style="width: 30px"><input name="chkMenuID[]" type="checkbox" value="<?= $r2->MenuID?>" <?= (in_array($r2->MenuID, $_getArray)? 'checked':'')?> class="chk-child" /></td>
                                <td colspan="2"><?= $r2->LabelMenu ?></td>
                            </tr>
                            <?php foreach ($_selectMenu3 as $r3): ?>
                                <?php if ($r3->HeaderMenu == $r2->MenuID): ?>
                                    <tr class="info">
                                        <td style="width: 30px"></td>
                                        <td style="width: 30px"></td>
                                        <td style="width: 30px"><input name="chkMenuID[]" type="checkbox" value="<?= $r3->MenuID?>" <?= (in_array($r3->MenuID, $_getArray)? 'checked':'')?> class="chk-child" /></td>
                                        <td><?= $r3->LabelMenu ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="success">
                                <td style="width: 30px"></td>
                                <td style="width: 30px"><input name="chkMenuID[]" type="checkbox" value="<?= $r2->MenuID?>" <?= (in_array($r2->MenuID, $_getArray)? 'checked':'')?> class="chk-child" /></td>
                                <td colspan="2"><?= $r2->LabelMenu ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="danger">
                    <td style="width: 30px"><input name="chkMenuID[]" type="checkbox" value="<?= $r1->MenuID?>" <?= (in_array($r1->MenuID, $_getArray)? 'checked':'')?> class="chk-child" /></td>
                    <td colspan="3"><?= $r1->LabelMenu ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $('#tbl-menu-akses').ready( function (){
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
</script>