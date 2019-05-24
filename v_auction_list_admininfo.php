<?php

// Global variable for table object
$v_auction_list_admin = NULL;

//
// Table class for v_auction_list_admin
//
class cv_auction_list_admin extends cTable {
	var $tanggal;
	var $auc_number;
	var $start_bid;
	var $close_bid;
	var $lot_number;
	var $chop;
	var $grade;
	var $estate;
	var $sack;
	var $netto;
	var $open_bid;
	var $last_bid;
	var $highest_bid;
	var $enter_bid;
	var $auction_status;
	var $gross;
	var $row_id;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_auction_list_admin';
		$this->TableName = 'v_auction_list_admin';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v_auction_list_admin`";
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

		// tanggal
		$this->tanggal = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_tanggal', 'tanggal', '`tanggal`', ew_CastDateFieldForLike('`tanggal`', 7, "DB"), 133, 7, FALSE, '`tanggal`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->tanggal->Sortable = TRUE; // Allow sort
		$this->tanggal->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['tanggal'] = &$this->tanggal;

		// auc_number
		$this->auc_number = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_auc_number', 'auc_number', '`auc_number`', '`auc_number`', 200, -1, FALSE, '`auc_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_number->Sortable = TRUE; // Allow sort
		$this->fields['auc_number'] = &$this->auc_number;

		// start_bid
		$this->start_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_start_bid', 'start_bid', '`start_bid`', ew_CastDateFieldForLike('`start_bid`', 11, "DB"), 135, 11, FALSE, '`start_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->start_bid->Sortable = TRUE; // Allow sort
		$this->start_bid->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['start_bid'] = &$this->start_bid;

		// close_bid
		$this->close_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_close_bid', 'close_bid', '`close_bid`', ew_CastDateFieldForLike('`close_bid`', 11, "DB"), 135, 11, FALSE, '`close_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->close_bid->Sortable = TRUE; // Allow sort
		$this->close_bid->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['close_bid'] = &$this->close_bid;

		// lot_number
		$this->lot_number = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_lot_number', 'lot_number', '`lot_number`', '`lot_number`', 3, -1, FALSE, '`lot_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lot_number->Sortable = TRUE; // Allow sort
		$this->lot_number->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lot_number'] = &$this->lot_number;

		// chop
		$this->chop = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_chop', 'chop', '`chop`', '`chop`', 200, -1, FALSE, '`chop`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chop->Sortable = TRUE; // Allow sort
		$this->fields['chop'] = &$this->chop;

		// grade
		$this->grade = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_grade', 'grade', '`grade`', '`grade`', 200, -1, FALSE, '`grade`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grade->Sortable = TRUE; // Allow sort
		$this->fields['grade'] = &$this->grade;

		// estate
		$this->estate = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_estate', 'estate', '`estate`', '`estate`', 200, -1, FALSE, '`estate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->estate->Sortable = TRUE; // Allow sort
		$this->fields['estate'] = &$this->estate;

		// sack
		$this->sack = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_sack', 'sack', '`sack`', '`sack`', 3, -1, FALSE, '`sack`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sack->Sortable = TRUE; // Allow sort
		$this->sack->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sack'] = &$this->sack;

		// netto
		$this->netto = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_netto', 'netto', '`netto`', '`netto`', 5, -1, FALSE, '`netto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->netto->Sortable = TRUE; // Allow sort
		$this->netto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['netto'] = &$this->netto;

		// open_bid
		$this->open_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_open_bid', 'open_bid', '`open_bid`', '`open_bid`', 5, -1, FALSE, '`open_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->open_bid->Sortable = TRUE; // Allow sort
		$this->open_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['open_bid'] = &$this->open_bid;

		// last_bid
		$this->last_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_last_bid', 'last_bid', '`last_bid`', '`last_bid`', 5, -1, FALSE, '`last_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_bid->Sortable = TRUE; // Allow sort
		$this->last_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['last_bid'] = &$this->last_bid;

		// highest_bid
		$this->highest_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_highest_bid', 'highest_bid', '`highest_bid`', '`highest_bid`', 5, -1, FALSE, '`highest_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->highest_bid->Sortable = TRUE; // Allow sort
		$this->highest_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['highest_bid'] = &$this->highest_bid;

		// enter_bid
		$this->enter_bid = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_enter_bid', 'enter_bid', '`enter_bid`', '`enter_bid`', 3, -1, FALSE, '`enter_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->enter_bid->Sortable = TRUE; // Allow sort
		$this->enter_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['enter_bid'] = &$this->enter_bid;

		// auction_status
		$this->auction_status = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_auction_status', 'auction_status', '`auction_status`', '`auction_status`', 202, -1, FALSE, '`auction_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->auction_status->Sortable = TRUE; // Allow sort
		$this->auction_status->OptionCount = 3;
		$this->fields['auction_status'] = &$this->auction_status;

		// gross
		$this->gross = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_gross', 'gross', '`gross`', '`gross`', 5, -1, FALSE, '`gross`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gross->Sortable = TRUE; // Allow sort
		$this->gross->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['gross'] = &$this->gross;

		// row_id
		$this->row_id = new cField('v_auction_list_admin', 'v_auction_list_admin', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = TRUE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;
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

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "v_bid_histories_admin") {
			$sDetailUrl = $GLOBALS["v_bid_histories_admin"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_row_id=" . urlencode($this->row_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "v_auction_list_adminlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v_auction_list_admin`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`tanggal` DESC,`auc_number` DESC";
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
			return "v_auction_list_adminlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "v_auction_list_adminview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "v_auction_list_adminedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "v_auction_list_adminadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "v_auction_list_adminlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_auction_list_adminview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_auction_list_adminview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_auction_list_adminadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_auction_list_adminadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_auction_list_adminedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_auction_list_adminedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_auction_list_adminadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_auction_list_adminadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_auction_list_admindelete.php", $this->UrlParm());
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
		$this->tanggal->setDbValue($rs->fields('tanggal'));
		$this->auc_number->setDbValue($rs->fields('auc_number'));
		$this->start_bid->setDbValue($rs->fields('start_bid'));
		$this->close_bid->setDbValue($rs->fields('close_bid'));
		$this->lot_number->setDbValue($rs->fields('lot_number'));
		$this->chop->setDbValue($rs->fields('chop'));
		$this->grade->setDbValue($rs->fields('grade'));
		$this->estate->setDbValue($rs->fields('estate'));
		$this->sack->setDbValue($rs->fields('sack'));
		$this->netto->setDbValue($rs->fields('netto'));
		$this->open_bid->setDbValue($rs->fields('open_bid'));
		$this->last_bid->setDbValue($rs->fields('last_bid'));
		$this->highest_bid->setDbValue($rs->fields('highest_bid'));
		$this->enter_bid->setDbValue($rs->fields('enter_bid'));
		$this->auction_status->setDbValue($rs->fields('auction_status'));
		$this->gross->setDbValue($rs->fields('gross'));
		$this->row_id->setDbValue($rs->fields('row_id'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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
		// last_bid
		// highest_bid
		// enter_bid
		// auction_status
		// gross
		// row_id
		// tanggal

		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->CellCssStyle .= "text-align: center;";
		$this->tanggal->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

		// start_bid
		$this->start_bid->ViewValue = $this->start_bid->CurrentValue;
		$this->start_bid->ViewValue = ew_FormatDateTime($this->start_bid->ViewValue, 11);
		$this->start_bid->CellCssStyle .= "text-align: center;";
		$this->start_bid->ViewCustomAttributes = "";

		// close_bid
		$this->close_bid->ViewValue = $this->close_bid->CurrentValue;
		$this->close_bid->ViewValue = ew_FormatDateTime($this->close_bid->ViewValue, 11);
		$this->close_bid->CellCssStyle .= "text-align: center;";
		$this->close_bid->ViewCustomAttributes = "";

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->CellCssStyle .= "text-align: center;";
		$this->lot_number->ViewCustomAttributes = "";

		// chop
		$this->chop->ViewValue = $this->chop->CurrentValue;
		$this->chop->ViewCustomAttributes = "";

		// grade
		$this->grade->ViewValue = $this->grade->CurrentValue;
		$this->grade->ViewCustomAttributes = "";

		// estate
		$this->estate->ViewValue = $this->estate->CurrentValue;
		$this->estate->ViewCustomAttributes = "";

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

		// open_bid
		$this->open_bid->ViewValue = $this->open_bid->CurrentValue;
		$this->open_bid->ViewValue = ew_FormatNumber($this->open_bid->ViewValue, 2, -2, -2, -2);
		$this->open_bid->CellCssStyle .= "text-align: right;";
		$this->open_bid->ViewCustomAttributes = "";

		// last_bid
		$this->last_bid->ViewValue = $this->last_bid->CurrentValue;
		$this->last_bid->ViewValue = ew_FormatNumber($this->last_bid->ViewValue, 2, -2, -2, -2);
		$this->last_bid->CellCssStyle .= "text-align: right;";
		$this->last_bid->ViewCustomAttributes = "";

		// highest_bid
		$this->highest_bid->ViewValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->ViewValue = ew_FormatNumber($this->highest_bid->ViewValue, 2, -2, -2, -2);
		$this->highest_bid->CellCssStyle .= "text-align: right;";
		$this->highest_bid->ViewCustomAttributes = "";

		// enter_bid
		$this->enter_bid->ViewValue = $this->enter_bid->CurrentValue;
		$this->enter_bid->ViewValue = ew_FormatNumber($this->enter_bid->ViewValue, 0, -2, -2, -2);
		$this->enter_bid->CellCssStyle .= "text-align: right;";
		$this->enter_bid->ViewCustomAttributes = "";

		// auction_status
		if (strval($this->auction_status->CurrentValue) <> "") {
			$this->auction_status->ViewValue = $this->auction_status->OptionCaption($this->auction_status->CurrentValue);
		} else {
			$this->auction_status->ViewValue = NULL;
		}
		$this->auction_status->CellCssStyle .= "text-align: center;";
		$this->auction_status->ViewCustomAttributes = "";

		// gross
		$this->gross->ViewValue = $this->gross->CurrentValue;
		$this->gross->ViewCustomAttributes = "";

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// tanggal
		$this->tanggal->LinkCustomAttributes = "";
		$this->tanggal->HrefValue = "";
		$this->tanggal->TooltipValue = "";

		// auc_number
		$this->auc_number->LinkCustomAttributes = "";
		$this->auc_number->HrefValue = "";
		$this->auc_number->TooltipValue = "";

		// start_bid
		$this->start_bid->LinkCustomAttributes = "";
		$this->start_bid->HrefValue = "";
		$this->start_bid->TooltipValue = "";

		// close_bid
		$this->close_bid->LinkCustomAttributes = "";
		$this->close_bid->HrefValue = "";
		$this->close_bid->TooltipValue = "";

		// lot_number
		$this->lot_number->LinkCustomAttributes = "";
		$this->lot_number->HrefValue = "";
		$this->lot_number->TooltipValue = "";

		// chop
		$this->chop->LinkCustomAttributes = "";
		$this->chop->HrefValue = "";
		$this->chop->TooltipValue = "";

		// grade
		$this->grade->LinkCustomAttributes = "";
		$this->grade->HrefValue = "";
		$this->grade->TooltipValue = "";

		// estate
		$this->estate->LinkCustomAttributes = "";
		$this->estate->HrefValue = "";
		$this->estate->TooltipValue = "";

		// sack
		$this->sack->LinkCustomAttributes = "";
		$this->sack->HrefValue = "";
		$this->sack->TooltipValue = "";

		// netto
		$this->netto->LinkCustomAttributes = "";
		$this->netto->HrefValue = "";
		$this->netto->TooltipValue = "";

		// open_bid
		$this->open_bid->LinkCustomAttributes = "";
		$this->open_bid->HrefValue = "";
		$this->open_bid->TooltipValue = "";

		// last_bid
		$this->last_bid->LinkCustomAttributes = "";
		$this->last_bid->HrefValue = "";
		$this->last_bid->TooltipValue = "";

		// highest_bid
		$this->highest_bid->LinkCustomAttributes = "";
		$this->highest_bid->HrefValue = "";
		$this->highest_bid->TooltipValue = "";

		// enter_bid
		$this->enter_bid->LinkCustomAttributes = "";
		$this->enter_bid->HrefValue = "";
		$this->enter_bid->TooltipValue = "";

		// auction_status
		$this->auction_status->LinkCustomAttributes = "";
		$this->auction_status->HrefValue = "";
		$this->auction_status->TooltipValue = "";

		// gross
		$this->gross->LinkCustomAttributes = "";
		$this->gross->HrefValue = "";
		$this->gross->TooltipValue = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

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

		// tanggal
		$this->tanggal->EditAttrs["class"] = "form-control";
		$this->tanggal->EditCustomAttributes = "";
		$this->tanggal->EditValue = ew_FormatDateTime($this->tanggal->CurrentValue, 7);
		$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

		// auc_number
		$this->auc_number->EditAttrs["class"] = "form-control";
		$this->auc_number->EditCustomAttributes = "";
		$this->auc_number->EditValue = $this->auc_number->CurrentValue;
		$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

		// start_bid
		$this->start_bid->EditAttrs["class"] = "form-control";
		$this->start_bid->EditCustomAttributes = "";
		$this->start_bid->EditValue = ew_FormatDateTime($this->start_bid->CurrentValue, 11);
		$this->start_bid->PlaceHolder = ew_RemoveHtml($this->start_bid->FldCaption());

		// close_bid
		$this->close_bid->EditAttrs["class"] = "form-control";
		$this->close_bid->EditCustomAttributes = "";
		$this->close_bid->EditValue = ew_FormatDateTime($this->close_bid->CurrentValue, 11);
		$this->close_bid->PlaceHolder = ew_RemoveHtml($this->close_bid->FldCaption());

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

		// grade
		$this->grade->EditAttrs["class"] = "form-control";
		$this->grade->EditCustomAttributes = "";
		$this->grade->EditValue = $this->grade->CurrentValue;
		$this->grade->PlaceHolder = ew_RemoveHtml($this->grade->FldCaption());

		// estate
		$this->estate->EditAttrs["class"] = "form-control";
		$this->estate->EditCustomAttributes = "";
		$this->estate->EditValue = $this->estate->CurrentValue;
		$this->estate->PlaceHolder = ew_RemoveHtml($this->estate->FldCaption());

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

		// open_bid
		$this->open_bid->EditAttrs["class"] = "form-control";
		$this->open_bid->EditCustomAttributes = "";
		$this->open_bid->EditValue = $this->open_bid->CurrentValue;
		$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());
		if (strval($this->open_bid->EditValue) <> "" && is_numeric($this->open_bid->EditValue)) $this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -2, -2, -2);

		// last_bid
		$this->last_bid->EditAttrs["class"] = "form-control";
		$this->last_bid->EditCustomAttributes = "";
		$this->last_bid->EditValue = $this->last_bid->CurrentValue;
		$this->last_bid->PlaceHolder = ew_RemoveHtml($this->last_bid->FldCaption());
		if (strval($this->last_bid->EditValue) <> "" && is_numeric($this->last_bid->EditValue)) $this->last_bid->EditValue = ew_FormatNumber($this->last_bid->EditValue, -2, -2, -2, -2);

		// highest_bid
		$this->highest_bid->EditAttrs["class"] = "form-control";
		$this->highest_bid->EditCustomAttributes = "";
		$this->highest_bid->EditValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->PlaceHolder = ew_RemoveHtml($this->highest_bid->FldCaption());
		if (strval($this->highest_bid->EditValue) <> "" && is_numeric($this->highest_bid->EditValue)) $this->highest_bid->EditValue = ew_FormatNumber($this->highest_bid->EditValue, -2, -2, -2, -2);

		// enter_bid
		$this->enter_bid->EditAttrs["class"] = "form-control";
		$this->enter_bid->EditCustomAttributes = "";
		$this->enter_bid->EditValue = $this->enter_bid->CurrentValue;
		$this->enter_bid->PlaceHolder = ew_RemoveHtml($this->enter_bid->FldCaption());

		// auction_status
		$this->auction_status->EditCustomAttributes = "";
		$this->auction_status->EditValue = $this->auction_status->Options(FALSE);

		// gross
		$this->gross->EditAttrs["class"] = "form-control";
		$this->gross->EditCustomAttributes = "";
		$this->gross->EditValue = $this->gross->CurrentValue;
		$this->gross->PlaceHolder = ew_RemoveHtml($this->gross->FldCaption());
		if (strval($this->gross->EditValue) <> "" && is_numeric($this->gross->EditValue)) $this->gross->EditValue = ew_FormatNumber($this->gross->EditValue, -2, -1, -2, 0);

		// row_id
		$this->row_id->EditAttrs["class"] = "form-control";
		$this->row_id->EditCustomAttributes = "";
		$this->row_id->EditValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

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
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->start_bid->Exportable) $Doc->ExportCaption($this->start_bid);
					if ($this->close_bid->Exportable) $Doc->ExportCaption($this->close_bid);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->netto->Exportable) $Doc->ExportCaption($this->netto);
					if ($this->open_bid->Exportable) $Doc->ExportCaption($this->open_bid);
					if ($this->last_bid->Exportable) $Doc->ExportCaption($this->last_bid);
					if ($this->highest_bid->Exportable) $Doc->ExportCaption($this->highest_bid);
					if ($this->enter_bid->Exportable) $Doc->ExportCaption($this->enter_bid);
					if ($this->auction_status->Exportable) $Doc->ExportCaption($this->auction_status);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->row_id->Exportable) $Doc->ExportCaption($this->row_id);
				} else {
					if ($this->tanggal->Exportable) $Doc->ExportCaption($this->tanggal);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->start_bid->Exportable) $Doc->ExportCaption($this->start_bid);
					if ($this->close_bid->Exportable) $Doc->ExportCaption($this->close_bid);
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->netto->Exportable) $Doc->ExportCaption($this->netto);
					if ($this->open_bid->Exportable) $Doc->ExportCaption($this->open_bid);
					if ($this->last_bid->Exportable) $Doc->ExportCaption($this->last_bid);
					if ($this->highest_bid->Exportable) $Doc->ExportCaption($this->highest_bid);
					if ($this->enter_bid->Exportable) $Doc->ExportCaption($this->enter_bid);
					if ($this->auction_status->Exportable) $Doc->ExportCaption($this->auction_status);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->row_id->Exportable) $Doc->ExportCaption($this->row_id);
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
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->start_bid->Exportable) $Doc->ExportField($this->start_bid);
						if ($this->close_bid->Exportable) $Doc->ExportField($this->close_bid);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->netto->Exportable) $Doc->ExportField($this->netto);
						if ($this->open_bid->Exportable) $Doc->ExportField($this->open_bid);
						if ($this->last_bid->Exportable) $Doc->ExportField($this->last_bid);
						if ($this->highest_bid->Exportable) $Doc->ExportField($this->highest_bid);
						if ($this->enter_bid->Exportable) $Doc->ExportField($this->enter_bid);
						if ($this->auction_status->Exportable) $Doc->ExportField($this->auction_status);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->row_id->Exportable) $Doc->ExportField($this->row_id);
					} else {
						if ($this->tanggal->Exportable) $Doc->ExportField($this->tanggal);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->start_bid->Exportable) $Doc->ExportField($this->start_bid);
						if ($this->close_bid->Exportable) $Doc->ExportField($this->close_bid);
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->netto->Exportable) $Doc->ExportField($this->netto);
						if ($this->open_bid->Exportable) $Doc->ExportField($this->open_bid);
						if ($this->last_bid->Exportable) $Doc->ExportField($this->last_bid);
						if ($this->highest_bid->Exportable) $Doc->ExportField($this->highest_bid);
						if ($this->enter_bid->Exportable) $Doc->ExportField($this->enter_bid);
						if ($this->auction_status->Exportable) $Doc->ExportField($this->auction_status);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->row_id->Exportable) $Doc->ExportField($this->row_id);
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
