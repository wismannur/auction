<?php

// tanggal
// auc_number
// start_bid
// close_bid
// lot_number
// chop
// grade
// estate
// sack
// netto
// open_bid
// highest_bid
// auction_status

?>
<?php if ($v_auction_list_admin->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_v_auction_list_adminmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($v_auction_list_admin->tanggal->Visible) { // tanggal ?>
		<tr id="r_tanggal">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->tanggal->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->tanggal->CellAttributes() ?>>
<span id="el_v_auction_list_admin_tanggal">
<span<?php echo $v_auction_list_admin->tanggal->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->tanggal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->auc_number->Visible) { // auc_number ?>
		<tr id="r_auc_number">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->auc_number->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->auc_number->CellAttributes() ?>>
<span id="el_v_auction_list_admin_auc_number">
<span<?php echo $v_auction_list_admin->auc_number->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->auc_number->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->start_bid->Visible) { // start_bid ?>
		<tr id="r_start_bid">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->start_bid->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->start_bid->CellAttributes() ?>>
<span id="el_v_auction_list_admin_start_bid">
<span<?php echo $v_auction_list_admin->start_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->start_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->close_bid->Visible) { // close_bid ?>
		<tr id="r_close_bid">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->close_bid->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->close_bid->CellAttributes() ?>>
<span id="el_v_auction_list_admin_close_bid">
<span<?php echo $v_auction_list_admin->close_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->close_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->lot_number->Visible) { // lot_number ?>
		<tr id="r_lot_number">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->lot_number->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->lot_number->CellAttributes() ?>>
<span id="el_v_auction_list_admin_lot_number">
<span<?php echo $v_auction_list_admin->lot_number->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->lot_number->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->chop->Visible) { // chop ?>
		<tr id="r_chop">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->chop->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->chop->CellAttributes() ?>>
<span id="el_v_auction_list_admin_chop">
<span<?php echo $v_auction_list_admin->chop->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->chop->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->grade->Visible) { // grade ?>
		<tr id="r_grade">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->grade->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->grade->CellAttributes() ?>>
<span id="el_v_auction_list_admin_grade">
<span<?php echo $v_auction_list_admin->grade->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->grade->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->estate->Visible) { // estate ?>
		<tr id="r_estate">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->estate->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->estate->CellAttributes() ?>>
<span id="el_v_auction_list_admin_estate">
<span<?php echo $v_auction_list_admin->estate->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->estate->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->sack->Visible) { // sack ?>
		<tr id="r_sack">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->sack->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->sack->CellAttributes() ?>>
<span id="el_v_auction_list_admin_sack">
<span<?php echo $v_auction_list_admin->sack->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->sack->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->netto->Visible) { // netto ?>
		<tr id="r_netto">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->netto->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->netto->CellAttributes() ?>>
<span id="el_v_auction_list_admin_netto">
<span<?php echo $v_auction_list_admin->netto->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->netto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->open_bid->Visible) { // open_bid ?>
		<tr id="r_open_bid">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->open_bid->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->open_bid->CellAttributes() ?>>
<span id="el_v_auction_list_admin_open_bid">
<span<?php echo $v_auction_list_admin->open_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->open_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->highest_bid->Visible) { // highest_bid ?>
		<tr id="r_highest_bid">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->highest_bid->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->highest_bid->CellAttributes() ?>>
<span id="el_v_auction_list_admin_highest_bid">
<span<?php echo $v_auction_list_admin->highest_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->highest_bid->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($v_auction_list_admin->auction_status->Visible) { // auction_status ?>
		<tr id="r_auction_status">
			<td class="col-sm-2"><?php echo $v_auction_list_admin->auction_status->FldCaption() ?></td>
			<td<?php echo $v_auction_list_admin->auction_status->CellAttributes() ?>>
<span id="el_v_auction_list_admin_auction_status">
<span<?php echo $v_auction_list_admin->auction_status->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->auction_status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
