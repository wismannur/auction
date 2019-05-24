<?php include_once "membersinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($v_bid_histories_admin_grid)) $v_bid_histories_admin_grid = new cv_bid_histories_admin_grid();

// Page init
$v_bid_histories_admin_grid->Page_Init();

// Page main
$v_bid_histories_admin_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_bid_histories_admin_grid->Page_Render();
?>
<?php if ($v_bid_histories_admin->Export == "") { ?>
<script type="text/javascript">

// Form object
var fv_bid_histories_admingrid = new ew_Form("fv_bid_histories_admingrid", "grid");
fv_bid_histories_admingrid.FormKeyCountName = '<?php echo $v_bid_histories_admin_grid->FormKeyCountName ?>';

// Validate form
fv_bid_histories_admingrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_bid_histories_admin->lot_number->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_value");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_bid_histories_admin->bid_value->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fv_bid_histories_admingrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lot_number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "chop", false)) return false;
	if (ew_ValueChanged(fobj, infix, "grade", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_value", false)) return false;
	if (ew_ValueChanged(fobj, infix, "CompanyName", false)) return false;
	return true;
}

// Form_CustomValidate event
fv_bid_histories_admingrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_bid_histories_admingrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($v_bid_histories_admin->CurrentAction == "gridadd") {
	if ($v_bid_histories_admin->CurrentMode == "copy") {
		$bSelectLimit = $v_bid_histories_admin_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$v_bid_histories_admin_grid->TotalRecs = $v_bid_histories_admin->ListRecordCount();
			$v_bid_histories_admin_grid->Recordset = $v_bid_histories_admin_grid->LoadRecordset($v_bid_histories_admin_grid->StartRec-1, $v_bid_histories_admin_grid->DisplayRecs);
		} else {
			if ($v_bid_histories_admin_grid->Recordset = $v_bid_histories_admin_grid->LoadRecordset())
				$v_bid_histories_admin_grid->TotalRecs = $v_bid_histories_admin_grid->Recordset->RecordCount();
		}
		$v_bid_histories_admin_grid->StartRec = 1;
		$v_bid_histories_admin_grid->DisplayRecs = $v_bid_histories_admin_grid->TotalRecs;
	} else {
		$v_bid_histories_admin->CurrentFilter = "0=1";
		$v_bid_histories_admin_grid->StartRec = 1;
		$v_bid_histories_admin_grid->DisplayRecs = $v_bid_histories_admin->GridAddRowCount;
	}
	$v_bid_histories_admin_grid->TotalRecs = $v_bid_histories_admin_grid->DisplayRecs;
	$v_bid_histories_admin_grid->StopRec = $v_bid_histories_admin_grid->DisplayRecs;
} else {
	$bSelectLimit = $v_bid_histories_admin_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_bid_histories_admin_grid->TotalRecs <= 0)
			$v_bid_histories_admin_grid->TotalRecs = $v_bid_histories_admin->ListRecordCount();
	} else {
		if (!$v_bid_histories_admin_grid->Recordset && ($v_bid_histories_admin_grid->Recordset = $v_bid_histories_admin_grid->LoadRecordset()))
			$v_bid_histories_admin_grid->TotalRecs = $v_bid_histories_admin_grid->Recordset->RecordCount();
	}
	$v_bid_histories_admin_grid->StartRec = 1;
	$v_bid_histories_admin_grid->DisplayRecs = $v_bid_histories_admin_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$v_bid_histories_admin_grid->Recordset = $v_bid_histories_admin_grid->LoadRecordset($v_bid_histories_admin_grid->StartRec-1, $v_bid_histories_admin_grid->DisplayRecs);

	// Set no record found message
	if ($v_bid_histories_admin->CurrentAction == "" && $v_bid_histories_admin_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_bid_histories_admin_grid->setWarningMessage(ew_DeniedMsg());
		if ($v_bid_histories_admin_grid->SearchWhere == "0=101")
			$v_bid_histories_admin_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_bid_histories_admin_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$v_bid_histories_admin_grid->RenderOtherOptions();
?>
<?php $v_bid_histories_admin_grid->ShowPageHeader(); ?>
<?php
$v_bid_histories_admin_grid->ShowMessage();
?>
<?php if ($v_bid_histories_admin_grid->TotalRecs > 0 || $v_bid_histories_admin->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_bid_histories_admin_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_bid_histories_admin">
<div id="fv_bid_histories_admingrid" class="ewForm ewListForm form-inline">
<?php if ($v_bid_histories_admin_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($v_bid_histories_admin_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_v_bid_histories_admin" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_v_bid_histories_admingrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_bid_histories_admin_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_bid_histories_admin_grid->RenderListOptions();

// Render list options (header, left)
$v_bid_histories_admin_grid->ListOptions->Render("header", "left");
?>
<?php if ($v_bid_histories_admin->lot_number->Visible) { // lot_number ?>
	<?php if ($v_bid_histories_admin->SortUrl($v_bid_histories_admin->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_bid_histories_admin->lot_number->HeaderCellClass() ?>"><div id="elh_v_bid_histories_admin_lot_number" class="v_bid_histories_admin_lot_number"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_bid_histories_admin->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_bid_histories_admin->lot_number->HeaderCellClass() ?>"><div><div id="elh_v_bid_histories_admin_lot_number" class="v_bid_histories_admin_lot_number">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_bid_histories_admin->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_bid_histories_admin->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_bid_histories_admin->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_bid_histories_admin->chop->Visible) { // chop ?>
	<?php if ($v_bid_histories_admin->SortUrl($v_bid_histories_admin->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_bid_histories_admin->chop->HeaderCellClass() ?>"><div id="elh_v_bid_histories_admin_chop" class="v_bid_histories_admin_chop"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_bid_histories_admin->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_bid_histories_admin->chop->HeaderCellClass() ?>"><div><div id="elh_v_bid_histories_admin_chop" class="v_bid_histories_admin_chop">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_bid_histories_admin->chop->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_bid_histories_admin->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_bid_histories_admin->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_bid_histories_admin->grade->Visible) { // grade ?>
	<?php if ($v_bid_histories_admin->SortUrl($v_bid_histories_admin->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_bid_histories_admin->grade->HeaderCellClass() ?>"><div id="elh_v_bid_histories_admin_grade" class="v_bid_histories_admin_grade"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_bid_histories_admin->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_bid_histories_admin->grade->HeaderCellClass() ?>"><div><div id="elh_v_bid_histories_admin_grade" class="v_bid_histories_admin_grade">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_bid_histories_admin->grade->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_bid_histories_admin->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_bid_histories_admin->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_bid_histories_admin->bid_value->Visible) { // bid_value ?>
	<?php if ($v_bid_histories_admin->SortUrl($v_bid_histories_admin->bid_value) == "") { ?>
		<th data-name="bid_value" class="<?php echo $v_bid_histories_admin->bid_value->HeaderCellClass() ?>"><div id="elh_v_bid_histories_admin_bid_value" class="v_bid_histories_admin_bid_value"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_bid_histories_admin->bid_value->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_value" class="<?php echo $v_bid_histories_admin->bid_value->HeaderCellClass() ?>"><div><div id="elh_v_bid_histories_admin_bid_value" class="v_bid_histories_admin_bid_value">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_bid_histories_admin->bid_value->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_bid_histories_admin->bid_value->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_bid_histories_admin->bid_value->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_bid_histories_admin->CompanyName->Visible) { // CompanyName ?>
	<?php if ($v_bid_histories_admin->SortUrl($v_bid_histories_admin->CompanyName) == "") { ?>
		<th data-name="CompanyName" class="<?php echo $v_bid_histories_admin->CompanyName->HeaderCellClass() ?>"><div id="elh_v_bid_histories_admin_CompanyName" class="v_bid_histories_admin_CompanyName"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_bid_histories_admin->CompanyName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CompanyName" class="<?php echo $v_bid_histories_admin->CompanyName->HeaderCellClass() ?>"><div><div id="elh_v_bid_histories_admin_CompanyName" class="v_bid_histories_admin_CompanyName">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_bid_histories_admin->CompanyName->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_bid_histories_admin->CompanyName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_bid_histories_admin->CompanyName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_bid_histories_admin_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$v_bid_histories_admin_grid->StartRec = 1;
$v_bid_histories_admin_grid->StopRec = $v_bid_histories_admin_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($v_bid_histories_admin_grid->FormKeyCountName) && ($v_bid_histories_admin->CurrentAction == "gridadd" || $v_bid_histories_admin->CurrentAction == "gridedit" || $v_bid_histories_admin->CurrentAction == "F")) {
		$v_bid_histories_admin_grid->KeyCount = $objForm->GetValue($v_bid_histories_admin_grid->FormKeyCountName);
		$v_bid_histories_admin_grid->StopRec = $v_bid_histories_admin_grid->StartRec + $v_bid_histories_admin_grid->KeyCount - 1;
	}
}
$v_bid_histories_admin_grid->RecCnt = $v_bid_histories_admin_grid->StartRec - 1;
if ($v_bid_histories_admin_grid->Recordset && !$v_bid_histories_admin_grid->Recordset->EOF) {
	$v_bid_histories_admin_grid->Recordset->MoveFirst();
	$bSelectLimit = $v_bid_histories_admin_grid->UseSelectLimit;
	if (!$bSelectLimit && $v_bid_histories_admin_grid->StartRec > 1)
		$v_bid_histories_admin_grid->Recordset->Move($v_bid_histories_admin_grid->StartRec - 1);
} elseif (!$v_bid_histories_admin->AllowAddDeleteRow && $v_bid_histories_admin_grid->StopRec == 0) {
	$v_bid_histories_admin_grid->StopRec = $v_bid_histories_admin->GridAddRowCount;
}

// Initialize aggregate
$v_bid_histories_admin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_bid_histories_admin->ResetAttrs();
$v_bid_histories_admin_grid->RenderRow();
if ($v_bid_histories_admin->CurrentAction == "gridadd")
	$v_bid_histories_admin_grid->RowIndex = 0;
if ($v_bid_histories_admin->CurrentAction == "gridedit")
	$v_bid_histories_admin_grid->RowIndex = 0;
while ($v_bid_histories_admin_grid->RecCnt < $v_bid_histories_admin_grid->StopRec) {
	$v_bid_histories_admin_grid->RecCnt++;
	if (intval($v_bid_histories_admin_grid->RecCnt) >= intval($v_bid_histories_admin_grid->StartRec)) {
		$v_bid_histories_admin_grid->RowCnt++;
		if ($v_bid_histories_admin->CurrentAction == "gridadd" || $v_bid_histories_admin->CurrentAction == "gridedit" || $v_bid_histories_admin->CurrentAction == "F") {
			$v_bid_histories_admin_grid->RowIndex++;
			$objForm->Index = $v_bid_histories_admin_grid->RowIndex;
			if ($objForm->HasValue($v_bid_histories_admin_grid->FormActionName))
				$v_bid_histories_admin_grid->RowAction = strval($objForm->GetValue($v_bid_histories_admin_grid->FormActionName));
			elseif ($v_bid_histories_admin->CurrentAction == "gridadd")
				$v_bid_histories_admin_grid->RowAction = "insert";
			else
				$v_bid_histories_admin_grid->RowAction = "";
		}

		// Set up key count
		$v_bid_histories_admin_grid->KeyCount = $v_bid_histories_admin_grid->RowIndex;

		// Init row class and style
		$v_bid_histories_admin->ResetAttrs();
		$v_bid_histories_admin->CssClass = "";
		if ($v_bid_histories_admin->CurrentAction == "gridadd") {
			if ($v_bid_histories_admin->CurrentMode == "copy") {
				$v_bid_histories_admin_grid->LoadRowValues($v_bid_histories_admin_grid->Recordset); // Load row values
				$v_bid_histories_admin_grid->SetRecordKey($v_bid_histories_admin_grid->RowOldKey, $v_bid_histories_admin_grid->Recordset); // Set old record key
			} else {
				$v_bid_histories_admin_grid->LoadRowValues(); // Load default values
				$v_bid_histories_admin_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$v_bid_histories_admin_grid->LoadRowValues($v_bid_histories_admin_grid->Recordset); // Load row values
		}
		$v_bid_histories_admin->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($v_bid_histories_admin->CurrentAction == "gridadd") // Grid add
			$v_bid_histories_admin->RowType = EW_ROWTYPE_ADD; // Render add
		if ($v_bid_histories_admin->CurrentAction == "gridadd" && $v_bid_histories_admin->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$v_bid_histories_admin_grid->RestoreCurrentRowFormValues($v_bid_histories_admin_grid->RowIndex); // Restore form values
		if ($v_bid_histories_admin->CurrentAction == "gridedit") { // Grid edit
			if ($v_bid_histories_admin->EventCancelled) {
				$v_bid_histories_admin_grid->RestoreCurrentRowFormValues($v_bid_histories_admin_grid->RowIndex); // Restore form values
			}
			if ($v_bid_histories_admin_grid->RowAction == "insert")
				$v_bid_histories_admin->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$v_bid_histories_admin->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($v_bid_histories_admin->CurrentAction == "gridedit" && ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT || $v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) && $v_bid_histories_admin->EventCancelled) // Update failed
			$v_bid_histories_admin_grid->RestoreCurrentRowFormValues($v_bid_histories_admin_grid->RowIndex); // Restore form values
		if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) // Edit row
			$v_bid_histories_admin_grid->EditRowCnt++;
		if ($v_bid_histories_admin->CurrentAction == "F") // Confirm row
			$v_bid_histories_admin_grid->RestoreCurrentRowFormValues($v_bid_histories_admin_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$v_bid_histories_admin->RowAttrs = array_merge($v_bid_histories_admin->RowAttrs, array('data-rowindex'=>$v_bid_histories_admin_grid->RowCnt, 'id'=>'r' . $v_bid_histories_admin_grid->RowCnt . '_v_bid_histories_admin', 'data-rowtype'=>$v_bid_histories_admin->RowType));

		// Render row
		$v_bid_histories_admin_grid->RenderRow();

		// Render list options
		$v_bid_histories_admin_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($v_bid_histories_admin_grid->RowAction <> "delete" && $v_bid_histories_admin_grid->RowAction <> "insertdelete" && !($v_bid_histories_admin_grid->RowAction == "insert" && $v_bid_histories_admin->CurrentAction == "F" && $v_bid_histories_admin_grid->EmptyRow())) {
?>
	<tr<?php echo $v_bid_histories_admin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_bid_histories_admin_grid->ListOptions->Render("body", "left", $v_bid_histories_admin_grid->RowCnt);
?>
	<?php if ($v_bid_histories_admin->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_bid_histories_admin->lot_number->CellAttributes() ?>>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_lot_number" class="form-group v_bid_histories_admin_lot_number">
<input type="text" data-table="v_bid_histories_admin" data-field="x_lot_number" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->lot_number->EditValue ?>"<?php echo $v_bid_histories_admin->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_lot_number" class="form-group v_bid_histories_admin_lot_number">
<input type="text" data-table="v_bid_histories_admin" data-field="x_lot_number" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->lot_number->EditValue ?>"<?php echo $v_bid_histories_admin->lot_number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_lot_number" class="v_bid_histories_admin_lot_number">
<span<?php echo $v_bid_histories_admin->lot_number->ViewAttributes() ?>>
<?php echo $v_bid_histories_admin->lot_number->ListViewValue() ?></span>
</span>
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_row_id" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->row_id->CurrentValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_row_id" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->row_id->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT || $v_bid_histories_admin->CurrentMode == "edit") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_row_id" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->row_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($v_bid_histories_admin->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_bid_histories_admin->chop->CellAttributes() ?>>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_chop" class="form-group v_bid_histories_admin_chop">
<input type="text" data-table="v_bid_histories_admin" data-field="x_chop" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->chop->EditValue ?>"<?php echo $v_bid_histories_admin->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_chop" class="form-group v_bid_histories_admin_chop">
<input type="text" data-table="v_bid_histories_admin" data-field="x_chop" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->chop->EditValue ?>"<?php echo $v_bid_histories_admin->chop->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_chop" class="v_bid_histories_admin_chop">
<span<?php echo $v_bid_histories_admin->chop->ViewAttributes() ?>>
<?php echo $v_bid_histories_admin->chop->ListViewValue() ?></span>
</span>
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_bid_histories_admin->grade->CellAttributes() ?>>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_grade" class="form-group v_bid_histories_admin_grade">
<input type="text" data-table="v_bid_histories_admin" data-field="x_grade" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->grade->EditValue ?>"<?php echo $v_bid_histories_admin->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_grade" class="form-group v_bid_histories_admin_grade">
<input type="text" data-table="v_bid_histories_admin" data-field="x_grade" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->grade->EditValue ?>"<?php echo $v_bid_histories_admin->grade->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_grade" class="v_bid_histories_admin_grade">
<span<?php echo $v_bid_histories_admin->grade->ViewAttributes() ?>>
<?php echo $v_bid_histories_admin->grade->ListViewValue() ?></span>
</span>
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->bid_value->Visible) { // bid_value ?>
		<td data-name="bid_value"<?php echo $v_bid_histories_admin->bid_value->CellAttributes() ?>>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_bid_value" class="form-group v_bid_histories_admin_bid_value">
<input type="text" data-table="v_bid_histories_admin" data-field="x_bid_value" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" size="30" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->bid_value->EditValue ?>"<?php echo $v_bid_histories_admin->bid_value->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_bid_value" class="form-group v_bid_histories_admin_bid_value">
<input type="text" data-table="v_bid_histories_admin" data-field="x_bid_value" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" size="30" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->bid_value->EditValue ?>"<?php echo $v_bid_histories_admin->bid_value->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_bid_value" class="v_bid_histories_admin_bid_value">
<span<?php echo $v_bid_histories_admin->bid_value->ViewAttributes() ?>>
<?php echo $v_bid_histories_admin->bid_value->ListViewValue() ?></span>
</span>
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->CompanyName->Visible) { // CompanyName ?>
		<td data-name="CompanyName"<?php echo $v_bid_histories_admin->CompanyName->CellAttributes() ?>>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_CompanyName" class="form-group v_bid_histories_admin_CompanyName">
<input type="text" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" size="40" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->CompanyName->EditValue ?>"<?php echo $v_bid_histories_admin->CompanyName->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->OldValue) ?>">
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_CompanyName" class="form-group v_bid_histories_admin_CompanyName">
<input type="text" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" size="40" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->CompanyName->EditValue ?>"<?php echo $v_bid_histories_admin->CompanyName->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_bid_histories_admin_grid->RowCnt ?>_v_bid_histories_admin_CompanyName" class="v_bid_histories_admin_CompanyName">
<span<?php echo $v_bid_histories_admin->CompanyName->ViewAttributes() ?>>
<?php echo $v_bid_histories_admin->CompanyName->ListViewValue() ?></span>
</span>
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="fv_bid_histories_admingrid$x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->FormValue) ?>">
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="fv_bid_histories_admingrid$o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_bid_histories_admin_grid->ListOptions->Render("body", "right", $v_bid_histories_admin_grid->RowCnt);
?>
	</tr>
<?php if ($v_bid_histories_admin->RowType == EW_ROWTYPE_ADD || $v_bid_histories_admin->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fv_bid_histories_admingrid.UpdateOpts(<?php echo $v_bid_histories_admin_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($v_bid_histories_admin->CurrentAction <> "gridadd" || $v_bid_histories_admin->CurrentMode == "copy")
		if (!$v_bid_histories_admin_grid->Recordset->EOF) $v_bid_histories_admin_grid->Recordset->MoveNext();
}
?>
<?php
	if ($v_bid_histories_admin->CurrentMode == "add" || $v_bid_histories_admin->CurrentMode == "copy" || $v_bid_histories_admin->CurrentMode == "edit") {
		$v_bid_histories_admin_grid->RowIndex = '$rowindex$';
		$v_bid_histories_admin_grid->LoadRowValues();

		// Set row properties
		$v_bid_histories_admin->ResetAttrs();
		$v_bid_histories_admin->RowAttrs = array_merge($v_bid_histories_admin->RowAttrs, array('data-rowindex'=>$v_bid_histories_admin_grid->RowIndex, 'id'=>'r0_v_bid_histories_admin', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($v_bid_histories_admin->RowAttrs["class"], "ewTemplate");
		$v_bid_histories_admin->RowType = EW_ROWTYPE_ADD;

		// Render row
		$v_bid_histories_admin_grid->RenderRow();

		// Render list options
		$v_bid_histories_admin_grid->RenderListOptions();
		$v_bid_histories_admin_grid->StartRowCnt = 0;
?>
	<tr<?php echo $v_bid_histories_admin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_bid_histories_admin_grid->ListOptions->Render("body", "left", $v_bid_histories_admin_grid->RowIndex);
?>
	<?php if ($v_bid_histories_admin->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number">
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_bid_histories_admin_lot_number" class="form-group v_bid_histories_admin_lot_number">
<input type="text" data-table="v_bid_histories_admin" data-field="x_lot_number" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->lot_number->EditValue ?>"<?php echo $v_bid_histories_admin->lot_number->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bid_histories_admin_lot_number" class="form-group v_bid_histories_admin_lot_number">
<span<?php echo $v_bid_histories_admin->lot_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_bid_histories_admin->lot_number->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_lot_number" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->lot_number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->chop->Visible) { // chop ?>
		<td data-name="chop">
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_bid_histories_admin_chop" class="form-group v_bid_histories_admin_chop">
<input type="text" data-table="v_bid_histories_admin" data-field="x_chop" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->chop->EditValue ?>"<?php echo $v_bid_histories_admin->chop->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bid_histories_admin_chop" class="form-group v_bid_histories_admin_chop">
<span<?php echo $v_bid_histories_admin->chop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_bid_histories_admin->chop->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_chop" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->chop->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->grade->Visible) { // grade ?>
		<td data-name="grade">
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_bid_histories_admin_grade" class="form-group v_bid_histories_admin_grade">
<input type="text" data-table="v_bid_histories_admin" data-field="x_grade" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->grade->EditValue ?>"<?php echo $v_bid_histories_admin->grade->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bid_histories_admin_grade" class="form-group v_bid_histories_admin_grade">
<span<?php echo $v_bid_histories_admin->grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_bid_histories_admin->grade->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_grade" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->grade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->bid_value->Visible) { // bid_value ?>
		<td data-name="bid_value">
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_bid_histories_admin_bid_value" class="form-group v_bid_histories_admin_bid_value">
<input type="text" data-table="v_bid_histories_admin" data-field="x_bid_value" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" size="30" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->bid_value->EditValue ?>"<?php echo $v_bid_histories_admin->bid_value->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bid_histories_admin_bid_value" class="form-group v_bid_histories_admin_bid_value">
<span<?php echo $v_bid_histories_admin->bid_value->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_bid_histories_admin->bid_value->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_bid_value" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_bid_value" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->bid_value->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_bid_histories_admin->CompanyName->Visible) { // CompanyName ?>
		<td data-name="CompanyName">
<?php if ($v_bid_histories_admin->CurrentAction <> "F") { ?>
<span id="el$rowindex$_v_bid_histories_admin_CompanyName" class="form-group v_bid_histories_admin_CompanyName">
<input type="text" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" size="40" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->getPlaceHolder()) ?>" value="<?php echo $v_bid_histories_admin->CompanyName->EditValue ?>"<?php echo $v_bid_histories_admin->CompanyName->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_v_bid_histories_admin_CompanyName" class="form-group v_bid_histories_admin_CompanyName">
<span<?php echo $v_bid_histories_admin->CompanyName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_bid_histories_admin->CompanyName->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="x<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="v_bid_histories_admin" data-field="x_CompanyName" name="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" id="o<?php echo $v_bid_histories_admin_grid->RowIndex ?>_CompanyName" value="<?php echo ew_HtmlEncode($v_bid_histories_admin->CompanyName->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_bid_histories_admin_grid->ListOptions->Render("body", "right", $v_bid_histories_admin_grid->RowIndex);
?>
<script type="text/javascript">
fv_bid_histories_admingrid.UpdateOpts(<?php echo $v_bid_histories_admin_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($v_bid_histories_admin->CurrentMode == "add" || $v_bid_histories_admin->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $v_bid_histories_admin_grid->FormKeyCountName ?>" id="<?php echo $v_bid_histories_admin_grid->FormKeyCountName ?>" value="<?php echo $v_bid_histories_admin_grid->KeyCount ?>">
<?php echo $v_bid_histories_admin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_bid_histories_admin->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $v_bid_histories_admin_grid->FormKeyCountName ?>" id="<?php echo $v_bid_histories_admin_grid->FormKeyCountName ?>" value="<?php echo $v_bid_histories_admin_grid->KeyCount ?>">
<?php echo $v_bid_histories_admin_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($v_bid_histories_admin->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fv_bid_histories_admingrid">
</div>
<?php

// Close recordset
if ($v_bid_histories_admin_grid->Recordset)
	$v_bid_histories_admin_grid->Recordset->Close();
?>
</div>
</div>
<?php } ?>
<?php if ($v_bid_histories_admin_grid->TotalRecs == 0 && $v_bid_histories_admin->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_bid_histories_admin_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($v_bid_histories_admin->Export == "") { ?>
<script type="text/javascript">
fv_bid_histories_admingrid.Init();
</script>
<?php } ?>
<?php
$v_bid_histories_admin_grid->Page_Terminate();
?>
