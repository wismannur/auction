<?php

// Global variable for table object
$v_payment_confirmation = NULL;

//
// Table class for v_payment_confirmation
//
class cv_payment_confirmation extends cTable {
	var $invoice_number;
	var $payment_date;
	var $CompanyName;
	var $bank_from;
	var $payment_amount;
	var $curr_pay;
	var $proforma_number;
	var $proforma_amount;
	var $curr_ar;
	var $auc_number;
	var $lot_number;
	var $chop;
	var $confirmed;
	var $row_id;
	var $user_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_payment_confirmation';
		$this->TableName = 'v_payment_confirmation';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v_payment_confirmation`";
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

		// invoice_number
		$this->invoice_number = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_invoice_number', 'invoice_number', '`invoice_number`', '`invoice_number`', 200, -1, FALSE, '`invoice_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->invoice_number->Sortable = TRUE; // Allow sort
		$this->fields['invoice_number'] = &$this->invoice_number;

		// payment_date
		$this->payment_date = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_payment_date', 'payment_date', '`payment_date`', ew_CastDateFieldForLike('`payment_date`', 7, "DB"), 133, 7, FALSE, '`payment_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->payment_date->Sortable = TRUE; // Allow sort
		$this->payment_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['payment_date'] = &$this->payment_date;

		// CompanyName
		$this->CompanyName = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_CompanyName', 'CompanyName', '`CompanyName`', '`CompanyName`', 200, -1, FALSE, '`CompanyName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CompanyName->Sortable = TRUE; // Allow sort
		$this->fields['CompanyName'] = &$this->CompanyName;

		// bank_from
		$this->bank_from = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_bank_from', 'bank_from', '`bank_from`', '`bank_from`', 200, -1, FALSE, '`bank_from`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bank_from->Sortable = TRUE; // Allow sort
		$this->fields['bank_from'] = &$this->bank_from;

		// payment_amount
		$this->payment_amount = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_payment_amount', 'payment_amount', '`payment_amount`', '`payment_amount`', 5, -1, FALSE, '`payment_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->payment_amount->Sortable = TRUE; // Allow sort
		$this->payment_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['payment_amount'] = &$this->payment_amount;

		// curr_pay
		$this->curr_pay = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_curr_pay', 'curr_pay', '`curr_pay`', '`curr_pay`', 200, -1, FALSE, '`curr_pay`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->curr_pay->Sortable = TRUE; // Allow sort
		$this->fields['curr_pay'] = &$this->curr_pay;

		// proforma_number
		$this->proforma_number = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_proforma_number', 'proforma_number', '`proforma_number`', '`proforma_number`', 200, -1, FALSE, '`proforma_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_number->Sortable = TRUE; // Allow sort
		$this->fields['proforma_number'] = &$this->proforma_number;

		// proforma_amount
		$this->proforma_amount = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_proforma_amount', 'proforma_amount', '`proforma_amount`', '`proforma_amount`', 5, -1, FALSE, '`proforma_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_amount->Sortable = TRUE; // Allow sort
		$this->proforma_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['proforma_amount'] = &$this->proforma_amount;

		// curr_ar
		$this->curr_ar = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_curr_ar', 'curr_ar', '`curr_ar`', '`curr_ar`', 200, -1, FALSE, '`curr_ar`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->curr_ar->Sortable = TRUE; // Allow sort
		$this->fields['curr_ar'] = &$this->curr_ar;

		// auc_number
		$this->auc_number = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_auc_number', 'auc_number', '`auc_number`', '`auc_number`', 200, -1, FALSE, '`auc_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_number->Sortable = TRUE; // Allow sort
		$this->fields['auc_number'] = &$this->auc_number;

		// lot_number
		$this->lot_number = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_lot_number', 'lot_number', '`lot_number`', '`lot_number`', 3, -1, FALSE, '`lot_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lot_number->Sortable = TRUE; // Allow sort
		$this->lot_number->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lot_number'] = &$this->lot_number;

		// chop
		$this->chop = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_chop', 'chop', '`chop`', '`chop`', 200, -1, FALSE, '`chop`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chop->Sortable = TRUE; // Allow sort
		$this->fields['chop'] = &$this->chop;

		// confirmed
		$this->confirmed = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_confirmed', 'confirmed', '`confirmed`', '`confirmed`', 202, -1, FALSE, '`confirmed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->confirmed->Sortable = TRUE; // Allow sort
		$this->confirmed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->confirmed->OptionCount = 2;
		$this->fields['confirmed'] = &$this->confirmed;

		// row_id
		$this->row_id = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = TRUE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;

		// user_id
		$this->user_id = new cField('v_payment_confirmation', 'v_payment_confirmation', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->user_id->Sortable = TRUE; // Allow sort
		$this->user_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->user_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->user_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v_payment_confirmation`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`payment_date` DESC";
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
			return "v_payment_confirmationlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "v_payment_confirmationview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "v_payment_confirmationedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "v_payment_confirmationadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "v_payment_confirmationlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_payment_confirmationview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_payment_confirmationview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_payment_confirmationadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_payment_confirmationadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v_payment_confirmationedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v_payment_confirmationadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_payment_confirmationdelete.php", $this->UrlParm());
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
		$this->invoice_number->setDbValue($rs->fields('invoice_number'));
		$this->payment_date->setDbValue($rs->fields('payment_date'));
		$this->CompanyName->setDbValue($rs->fields('CompanyName'));
		$this->bank_from->setDbValue($rs->fields('bank_from'));
		$this->payment_amount->setDbValue($rs->fields('payment_amount'));
		$this->curr_pay->setDbValue($rs->fields('curr_pay'));
		$this->proforma_number->setDbValue($rs->fields('proforma_number'));
		$this->proforma_amount->setDbValue($rs->fields('proforma_amount'));
		$this->curr_ar->setDbValue($rs->fields('curr_ar'));
		$this->auc_number->setDbValue($rs->fields('auc_number'));
		$this->lot_number->setDbValue($rs->fields('lot_number'));
		$this->chop->setDbValue($rs->fields('chop'));
		$this->confirmed->setDbValue($rs->fields('confirmed'));
		$this->row_id->setDbValue($rs->fields('row_id'));
		$this->user_id->setDbValue($rs->fields('user_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// invoice_number
		// payment_date
		// CompanyName
		// bank_from
		// payment_amount
		// curr_pay
		// proforma_number
		// proforma_amount
		// curr_ar
		// auc_number
		// lot_number
		// chop
		// confirmed
		// row_id
		// user_id
		// invoice_number

		$this->invoice_number->ViewValue = $this->invoice_number->CurrentValue;
		$this->invoice_number->CellCssStyle .= "text-align: center;";
		$this->invoice_number->ViewCustomAttributes = "";

		// payment_date
		$this->payment_date->ViewValue = $this->payment_date->CurrentValue;
		$this->payment_date->ViewValue = ew_FormatDateTime($this->payment_date->ViewValue, 7);
		$this->payment_date->CellCssStyle .= "text-align: center;";
		$this->payment_date->ViewCustomAttributes = "";

		// CompanyName
		$this->CompanyName->ViewValue = $this->CompanyName->CurrentValue;
		$this->CompanyName->ViewCustomAttributes = "";

		// bank_from
		$this->bank_from->ViewValue = $this->bank_from->CurrentValue;
		$this->bank_from->ViewCustomAttributes = "";

		// payment_amount
		$this->payment_amount->ViewValue = $this->payment_amount->CurrentValue;
		$this->payment_amount->ViewValue = ew_FormatNumber($this->payment_amount->ViewValue, 2, -2, -2, -2);
		$this->payment_amount->CellCssStyle .= "text-align: right;";
		$this->payment_amount->ViewCustomAttributes = "";

		// curr_pay
		$this->curr_pay->ViewValue = $this->curr_pay->CurrentValue;
		$this->curr_pay->ViewCustomAttributes = "";

		// proforma_number
		$this->proforma_number->ViewValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->CellCssStyle .= "text-align: center;";
		$this->proforma_number->ViewCustomAttributes = "";

		// proforma_amount
		$this->proforma_amount->ViewValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->ViewValue = ew_FormatNumber($this->proforma_amount->ViewValue, 3, -2, -2, -2);
		$this->proforma_amount->CellCssStyle .= "text-align: right;";
		$this->proforma_amount->ViewCustomAttributes = "";

		// curr_ar
		$this->curr_ar->ViewValue = $this->curr_ar->CurrentValue;
		$this->curr_ar->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->CellCssStyle .= "text-align: center;";
		$this->lot_number->ViewCustomAttributes = "";

		// chop
		$this->chop->ViewValue = $this->chop->CurrentValue;
		$this->chop->ViewCustomAttributes = "";

		// confirmed
		if (ew_ConvertToBool($this->confirmed->CurrentValue)) {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(2) <> "" ? $this->confirmed->FldTagCaption(2) : "1";
		} else {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(1) <> "" ? $this->confirmed->FldTagCaption(1) : "0";
		}
		$this->confirmed->CellCssStyle .= "text-align: center;";
		$this->confirmed->ViewCustomAttributes = "";

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// user_id
		if (strval($this->user_id->CurrentValue) <> "") {
			$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->user_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `user_id`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
		$sWhereWrk = "";
		$this->user_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->user_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->user_id->ViewValue = $this->user_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->user_id->ViewValue = $this->user_id->CurrentValue;
			}
		} else {
			$this->user_id->ViewValue = NULL;
		}
		$this->user_id->ViewCustomAttributes = "";

		// invoice_number
		$this->invoice_number->LinkCustomAttributes = "";
		$this->invoice_number->HrefValue = "";
		$this->invoice_number->TooltipValue = "";

		// payment_date
		$this->payment_date->LinkCustomAttributes = "";
		$this->payment_date->HrefValue = "";
		$this->payment_date->TooltipValue = "";

		// CompanyName
		$this->CompanyName->LinkCustomAttributes = "";
		$this->CompanyName->HrefValue = "";
		$this->CompanyName->TooltipValue = "";

		// bank_from
		$this->bank_from->LinkCustomAttributes = "";
		$this->bank_from->HrefValue = "";
		$this->bank_from->TooltipValue = "";

		// payment_amount
		$this->payment_amount->LinkCustomAttributes = "";
		$this->payment_amount->HrefValue = "";
		$this->payment_amount->TooltipValue = "";

		// curr_pay
		$this->curr_pay->LinkCustomAttributes = "";
		$this->curr_pay->HrefValue = "";
		$this->curr_pay->TooltipValue = "";

		// proforma_number
		$this->proforma_number->LinkCustomAttributes = "";
		$this->proforma_number->HrefValue = "";
		$this->proforma_number->TooltipValue = "";

		// proforma_amount
		$this->proforma_amount->LinkCustomAttributes = "";
		$this->proforma_amount->HrefValue = "";
		$this->proforma_amount->TooltipValue = "";

		// curr_ar
		$this->curr_ar->LinkCustomAttributes = "";
		$this->curr_ar->HrefValue = "";
		$this->curr_ar->TooltipValue = "";

		// auc_number
		$this->auc_number->LinkCustomAttributes = "";
		$this->auc_number->HrefValue = "";
		$this->auc_number->TooltipValue = "";

		// lot_number
		$this->lot_number->LinkCustomAttributes = "";
		$this->lot_number->HrefValue = "";
		$this->lot_number->TooltipValue = "";

		// chop
		$this->chop->LinkCustomAttributes = "";
		$this->chop->HrefValue = "";
		$this->chop->TooltipValue = "";

		// confirmed
		$this->confirmed->LinkCustomAttributes = "";
		$this->confirmed->HrefValue = "";
		$this->confirmed->TooltipValue = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

		// user_id
		$this->user_id->LinkCustomAttributes = "";
		$this->user_id->HrefValue = "";
		$this->user_id->TooltipValue = "";

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

		// invoice_number
		$this->invoice_number->EditAttrs["class"] = "form-control";
		$this->invoice_number->EditCustomAttributes = "";
		$this->invoice_number->EditValue = $this->invoice_number->CurrentValue;
		$this->invoice_number->PlaceHolder = ew_RemoveHtml($this->invoice_number->FldCaption());

		// payment_date
		$this->payment_date->EditAttrs["class"] = "form-control";
		$this->payment_date->EditCustomAttributes = "";
		$this->payment_date->EditValue = ew_FormatDateTime($this->payment_date->CurrentValue, 7);
		$this->payment_date->PlaceHolder = ew_RemoveHtml($this->payment_date->FldCaption());

		// CompanyName
		$this->CompanyName->EditAttrs["class"] = "form-control";
		$this->CompanyName->EditCustomAttributes = "";
		$this->CompanyName->EditValue = $this->CompanyName->CurrentValue;
		$this->CompanyName->PlaceHolder = ew_RemoveHtml($this->CompanyName->FldCaption());

		// bank_from
		$this->bank_from->EditAttrs["class"] = "form-control";
		$this->bank_from->EditCustomAttributes = "";
		$this->bank_from->EditValue = $this->bank_from->CurrentValue;
		$this->bank_from->PlaceHolder = ew_RemoveHtml($this->bank_from->FldCaption());

		// payment_amount
		$this->payment_amount->EditAttrs["class"] = "form-control";
		$this->payment_amount->EditCustomAttributes = "";
		$this->payment_amount->EditValue = $this->payment_amount->CurrentValue;
		$this->payment_amount->PlaceHolder = ew_RemoveHtml($this->payment_amount->FldCaption());
		if (strval($this->payment_amount->EditValue) <> "" && is_numeric($this->payment_amount->EditValue)) $this->payment_amount->EditValue = ew_FormatNumber($this->payment_amount->EditValue, -2, -2, -2, -2);

		// curr_pay
		$this->curr_pay->EditAttrs["class"] = "form-control";
		$this->curr_pay->EditCustomAttributes = "";
		$this->curr_pay->EditValue = $this->curr_pay->CurrentValue;
		$this->curr_pay->PlaceHolder = ew_RemoveHtml($this->curr_pay->FldCaption());

		// proforma_number
		$this->proforma_number->EditAttrs["class"] = "form-control";
		$this->proforma_number->EditCustomAttributes = "";
		$this->proforma_number->EditValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->PlaceHolder = ew_RemoveHtml($this->proforma_number->FldCaption());

		// proforma_amount
		$this->proforma_amount->EditAttrs["class"] = "form-control";
		$this->proforma_amount->EditCustomAttributes = "";
		$this->proforma_amount->EditValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->PlaceHolder = ew_RemoveHtml($this->proforma_amount->FldCaption());
		if (strval($this->proforma_amount->EditValue) <> "" && is_numeric($this->proforma_amount->EditValue)) $this->proforma_amount->EditValue = ew_FormatNumber($this->proforma_amount->EditValue, -2, -2, -2, -2);

		// curr_ar
		$this->curr_ar->EditAttrs["class"] = "form-control";
		$this->curr_ar->EditCustomAttributes = "";
		$this->curr_ar->EditValue = $this->curr_ar->CurrentValue;
		$this->curr_ar->PlaceHolder = ew_RemoveHtml($this->curr_ar->FldCaption());

		// auc_number
		$this->auc_number->EditAttrs["class"] = "form-control";
		$this->auc_number->EditCustomAttributes = "";
		$this->auc_number->EditValue = $this->auc_number->CurrentValue;
		$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

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

		// confirmed
		$this->confirmed->EditCustomAttributes = "";
		$this->confirmed->EditValue = $this->confirmed->Options(FALSE);

		// row_id
		$this->row_id->EditAttrs["class"] = "form-control";
		$this->row_id->EditCustomAttributes = "";
		$this->row_id->EditValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->EditCustomAttributes = "";

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
					if ($this->invoice_number->Exportable) $Doc->ExportCaption($this->invoice_number);
					if ($this->payment_date->Exportable) $Doc->ExportCaption($this->payment_date);
					if ($this->CompanyName->Exportable) $Doc->ExportCaption($this->CompanyName);
					if ($this->bank_from->Exportable) $Doc->ExportCaption($this->bank_from);
					if ($this->payment_amount->Exportable) $Doc->ExportCaption($this->payment_amount);
					if ($this->curr_pay->Exportable) $Doc->ExportCaption($this->curr_pay);
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->curr_ar->Exportable) $Doc->ExportCaption($this->curr_ar);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->confirmed->Exportable) $Doc->ExportCaption($this->confirmed);
					if ($this->row_id->Exportable) $Doc->ExportCaption($this->row_id);
					if ($this->user_id->Exportable) $Doc->ExportCaption($this->user_id);
				} else {
					if ($this->invoice_number->Exportable) $Doc->ExportCaption($this->invoice_number);
					if ($this->payment_date->Exportable) $Doc->ExportCaption($this->payment_date);
					if ($this->CompanyName->Exportable) $Doc->ExportCaption($this->CompanyName);
					if ($this->bank_from->Exportable) $Doc->ExportCaption($this->bank_from);
					if ($this->payment_amount->Exportable) $Doc->ExportCaption($this->payment_amount);
					if ($this->curr_pay->Exportable) $Doc->ExportCaption($this->curr_pay);
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->curr_ar->Exportable) $Doc->ExportCaption($this->curr_ar);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->confirmed->Exportable) $Doc->ExportCaption($this->confirmed);
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
						if ($this->invoice_number->Exportable) $Doc->ExportField($this->invoice_number);
						if ($this->payment_date->Exportable) $Doc->ExportField($this->payment_date);
						if ($this->CompanyName->Exportable) $Doc->ExportField($this->CompanyName);
						if ($this->bank_from->Exportable) $Doc->ExportField($this->bank_from);
						if ($this->payment_amount->Exportable) $Doc->ExportField($this->payment_amount);
						if ($this->curr_pay->Exportable) $Doc->ExportField($this->curr_pay);
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->curr_ar->Exportable) $Doc->ExportField($this->curr_ar);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->confirmed->Exportable) $Doc->ExportField($this->confirmed);
						if ($this->row_id->Exportable) $Doc->ExportField($this->row_id);
						if ($this->user_id->Exportable) $Doc->ExportField($this->user_id);
					} else {
						if ($this->invoice_number->Exportable) $Doc->ExportField($this->invoice_number);
						if ($this->payment_date->Exportable) $Doc->ExportField($this->payment_date);
						if ($this->CompanyName->Exportable) $Doc->ExportField($this->CompanyName);
						if ($this->bank_from->Exportable) $Doc->ExportField($this->bank_from);
						if ($this->payment_amount->Exportable) $Doc->ExportField($this->payment_amount);
						if ($this->curr_pay->Exportable) $Doc->ExportField($this->curr_pay);
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->curr_ar->Exportable) $Doc->ExportField($this->curr_ar);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->confirmed->Exportable) $Doc->ExportField($this->confirmed);
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
