<?php

// auc_number
// auc_place
// start_bid
// close_bid
// auc_notes
// total_sack
// total_gross
// auc_status

?>
<?php if ($tr_lelang_master->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_tr_lelang_mastermaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($tr_lelang_master->auc_number->Visible) { // auc_number ?>
		<tr id="r_auc_number">
			<td class="col-sm-2"><?php echo $tr_lelang_master->auc_number->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->auc_number->CellAttributes() ?>>
<span id="el_tr_lelang_master_auc_number">
<span<?php echo $tr_lelang_master->auc_number->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_number->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->auc_place->Visible) { // auc_place ?>
		<tr id="r_auc_place">
			<td class="col-sm-2"><?php echo $tr_lelang_master->auc_place->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->auc_place->CellAttributes() ?>>
<span id="el_tr_lelang_master_auc_place">
<span<?php echo $tr_lelang_master->auc_place->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_place->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->start_bid->Visible) { // start_bid ?>
		<tr id="r_start_bid">
			<td class="col-sm-2"><?php echo $tr_lelang_master->start_bid->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->start_bid->CellAttributes() ?>>
<span id="el_tr_lelang_master_start_bid">
<span<?php echo $tr_lelang_master->start_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_master->start_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->close_bid->Visible) { // close_bid ?>
		<tr id="r_close_bid">
			<td class="col-sm-2"><?php echo $tr_lelang_master->close_bid->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->close_bid->CellAttributes() ?>>
<span id="el_tr_lelang_master_close_bid">
<span<?php echo $tr_lelang_master->close_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_master->close_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
		<tr id="r_auc_notes">
			<td class="col-sm-2"><?php echo $tr_lelang_master->auc_notes->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->auc_notes->CellAttributes() ?>>
<span id="el_tr_lelang_master_auc_notes">
<span<?php echo $tr_lelang_master->auc_notes->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_notes->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->total_sack->Visible) { // total_sack ?>
		<tr id="r_total_sack">
			<td class="col-sm-2"><?php echo $tr_lelang_master->total_sack->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->total_sack->CellAttributes() ?>>
<span id="el_tr_lelang_master_total_sack">
<span<?php echo $tr_lelang_master->total_sack->ViewAttributes() ?>>
<?php echo $tr_lelang_master->total_sack->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->total_gross->Visible) { // total_gross ?>
		<tr id="r_total_gross">
			<td class="col-sm-2"><?php echo $tr_lelang_master->total_gross->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->total_gross->CellAttributes() ?>>
<span id="el_tr_lelang_master_total_gross">
<span<?php echo $tr_lelang_master->total_gross->ViewAttributes() ?>>
<?php echo $tr_lelang_master->total_gross->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tr_lelang_master->auc_status->Visible) { // auc_status ?>
		<tr id="r_auc_status">
			<td class="col-sm-2"><?php echo $tr_lelang_master->auc_status->FldCaption() ?></td>
			<td<?php echo $tr_lelang_master->auc_status->CellAttributes() ?>>
<span id="el_tr_lelang_master_auc_status">
<span<?php echo $tr_lelang_master->auc_status->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
