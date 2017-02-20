<?php foreach ($_selectGroup as $r): ?>
<option value="<?= $r->GroupID ?>" <?= (in_array($r->GroupID, $_getArray)? 'selected': '')?>><?= $r->GroupName ?></option>
<?php endforeach;