<?php

// Global variable for table object
$v_auction_date = NULL;

//
// Table class for v_auction_date
//
class cv_auction_date extends cTable {
	var $auc_date;
	var $SUM28tr_lelang_master_total_sack29;
	var $SUM28tr_lelang_master_total_netto29;
	var $SUM28tr_lelang_master_total_gross29;
	var $COUNT28tr_lelang_item_chop29;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'v_auction_date';
		$this->TableName = 'v_auction_date';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`v_auction_date`";
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

		// auc_date
		$this->auc_date = new cField('v_auction_date', 'v_auction_date', 'x_auc_date', 'auc_date', '`auc_date`', ew_CastDateFieldForLike('`auc_date`', 2, "DB"), 133, 2, FALSE, '`auc_date`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->auc_date->Sortable = TRUE; // Allow sort
		$this->auc_date->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['auc_date'] = &$this->auc_date;

		// SUM(tr_lelang_master.total_sack)
		$this->SUM28tr_lelang_master_total_sack29 = new cField('v_auction_date', 'v_auction_date', 'x_SUM28tr_lelang_master_total_sack29', 'SUM(tr_lelang_master.total_sack)', '`SUM(tr_lelang_master.total_sack)`', '`SUM(tr_lelang_master.total_sack)`', 131, -1, FALSE, '`SUM(tr_lelang_master.total_sack)`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUM28tr_lelang_master_total_sack29->Sortable = TRUE; // Allow sort
		$this->SUM28tr_lelang_master_total_sack29->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['SUM(tr_lelang_master.total_sack)'] = &$this->SUM28tr_lelang_master_total_sack29;

		// SUM(tr_lelang_master.total_netto)
		$this->SUM28tr_lelang_master_total_netto29 = new cField('v_auction_date', 'v_auction_date', 'x_SUM28tr_lelang_master_total_netto29', 'SUM(tr_lelang_master.total_netto)', '`SUM(tr_lelang_master.total_netto)`', '`SUM(tr_lelang_master.total_netto)`', 5, -1, FALSE, '`SUM(tr_lelang_master.total_netto)`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUM28tr_lelang_master_total_netto29->Sortable = TRUE; // Allow sort
		$this->SUM28tr_lelang_master_total_netto29->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['SUM(tr_lelang_master.total_netto)'] = &$this->SUM28tr_lelang_master_total_netto29;

		// SUM(tr_lelang_master.total_gross)
		$this->SUM28tr_lelang_master_total_gross29 = new cField('v_auction_date', 'v_auction_date', 'x_SUM28tr_lelang_master_total_gross29', 'SUM(tr_lelang_master.total_gross)', '`SUM(tr_lelang_master.total_gross)`', '`SUM(tr_lelang_master.total_gross)`', 5, -1, FALSE, '`SUM(tr_lelang_master.total_gross)`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->SUM28tr_lelang_master_total_gross29->Sortable = TRUE; // Allow sort
		$this->SUM28tr_lelang_master_total_gross29->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['SUM(tr_lelang_master.total_gross)'] = &$this->SUM28tr_lelang_master_total_gross29;

		// COUNT(tr_lelang_item.chop)
		$this->COUNT28tr_lelang_item_chop29 = new cField('v_auction_date', 'v_auction_date', 'x_COUNT28tr_lelang_item_chop29', 'COUNT(tr_lelang_item.chop)', '`COUNT(tr_lelang_item.chop)`', '`COUNT(tr_lelang_item.chop)`', 20, -1, FALSE, '`COUNT(tr_lelang_item.chop)`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->COUNT28tr_lelang_item_chop29->Sortable = TRUE; // Allow sort
		$this->COUNT28tr_lelang_item_chop29->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['COUNT(tr_lelang_item.chop)'] = &$this->COUNT28tr_lelang_item_chop29;
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
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`v_auction_date`";
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
		return "";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
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
			return "v_auction_datelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "v_auction_dateview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "v_auction_dateedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "v_auction_dateadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "v_auction_datelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("v_auction_dateview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("v_auction_dateview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "v_auction_dateadd.php?" . $this->UrlParm($parm);
		else
			$url = "v_auction_dateadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("v_auction_dateedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("v_auction_dateadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("v_auction_datedelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
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

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
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
		$this->auc_date->setDbValue($rs->fields('auc_date'));
		$this->SUM28tr_lelang_master_total_sack29->setDbValue($rs->fields('SUM(tr_lelang_master.total_sack)'));
		$this->SUM28tr_lelang_master_total_netto29->setDbValue($rs->fields('SUM(tr_lelang_master.total_netto)'));
		$this->SUM28tr_lelang_master_total_gross29->setDbValue($rs->fields('SUM(tr_lelang_master.total_gross)'));
		$this->COUNT28tr_lelang_item_chop29->setDbValue($rs->fields('COUNT(tr_lelang_item.chop)'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// auc_date
		// SUM(tr_lelang_master.total_sack)
		// SUM(tr_lelang_master.total_netto)
		// SUM(tr_lelang_master.total_gross)
		// COUNT(tr_lelang_item.chop)
		// auc_date

		$this->auc_date->ViewValue = $this->auc_date->CurrentValue;
		$this->auc_date->ViewValue = ew_FormatDateTime($this->auc_date->ViewValue, 2);
		$this->auc_date->CellCssStyle .= "text-align: center;";
		$this->auc_date->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_sack)
		$this->SUM28tr_lelang_master_total_sack29->ViewValue = $this->SUM28tr_lelang_master_total_sack29->CurrentValue;
		$this->SUM28tr_lelang_master_total_sack29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_sack29->ViewValue, 0, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_sack29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_sack29->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_netto)
		$this->SUM28tr_lelang_master_total_netto29->ViewValue = $this->SUM28tr_lelang_master_total_netto29->CurrentValue;
		$this->SUM28tr_lelang_master_total_netto29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_netto29->ViewValue, 2, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_netto29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_netto29->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_gross)
		$this->SUM28tr_lelang_master_total_gross29->ViewValue = $this->SUM28tr_lelang_master_total_gross29->CurrentValue;
		$this->SUM28tr_lelang_master_total_gross29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_gross29->ViewValue, 2, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_gross29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_gross29->ViewCustomAttributes = "";

		// COUNT(tr_lelang_item.chop)
		$this->COUNT28tr_lelang_item_chop29->ViewValue = $this->COUNT28tr_lelang_item_chop29->CurrentValue;
		$this->COUNT28tr_lelang_item_chop29->ViewValue = ew_FormatNumber($this->COUNT28tr_lelang_item_chop29->ViewValue, 0, -2, -2, -2);
		$this->COUNT28tr_lelang_item_chop29->CellCssStyle .= "text-align: center;";
		$this->COUNT28tr_lelang_item_chop29->ViewCustomAttributes = "";

		// auc_date
		$this->auc_date->LinkCustomAttributes = "";
		$this->auc_date->HrefValue = "";
		$this->auc_date->TooltipValue = "";

		// SUM(tr_lelang_master.total_sack)
		$this->SUM28tr_lelang_master_total_sack29->LinkCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_sack29->HrefValue = "";
		$this->SUM28tr_lelang_master_total_sack29->TooltipValue = "";

		// SUM(tr_lelang_master.total_netto)
		$this->SUM28tr_lelang_master_total_netto29->LinkCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_netto29->HrefValue = "";
		$this->SUM28tr_lelang_master_total_netto29->TooltipValue = "";

		// SUM(tr_lelang_master.total_gross)
		$this->SUM28tr_lelang_master_total_gross29->LinkCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_gross29->HrefValue = "";
		$this->SUM28tr_lelang_master_total_gross29->TooltipValue = "";

		// COUNT(tr_lelang_item.chop)
		$this->COUNT28tr_lelang_item_chop29->LinkCustomAttributes = "";
		$this->COUNT28tr_lelang_item_chop29->HrefValue = "";
		$this->COUNT28tr_lelang_item_chop29->TooltipValue = "";

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

		// auc_date
		$this->auc_date->EditAttrs["class"] = "form-control";
		$this->auc_date->EditCustomAttributes = "";
		$this->auc_date->EditValue = ew_FormatDateTime($this->auc_date->CurrentValue, 2);
		$this->auc_date->PlaceHolder = ew_RemoveHtml($this->auc_date->FldCaption());

		// SUM(tr_lelang_master.total_sack)
		$this->SUM28tr_lelang_master_total_sack29->EditAttrs["class"] = "form-control";
		$this->SUM28tr_lelang_master_total_sack29->EditCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_sack29->EditValue = $this->SUM28tr_lelang_master_total_sack29->CurrentValue;
		$this->SUM28tr_lelang_master_total_sack29->PlaceHolder = ew_RemoveHtml($this->SUM28tr_lelang_master_total_sack29->FldCaption());
		if (strval($this->SUM28tr_lelang_master_total_sack29->EditValue) <> "" && is_numeric($this->SUM28tr_lelang_master_total_sack29->EditValue)) $this->SUM28tr_lelang_master_total_sack29->EditValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_sack29->EditValue, -2, -2, -2, -2);

		// SUM(tr_lelang_master.total_netto)
		$this->SUM28tr_lelang_master_total_netto29->EditAttrs["class"] = "form-control";
		$this->SUM28tr_lelang_master_total_netto29->EditCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_netto29->EditValue = $this->SUM28tr_lelang_master_total_netto29->CurrentValue;
		$this->SUM28tr_lelang_master_total_netto29->PlaceHolder = ew_RemoveHtml($this->SUM28tr_lelang_master_total_netto29->FldCaption());
		if (strval($this->SUM28tr_lelang_master_total_netto29->EditValue) <> "" && is_numeric($this->SUM28tr_lelang_master_total_netto29->EditValue)) $this->SUM28tr_lelang_master_total_netto29->EditValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_netto29->EditValue, -2, -2, -2, -2);

		// SUM(tr_lelang_master.total_gross)
		$this->SUM28tr_lelang_master_total_gross29->EditAttrs["class"] = "form-control";
		$this->SUM28tr_lelang_master_total_gross29->EditCustomAttributes = "";
		$this->SUM28tr_lelang_master_total_gross29->EditValue = $this->SUM28tr_lelang_master_total_gross29->CurrentValue;
		$this->SUM28tr_lelang_master_total_gross29->PlaceHolder = ew_RemoveHtml($this->SUM28tr_lelang_master_total_gross29->FldCaption());
		if (strval($this->SUM28tr_lelang_master_total_gross29->EditValue) <> "" && is_numeric($this->SUM28tr_lelang_master_total_gross29->EditValue)) $this->SUM28tr_lelang_master_total_gross29->EditValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_gross29->EditValue, -2, -2, -2, -2);

		// COUNT(tr_lelang_item.chop)
		$this->COUNT28tr_lelang_item_chop29->EditAttrs["class"] = "form-control";
		$this->COUNT28tr_lelang_item_chop29->EditCustomAttributes = "";
		$this->COUNT28tr_lelang_item_chop29->EditValue = $this->COUNT28tr_lelang_item_chop29->CurrentValue;
		$this->COUNT28tr_lelang_item_chop29->PlaceHolder = ew_RemoveHtml($this->COUNT28tr_lelang_item_chop29->FldCaption());

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
					if ($this->auc_date->Exportable) $Doc->ExportCaption($this->auc_date);
					if ($this->SUM28tr_lelang_master_total_sack29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_sack29);
					if ($this->SUM28tr_lelang_master_total_netto29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_netto29);
					if ($this->SUM28tr_lelang_master_total_gross29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_gross29);
					if ($this->COUNT28tr_lelang_item_chop29->Exportable) $Doc->ExportCaption($this->COUNT28tr_lelang_item_chop29);
				} else {
					if ($this->auc_date->Exportable) $Doc->ExportCaption($this->auc_date);
					if ($this->SUM28tr_lelang_master_total_sack29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_sack29);
					if ($this->SUM28tr_lelang_master_total_netto29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_netto29);
					if ($this->SUM28tr_lelang_master_total_gross29->Exportable) $Doc->ExportCaption($this->SUM28tr_lelang_master_total_gross29);
					if ($this->COUNT28tr_lelang_item_chop29->Exportable) $Doc->ExportCaption($this->COUNT28tr_lelang_item_chop29);
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
						if ($this->auc_date->Exportable) $Doc->ExportField($this->auc_date);
						if ($this->SUM28tr_lelang_master_total_sack29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_sack29);
						if ($this->SUM28tr_lelang_master_total_netto29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_netto29);
						if ($this->SUM28tr_lelang_master_total_gross29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_gross29);
						if ($this->COUNT28tr_lelang_item_chop29->Exportable) $Doc->ExportField($this->COUNT28tr_lelang_item_chop29);
					} else {
						if ($this->auc_date->Exportable) $Doc->ExportField($this->auc_date);
						if ($this->SUM28tr_lelang_master_total_sack29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_sack29);
						if ($this->SUM28tr_lelang_master_total_netto29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_netto29);
						if ($this->SUM28tr_lelang_master_total_gross29->Exportable) $Doc->ExportField($this->SUM28tr_lelang_master_total_gross29);
						if ($this->COUNT28tr_lelang_item_chop29->Exportable) $Doc->ExportField($this->COUNT28tr_lelang_item_chop29);
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
