<?php

// Global variable for table object
$v_proforma = NULL;

//
// Table class for v_proforma
//
class cv_proforma extends cTable {
	var $row_id;
	var $proforma_number;
	var $auc_number;
	var $start_bid;
	var $lot_number;
	var $chop;
	var $estate;
	var $grade;
	var $sack;
	var $netto;
	var $gross;
	var $proforma_amount;
	var $currency;
	var $rate;
	var $winner_id;
	var $sold_bid;
	var $proforma_status;
	var $btn_pay;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_proforma';
		$this->TableName = 'v_proforma';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v_proforma`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// row_id
		$this->row_id = new cField('v_proforma', 'v_proforma', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = TRUE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;

		// proforma_number
		$this->proforma_number = new cField('v_proforma', 'v_proforma', 'x_proforma_number', 'proforma_number', '`proforma_number`', '`proforma_number`', 200, -1, FALSE, '`proforma_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_number->Sortable = TRUE; // Allow sort
		$this->fields['proforma_number'] = &$this->proforma_number;

		// auc_number
		$this->auc_number = new cField('v_proforma', 'v_proforma', 'x_auc_number', 'auc_number', '`auc_number`', '`auc_number`', 200, -1, FALSE, '`auc_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_number->Sortable = TRUE; // Allow sort
		$this->fields['auc_number'] = &$this->auc_number;

		// start_bid
		$this->start_bid = new cField('v_proforma', 'v_proforma', 'x_start_bid', 'start_bid', '`start_bid`', ew_CastDateFieldForLike('`start_bid`', 1, "DB"), 135, 1, FALSE, '`start_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->start_bid->Sortable = TRUE; // Allow sort
		$this->start_bid->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['start_bid'] = &$this->start_bid;

		// lot_number
		$this->lot_number = new cField('v_proforma', 'v_proforma', 'x_lot_number', 'lot_number', '`lot_number`', '`lot_number`', 3, -1, FALSE, '`lot_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lot_number->Sortable = TRUE; // Allow sort
		$this->lot_number->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lot_number'] = &$this->lot_number;

		// chop
		$this->chop = new cField('v_proforma', 'v_proforma', 'x_chop', 'chop', '`chop`', '`chop`', 200, -1, FALSE, '`chop`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chop->Sortable = TRUE; // Allow sort
		$this->fields['chop'] = &$this->chop;

		// estate
		$this->estate = new cField('v_proforma', 'v_proforma', 'x_estate', 'estate', '`estate`', '`estate`', 200, -1, FALSE, '`estate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->estate->Sortable = TRUE; // Allow sort
		$this->fields['estate'] = &$this->estate;

		// grade
		$this->grade = new cField('v_proforma', 'v_proforma', 'x_grade', 'grade', '`grade`', '`grade`', 200, -1, FALSE, '`grade`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grade->Sortable = TRUE; // Allow sort
		$this->fields['grade'] = &$this->grade;

		// sack
		$this->sack = new cField('v_proforma', 'v_proforma', 'x_sack', 'sack', '`sack`', '`sack`', 3, -1, FALSE, '`sack`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sack->Sortable = TRUE; // Allow sort
		$this->sack->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sack'] = &$this->sack;

		// netto
		$this->netto = new cField('v_proforma', 'v_proforma', 'x_netto', 'netto', '`netto`', '`netto`', 5, -1, FALSE, '`netto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->netto->Sortable = TRUE; // Allow sort
		$this->netto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['netto'] = &$this->netto;

		// gross
		$this->gross = new cField('v_proforma', 'v_proforma', 'x_gross', 'gross', '`gross`', '`gross`', 5, -1, FALSE, '`gross`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gross->Sortable = TRUE; // Allow sort
		$this->gross->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['gross'] = &$this->gross;

		// proforma_amount
		$this->proforma_amount = new cField('v_proforma', 'v_proforma', 'x_proforma_amount', 'proforma_amount', '`proforma_amount`', '`proforma_amount`', 5, -1, FALSE, '`proforma_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_amount->Sortable = TRUE; // Allow sort
		$this->proforma_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['proforma_amount'] = &$this->proforma_amount;

		// currency
		$this->currency = new cField('v_proforma', 'v_proforma', 'x_currency', 'currency', '`currency`', '`currency`', 200, -1, FALSE, '`currency`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->currency->Sortable = TRUE; // Allow sort
		$this->currency->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->currency->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->currency->OptionCount = 3;
		$this->fields['currency'] = &$this->currency;

		// rate
		$this->rate = new cField('v_proforma', 'v_proforma', 'x_rate', 'rate', '`rate`', '`rate`', 5, -1, FALSE, '`rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rate->Sortable = TRUE; // Allow sort
		$this->rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['rate'] = &$this->rate;

		// winner_id
		$this->winner_id = new cField('v_proforma', 'v_proforma', 'x_winner_id', 'winner_id', '`winner_id`', '`winner_id`', 3, -1, FALSE, '`winner_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->winner_id->Sortable = TRUE; // Allow sort
		$this->winner_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['winner_id'] = &$this->winner_id;

		// sold_bid
		$this->sold_bid = new cField('v_proforma', 'v_proforma', 'x_sold_bid', 'sold_bid', '`sold_bid`', '`sold_bid`', 5, -1, FALSE, '`sold_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sold_bid->Sortable = TRUE; // Allow sort
		$this->sold_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['sold_bid'] = &$this->sold_bid;

		// proforma_status
		$this->proforma_status = new cField('v_proforma', 'v_proforma', 'x_proforma_status', 'proforma_status', '`proforma_status`', '`proforma_status`', 202, -1, FALSE, '`proforma_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->proforma_status->Sortable = TRUE; // Allow sort
		$this->proforma_status->OptionCount = 3;
		$this->fields['proforma_status'] = &$this->proforma_status;

		// btn_pay
		$this->btn_pay = new cField('v_proforma', 'v_proforma', 'x_btn_pay', 'btn_pay', '\'\'', '\'\'', 201, -1, FALSE, '\'\'', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->btn_pay->FldIsCustom = TRUE; // Custom field
		$this->btn_pay->Sortable = TRUE; // Allow sort
		$this->fields['btn_pay'] = &$this->btn_pay;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v_proforma`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT *, '' AS `btn_pay` FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->row_id->setDbValue($conn->Insert_ID());
			$rs['row_id'] = $this->row_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('row_id', $rs))
				ew_AddFilter($where, ew_QuotedName('row_id', $this->DBID) . '=' . ew_QuotedValue($rs['row_id'], $this->row_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`row_id` = @row_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->row_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->row_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@row_id@", ew_AdjustSql($this->row_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "v_proformalist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "v_proformaview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "v_proformaedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "v_proformaadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "v_proformalist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_proformaview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_proformaview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_proformaadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_proformaadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v_proformaedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v_proformaadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_proformadelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "row_id:" . ew_VarToJson($this->row_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->row_id->CurrentValue)) {
			$sUrl .= "row_id=" . urlencode($this->row_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["row_id"]))
				$arKeys[] = $_POST["row_id"];
			elseif (isset($_GET["row_id"]))
				$arKeys[] = $_GET["row_id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->row_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->row_id->setDbValue($rs->fields('row_id'));
		$this->proforma_number->setDbValue($rs->fields('proforma_number'));
		$this->auc_number->setDbValue($rs->fields('auc_number'));
		$this->start_bid->setDbValue($rs->fields('start_bid'));
		$this->lot_number->setDbValue($rs->fields('lot_number'));
		$this->chop->setDbValue($rs->fields('chop'));
		$this->estate->setDbValue($rs->fields('estate'));
		$this->grade->setDbValue($rs->fields('grade'));
		$this->sack->setDbValue($rs->fields('sack'));
		$this->netto->setDbValue($rs->fields('netto'));
		$this->gross->setDbValue($rs->fields('gross'));
		$this->proforma_amount->setDbValue($rs->fields('proforma_amount'));
		$this->currency->setDbValue($rs->fields('currency'));
		$this->rate->setDbValue($rs->fields('rate'));
		$this->winner_id->setDbValue($rs->fields('winner_id'));
		$this->sold_bid->setDbValue($rs->fields('sold_bid'));
		$this->proforma_status->setDbValue($rs->fields('proforma_status'));
		$this->btn_pay->setDbValue($rs->fields('btn_pay'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// row_id
		// proforma_number
		// auc_number
		// start_bid
		// lot_number
		// chop
		// estate
		// grade
		// sack
		// netto
		// gross
		// proforma_amount
		// currency
		// rate
		// winner_id
		// sold_bid
		// proforma_status
		// btn_pay
		// row_id

		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// proforma_number
		$this->proforma_number->ViewValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->CellCssStyle .= "text-align: center;";
		$this->proforma_number->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

		// start_bid
		$this->start_bid->ViewValue = $this->start_bid->CurrentValue;
		$this->start_bid->ViewValue = ew_FormatDateTime($this->start_bid->ViewValue, 1);
		$this->start_bid->CellCssStyle .= "text-align: center;";
		$this->start_bid->ViewCustomAttributes = "";

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->CellCssStyle .= "text-align: center;";
		$this->lot_number->ViewCustomAttributes = "";

		// chop
		$this->chop->ViewValue = $this->chop->CurrentValue;
		$this->chop->CellCssStyle .= "text-align: center;";
		$this->chop->ViewCustomAttributes = "";

		// estate
		$this->estate->ViewValue = $this->estate->CurrentValue;
		$this->estate->ViewCustomAttributes = "";

		// grade
		$this->grade->ViewValue = $this->grade->CurrentValue;
		$this->grade->CellCssStyle .= "text-align: left;";
		$this->grade->ViewCustomAttributes = "";

		// sack
		$this->sack->ViewValue = $this->sack->CurrentValue;
		$this->sack->ViewValue = ew_FormatNumber($this->sack->ViewValue, 0, -2, -2, -2);
		$this->sack->CellCssStyle .= "text-align: right;";
		$this->sack->ViewCustomAttributes = "";

		// netto
		$this->netto->ViewValue = $this->netto->CurrentValue;
		$this->netto->ViewValue = ew_FormatNumber($this->netto->ViewValue, 2, -2, -2, -2);
		$this->netto->CellCssStyle .= "text-align: right;";
		$this->netto->ViewCustomAttributes = "";

		// gross
		$this->gross->ViewValue = $this->gross->CurrentValue;
		$this->gross->ViewValue = ew_FormatNumber($this->gross->ViewValue, 2, -2, -2, -2);
		$this->gross->CellCssStyle .= "text-align: right;";
		$this->gross->ViewCustomAttributes = "";

		// proforma_amount
		$this->proforma_amount->ViewValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->ViewValue = ew_FormatNumber($this->proforma_amount->ViewValue, 2, -2, -2, -2);
		$this->proforma_amount->CellCssStyle .= "text-align: right;";
		$this->proforma_amount->ViewCustomAttributes = "";

		// currency
		if (strval($this->currency->CurrentValue) <> "") {
			$this->currency->ViewValue = $this->currency->OptionCaption($this->currency->CurrentValue);
		} else {
			$this->currency->ViewValue = NULL;
		}
		$this->currency->CellCssStyle .= "text-align: center;";
		$this->currency->ViewCustomAttributes = "";

		// rate
		$this->rate->ViewValue = $this->rate->CurrentValue;
		$this->rate->CellCssStyle .= "text-align: right;";
		$this->rate->ViewCustomAttributes = "";

		// winner_id
		$this->winner_id->ViewValue = $this->winner_id->CurrentValue;
		$this->winner_id->ViewCustomAttributes = "";

		// sold_bid
		$this->sold_bid->ViewValue = $this->sold_bid->CurrentValue;
		$this->sold_bid->ViewCustomAttributes = "";

		// proforma_status
		if (strval($this->proforma_status->CurrentValue) <> "") {
			$this->proforma_status->ViewValue = "";
			$arwrk = explode(",", strval($this->proforma_status->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->proforma_status->ViewValue .= $this->proforma_status->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->proforma_status->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->proforma_status->ViewValue = NULL;
		}
		$this->proforma_status->ViewCustomAttributes = "";

		// btn_pay
		$this->btn_pay->ViewValue = $this->btn_pay->CurrentValue;
		$this->btn_pay->ViewCustomAttributes = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

		// proforma_number
		$this->proforma_number->LinkCustomAttributes = "";
		$this->proforma_number->HrefValue = "";
		$this->proforma_number->TooltipValue = "";

		// auc_number
		$this->auc_number->LinkCustomAttributes = "";
		$this->auc_number->HrefValue = "";
		$this->auc_number->TooltipValue = "";

		// start_bid
		$this->start_bid->LinkCustomAttributes = "";
		$this->start_bid->HrefValue = "";
		$this->start_bid->TooltipValue = "";

		// lot_number
		$this->lot_number->LinkCustomAttributes = "";
		$this->lot_number->HrefValue = "";
		$this->lot_number->TooltipValue = "";

		// chop
		$this->chop->LinkCustomAttributes = "";
		$this->chop->HrefValue = "";
		$this->chop->TooltipValue = "";

		// estate
		$this->estate->LinkCustomAttributes = "";
		$this->estate->HrefValue = "";
		$this->estate->TooltipValue = "";

		// grade
		$this->grade->LinkCustomAttributes = "";
		$this->grade->HrefValue = "";
		$this->grade->TooltipValue = "";

		// sack
		$this->sack->LinkCustomAttributes = "";
		$this->sack->HrefValue = "";
		$this->sack->TooltipValue = "";

		// netto
		$this->netto->LinkCustomAttributes = "";
		$this->netto->HrefValue = "";
		$this->netto->TooltipValue = "";

		// gross
		$this->gross->LinkCustomAttributes = "";
		$this->gross->HrefValue = "";
		$this->gross->TooltipValue = "";

		// proforma_amount
		$this->proforma_amount->LinkCustomAttributes = "";
		$this->proforma_amount->HrefValue = "";
		$this->proforma_amount->TooltipValue = "";

		// currency
		$this->currency->LinkCustomAttributes = "";
		$this->currency->HrefValue = "";
		$this->currency->TooltipValue = "";

		// rate
		$this->rate->LinkCustomAttributes = "";
		$this->rate->HrefValue = "";
		$this->rate->TooltipValue = "";

		// winner_id
		$this->winner_id->LinkCustomAttributes = "";
		$this->winner_id->HrefValue = "";
		$this->winner_id->TooltipValue = "";

		// sold_bid
		$this->sold_bid->LinkCustomAttributes = "";
		$this->sold_bid->HrefValue = "";
		$this->sold_bid->TooltipValue = "";

		// proforma_status
		$this->proforma_status->LinkCustomAttributes = "";
		$this->proforma_status->HrefValue = "";
		$this->proforma_status->TooltipValue = "";

		// btn_pay
		$this->btn_pay->LinkCustomAttributes = "";
		$this->btn_pay->HrefValue = "";
		$this->btn_pay->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// row_id
		$this->row_id->EditAttrs["class"] = "form-control";
		$this->row_id->EditCustomAttributes = "";
		$this->row_id->EditValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// proforma_number
		$this->proforma_number->EditAttrs["class"] = "form-control";
		$this->proforma_number->EditCustomAttributes = "";
		$this->proforma_number->EditValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->PlaceHolder = ew_RemoveHtml($this->proforma_number->FldCaption());

		// auc_number
		$this->auc_number->EditAttrs["class"] = "form-control";
		$this->auc_number->EditCustomAttributes = "";
		$this->auc_number->EditValue = $this->auc_number->CurrentValue;
		$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

		// start_bid
		$this->start_bid->EditAttrs["class"] = "form-control";
		$this->start_bid->EditCustomAttributes = "";
		$this->start_bid->EditValue = ew_FormatDateTime($this->start_bid->CurrentValue, 8);
		$this->start_bid->PlaceHolder = ew_RemoveHtml($this->start_bid->FldCaption());

		// lot_number
		$this->lot_number->EditAttrs["class"] = "form-control";
		$this->lot_number->EditCustomAttributes = "";
		$this->lot_number->EditValue = $this->lot_number->CurrentValue;
		$this->lot_number->PlaceHolder = ew_RemoveHtml($this->lot_number->FldCaption());

		// chop
		$this->chop->EditAttrs["class"] = "form-control";
		$this->chop->EditCustomAttributes = "";
		$this->chop->EditValue = $this->chop->CurrentValue;
		$this->chop->PlaceHolder = ew_RemoveHtml($this->chop->FldCaption());

		// estate
		$this->estate->EditAttrs["class"] = "form-control";
		$this->estate->EditCustomAttributes = "";
		$this->estate->EditValue = $this->estate->CurrentValue;
		$this->estate->PlaceHolder = ew_RemoveHtml($this->estate->FldCaption());

		// grade
		$this->grade->EditAttrs["class"] = "form-control";
		$this->grade->EditCustomAttributes = "";
		$this->grade->EditValue = $this->grade->CurrentValue;
		$this->grade->PlaceHolder = ew_RemoveHtml($this->grade->FldCaption());

		// sack
		$this->sack->EditAttrs["class"] = "form-control";
		$this->sack->EditCustomAttributes = "";
		$this->sack->EditValue = $this->sack->CurrentValue;
		$this->sack->PlaceHolder = ew_RemoveHtml($this->sack->FldCaption());

		// netto
		$this->netto->EditAttrs["class"] = "form-control";
		$this->netto->EditCustomAttributes = "";
		$this->netto->EditValue = $this->netto->CurrentValue;
		$this->netto->PlaceHolder = ew_RemoveHtml($this->netto->FldCaption());
		if (strval($this->netto->EditValue) <> "" && is_numeric($this->netto->EditValue)) $this->netto->EditValue = ew_FormatNumber($this->netto->EditValue, -2, -2, -2, -2);

		// gross
		$this->gross->EditAttrs["class"] = "form-control";
		$this->gross->EditCustomAttributes = "";
		$this->gross->EditValue = $this->gross->CurrentValue;
		$this->gross->PlaceHolder = ew_RemoveHtml($this->gross->FldCaption());
		if (strval($this->gross->EditValue) <> "" && is_numeric($this->gross->EditValue)) $this->gross->EditValue = ew_FormatNumber($this->gross->EditValue, -2, -2, -2, -2);

		// proforma_amount
		$this->proforma_amount->EditAttrs["class"] = "form-control";
		$this->proforma_amount->EditCustomAttributes = "";
		$this->proforma_amount->EditValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->PlaceHolder = ew_RemoveHtml($this->proforma_amount->FldCaption());
		if (strval($this->proforma_amount->EditValue) <> "" && is_numeric($this->proforma_amount->EditValue)) $this->proforma_amount->EditValue = ew_FormatNumber($this->proforma_amount->EditValue, -2, -2, -2, -2);

		// currency
		$this->currency->EditCustomAttributes = "";
		$this->currency->EditValue = $this->currency->Options(TRUE);

		// rate
		$this->rate->EditAttrs["class"] = "form-control";
		$this->rate->EditCustomAttributes = "";
		$this->rate->EditValue = $this->rate->CurrentValue;
		$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
		if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) $this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);

		// winner_id
		$this->winner_id->EditAttrs["class"] = "form-control";
		$this->winner_id->EditCustomAttributes = "";
		$this->winner_id->EditValue = $this->winner_id->CurrentValue;
		$this->winner_id->PlaceHolder = ew_RemoveHtml($this->winner_id->FldCaption());

		// sold_bid
		$this->sold_bid->EditAttrs["class"] = "form-control";
		$this->sold_bid->EditCustomAttributes = "";
		$this->sold_bid->EditValue = $this->sold_bid->CurrentValue;
		$this->sold_bid->PlaceHolder = ew_RemoveHtml($this->sold_bid->FldCaption());
		if (strval($this->sold_bid->EditValue) <> "" && is_numeric($this->sold_bid->EditValue)) $this->sold_bid->EditValue = ew_FormatNumber($this->sold_bid->EditValue, -2, -1, -2, 0);

		// proforma_status
		$this->proforma_status->EditCustomAttributes = "";
		$this->proforma_status->EditValue = $this->proforma_status->Options(FALSE);

		// btn_pay
		$this->btn_pay->EditAttrs["class"] = "form-control";
		$this->btn_pay->EditCustomAttributes = "";
		$this->btn_pay->EditValue = $this->btn_pay->CurrentValue;
		$this->btn_pay->PlaceHolder = ew_RemoveHtml($this->btn_pay->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->start_bid->Exportable) $Doc->ExportCaption($this->start_bid);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->netto->Exportable) $Doc->ExportCaption($this->netto);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->currency->Exportable) $Doc->ExportCaption($this->currency);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
					if ($this->winner_id->Exportable) $Doc->ExportCaption($this->winner_id);
					if ($this->sold_bid->Exportable) $Doc->ExportCaption($this->sold_bid);
					if ($this->btn_pay->Exportable) $Doc->ExportCaption($this->btn_pay);
				} else {
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->start_bid->Exportable) $Doc->ExportField($this->start_bid);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->netto->Exportable) $Doc->ExportField($this->netto);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->currency->Exportable) $Doc->ExportField($this->currency);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
						if ($this->winner_id->Exportable) $Doc->ExportField($this->winner_id);
						if ($this->sold_bid->Exportable) $Doc->ExportField($this->sold_bid);
						if ($this->btn_pay->Exportable) $Doc->ExportField($this->btn_pay);
					} else {
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
		// Untuk memfilter view

		ew_AddFilter($filter, "winner_id = '".CurrentUserID()."'"); 
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
