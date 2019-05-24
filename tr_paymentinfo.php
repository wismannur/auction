<?php

// Global variable for table object
$tr_payment = NULL;

//
// Table class for tr_payment
//
class ctr_payment extends cTable {
	var $row_id;
	var $master_id;
	var $invoice_number;
	var $payment_date;
	var $payment_amount;
	var $currency;
	var $bank_from;
	var $bank_account;
	var $rate;
	var $user_id;
	var $slip_file;
	var $notes;
	var $confirmed;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tr_payment';
		$this->TableName = 'tr_payment';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tr_payment`";
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
		$this->row_id = new cField('tr_payment', 'tr_payment', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = TRUE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;

		// master_id
		$this->master_id = new cField('tr_payment', 'tr_payment', 'x_master_id', 'master_id', '`master_id`', '`master_id`', 3, -1, FALSE, '`master_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->master_id->Sortable = TRUE; // Allow sort
		$this->master_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['master_id'] = &$this->master_id;

		// invoice_number
		$this->invoice_number = new cField('tr_payment', 'tr_payment', 'x_invoice_number', 'invoice_number', '`invoice_number`', '`invoice_number`', 200, -1, FALSE, '`invoice_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->invoice_number->Sortable = TRUE; // Allow sort
		$this->fields['invoice_number'] = &$this->invoice_number;

		// payment_date
		$this->payment_date = new cField('tr_payment', 'tr_payment', 'x_payment_date', 'payment_date', '`payment_date`', ew_CastDateFieldForLike('`payment_date`', 7, "DB"), 133, 7, FALSE, '`payment_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->payment_date->Sortable = TRUE; // Allow sort
		$this->payment_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['payment_date'] = &$this->payment_date;

		// payment_amount
		$this->payment_amount = new cField('tr_payment', 'tr_payment', 'x_payment_amount', 'payment_amount', '`payment_amount`', '`payment_amount`', 5, -1, FALSE, '`payment_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->payment_amount->Sortable = TRUE; // Allow sort
		$this->payment_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['payment_amount'] = &$this->payment_amount;

		// currency
		$this->currency = new cField('tr_payment', 'tr_payment', 'x_currency', 'currency', '`currency`', '`currency`', 200, -1, FALSE, '`currency`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->currency->Sortable = TRUE; // Allow sort
		$this->currency->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->currency->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->currency->OptionCount = 3;
		$this->fields['currency'] = &$this->currency;

		// bank_from
		$this->bank_from = new cField('tr_payment', 'tr_payment', 'x_bank_from', 'bank_from', '`bank_from`', '`bank_from`', 200, -1, FALSE, '`bank_from`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bank_from->Sortable = TRUE; // Allow sort
		$this->fields['bank_from'] = &$this->bank_from;

		// bank_account
		$this->bank_account = new cField('tr_payment', 'tr_payment', 'x_bank_account', 'bank_account', '`bank_account`', '`bank_account`', 200, -1, FALSE, '`bank_account`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bank_account->Sortable = TRUE; // Allow sort
		$this->fields['bank_account'] = &$this->bank_account;

		// rate
		$this->rate = new cField('tr_payment', 'tr_payment', 'x_rate', 'rate', '`rate`', '`rate`', 5, -1, FALSE, '`rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rate->Sortable = TRUE; // Allow sort
		$this->rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['rate'] = &$this->rate;

		// user_id
		$this->user_id = new cField('tr_payment', 'tr_payment', 'x_user_id', 'user_id', '`user_id`', '`user_id`', 3, -1, FALSE, '`user_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_id->Sortable = TRUE; // Allow sort
		$this->user_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['user_id'] = &$this->user_id;

		// slip_file
		$this->slip_file = new cField('tr_payment', 'tr_payment', 'x_slip_file', 'slip_file', '`slip_file`', '`slip_file`', 200, -1, TRUE, '`slip_file`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'FILE');
		$this->slip_file->Sortable = TRUE; // Allow sort
		$this->fields['slip_file'] = &$this->slip_file;

		// notes
		$this->notes = new cField('tr_payment', 'tr_payment', 'x_notes', 'notes', '`notes`', '`notes`', 201, -1, FALSE, '`notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->notes->Sortable = TRUE; // Allow sort
		$this->fields['notes'] = &$this->notes;

		// confirmed
		$this->confirmed = new cField('tr_payment', 'tr_payment', 'x_confirmed', 'confirmed', '`confirmed`', '`confirmed`', 202, -1, FALSE, '`confirmed`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->confirmed->Sortable = TRUE; // Allow sort
		$this->confirmed->FldDataType = EW_DATATYPE_BOOLEAN;
		$this->confirmed->OptionCount = 2;
		$this->fields['confirmed'] = &$this->confirmed;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tr_payment`";
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
			return "tr_paymentlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tr_paymentview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tr_paymentedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tr_paymentadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tr_paymentlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tr_paymentview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tr_paymentview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tr_paymentadd.php?" . $this->UrlParm($parm);
		else
			$url = "tr_paymentadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tr_paymentedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tr_paymentadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tr_paymentdelete.php", $this->UrlParm());
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
		$this->master_id->setDbValue($rs->fields('master_id'));
		$this->invoice_number->setDbValue($rs->fields('invoice_number'));
		$this->payment_date->setDbValue($rs->fields('payment_date'));
		$this->payment_amount->setDbValue($rs->fields('payment_amount'));
		$this->currency->setDbValue($rs->fields('currency'));
		$this->bank_from->setDbValue($rs->fields('bank_from'));
		$this->bank_account->setDbValue($rs->fields('bank_account'));
		$this->rate->setDbValue($rs->fields('rate'));
		$this->user_id->setDbValue($rs->fields('user_id'));
		$this->slip_file->Upload->DbValue = $rs->fields('slip_file');
		$this->notes->setDbValue($rs->fields('notes'));
		$this->confirmed->setDbValue($rs->fields('confirmed'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// row_id
		// master_id
		// invoice_number
		// payment_date
		// payment_amount
		// currency
		// bank_from
		// bank_account
		// rate
		// user_id
		// slip_file
		// notes
		// confirmed
		// row_id

		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// master_id
		$this->master_id->ViewValue = $this->master_id->CurrentValue;
		$this->master_id->ViewCustomAttributes = "";

		// invoice_number
		$this->invoice_number->ViewValue = $this->invoice_number->CurrentValue;
		$this->invoice_number->ViewCustomAttributes = "";

		// payment_date
		$this->payment_date->ViewValue = $this->payment_date->CurrentValue;
		$this->payment_date->ViewValue = ew_FormatDateTime($this->payment_date->ViewValue, 7);
		$this->payment_date->ViewCustomAttributes = "";

		// payment_amount
		$this->payment_amount->ViewValue = $this->payment_amount->CurrentValue;
		$this->payment_amount->ViewCustomAttributes = "";

		// currency
		if (strval($this->currency->CurrentValue) <> "") {
			$this->currency->ViewValue = $this->currency->OptionCaption($this->currency->CurrentValue);
		} else {
			$this->currency->ViewValue = NULL;
		}
		$this->currency->ViewCustomAttributes = "";

		// bank_from
		$this->bank_from->ViewValue = $this->bank_from->CurrentValue;
		$this->bank_from->ViewCustomAttributes = "";

		// bank_account
		$this->bank_account->ViewValue = $this->bank_account->CurrentValue;
		$this->bank_account->ViewCustomAttributes = "";

		// rate
		$this->rate->ViewValue = $this->rate->CurrentValue;
		$this->rate->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// slip_file
		if (!ew_Empty($this->slip_file->Upload->DbValue)) {
			$this->slip_file->ViewValue = $this->slip_file->Upload->DbValue;
		} else {
			$this->slip_file->ViewValue = "";
		}
		$this->slip_file->ViewCustomAttributes = "";

		// notes
		$this->notes->ViewValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

		// confirmed
		if (ew_ConvertToBool($this->confirmed->CurrentValue)) {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(2) <> "" ? $this->confirmed->FldTagCaption(2) : "1";
		} else {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(1) <> "" ? $this->confirmed->FldTagCaption(1) : "0";
		}
		$this->confirmed->ViewCustomAttributes = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

		// master_id
		$this->master_id->LinkCustomAttributes = "";
		$this->master_id->HrefValue = "";
		$this->master_id->TooltipValue = "";

		// invoice_number
		$this->invoice_number->LinkCustomAttributes = "";
		$this->invoice_number->HrefValue = "";
		$this->invoice_number->TooltipValue = "";

		// payment_date
		$this->payment_date->LinkCustomAttributes = "";
		$this->payment_date->HrefValue = "";
		$this->payment_date->TooltipValue = "";

		// payment_amount
		$this->payment_amount->LinkCustomAttributes = "";
		$this->payment_amount->HrefValue = "";
		$this->payment_amount->TooltipValue = "";

		// currency
		$this->currency->LinkCustomAttributes = "";
		$this->currency->HrefValue = "";
		$this->currency->TooltipValue = "";

		// bank_from
		$this->bank_from->LinkCustomAttributes = "";
		$this->bank_from->HrefValue = "";
		$this->bank_from->TooltipValue = "";

		// bank_account
		$this->bank_account->LinkCustomAttributes = "";
		$this->bank_account->HrefValue = "";
		$this->bank_account->TooltipValue = "";

		// rate
		$this->rate->LinkCustomAttributes = "";
		$this->rate->HrefValue = "";
		$this->rate->TooltipValue = "";

		// user_id
		$this->user_id->LinkCustomAttributes = "";
		$this->user_id->HrefValue = "";
		$this->user_id->TooltipValue = "";

		// slip_file
		$this->slip_file->LinkCustomAttributes = "";
		$this->slip_file->HrefValue = "";
		$this->slip_file->HrefValue2 = $this->slip_file->UploadPath . $this->slip_file->Upload->DbValue;
		$this->slip_file->TooltipValue = "";

		// notes
		$this->notes->LinkCustomAttributes = "";
		$this->notes->HrefValue = "";
		$this->notes->TooltipValue = "";

		// confirmed
		$this->confirmed->LinkCustomAttributes = "";
		$this->confirmed->HrefValue = "";
		$this->confirmed->TooltipValue = "";

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

		// master_id
		$this->master_id->EditAttrs["class"] = "form-control";
		$this->master_id->EditCustomAttributes = "";
		$this->master_id->EditValue = $this->master_id->CurrentValue;
		$this->master_id->PlaceHolder = ew_RemoveHtml($this->master_id->FldCaption());

		// invoice_number
		$this->invoice_number->EditAttrs["class"] = "form-control";
		$this->invoice_number->EditCustomAttributes = "";
		$this->invoice_number->EditValue = $this->invoice_number->CurrentValue;
		$this->invoice_number->PlaceHolder = ew_RemoveHtml($this->invoice_number->FldCaption());

		// payment_date
		$this->payment_date->EditAttrs["class"] = "form-control";
		$this->payment_date->EditCustomAttributes = "";
		$this->payment_date->EditValue = $this->payment_date->CurrentValue;
		$this->payment_date->EditValue = ew_FormatDateTime($this->payment_date->EditValue, 7);
		$this->payment_date->ViewCustomAttributes = "";

		// payment_amount
		$this->payment_amount->EditAttrs["class"] = "form-control";
		$this->payment_amount->EditCustomAttributes = "";
		$this->payment_amount->EditValue = $this->payment_amount->CurrentValue;
		$this->payment_amount->ViewCustomAttributes = "";

		// currency
		$this->currency->EditAttrs["class"] = "form-control";
		$this->currency->EditCustomAttributes = "";
		if (strval($this->currency->CurrentValue) <> "") {
			$this->currency->EditValue = $this->currency->OptionCaption($this->currency->CurrentValue);
		} else {
			$this->currency->EditValue = NULL;
		}
		$this->currency->ViewCustomAttributes = "";

		// bank_from
		$this->bank_from->EditAttrs["class"] = "form-control";
		$this->bank_from->EditCustomAttributes = "";
		$this->bank_from->EditValue = $this->bank_from->CurrentValue;
		$this->bank_from->ViewCustomAttributes = "";

		// bank_account
		$this->bank_account->EditAttrs["class"] = "form-control";
		$this->bank_account->EditCustomAttributes = "";
		$this->bank_account->EditValue = $this->bank_account->CurrentValue;
		$this->bank_account->ViewCustomAttributes = "";

		// rate
		$this->rate->EditAttrs["class"] = "form-control";
		$this->rate->EditCustomAttributes = "";
		$this->rate->EditValue = $this->rate->CurrentValue;
		$this->rate->ViewCustomAttributes = "";

		// user_id
		$this->user_id->EditAttrs["class"] = "form-control";
		$this->user_id->EditCustomAttributes = "";
		$this->user_id->EditValue = $this->user_id->CurrentValue;
		$this->user_id->PlaceHolder = ew_RemoveHtml($this->user_id->FldCaption());

		// slip_file
		$this->slip_file->EditAttrs["class"] = "form-control";
		$this->slip_file->EditCustomAttributes = "";
		if (!ew_Empty($this->slip_file->Upload->DbValue)) {
			$this->slip_file->EditValue = $this->slip_file->Upload->DbValue;
		} else {
			$this->slip_file->EditValue = "";
		}
		$this->slip_file->ViewCustomAttributes = "";

		// notes
		$this->notes->EditAttrs["class"] = "form-control";
		$this->notes->EditCustomAttributes = "";
		$this->notes->EditValue = $this->notes->CurrentValue;
		$this->notes->ViewCustomAttributes = "";

		// confirmed
		$this->confirmed->EditCustomAttributes = "";
		$this->confirmed->EditValue = $this->confirmed->Options(FALSE);

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
					if ($this->payment_amount->Exportable) $Doc->ExportCaption($this->payment_amount);
					if ($this->currency->Exportable) $Doc->ExportCaption($this->currency);
					if ($this->bank_from->Exportable) $Doc->ExportCaption($this->bank_from);
					if ($this->bank_account->Exportable) $Doc->ExportCaption($this->bank_account);
					if ($this->slip_file->Exportable) $Doc->ExportCaption($this->slip_file);
					if ($this->notes->Exportable) $Doc->ExportCaption($this->notes);
					if ($this->confirmed->Exportable) $Doc->ExportCaption($this->confirmed);
				} else {
					if ($this->invoice_number->Exportable) $Doc->ExportCaption($this->invoice_number);
					if ($this->payment_date->Exportable) $Doc->ExportCaption($this->payment_date);
					if ($this->payment_amount->Exportable) $Doc->ExportCaption($this->payment_amount);
					if ($this->currency->Exportable) $Doc->ExportCaption($this->currency);
					if ($this->bank_from->Exportable) $Doc->ExportCaption($this->bank_from);
					if ($this->bank_account->Exportable) $Doc->ExportCaption($this->bank_account);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
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
						if ($this->payment_amount->Exportable) $Doc->ExportField($this->payment_amount);
						if ($this->currency->Exportable) $Doc->ExportField($this->currency);
						if ($this->bank_from->Exportable) $Doc->ExportField($this->bank_from);
						if ($this->bank_account->Exportable) $Doc->ExportField($this->bank_account);
						if ($this->slip_file->Exportable) $Doc->ExportField($this->slip_file);
						if ($this->notes->Exportable) $Doc->ExportField($this->notes);
						if ($this->confirmed->Exportable) $Doc->ExportField($this->confirmed);
					} else {
						if ($this->invoice_number->Exportable) $Doc->ExportField($this->invoice_number);
						if ($this->payment_date->Exportable) $Doc->ExportField($this->payment_date);
						if ($this->payment_amount->Exportable) $Doc->ExportField($this->payment_amount);
						if ($this->currency->Exportable) $Doc->ExportField($this->currency);
						if ($this->bank_from->Exportable) $Doc->ExportField($this->bank_from);
						if ($this->bank_account->Exportable) $Doc->ExportField($this->bank_account);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
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

		$rsnew["invoice_number"] = GetNextInvNumber();
		$rsnew["user_id"] = @$_SESSION["userID"];
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

		if (CurrentPageID() == "add") {
			$this->invoice_number->CurrentValue = GetNextInvNumber();
			$this->invoice_number->EditValue = $this->invoice_number->CurrentValue; 
		}
		$this->invoice_number->ReadOnly = TRUE;	
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
