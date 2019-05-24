<?php

// Global variable for table object
$tr_lelang_master = NULL;

//
// Table class for tr_lelang_master
//
class ctr_lelang_master extends cTable {
	var $row_id;
	var $auc_date;
	var $auc_number;
	var $auc_place;
	var $start_bid;
	var $close_bid;
	var $auc_notes;
	var $total_sack;
	var $total_netto;
	var $total_gross;
	var $auc_status;
	var $rate;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tr_lelang_master';
		$this->TableName = 'tr_lelang_master';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tr_lelang_master`";
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
		$this->row_id = new cField('tr_lelang_master', 'tr_lelang_master', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = FALSE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;

		// auc_date
		$this->auc_date = new cField('tr_lelang_master', 'tr_lelang_master', 'x_auc_date', 'auc_date', '`auc_date`', ew_CastDateFieldForLike('`auc_date`', 7, "DB"), 133, 7, FALSE, '`auc_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_date->Sortable = FALSE; // Allow sort
		$this->auc_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['auc_date'] = &$this->auc_date;

		// auc_number
		$this->auc_number = new cField('tr_lelang_master', 'tr_lelang_master', 'x_auc_number', 'auc_number', '`auc_number`', '`auc_number`', 200, -1, FALSE, '`auc_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_number->Sortable = FALSE; // Allow sort
		$this->fields['auc_number'] = &$this->auc_number;

		// auc_place
		$this->auc_place = new cField('tr_lelang_master', 'tr_lelang_master', 'x_auc_place', 'auc_place', '`auc_place`', '`auc_place`', 200, -1, FALSE, '`auc_place`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_place->Sortable = FALSE; // Allow sort
		$this->fields['auc_place'] = &$this->auc_place;

		// start_bid
		$this->start_bid = new cField('tr_lelang_master', 'tr_lelang_master', 'x_start_bid', 'start_bid', '`start_bid`', ew_CastDateFieldForLike('`start_bid`', 11, "DB"), 135, 11, FALSE, '`start_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->start_bid->Sortable = FALSE; // Allow sort
		$this->start_bid->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['start_bid'] = &$this->start_bid;

		// close_bid
		$this->close_bid = new cField('tr_lelang_master', 'tr_lelang_master', 'x_close_bid', 'close_bid', '`close_bid`', ew_CastDateFieldForLike('`close_bid`', 11, "DB"), 135, 11, FALSE, '`close_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->close_bid->Sortable = FALSE; // Allow sort
		$this->close_bid->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_SEPARATOR"], $Language->Phrase("IncorrectDateDMY"));
		$this->fields['close_bid'] = &$this->close_bid;

		// auc_notes
		$this->auc_notes = new cField('tr_lelang_master', 'tr_lelang_master', 'x_auc_notes', 'auc_notes', '`auc_notes`', '`auc_notes`', 200, -1, FALSE, '`auc_notes`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_notes->Sortable = FALSE; // Allow sort
		$this->fields['auc_notes'] = &$this->auc_notes;

		// total_sack
		$this->total_sack = new cField('tr_lelang_master', 'tr_lelang_master', 'x_total_sack', 'total_sack', '`total_sack`', '`total_sack`', 3, -1, FALSE, '`total_sack`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_sack->Sortable = FALSE; // Allow sort
		$this->total_sack->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['total_sack'] = &$this->total_sack;

		// total_netto
		$this->total_netto = new cField('tr_lelang_master', 'tr_lelang_master', 'x_total_netto', 'total_netto', '`total_netto`', '`total_netto`', 5, -1, FALSE, '`total_netto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'HIDDEN');
		$this->total_netto->Sortable = FALSE; // Allow sort
		$this->total_netto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_netto'] = &$this->total_netto;

		// total_gross
		$this->total_gross = new cField('tr_lelang_master', 'tr_lelang_master', 'x_total_gross', 'total_gross', '`total_gross`', '`total_gross`', 5, -1, FALSE, '`total_gross`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_gross->Sortable = FALSE; // Allow sort
		$this->total_gross->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_gross'] = &$this->total_gross;

		// auc_status
		$this->auc_status = new cField('tr_lelang_master', 'tr_lelang_master', 'x_auc_status', 'auc_status', '`auc_status`', '`auc_status`', 202, -1, FALSE, '`auc_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->auc_status->Sortable = FALSE; // Allow sort
		$this->auc_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->auc_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->auc_status->OptionCount = 3;
		$this->fields['auc_status'] = &$this->auc_status;

		// rate
		$this->rate = new cField('tr_lelang_master', 'tr_lelang_master', 'x_rate', 'rate', '`rate`', '`rate`', 5, -1, FALSE, '`rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rate->Sortable = TRUE; // Allow sort
		$this->rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['rate'] = &$this->rate;
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
		if ($this->getCurrentDetailTable() == "tr_lelang_item") {
			$sDetailUrl = $GLOBALS["tr_lelang_item"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_row_id=" . urlencode($this->row_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "tr_lelang_masterlist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tr_lelang_master`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`auc_number` DESC";
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

		// Cascade delete detail table 'tr_lelang_item'
		if (!isset($GLOBALS["tr_lelang_item"])) $GLOBALS["tr_lelang_item"] = new ctr_lelang_item();
		$rscascade = $GLOBALS["tr_lelang_item"]->LoadRs("`master_id` = " . ew_QuotedValue($rs['row_id'], EW_DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->GetRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$bDelete = $GLOBALS["tr_lelang_item"]->Row_Deleting($dtlrow);
			if (!$bDelete) break;
		}
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$bDelete = $GLOBALS["tr_lelang_item"]->Delete($dtlrow); // Delete
				if ($bDelete === FALSE)
					break;
			}
		}

		// Call Row Deleted event
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$GLOBALS["tr_lelang_item"]->Row_Deleted($dtlrow);
			}
		}
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
			return "tr_lelang_masterlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tr_lelang_masterview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tr_lelang_masteredit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tr_lelang_masteradd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tr_lelang_masterlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tr_lelang_masterview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tr_lelang_masterview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tr_lelang_masteradd.php?" . $this->UrlParm($parm);
		else
			$url = "tr_lelang_masteradd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tr_lelang_masteredit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tr_lelang_masteredit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("tr_lelang_masteradd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tr_lelang_masteradd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tr_lelang_masterdelete.php", $this->UrlParm());
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
		$this->auc_date->setDbValue($rs->fields('auc_date'));
		$this->auc_number->setDbValue($rs->fields('auc_number'));
		$this->auc_place->setDbValue($rs->fields('auc_place'));
		$this->start_bid->setDbValue($rs->fields('start_bid'));
		$this->close_bid->setDbValue($rs->fields('close_bid'));
		$this->auc_notes->setDbValue($rs->fields('auc_notes'));
		$this->total_sack->setDbValue($rs->fields('total_sack'));
		$this->total_netto->setDbValue($rs->fields('total_netto'));
		$this->total_gross->setDbValue($rs->fields('total_gross'));
		$this->auc_status->setDbValue($rs->fields('auc_status'));
		$this->rate->setDbValue($rs->fields('rate'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// row_id

		$this->row_id->CellCssStyle = "white-space: nowrap;";

		// auc_date
		$this->auc_date->CellCssStyle = "white-space: nowrap;";

		// auc_number
		$this->auc_number->CellCssStyle = "white-space: nowrap;";

		// auc_place
		$this->auc_place->CellCssStyle = "white-space: nowrap;";

		// start_bid
		$this->start_bid->CellCssStyle = "white-space: nowrap;";

		// close_bid
		$this->close_bid->CellCssStyle = "white-space: nowrap;";

		// auc_notes
		// total_sack

		$this->total_sack->CellCssStyle = "white-space: nowrap;";

		// total_netto
		$this->total_netto->CellCssStyle = "white-space: nowrap;";

		// total_gross
		$this->total_gross->CellCssStyle = "white-space: nowrap;";

		// auc_status
		$this->auc_status->CellCssStyle = "white-space: nowrap;";

		// rate
		// row_id

		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// auc_date
		$this->auc_date->ViewValue = $this->auc_date->CurrentValue;
		$this->auc_date->ViewValue = ew_FormatDateTime($this->auc_date->ViewValue, 7);
		$this->auc_date->CellCssStyle .= "text-align: center;";
		$this->auc_date->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

		// auc_place
		$this->auc_place->ViewValue = $this->auc_place->CurrentValue;
		$this->auc_place->ViewCustomAttributes = "";

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

		// auc_notes
		$this->auc_notes->ViewValue = $this->auc_notes->CurrentValue;
		$this->auc_notes->ViewCustomAttributes = "";

		// total_sack
		$this->total_sack->ViewValue = $this->total_sack->CurrentValue;
		$this->total_sack->ViewValue = ew_FormatNumber($this->total_sack->ViewValue, 0, -2, -2, -2);
		$this->total_sack->CellCssStyle .= "text-align: right;";
		$this->total_sack->ViewCustomAttributes = "";

		// total_netto
		$this->total_netto->ViewValue = $this->total_netto->CurrentValue;
		$this->total_netto->ViewValue = ew_FormatNumber($this->total_netto->ViewValue, 0, -2, -2, -2);
		$this->total_netto->CellCssStyle .= "text-align: right;";
		$this->total_netto->ViewCustomAttributes = "";

		// total_gross
		$this->total_gross->ViewValue = $this->total_gross->CurrentValue;
		$this->total_gross->ViewValue = ew_FormatNumber($this->total_gross->ViewValue, 0, -2, -2, -2);
		$this->total_gross->CellCssStyle .= "text-align: right;";
		$this->total_gross->ViewCustomAttributes = "";

		// auc_status
		if (strval($this->auc_status->CurrentValue) <> "") {
			$this->auc_status->ViewValue = $this->auc_status->OptionCaption($this->auc_status->CurrentValue);
		} else {
			$this->auc_status->ViewValue = NULL;
		}
		$this->auc_status->CellCssStyle .= "text-align: center;";
		$this->auc_status->ViewCustomAttributes = "";

		// rate
		$this->rate->ViewValue = $this->rate->CurrentValue;
		$this->rate->ViewCustomAttributes = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

		// auc_date
		$this->auc_date->LinkCustomAttributes = "";
		$this->auc_date->HrefValue = "";
		$this->auc_date->TooltipValue = "";

		// auc_number
		$this->auc_number->LinkCustomAttributes = "";
		$this->auc_number->HrefValue = "";
		$this->auc_number->TooltipValue = "";

		// auc_place
		$this->auc_place->LinkCustomAttributes = "";
		$this->auc_place->HrefValue = "";
		$this->auc_place->TooltipValue = "";

		// start_bid
		$this->start_bid->LinkCustomAttributes = "";
		$this->start_bid->HrefValue = "";
		$this->start_bid->TooltipValue = "";

		// close_bid
		$this->close_bid->LinkCustomAttributes = "";
		$this->close_bid->HrefValue = "";
		$this->close_bid->TooltipValue = "";

		// auc_notes
		$this->auc_notes->LinkCustomAttributes = "";
		$this->auc_notes->HrefValue = "";
		$this->auc_notes->TooltipValue = "";

		// total_sack
		$this->total_sack->LinkCustomAttributes = "";
		$this->total_sack->HrefValue = "";
		$this->total_sack->TooltipValue = "";

		// total_netto
		$this->total_netto->LinkCustomAttributes = "";
		$this->total_netto->HrefValue = "";
		$this->total_netto->TooltipValue = "";

		// total_gross
		$this->total_gross->LinkCustomAttributes = "";
		$this->total_gross->HrefValue = "";
		$this->total_gross->TooltipValue = "";

		// auc_status
		$this->auc_status->LinkCustomAttributes = "";
		$this->auc_status->HrefValue = "";
		$this->auc_status->TooltipValue = "";

		// rate
		$this->rate->LinkCustomAttributes = "";
		$this->rate->HrefValue = "";
		$this->rate->TooltipValue = "";

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

		// auc_date
		$this->auc_date->EditAttrs["class"] = "form-control";
		$this->auc_date->EditCustomAttributes = "";
		$this->auc_date->EditValue = ew_FormatDateTime($this->auc_date->CurrentValue, 7);
		$this->auc_date->PlaceHolder = ew_RemoveHtml($this->auc_date->FldCaption());

		// auc_number
		$this->auc_number->EditAttrs["class"] = "form-control";
		$this->auc_number->EditCustomAttributes = "";
		$this->auc_number->EditValue = $this->auc_number->CurrentValue;
		$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

		// auc_place
		$this->auc_place->EditAttrs["class"] = "form-control";
		$this->auc_place->EditCustomAttributes = "";
		$this->auc_place->EditValue = $this->auc_place->CurrentValue;
		$this->auc_place->PlaceHolder = ew_RemoveHtml($this->auc_place->FldCaption());

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

		// auc_notes
		$this->auc_notes->EditAttrs["class"] = "form-control";
		$this->auc_notes->EditCustomAttributes = "";
		$this->auc_notes->EditValue = $this->auc_notes->CurrentValue;
		$this->auc_notes->PlaceHolder = ew_RemoveHtml($this->auc_notes->FldCaption());

		// total_sack
		$this->total_sack->EditAttrs["class"] = "form-control";
		$this->total_sack->EditCustomAttributes = "";
		$this->total_sack->EditValue = $this->total_sack->CurrentValue;
		$this->total_sack->PlaceHolder = ew_RemoveHtml($this->total_sack->FldCaption());

		// total_netto
		$this->total_netto->EditAttrs["class"] = "form-control";
		$this->total_netto->EditCustomAttributes = "";

		// total_gross
		$this->total_gross->EditAttrs["class"] = "form-control";
		$this->total_gross->EditCustomAttributes = "";
		$this->total_gross->EditValue = $this->total_gross->CurrentValue;
		$this->total_gross->PlaceHolder = ew_RemoveHtml($this->total_gross->FldCaption());
		if (strval($this->total_gross->EditValue) <> "" && is_numeric($this->total_gross->EditValue)) $this->total_gross->EditValue = ew_FormatNumber($this->total_gross->EditValue, -2, -2, -2, -2);

		// auc_status
		$this->auc_status->EditAttrs["class"] = "form-control";
		$this->auc_status->EditCustomAttributes = "";
		$this->auc_status->EditValue = $this->auc_status->Options(TRUE);

		// rate
		$this->rate->EditAttrs["class"] = "form-control";
		$this->rate->EditCustomAttributes = "";
		$this->rate->EditValue = $this->rate->CurrentValue;
		$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
		if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) $this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);

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
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->auc_place->Exportable) $Doc->ExportCaption($this->auc_place);
					if ($this->start_bid->Exportable) $Doc->ExportCaption($this->start_bid);
					if ($this->close_bid->Exportable) $Doc->ExportCaption($this->close_bid);
					if ($this->auc_notes->Exportable) $Doc->ExportCaption($this->auc_notes);
					if ($this->total_sack->Exportable) $Doc->ExportCaption($this->total_sack);
					if ($this->total_netto->Exportable) $Doc->ExportCaption($this->total_netto);
					if ($this->total_gross->Exportable) $Doc->ExportCaption($this->total_gross);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
				} else {
					if ($this->auc_date->Exportable) $Doc->ExportCaption($this->auc_date);
					if ($this->auc_number->Exportable) $Doc->ExportCaption($this->auc_number);
					if ($this->auc_place->Exportable) $Doc->ExportCaption($this->auc_place);
					if ($this->start_bid->Exportable) $Doc->ExportCaption($this->start_bid);
					if ($this->close_bid->Exportable) $Doc->ExportCaption($this->close_bid);
					if ($this->auc_notes->Exportable) $Doc->ExportCaption($this->auc_notes);
					if ($this->total_sack->Exportable) $Doc->ExportCaption($this->total_sack);
					if ($this->total_netto->Exportable) $Doc->ExportCaption($this->total_netto);
					if ($this->total_gross->Exportable) $Doc->ExportCaption($this->total_gross);
					if ($this->auc_status->Exportable) $Doc->ExportCaption($this->auc_status);
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
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->auc_place->Exportable) $Doc->ExportField($this->auc_place);
						if ($this->start_bid->Exportable) $Doc->ExportField($this->start_bid);
						if ($this->close_bid->Exportable) $Doc->ExportField($this->close_bid);
						if ($this->auc_notes->Exportable) $Doc->ExportField($this->auc_notes);
						if ($this->total_sack->Exportable) $Doc->ExportField($this->total_sack);
						if ($this->total_netto->Exportable) $Doc->ExportField($this->total_netto);
						if ($this->total_gross->Exportable) $Doc->ExportField($this->total_gross);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
					} else {
						if ($this->auc_date->Exportable) $Doc->ExportField($this->auc_date);
						if ($this->auc_number->Exportable) $Doc->ExportField($this->auc_number);
						if ($this->auc_place->Exportable) $Doc->ExportField($this->auc_place);
						if ($this->start_bid->Exportable) $Doc->ExportField($this->start_bid);
						if ($this->close_bid->Exportable) $Doc->ExportField($this->close_bid);
						if ($this->auc_notes->Exportable) $Doc->ExportField($this->auc_notes);
						if ($this->total_sack->Exportable) $Doc->ExportField($this->total_sack);
						if ($this->total_netto->Exportable) $Doc->ExportField($this->total_netto);
						if ($this->total_gross->Exportable) $Doc->ExportField($this->total_gross);
						if ($this->auc_status->Exportable) $Doc->ExportField($this->auc_status);
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

		$rsnew["auc_number"] = GetNextAucNumber($rsnew["start_bid"]);
		$startDate = strtotime($rsnew["start_bid"]);
		$rsnew["auc_date"] = date("Y/m/d",$startDate);
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
		ew_Execute("UPDATE tr_lelang_master SET auc_date = Date(start_bid) WHERE auc_number = '".$rsnew["auc_number"]."'");			
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
	//	if (CurrentPageID() == "add") {
	//		$this->auc_number->CurrentValue = GetNextAucNumber();
	//		$this->auc_number->EditValue = $this->auc_number->CurrentValue; 
	//	}

		$this->auc_number->ReadOnly = TRUE;
	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
