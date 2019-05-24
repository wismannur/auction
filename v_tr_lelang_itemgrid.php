<?php include_once "membersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($v_tr_lelang_item_grid)) $v_tr_lelang_item_grid = new cv_tr_lelang_item_grid();

// Page init
$v_tr_lelang_item_grid->Page_Init();

// Page main
$v_tr_lelang_item_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_tr_lelang_item_grid->Page_Render();
?>
<?php if ($v_tr_lelang_item->Export == "") { ?>
<script type="text/javascript">

// Form object
var fv_tr_lelang_itemgrid = new ew_Form("fv_tr_lelang_itemgrid", "grid");
fv_tr_lelang_itemgrid.FormKeyCountName = '<?php echo $v_tr_lelang_item_grid->FormKeyCountName ?>';

// Validate form
fv_tr_lelang_itemgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_lot_number");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->lot_number->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->sack->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gross");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->gross->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->open_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->bid_step->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->last_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_highest_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->highest_bid->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fv_tr_lelang_itemgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "req_sample", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lot_number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "chop", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "grade", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jenis", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sack", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gross", false)) return false;
	if (ew_ValueChanged(fobj, infix, "open_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_step", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency", false)) return false;
	if (ew_ValueChanged(fobj, infix, "last_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "highest_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_val", false)) return false;
	if (ew_ValueChanged(fobj, infix, "btn_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "auction_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "winner_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "check_list[]", false)) return false;
	return true;
}

// Form_CustomValidate event
fv_tr_lelang_itemgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_tr_lelang_itemgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_tr_lelang_itemgrid.Lists["x_currency"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_tr_lelang_itemgrid.Lists["x_currency"].Options = <?php echo json_encode($v_tr_lelang_item_grid->currency->Options()) ?>;
fv_tr_lelang_itemgrid.Lists["x_auction_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_tr_lelang_itemgrid.Lists["x_auction_status"].Options = <?php echo json_encode($v_tr_lelang_item_grid->auction_status->Options()) ?>;
fv_tr_lelang_itemgrid.Lists["x_winner_id"] = {"LinkField":"x_user_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_CompanyName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"members"};
fv_tr_lelang_itemgrid.Lists["x_winner_id"].Data = "<?php echo $v_tr_lelang_item_grid->winner_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($v_tr_lelang_item->CurrentAction == "gridadd") {
	if ($v_tr_lelang_item->CurrentMode == "copy") {
		$bSelectLimit = $v_tr_lelang_item_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$v_tr_lelang_item_grid->TotalRecs = $v_tr_lelang_item->ListRecordCount();
			$v_tr_lelang_item_grid->Recordset = $v_tr_lelang_item_grid->LoadRecordset($v_tr_lelang_item_grid->StartRec-1, $v_tr_lelang_item_grid->DisplayRecs);
		} else {
			if ($v_tr_lelang_item_grid->Recordset = $v_tr_lelang_item_grid->LoadRecordset())
				$v_tr_lelang_item_grid->TotalRecs = $v_tr_lelang_item_grid->Recordset->RecordCount();
		}
		$v_tr_lelang_item_grid->StartRec = 1;
		$v_tr_lelang_item_grid->DisplayRecs = $v_tr_lelang_item_grid->TotalRecs;
	} else {
		$v_tr_lelang_item->CurrentFilter = "0=1";
		$v_tr_lelang_item_grid->StartRec = 1;
		$v_tr_lelang_item_grid->DisplayRecs = $v_tr_lelang_item->GridAddRowCount;
	}
	$v_tr_lelang_item_grid->TotalRecs = $v_tr_lelang_item_grid->DisplayRecs;
	$v_tr_lelang_item_grid->StopRec = $v_tr_lelang_item_grid->DisplayRecs;
} else {
	$bSelectLimit = $v_tr_lelang_item_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_tr_lelang_item_grid->TotalRecs <= 0)
			$v_tr_lelang_item_grid->TotalRecs = $v_tr_lelang_item->ListRecordCount();
	} else {
		if (!$v_tr_lelang_item_grid->Recordset && ($v_tr_lelang_item_grid->Recordset = $v_tr_lelang_item_grid->LoadRecordset()))
			$v_tr_lelang_item_grid->TotalRecs = $v_tr_lelang_item_grid->Recordset->RecordCount();
	}
	$v_tr_lelang_item_grid->StartRec = 1;
	$v_tr_lelang_item_grid->DisplayRecs = $v_tr_lelang_item_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$v_tr_lelang_item_grid->Recordset = $v_tr_lelang_item_grid->LoadRecordset($v_tr_lelang_item_grid->StartRec-1, $v_tr_lelang_item_grid->DisplayRecs);

	// Set no record found message
	if ($v_tr_lelang_item->CurrentAction == "" && $v_tr_lelang_item_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_tr_lelang_item_grid->setWarningMessage(ew_DeniedMsg());
		if ($v_tr_lelang_item_grid->SearchWhere == "0=101")
			$v_tr_lelang_item_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_tr_lelang_item_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$v_tr_lelang_item_grid->RenderOtherOptions();
?>
<?php $v_tr_lelang_item_grid->ShowPageHeader(); ?>
<?php
$v_tr_lelang_item_grid->ShowMessage();
?>
<?php if ($v_tr_lelang_item_grid->TotalRecs > 0 || $v_tr_lelang_item->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_tr_lelang_item_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_tr_lelang_item">
<div id="fv_tr_lelang_itemgrid" class="ewForm ewListForm form-inline">
<div id="gmp_v_tr_lelang_item" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_v_tr_lelang_itemgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_tr_lelang_item_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_tr_lelang_item_grid->RenderListOptions();

// Render list options (header, left)
$v_tr_lelang_item_grid->ListOptions->Render("header", "left");
?>
<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->row_id) == "") { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_item->row_id->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->row_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_item->row_id->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->row_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->row_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->row_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->req_sample) == "") { ?>
		<th data-name="req_sample" class="<?php echo $v_tr_lelang_item->req_sample->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->req_sample->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="req_sample" class="<?php echo $v_tr_lelang_item->req_sample->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->req_sample->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->req_sample->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->req_sample->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_tr_lelang_item->lot_number->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_tr_lelang_item->lot_number->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_tr_lelang_item->chop->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_tr_lelang_item->chop->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->chop->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $v_tr_lelang_item->estate->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $v_tr_lelang_item->estate->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->estate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_tr_lelang_item->grade->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_tr_lelang_item->grade->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->grade->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->jenis) == "") { ?>
		<th data-name="jenis" class="<?php echo $v_tr_lelang_item->jenis->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->jenis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis" class="<?php echo $v_tr_lelang_item->jenis->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->jenis->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $v_tr_lelang_item->sack->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $v_tr_lelang_item->sack->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->gross) == "") { ?>
		<th data-name="gross" class="<?php echo $v_tr_lelang_item->gross->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->gross->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gross" class="<?php echo $v_tr_lelang_item->gross->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->gross->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->gross->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->gross->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->open_bid) == "") { ?>
		<th data-name="open_bid" class="<?php echo $v_tr_lelang_item->open_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->open_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="open_bid" class="<?php echo $v_tr_lelang_item->open_bid->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->open_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->open_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->open_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_step) == "") { ?>
		<th data-name="bid_step" class="<?php echo $v_tr_lelang_item->bid_step->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_step->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_step" class="<?php echo $v_tr_lelang_item->bid_step->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_step->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->bid_step->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->bid_step->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->currency) == "") { ?>
		<th data-name="currency" class="<?php echo $v_tr_lelang_item->currency->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->currency->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency" class="<?php echo $v_tr_lelang_item->currency->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->currency->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->currency->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->currency->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->last_bid) == "") { ?>
		<th data-name="last_bid" class="<?php echo $v_tr_lelang_item->last_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->last_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_bid" class="<?php echo $v_tr_lelang_item->last_bid->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->last_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->last_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->last_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->highest_bid) == "") { ?>
		<th data-name="highest_bid" class="<?php echo $v_tr_lelang_item->highest_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->highest_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="highest_bid" class="<?php echo $v_tr_lelang_item->highest_bid->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->highest_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->highest_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->highest_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_val) == "") { ?>
		<th data-name="bid_val" class="<?php echo $v_tr_lelang_item->bid_val->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_val->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_val" class="<?php echo $v_tr_lelang_item->bid_val->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_val->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->bid_val->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->bid_val->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->btn_bid) == "") { ?>
		<th data-name="btn_bid" class="<?php echo $v_tr_lelang_item->btn_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->btn_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="btn_bid" class="<?php echo $v_tr_lelang_item->btn_bid->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->btn_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->btn_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->btn_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->auction_status) == "") { ?>
		<th data-name="auction_status" class="<?php echo $v_tr_lelang_item->auction_status->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->auction_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auction_status" class="<?php echo $v_tr_lelang_item->auction_status->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->auction_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->auction_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->auction_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->winner_id) == "") { ?>
		<th data-name="winner_id" class="<?php echo $v_tr_lelang_item->winner_id->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->winner_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="winner_id" class="<?php echo $v_tr_lelang_item->winner_id->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->winner_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->winner_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->winner_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->check_list) == "") { ?>
		<th data-name="check_list" class="<?php echo $v_tr_lelang_item->check_list->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->check_list->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="check_list" class="<?php echo $v_tr_lelang_item->check_list->HeaderCellClass() ?>"><div><div id="elh_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->check_list->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->check_list->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->check_list->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_tr_lelang_item_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$v_tr_lelang_item_grid->StartRec = 1;
$v_tr_lelang_item_grid->StopRec = $v_tr_lelang_item_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($v_tr_lelang_item_grid->FormKeyCountName) && ($v_tr_lelang_item->CurrentAction == "gridadd" || $v_tr_lelang_item->CurrentAction == "gridedit" || $v_tr_lelang_item->CurrentAction == "F")) {
		$v_tr_lelang_item_grid->KeyCount = $objForm->GetValue($v_tr_lelang_item_grid->FormKeyCountName);
		$v_tr_lelang_item_grid->StopRec = $v_tr_lelang_item_grid->StartRec + $v_tr_lelang_item_grid->KeyCount - 1;
	}
}
$v_tr_lelang_item_grid->RecCnt = $v_tr_lelang_item_grid->StartRec - 1;
if ($v_tr_lelang_item_grid->Recordset && !$v_tr_lelang_item_grid->Recordset->EOF) {
	$v_tr_lelang_item_grid->Recordset->MoveFirst();
	$bSelectLimit = $v_tr_lelang_item_grid->UseSelectLimit;
	if (!$bSelectLimit && $v_tr_lelang_item_grid->StartRec > 1)
		$v_tr_lelang_item_grid->Recordset->Move($v_tr_lelang_item_grid->StartRec - 1);
} elseif (!$v_tr_lelang_item->AllowAddDeleteRow && $v_tr_lelang_item_grid->StopRec == 0) {
	$v_tr_lelang_item_grid->StopRec = $v_tr_lelang_item->GridAddRowCount;
}

// Initialize aggregate
$v_tr_lelang_item->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_tr_lelang_item->ResetAttrs();
$v_tr_lelang_item_grid->RenderRow();
if ($v_tr_lelang_item->CurrentAction == "gridadd")
	$v_tr_lelang_item_grid->RowIndex = 0;
if ($v_tr_lelang_item->CurrentAction == "gridedit")
	$v_tr_lelang_item_grid->RowIndex = 0;
while ($v_tr_lelang_item_grid->RecCnt < $v_tr_lelang_item_grid->StopRec) {
	$v_tr_lelang_item_grid->RecCnt++;
	if (intval($v_tr_lelang_item_grid->RecCnt) >= intval($v_tr_lelang_item_grid->StartRec)) {
		$v_tr_lelang_item_grid->RowCnt++;
		if ($v_tr_lelang_item->CurrentAction == "gridadd" || $v_tr_lelang_item->CurrentAction == "gridedit" || $v_tr_lelang_item->CurrentAction == "F") {
			$v_tr_lelang_item_grid->RowIndex++;
			$objForm->Index = $v_tr_lelang_item_grid->RowIndex;
			if ($objForm->HasValue($v_tr_lelang_item_grid->FormActionName))
				$v_tr_lelang_item_grid->RowAction = strval($objForm->GetValue($v_tr_lelang_item_grid->FormActionName));
			elseif ($v_tr_lelang_item->CurrentAction == "gridadd")
				$v_tr_lelang_item_grid->RowAction = "insert";
			else
				$v_tr_lelang_item_grid->RowAction = "";
		}

		// Set up key count
		$v_tr_lelang_item_grid->KeyCount = $v_tr_lelang_item_grid->RowIndex;

		// Init row class and style
		$v_tr_lelang_item->ResetAttrs();
		$v_tr_lelang_item->CssClass = "";
		if ($v_tr_lelang_item->CurrentAction == "gridadd") {
			if ($v_tr_lelang_item->CurrentMode == "copy") {
				$v_tr_lelang_item_grid->LoadRowValues($v_tr_lelang_item_grid->Recordset); // Load row values
				$v_tr_lelang_item_grid->SetRecordKey($v_tr_lelang_item_grid->RowOldKey, $v_tr_lelang_item_grid->Recordset); // Set old record key
			} else {
				$v_tr_lelang_item_grid->LoadRowValues(); // Load default values
				$v_tr_lelang_item_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$v_tr_lelang_item_grid->LoadRowValues($v_tr_lelang_item_grid->Recordset); // Load row values
		}
		$v_tr_lelang_item->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($v_tr_lelang_item->CurrentAction == "gridadd") // Grid add
			$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
		if ($v_tr_lelang_item->CurrentAction == "gridadd" && $v_tr_lelang_item->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$v_tr_lelang_item_grid->RestoreCurrentRowFormValues($v_tr_lelang_item_grid->RowIndex); // Restore form values
		if ($v_tr_lelang_item->CurrentAction == "gridedit") { // Grid edit
			if ($v_tr_lelang_item->EventCancelled) {
				$v_tr_lelang_item_grid->RestoreCurrentRowFormValues($v_tr_lelang_item_grid->RowIndex); // Restore form values
			}
			if ($v_tr_lelang_item_grid->RowAction == "insert")
				$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$v_tr_lelang_item->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($v_tr_lelang_item->CurrentAction == "gridedit" && ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) && $v_tr_lelang_item->EventCancelled) // Update failed
			$v_tr_lelang_item_grid->RestoreCurrentRowFormValues($v_tr_lelang_item_grid->RowIndex); // Restore form values
		if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) // Edit row
			$v_tr_lelang_item_grid->EditRowCnt++;
		if ($v_tr_lelang_item->CurrentAction == "F") // Confirm row
			$v_tr_lelang_item_grid->RestoreCurrentRowFormValues($v_tr_lelang_item_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$v_tr_lelang_item->RowAttrs = array_merge($v_tr_lelang_item->RowAttrs, array('data-rowindex'=>$v_tr_lelang_item_grid->RowCnt, 'id'=>'r' . $v_tr_lelang_item_grid->RowCnt . '_v_tr_lelang_item', 'data-rowtype'=>$v_tr_lelang_item->RowType));

		// Render row
		$v_tr_lelang_item_grid->RenderRow();

		// Render list options
		$v_tr_lelang_item_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($v_tr_lelang_item_grid->RowAction <> "delete" && $v_tr_lelang_item_grid->RowAction <> "insertdelete" && !($v_tr_lelang_item_grid->RowAction == "insert" && $v_tr_lelang_item->CurrentAction == "F" && $v_tr_lelang_item_grid->EmptyRow())) {
?>
	<tr<?php echo $v_tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_tr_lelang_item_grid->ListOptions->Render("body", "left", $v_tr_lelang_item_grid->RowCnt);
?>
	<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
		<td data-name="row_id"<?php echo $v_tr_lelang_item->row_id->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_row_id" class="form-group v_tr_lelang_item_row_id">
<span<?php echo $v_tr_lelang_item->row_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->row_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->CurrentValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id">
<span<?php echo $v_tr_lelang_item->row_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->row_id->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
		<td data-name="req_sample"<?php echo $v_tr_lelang_item->req_sample->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample">
<span<?php echo $v_tr_lelang_item->req_sample->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->req_sample->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_tr_lelang_item->lot_number->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number">
<span<?php echo $v_tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->lot_number->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_tr_lelang_item->chop->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop">
<span<?php echo $v_tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->chop->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $v_tr_lelang_item->estate->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate">
<span<?php echo $v_tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->estate->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_tr_lelang_item->grade->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade">
<span<?php echo $v_tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->grade->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis"<?php echo $v_tr_lelang_item->jenis->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis">
<span<?php echo $v_tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->jenis->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $v_tr_lelang_item->sack->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack">
<span<?php echo $v_tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->sack->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross"<?php echo $v_tr_lelang_item->gross->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross">
<span<?php echo $v_tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->gross->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid"<?php echo $v_tr_lelang_item->open_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid">
<span<?php echo $v_tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->open_bid->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step"<?php echo $v_tr_lelang_item->bid_step->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step">
<span<?php echo $v_tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->bid_step->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency"<?php echo $v_tr_lelang_item->currency->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency">
<span<?php echo $v_tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->currency->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
		<td data-name="last_bid"<?php echo $v_tr_lelang_item->last_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid">
<span<?php echo $v_tr_lelang_item->last_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->last_bid->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
		<td data-name="highest_bid"<?php echo $v_tr_lelang_item->highest_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid">
<span<?php echo $v_tr_lelang_item->highest_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->highest_bid->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
		<td data-name="bid_val"<?php echo $v_tr_lelang_item->bid_val->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val">
<span<?php echo $v_tr_lelang_item->bid_val->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->bid_val->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
		<td data-name="btn_bid"<?php echo $v_tr_lelang_item->btn_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid">
<span<?php echo $v_tr_lelang_item->btn_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->btn_bid->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
		<td data-name="auction_status"<?php echo $v_tr_lelang_item->auction_status->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_auction_status") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_auction_status") ?>
</div></div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status">
<span<?php echo $v_tr_lelang_item->auction_status->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->auction_status->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
		<td data-name="winner_id"<?php echo $v_tr_lelang_item->winner_id->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id") ?>
</select>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id") ?>
</select>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id">
<span<?php echo $v_tr_lelang_item->winner_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
		<td data-name="check_list"<?php echo $v_tr_lelang_item->check_list->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_check_list[]") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_check_list[]") ?>
</div></div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_grid->RowCnt ?>_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list">
<span<?php echo $v_tr_lelang_item->check_list->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->check_list->ListViewValue() ?></span>
</span>
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" id="fv_tr_lelang_itemgrid$x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->FormValue) ?>">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="fv_tr_lelang_itemgrid$o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_tr_lelang_item_grid->ListOptions->Render("body", "right", $v_tr_lelang_item_grid->RowCnt);
?>
	</tr>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD || $v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fv_tr_lelang_itemgrid.UpdateOpts(<?php echo $v_tr_lelang_item_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($v_tr_lelang_item->CurrentAction <> "gridadd" || $v_tr_lelang_item->CurrentMode == "copy")
		if (!$v_tr_lelang_item_grid->Recordset->EOF) $v_tr_lelang_item_grid->Recordset->MoveNext();
}
?>
<?php
	if ($v_tr_lelang_item->CurrentMode == "add" || $v_tr_lelang_item->CurrentMode == "copy" || $v_tr_lelang_item->CurrentMode == "edit") {
		$v_tr_lelang_item_grid->RowIndex = '$rowindex$';
		$v_tr_lelang_item_grid->LoadRowValues();

		// Set row properties
		$v_tr_lelang_item->ResetAttrs();
		$v_tr_lelang_item->RowAttrs = array_merge($v_tr_lelang_item->RowAttrs, array('data-rowindex'=>$v_tr_lelang_item_grid->RowIndex, 'id'=>'r0_v_tr_lelang_item', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($v_tr_lelang_item->RowAttrs["class"], "ewTemplate");
		$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD;

		// Render row
		$v_tr_lelang_item_grid->RenderRow();

		// Render list options
		$v_tr_lelang_item_grid->RenderListOptions();
		$v_tr_lelang_item_grid->StartRowCnt = 0;
?>
	<tr<?php echo $v_tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_tr_lelang_item_grid->ListOptions->Render("body", "left", $v_tr_lelang_item_grid->RowIndex);
?>
	<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
		<td data-name="row_id">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_row_id" class="form-group v_tr_lelang_item_row_id">
<span<?php echo $v_tr_lelang_item->row_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->row_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
		<td data-name="req_sample">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<span<?php echo $v_tr_lelang_item->req_sample->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->req_sample->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<span<?php echo $v_tr_lelang_item->lot_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->lot_number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<span<?php echo $v_tr_lelang_item->chop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->chop->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<span<?php echo $v_tr_lelang_item->estate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->estate->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<span<?php echo $v_tr_lelang_item->grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->grade->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<span<?php echo $v_tr_lelang_item->jenis->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->jenis->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<span<?php echo $v_tr_lelang_item->sack->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->sack->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<span<?php echo $v_tr_lelang_item->gross->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->gross->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<span<?php echo $v_tr_lelang_item->open_bid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->open_bid->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<span<?php echo $v_tr_lelang_item->bid_step->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->bid_step->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<span<?php echo $v_tr_lelang_item->currency->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->currency->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
		<td data-name="last_bid">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<span<?php echo $v_tr_lelang_item->last_bid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->last_bid->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
		<td data-name="highest_bid">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<span<?php echo $v_tr_lelang_item->highest_bid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->highest_bid->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
		<td data-name="bid_val">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<span<?php echo $v_tr_lelang_item->bid_val->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->bid_val->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
		<td data-name="btn_bid">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<span<?php echo $v_tr_lelang_item->btn_bid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->btn_bid->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
		<td data-name="auction_status">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_auction_status") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<span<?php echo $v_tr_lelang_item->auction_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->auction_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
		<td data-name="winner_id">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<span<?php echo $v_tr_lelang_item->winner_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->winner_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
		<td data-name="check_list">
<?php if ($v_tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_grid->RowIndex}_check_list[]") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<span<?php echo $v_tr_lelang_item->check_list->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->check_list->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" id="x<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" id="o<?php echo $v_tr_lelang_item_grid->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_tr_lelang_item_grid->ListOptions->Render("body", "right", $v_tr_lelang_item_grid->RowIndex);
?>
<script type="text/javascript">
fv_tr_lelang_itemgrid.UpdateOpts(<?php echo $v_tr_lelang_item_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($v_tr_lelang_item->CurrentMode == "add" || $v_tr_lelang_item->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $v_tr_lelang_item_grid->FormKeyCountName ?>" id="<?php echo $v_tr_lelang_item_grid->FormKeyCountName ?>" value="<?php echo $v_tr_lelang_item_grid->KeyCount ?>">
<?php echo $v_tr_lelang_item_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_tr_lelang_item->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $v_tr_lelang_item_grid->FormKeyCountName ?>" id="<?php echo $v_tr_lelang_item_grid->FormKeyCountName ?>" value="<?php echo $v_tr_lelang_item_grid->KeyCount ?>">
<?php echo $v_tr_lelang_item_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_tr_lelang_item->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fv_tr_lelang_itemgrid">
</div>
<?php

// Close recordset
if ($v_tr_lelang_item_grid->Recordset)
	$v_tr_lelang_item_grid->Recordset->Close();
?>
<?php if ($v_tr_lelang_item_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($v_tr_lelang_item_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($v_tr_lelang_item_grid->TotalRecs == 0 && $v_tr_lelang_item->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_tr_lelang_item_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($v_tr_lelang_item->Export == "") { ?>
<script type="text/javascript">
fv_tr_lelang_itemgrid.Init();
</script>
<?php } ?>
<?php
$v_tr_lelang_item_grid->Page_Terminate();
?>
