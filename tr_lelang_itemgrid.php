<?php include_once "membersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tr_lelang_item_grid)) $tr_lelang_item_grid = new ctr_lelang_item_grid();

// Page init
$tr_lelang_item_grid->Page_Init();

// Page main
$tr_lelang_item_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_item_grid->Page_Render();
?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">

// Form object
var ftr_lelang_itemgrid = new ew_Form("ftr_lelang_itemgrid", "grid");
ftr_lelang_itemgrid.FormKeyCountName = '<?php echo $tr_lelang_item_grid->FormKeyCountName ?>';

// Validate form
ftr_lelang_itemgrid.Validate = function() {
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
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->lot_number->FldCaption(), $tr_lelang_item->lot_number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_lot_number");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->lot_number->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_chop");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->chop->FldCaption(), $tr_lelang_item->chop->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_grade");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->grade->FldCaption(), $tr_lelang_item->grade->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->sack->FldCaption(), $tr_lelang_item->sack->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->sack->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_netto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->netto->FldCaption(), $tr_lelang_item->netto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_netto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->netto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gross");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->gross->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->open_bid->FldCaption(), $tr_lelang_item->open_bid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->open_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->bid_step->FldCaption(), $tr_lelang_item->bid_step->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->bid_step->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rate");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->rate->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ftr_lelang_itemgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lot_number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "chop", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "grade", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jenis", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sack", false)) return false;
	if (ew_ValueChanged(fobj, infix, "netto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gross", false)) return false;
	if (ew_ValueChanged(fobj, infix, "open_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_step", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rate", false)) return false;
	return true;
}

// Form_CustomValidate event
ftr_lelang_itemgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_itemgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_itemgrid.Lists["x_currency"] = {"LinkField":"x_id_cur","Ajax":true,"AutoFill":true,"DisplayFields":["x_currency","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tbl_currency"};
ftr_lelang_itemgrid.Lists["x_currency"].Data = "<?php echo $tr_lelang_item_grid->currency->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<script type="text/javascript" src="phpjs/ewscrolltable.js"></script>
<?php } ?>
<?php
if ($tr_lelang_item->CurrentAction == "gridadd") {
	if ($tr_lelang_item->CurrentMode == "copy") {
		$bSelectLimit = $tr_lelang_item_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$tr_lelang_item_grid->TotalRecs = $tr_lelang_item->ListRecordCount();
			$tr_lelang_item_grid->Recordset = $tr_lelang_item_grid->LoadRecordset($tr_lelang_item_grid->StartRec-1, $tr_lelang_item_grid->DisplayRecs);
		} else {
			if ($tr_lelang_item_grid->Recordset = $tr_lelang_item_grid->LoadRecordset())
				$tr_lelang_item_grid->TotalRecs = $tr_lelang_item_grid->Recordset->RecordCount();
		}
		$tr_lelang_item_grid->StartRec = 1;
		$tr_lelang_item_grid->DisplayRecs = $tr_lelang_item_grid->TotalRecs;
	} else {
		$tr_lelang_item->CurrentFilter = "0=1";
		$tr_lelang_item_grid->StartRec = 1;
		$tr_lelang_item_grid->DisplayRecs = $tr_lelang_item->GridAddRowCount;
	}
	$tr_lelang_item_grid->TotalRecs = $tr_lelang_item_grid->DisplayRecs;
	$tr_lelang_item_grid->StopRec = $tr_lelang_item_grid->DisplayRecs;
} else {
	$bSelectLimit = $tr_lelang_item_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tr_lelang_item_grid->TotalRecs <= 0)
			$tr_lelang_item_grid->TotalRecs = $tr_lelang_item->ListRecordCount();
	} else {
		if (!$tr_lelang_item_grid->Recordset && ($tr_lelang_item_grid->Recordset = $tr_lelang_item_grid->LoadRecordset()))
			$tr_lelang_item_grid->TotalRecs = $tr_lelang_item_grid->Recordset->RecordCount();
	}
	$tr_lelang_item_grid->StartRec = 1;
	$tr_lelang_item_grid->DisplayRecs = $tr_lelang_item_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tr_lelang_item_grid->Recordset = $tr_lelang_item_grid->LoadRecordset($tr_lelang_item_grid->StartRec-1, $tr_lelang_item_grid->DisplayRecs);

	// Set no record found message
	if ($tr_lelang_item->CurrentAction == "" && $tr_lelang_item_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$tr_lelang_item_grid->setWarningMessage(ew_DeniedMsg());
		if ($tr_lelang_item_grid->SearchWhere == "0=101")
			$tr_lelang_item_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tr_lelang_item_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tr_lelang_item_grid->RenderOtherOptions();
?>
<?php $tr_lelang_item_grid->ShowPageHeader(); ?>
<?php
$tr_lelang_item_grid->ShowMessage();
?>
<?php if ($tr_lelang_item_grid->TotalRecs > 0 || $tr_lelang_item->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($tr_lelang_item_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> tr_lelang_item">
<div id="ftr_lelang_itemgrid" class="ewForm ewListForm form-inline">
<?php if ($tr_lelang_item_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($tr_lelang_item_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_tr_lelang_item" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_tr_lelang_itemgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$tr_lelang_item_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tr_lelang_item_grid->RenderListOptions();

// Render list options (header, left)
$tr_lelang_item_grid->ListOptions->Render("header", "left");
?>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_chop" class="tr_lelang_item_chop"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_chop" class="tr_lelang_item_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->chop->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_estate" class="tr_lelang_item_estate"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_estate" class="tr_lelang_item_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->estate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_grade" class="tr_lelang_item_grade"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_grade" class="tr_lelang_item_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->grade->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->jenis) == "") { ?>
		<th data-name="jenis" class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_jenis" class="tr_lelang_item_jenis"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->jenis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis" class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_jenis" class="tr_lelang_item_jenis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->jenis->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_sack" class="tr_lelang_item_sack"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_sack" class="tr_lelang_item_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->netto) == "") { ?>
		<th data-name="netto" class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_netto" class="tr_lelang_item_netto"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->netto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="netto" class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_netto" class="tr_lelang_item_netto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->netto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->netto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->netto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->gross) == "") { ?>
		<th data-name="gross" class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_gross" class="tr_lelang_item_gross"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->gross->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gross" class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_gross" class="tr_lelang_item_gross">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->gross->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->gross->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->gross->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->open_bid) == "") { ?>
		<th data-name="open_bid" class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="open_bid" class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->open_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->open_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->currency) == "") { ?>
		<th data-name="currency" class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_currency" class="tr_lelang_item_currency"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->currency->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency" class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_currency" class="tr_lelang_item_currency">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->currency->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->currency->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->currency->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->bid_step) == "") { ?>
		<th data-name="bid_step" class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_step" class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->bid_step->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->bid_step->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->rate) == "") { ?>
		<th data-name="rate" class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_rate" class="tr_lelang_item_rate"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->rate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rate" class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><div><div id="elh_tr_lelang_item_rate" class="tr_lelang_item_rate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->rate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->rate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->rate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tr_lelang_item_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tr_lelang_item_grid->StartRec = 1;
$tr_lelang_item_grid->StopRec = $tr_lelang_item_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tr_lelang_item_grid->FormKeyCountName) && ($tr_lelang_item->CurrentAction == "gridadd" || $tr_lelang_item->CurrentAction == "gridedit" || $tr_lelang_item->CurrentAction == "F")) {
		$tr_lelang_item_grid->KeyCount = $objForm->GetValue($tr_lelang_item_grid->FormKeyCountName);
		$tr_lelang_item_grid->StopRec = $tr_lelang_item_grid->StartRec + $tr_lelang_item_grid->KeyCount - 1;
	}
}
$tr_lelang_item_grid->RecCnt = $tr_lelang_item_grid->StartRec - 1;
if ($tr_lelang_item_grid->Recordset && !$tr_lelang_item_grid->Recordset->EOF) {
	$tr_lelang_item_grid->Recordset->MoveFirst();
	$bSelectLimit = $tr_lelang_item_grid->UseSelectLimit;
	if (!$bSelectLimit && $tr_lelang_item_grid->StartRec > 1)
		$tr_lelang_item_grid->Recordset->Move($tr_lelang_item_grid->StartRec - 1);
} elseif (!$tr_lelang_item->AllowAddDeleteRow && $tr_lelang_item_grid->StopRec == 0) {
	$tr_lelang_item_grid->StopRec = $tr_lelang_item->GridAddRowCount;
}

// Initialize aggregate
$tr_lelang_item->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tr_lelang_item->ResetAttrs();
$tr_lelang_item_grid->RenderRow();
if ($tr_lelang_item->CurrentAction == "gridadd")
	$tr_lelang_item_grid->RowIndex = 0;
if ($tr_lelang_item->CurrentAction == "gridedit")
	$tr_lelang_item_grid->RowIndex = 0;
while ($tr_lelang_item_grid->RecCnt < $tr_lelang_item_grid->StopRec) {
	$tr_lelang_item_grid->RecCnt++;
	if (intval($tr_lelang_item_grid->RecCnt) >= intval($tr_lelang_item_grid->StartRec)) {
		$tr_lelang_item_grid->RowCnt++;
		if ($tr_lelang_item->CurrentAction == "gridadd" || $tr_lelang_item->CurrentAction == "gridedit" || $tr_lelang_item->CurrentAction == "F") {
			$tr_lelang_item_grid->RowIndex++;
			$objForm->Index = $tr_lelang_item_grid->RowIndex;
			if ($objForm->HasValue($tr_lelang_item_grid->FormActionName))
				$tr_lelang_item_grid->RowAction = strval($objForm->GetValue($tr_lelang_item_grid->FormActionName));
			elseif ($tr_lelang_item->CurrentAction == "gridadd")
				$tr_lelang_item_grid->RowAction = "insert";
			else
				$tr_lelang_item_grid->RowAction = "";
		}

		// Set up key count
		$tr_lelang_item_grid->KeyCount = $tr_lelang_item_grid->RowIndex;

		// Init row class and style
		$tr_lelang_item->ResetAttrs();
		$tr_lelang_item->CssClass = "";
		if ($tr_lelang_item->CurrentAction == "gridadd") {
			if ($tr_lelang_item->CurrentMode == "copy") {
				$tr_lelang_item_grid->LoadRowValues($tr_lelang_item_grid->Recordset); // Load row values
				$tr_lelang_item_grid->SetRecordKey($tr_lelang_item_grid->RowOldKey, $tr_lelang_item_grid->Recordset); // Set old record key
			} else {
				$tr_lelang_item_grid->LoadRowValues(); // Load default values
				$tr_lelang_item_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tr_lelang_item_grid->LoadRowValues($tr_lelang_item_grid->Recordset); // Load row values
		}
		$tr_lelang_item->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tr_lelang_item->CurrentAction == "gridadd") // Grid add
			$tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tr_lelang_item->CurrentAction == "gridadd" && $tr_lelang_item->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tr_lelang_item_grid->RestoreCurrentRowFormValues($tr_lelang_item_grid->RowIndex); // Restore form values
		if ($tr_lelang_item->CurrentAction == "gridedit") { // Grid edit
			if ($tr_lelang_item->EventCancelled) {
				$tr_lelang_item_grid->RestoreCurrentRowFormValues($tr_lelang_item_grid->RowIndex); // Restore form values
			}
			if ($tr_lelang_item_grid->RowAction == "insert")
				$tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tr_lelang_item->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tr_lelang_item->CurrentAction == "gridedit" && ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $tr_lelang_item->RowType == EW_ROWTYPE_ADD) && $tr_lelang_item->EventCancelled) // Update failed
			$tr_lelang_item_grid->RestoreCurrentRowFormValues($tr_lelang_item_grid->RowIndex); // Restore form values
		if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tr_lelang_item_grid->EditRowCnt++;
		if ($tr_lelang_item->CurrentAction == "F") // Confirm row
			$tr_lelang_item_grid->RestoreCurrentRowFormValues($tr_lelang_item_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tr_lelang_item->RowAttrs = array_merge($tr_lelang_item->RowAttrs, array('data-rowindex'=>$tr_lelang_item_grid->RowCnt, 'id'=>'r' . $tr_lelang_item_grid->RowCnt . '_tr_lelang_item', 'data-rowtype'=>$tr_lelang_item->RowType));

		// Render row
		$tr_lelang_item_grid->RenderRow();

		// Render list options
		$tr_lelang_item_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tr_lelang_item_grid->RowAction <> "delete" && $tr_lelang_item_grid->RowAction <> "insertdelete" && !($tr_lelang_item_grid->RowAction == "insert" && $tr_lelang_item->CurrentAction == "F" && $tr_lelang_item_grid->EmptyRow())) {
?>
	<tr<?php echo $tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tr_lelang_item_grid->ListOptions->Render("body", "left", $tr_lelang_item_grid->RowCnt);
?>
	<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number">
<span<?php echo $tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $tr_lelang_item->lot_number->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->CurrentValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $tr_lelang_item->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_chop" class="tr_lelang_item_chop">
<span<?php echo $tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $tr_lelang_item->chop->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_estate" class="tr_lelang_item_estate">
<span<?php echo $tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->estate->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_grade" class="tr_lelang_item_grade">
<span<?php echo $tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $tr_lelang_item->grade->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis"<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_jenis" class="tr_lelang_item_jenis">
<span<?php echo $tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $tr_lelang_item->jenis->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_sack" class="tr_lelang_item_sack">
<span<?php echo $tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $tr_lelang_item->sack->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<td data-name="netto"<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_netto" class="tr_lelang_item_netto">
<span<?php echo $tr_lelang_item->netto->ViewAttributes() ?>>
<?php echo $tr_lelang_item->netto->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross"<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_gross" class="tr_lelang_item_gross">
<span<?php echo $tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $tr_lelang_item->gross->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid"<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid">
<span<?php echo $tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_item->open_bid->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency"<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step">
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step">
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_currency" class="tr_lelang_item_currency">
<span<?php echo $tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $tr_lelang_item->currency->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step"<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step">
<span<?php echo $tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $tr_lelang_item->bid_step->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<td data-name="rate"<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_grid->RowCnt ?>_tr_lelang_item_rate" class="tr_lelang_item_rate">
<span<?php echo $tr_lelang_item->rate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->rate->ListViewValue() ?></span>
</span>
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="ftr_lelang_itemgrid$x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->FormValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="ftr_lelang_itemgrid$o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tr_lelang_item_grid->ListOptions->Render("body", "right", $tr_lelang_item_grid->RowCnt);
?>
	</tr>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD || $tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftr_lelang_itemgrid.UpdateOpts(<?php echo $tr_lelang_item_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tr_lelang_item->CurrentAction <> "gridadd" || $tr_lelang_item->CurrentMode == "copy")
		if (!$tr_lelang_item_grid->Recordset->EOF) $tr_lelang_item_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tr_lelang_item->CurrentMode == "add" || $tr_lelang_item->CurrentMode == "copy" || $tr_lelang_item->CurrentMode == "edit") {
		$tr_lelang_item_grid->RowIndex = '$rowindex$';
		$tr_lelang_item_grid->LoadRowValues();

		// Set row properties
		$tr_lelang_item->ResetAttrs();
		$tr_lelang_item->RowAttrs = array_merge($tr_lelang_item->RowAttrs, array('data-rowindex'=>$tr_lelang_item_grid->RowIndex, 'id'=>'r0_tr_lelang_item', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tr_lelang_item->RowAttrs["class"], "ewTemplate");
		$tr_lelang_item->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tr_lelang_item_grid->RenderRow();

		// Render list options
		$tr_lelang_item_grid->RenderListOptions();
		$tr_lelang_item_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tr_lelang_item_grid->ListOptions->Render("body", "left", $tr_lelang_item_grid->RowIndex);
?>
	<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<span<?php echo $tr_lelang_item->lot_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->lot_number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<span<?php echo $tr_lelang_item->chop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->chop->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<span<?php echo $tr_lelang_item->estate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->estate->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<span<?php echo $tr_lelang_item->grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->grade->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<span<?php echo $tr_lelang_item->jenis->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->jenis->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<span<?php echo $tr_lelang_item->sack->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->sack->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<td data-name="netto">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<span<?php echo $tr_lelang_item->netto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->netto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<span<?php echo $tr_lelang_item->gross->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->gross->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<span<?php echo $tr_lelang_item->open_bid->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->open_bid->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_grid->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step">
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<span<?php echo $tr_lelang_item->currency->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->currency->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<span<?php echo $tr_lelang_item->bid_step->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->bid_step->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<td data-name="rate">
<?php if ($tr_lelang_item->CurrentAction <> "F") { ?>
<span id="el$rowindex$_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<span<?php echo $tr_lelang_item->rate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tr_lelang_item->rate->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" id="o<?php echo $tr_lelang_item_grid->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tr_lelang_item_grid->ListOptions->Render("body", "right", $tr_lelang_item_grid->RowIndex);
?>
<script type="text/javascript">
ftr_lelang_itemgrid.UpdateOpts(<?php echo $tr_lelang_item_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tr_lelang_item->CurrentMode == "add" || $tr_lelang_item->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tr_lelang_item_grid->FormKeyCountName ?>" id="<?php echo $tr_lelang_item_grid->FormKeyCountName ?>" value="<?php echo $tr_lelang_item_grid->KeyCount ?>">
<?php echo $tr_lelang_item_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tr_lelang_item->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tr_lelang_item_grid->FormKeyCountName ?>" id="<?php echo $tr_lelang_item_grid->FormKeyCountName ?>" value="<?php echo $tr_lelang_item_grid->KeyCount ?>">
<?php echo $tr_lelang_item_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tr_lelang_item->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftr_lelang_itemgrid">
</div>
<?php

// Close recordset
if ($tr_lelang_item_grid->Recordset)
	$tr_lelang_item_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($tr_lelang_item_grid->TotalRecs == 0 && $tr_lelang_item->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tr_lelang_item_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">
ftr_lelang_itemgrid.Init();
</script>
<?php } ?>
<?php
$tr_lelang_item_grid->Page_Terminate();
?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">
ew_ScrollableTable("gmp_tr_lelang_item", "100%", "310px");
</script>
<?php } ?>
