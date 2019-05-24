<?php

// Global variable for table object
$tr_lelang_item = NULL;

//
// Table class for tr_lelang_item
//
class ctr_lelang_item extends cTable {
	var $row_id;
	var $master_id;
	var $lot_number;
	var $chop;
	var $estate;
	var $grade;
	var $jenis;
	var $sack;
	var $netto;
	var $gross;
	var $open_bid;
	var $currency;
	var $bid_step;
	var $rate;
	var $winner_id;
	var $sold_bid;
	var $proforma_number;
	var $proforma_amount;
	var $proforma_status;
	var $auction_status;
	var $enter_bid;
	var $last_bid;
	var $highest_bid;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'tr_lelang_item';
		$this->TableName = 'tr_lelang_item';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`tr_lelang_item`";
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = TRUE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// row_id
		$this->row_id = new cField('tr_lelang_item', 'tr_lelang_item', 'x_row_id', 'row_id', '`row_id`', '`row_id`', 3, -1, FALSE, '`row_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->row_id->Sortable = FALSE; // Allow sort
		$this->row_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['row_id'] = &$this->row_id;

		// master_id
		$this->master_id = new cField('tr_lelang_item', 'tr_lelang_item', 'x_master_id', 'master_id', '`master_id`', '`master_id`', 3, -1, FALSE, '`master_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->master_id->Sortable = FALSE; // Allow sort
		$this->master_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['master_id'] = &$this->master_id;

		// lot_number
		$this->lot_number = new cField('tr_lelang_item', 'tr_lelang_item', 'x_lot_number', 'lot_number', '`lot_number`', '`lot_number`', 3, -1, FALSE, '`lot_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->lot_number->Sortable = TRUE; // Allow sort
		$this->lot_number->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['lot_number'] = &$this->lot_number;

		// chop
		$this->chop = new cField('tr_lelang_item', 'tr_lelang_item', 'x_chop', 'chop', '`chop`', '`chop`', 200, -1, FALSE, '`chop`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->chop->Sortable = TRUE; // Allow sort
		$this->fields['chop'] = &$this->chop;

		// estate
		$this->estate = new cField('tr_lelang_item', 'tr_lelang_item', 'x_estate', 'estate', '`estate`', '`estate`', 200, -1, FALSE, '`estate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->estate->Sortable = TRUE; // Allow sort
		$this->fields['estate'] = &$this->estate;

		// grade
		$this->grade = new cField('tr_lelang_item', 'tr_lelang_item', 'x_grade', 'grade', '`grade`', '`grade`', 200, -1, FALSE, '`grade`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->grade->Sortable = TRUE; // Allow sort
		$this->fields['grade'] = &$this->grade;

		// jenis
		$this->jenis = new cField('tr_lelang_item', 'tr_lelang_item', 'x_jenis', 'jenis', '`jenis`', '`jenis`', 200, -1, FALSE, '`jenis`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->jenis->Sortable = TRUE; // Allow sort
		$this->fields['jenis'] = &$this->jenis;

		// sack
		$this->sack = new cField('tr_lelang_item', 'tr_lelang_item', 'x_sack', 'sack', '`sack`', '`sack`', 3, -1, FALSE, '`sack`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sack->Sortable = TRUE; // Allow sort
		$this->sack->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sack'] = &$this->sack;

		// netto
		$this->netto = new cField('tr_lelang_item', 'tr_lelang_item', 'x_netto', 'netto', '`netto`', '`netto`', 5, -1, FALSE, '`netto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->netto->Sortable = TRUE; // Allow sort
		$this->netto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['netto'] = &$this->netto;

		// gross
		$this->gross = new cField('tr_lelang_item', 'tr_lelang_item', 'x_gross', 'gross', '`gross`', '`gross`', 5, -1, FALSE, '`gross`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->gross->Sortable = TRUE; // Allow sort
		$this->gross->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['gross'] = &$this->gross;

		// open_bid
		$this->open_bid = new cField('tr_lelang_item', 'tr_lelang_item', 'x_open_bid', 'open_bid', '`open_bid`', '`open_bid`', 5, -1, FALSE, '`open_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->open_bid->Sortable = TRUE; // Allow sort
		$this->open_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['open_bid'] = &$this->open_bid;

		// currency
		$this->currency = new cField('tr_lelang_item', 'tr_lelang_item', 'x_currency', 'currency', '`currency`', '`currency`', 200, -1, FALSE, '`currency`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->currency->Sortable = TRUE; // Allow sort
		$this->currency->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->currency->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['currency'] = &$this->currency;

		// bid_step
		$this->bid_step = new cField('tr_lelang_item', 'tr_lelang_item', 'x_bid_step', 'bid_step', '`bid_step`', '`bid_step`', 5, -1, FALSE, '`bid_step`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->bid_step->Sortable = TRUE; // Allow sort
		$this->bid_step->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['bid_step'] = &$this->bid_step;

		// rate
		$this->rate = new cField('tr_lelang_item', 'tr_lelang_item', 'x_rate', 'rate', '`rate`', '`rate`', 5, -1, FALSE, '`rate`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->rate->Sortable = TRUE; // Allow sort
		$this->rate->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['rate'] = &$this->rate;

		// winner_id
		$this->winner_id = new cField('tr_lelang_item', 'tr_lelang_item', 'x_winner_id', 'winner_id', '`winner_id`', '`winner_id`', 3, -1, FALSE, '`winner_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->winner_id->Sortable = TRUE; // Allow sort
		$this->winner_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['winner_id'] = &$this->winner_id;

		// sold_bid
		$this->sold_bid = new cField('tr_lelang_item', 'tr_lelang_item', 'x_sold_bid', 'sold_bid', '`sold_bid`', '`sold_bid`', 5, -1, FALSE, '`sold_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sold_bid->Sortable = TRUE; // Allow sort
		$this->sold_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['sold_bid'] = &$this->sold_bid;

		// proforma_number
		$this->proforma_number = new cField('tr_lelang_item', 'tr_lelang_item', 'x_proforma_number', 'proforma_number', '`proforma_number`', '`proforma_number`', 200, -1, FALSE, '`proforma_number`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_number->Sortable = TRUE; // Allow sort
		$this->fields['proforma_number'] = &$this->proforma_number;

		// proforma_amount
		$this->proforma_amount = new cField('tr_lelang_item', 'tr_lelang_item', 'x_proforma_amount', 'proforma_amount', '`proforma_amount`', '`proforma_amount`', 5, -1, FALSE, '`proforma_amount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->proforma_amount->Sortable = TRUE; // Allow sort
		$this->proforma_amount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['proforma_amount'] = &$this->proforma_amount;

		// proforma_status
		$this->proforma_status = new cField('tr_lelang_item', 'tr_lelang_item', 'x_proforma_status', 'proforma_status', '`proforma_status`', '`proforma_status`', 202, -1, FALSE, '`proforma_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->proforma_status->Sortable = TRUE; // Allow sort
		$this->proforma_status->OptionCount = 3;
		$this->fields['proforma_status'] = &$this->proforma_status;

		// auction_status
		$this->auction_status = new cField('tr_lelang_item', 'tr_lelang_item', 'x_auction_status', 'auction_status', '`auction_status`', '`auction_status`', 202, -1, FALSE, '`auction_status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->auction_status->Sortable = TRUE; // Allow sort
		$this->auction_status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->auction_status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->auction_status->OptionCount = 3;
		$this->fields['auction_status'] = &$this->auction_status;

		// enter_bid
		$this->enter_bid = new cField('tr_lelang_item', 'tr_lelang_item', 'x_enter_bid', 'enter_bid', '`enter_bid`', '`enter_bid`', 3, -1, FALSE, '`enter_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->enter_bid->Sortable = TRUE; // Allow sort
		$this->enter_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['enter_bid'] = &$this->enter_bid;

		// last_bid
		$this->last_bid = new cField('tr_lelang_item', 'tr_lelang_item', 'x_last_bid', 'last_bid', '`last_bid`', '`last_bid`', 5, -1, FALSE, '`last_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->last_bid->Sortable = TRUE; // Allow sort
		$this->last_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['last_bid'] = &$this->last_bid;

		// highest_bid
		$this->highest_bid = new cField('tr_lelang_item', 'tr_lelang_item', 'x_highest_bid', 'highest_bid', '`highest_bid`', '`highest_bid`', 5, -1, FALSE, '`highest_bid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->highest_bid->Sortable = TRUE; // Allow sort
		$this->highest_bid->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['highest_bid'] = &$this->highest_bid;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "tr_lelang_master") {
			if ($this->master_id->getSessionValue() <> "")
				$sMasterFilter .= "`row_id`=" . ew_QuotedValue($this->master_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "tr_lelang_master") {
			if ($this->master_id->getSessionValue() <> "")
				$sDetailFilter .= "`master_id`=" . ew_QuotedValue($this->master_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_tr_lelang_master() {
		return "`row_id`=@row_id@";
	}

	// Detail filter
	function SqlDetailFilter_tr_lelang_master() {
		return "`master_id`=@master_id@";
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`tr_lelang_item`";
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
			return "tr_lelang_itemlist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "tr_lelang_itemview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "tr_lelang_itemedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "tr_lelang_itemadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "tr_lelang_itemlist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("tr_lelang_itemview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("tr_lelang_itemview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "tr_lelang_itemadd.php?" . $this->UrlParm($parm);
		else
			$url = "tr_lelang_itemadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("tr_lelang_itemedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("tr_lelang_itemadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("tr_lelang_itemdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "tr_lelang_master" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_row_id=" . urlencode($this->master_id->CurrentValue);
		}
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
		$this->lot_number->setDbValue($rs->fields('lot_number'));
		$this->chop->setDbValue($rs->fields('chop'));
		$this->estate->setDbValue($rs->fields('estate'));
		$this->grade->setDbValue($rs->fields('grade'));
		$this->jenis->setDbValue($rs->fields('jenis'));
		$this->sack->setDbValue($rs->fields('sack'));
		$this->netto->setDbValue($rs->fields('netto'));
		$this->gross->setDbValue($rs->fields('gross'));
		$this->open_bid->setDbValue($rs->fields('open_bid'));
		$this->currency->setDbValue($rs->fields('currency'));
		$this->bid_step->setDbValue($rs->fields('bid_step'));
		$this->rate->setDbValue($rs->fields('rate'));
		$this->winner_id->setDbValue($rs->fields('winner_id'));
		$this->sold_bid->setDbValue($rs->fields('sold_bid'));
		$this->proforma_number->setDbValue($rs->fields('proforma_number'));
		$this->proforma_amount->setDbValue($rs->fields('proforma_amount'));
		$this->proforma_status->setDbValue($rs->fields('proforma_status'));
		$this->auction_status->setDbValue($rs->fields('auction_status'));
		$this->enter_bid->setDbValue($rs->fields('enter_bid'));
		$this->last_bid->setDbValue($rs->fields('last_bid'));
		$this->highest_bid->setDbValue($rs->fields('highest_bid'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// row_id
		// master_id
		// lot_number
		// chop
		// estate
		// grade
		// jenis
		// sack
		// netto
		// gross
		// open_bid
		// currency
		// bid_step
		// rate
		// winner_id
		// sold_bid
		// proforma_number
		// proforma_amount
		// proforma_status
		// auction_status
		// enter_bid
		// last_bid
		// highest_bid
		// row_id

		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// master_id
		$this->master_id->ViewValue = $this->master_id->CurrentValue;
		$this->master_id->ViewCustomAttributes = "";

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->ViewCustomAttributes = "";

		// chop
		$this->chop->ViewValue = $this->chop->CurrentValue;
		$this->chop->ViewCustomAttributes = "";

		// estate
		$this->estate->ViewValue = $this->estate->CurrentValue;
		$this->estate->ViewCustomAttributes = "";

		// grade
		$this->grade->ViewValue = $this->grade->CurrentValue;
		$this->grade->ViewCustomAttributes = "";

		// jenis
		$this->jenis->ViewValue = $this->jenis->CurrentValue;
		$this->jenis->ViewCustomAttributes = "";

		// sack
		$this->sack->ViewValue = $this->sack->CurrentValue;
		$this->sack->ViewValue = ew_FormatNumber($this->sack->ViewValue, 0, -2, -2, -2);
		$this->sack->ViewCustomAttributes = "";

		// netto
		$this->netto->ViewValue = $this->netto->CurrentValue;
		$this->netto->ViewValue = ew_FormatNumber($this->netto->ViewValue, 2, -2, -2, -2);
		$this->netto->ViewCustomAttributes = "";

		// gross
		$this->gross->ViewValue = $this->gross->CurrentValue;
		$this->gross->ViewValue = ew_FormatNumber($this->gross->ViewValue, 2, -2, -2, -2);
		$this->gross->ViewCustomAttributes = "";

		// open_bid
		$this->open_bid->ViewValue = $this->open_bid->CurrentValue;
		$this->open_bid->ViewValue = ew_FormatNumber($this->open_bid->ViewValue, 2, -2, -2, -2);
		$this->open_bid->CellCssStyle .= "text-align: right;";
		$this->open_bid->ViewCustomAttributes = "";

		// currency
		if (strval($this->currency->CurrentValue) <> "") {
			$sFilterWrk = "`id_cur`" . ew_SearchString("=", $this->currency->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `id_cur`, `currency` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_currency`";
		$sWhereWrk = "";
		$this->currency->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->currency, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->currency->ViewValue = $this->currency->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->currency->ViewValue = $this->currency->CurrentValue;
			}
		} else {
			$this->currency->ViewValue = NULL;
		}
		$this->currency->ViewCustomAttributes = "";

		// bid_step
		$this->bid_step->ViewValue = $this->bid_step->CurrentValue;
		$this->bid_step->ViewCustomAttributes = "";

		// rate
		$this->rate->ViewValue = $this->rate->CurrentValue;
		$this->rate->ViewCustomAttributes = "";

		// winner_id
		$this->winner_id->ViewValue = $this->winner_id->CurrentValue;
		$this->winner_id->ViewCustomAttributes = "";

		// sold_bid
		$this->sold_bid->ViewValue = $this->sold_bid->CurrentValue;
		$this->sold_bid->ViewCustomAttributes = "";

		// proforma_number
		$this->proforma_number->ViewValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->ViewCustomAttributes = "";

		// proforma_amount
		$this->proforma_amount->ViewValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->ViewCustomAttributes = "";

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

		// auction_status
		if (strval($this->auction_status->CurrentValue) <> "") {
			$this->auction_status->ViewValue = $this->auction_status->OptionCaption($this->auction_status->CurrentValue);
		} else {
			$this->auction_status->ViewValue = NULL;
		}
		$this->auction_status->ViewCustomAttributes = "";

		// enter_bid
		$this->enter_bid->ViewValue = $this->enter_bid->CurrentValue;
		$this->enter_bid->ViewCustomAttributes = "";

		// last_bid
		$this->last_bid->ViewValue = $this->last_bid->CurrentValue;
		$this->last_bid->ViewCustomAttributes = "";

		// highest_bid
		$this->highest_bid->ViewValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->ViewCustomAttributes = "";

		// row_id
		$this->row_id->LinkCustomAttributes = "";
		$this->row_id->HrefValue = "";
		$this->row_id->TooltipValue = "";

		// master_id
		$this->master_id->LinkCustomAttributes = "";
		$this->master_id->HrefValue = "";
		$this->master_id->TooltipValue = "";

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

		// jenis
		$this->jenis->LinkCustomAttributes = "";
		$this->jenis->HrefValue = "";
		$this->jenis->TooltipValue = "";

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

		// open_bid
		$this->open_bid->LinkCustomAttributes = "";
		$this->open_bid->HrefValue = "";
		$this->open_bid->TooltipValue = "";

		// currency
		$this->currency->LinkCustomAttributes = "";
		$this->currency->HrefValue = "";
		$this->currency->TooltipValue = "";

		// bid_step
		$this->bid_step->LinkCustomAttributes = "";
		$this->bid_step->HrefValue = "";
		$this->bid_step->TooltipValue = "";

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

		// proforma_number
		$this->proforma_number->LinkCustomAttributes = "";
		$this->proforma_number->HrefValue = "";
		$this->proforma_number->TooltipValue = "";

		// proforma_amount
		$this->proforma_amount->LinkCustomAttributes = "";
		$this->proforma_amount->HrefValue = "";
		$this->proforma_amount->TooltipValue = "";

		// proforma_status
		$this->proforma_status->LinkCustomAttributes = "";
		$this->proforma_status->HrefValue = "";
		$this->proforma_status->TooltipValue = "";

		// auction_status
		$this->auction_status->LinkCustomAttributes = "";
		$this->auction_status->HrefValue = "";
		$this->auction_status->TooltipValue = "";

		// enter_bid
		$this->enter_bid->LinkCustomAttributes = "";
		$this->enter_bid->HrefValue = "";
		$this->enter_bid->TooltipValue = "";

		// last_bid
		$this->last_bid->LinkCustomAttributes = "";
		$this->last_bid->HrefValue = "";
		$this->last_bid->TooltipValue = "";

		// highest_bid
		$this->highest_bid->LinkCustomAttributes = "";
		$this->highest_bid->HrefValue = "";
		$this->highest_bid->TooltipValue = "";

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
		if ($this->master_id->getSessionValue() <> "") {
			$this->master_id->CurrentValue = $this->master_id->getSessionValue();
		$this->master_id->ViewValue = $this->master_id->CurrentValue;
		$this->master_id->ViewCustomAttributes = "";
		} else {
		$this->master_id->EditValue = $this->master_id->CurrentValue;
		$this->master_id->PlaceHolder = ew_RemoveHtml($this->master_id->FldCaption());
		}

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

		// jenis
		$this->jenis->EditAttrs["class"] = "form-control";
		$this->jenis->EditCustomAttributes = "";
		$this->jenis->EditValue = $this->jenis->CurrentValue;
		$this->jenis->PlaceHolder = ew_RemoveHtml($this->jenis->FldCaption());

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

		// open_bid
		$this->open_bid->EditAttrs["class"] = "form-control";
		$this->open_bid->EditCustomAttributes = "";
		$this->open_bid->EditValue = $this->open_bid->CurrentValue;
		$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());
		if (strval($this->open_bid->EditValue) <> "" && is_numeric($this->open_bid->EditValue)) $this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -2, -2, -2);

		// currency
		$this->currency->EditCustomAttributes = "";

		// bid_step
		$this->bid_step->EditAttrs["class"] = "form-control";
		$this->bid_step->EditCustomAttributes = "";
		$this->bid_step->EditValue = $this->bid_step->CurrentValue;
		$this->bid_step->PlaceHolder = ew_RemoveHtml($this->bid_step->FldCaption());
		if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) $this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);

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
		if (strval($this->proforma_amount->EditValue) <> "" && is_numeric($this->proforma_amount->EditValue)) $this->proforma_amount->EditValue = ew_FormatNumber($this->proforma_amount->EditValue, -2, -1, -2, 0);

		// proforma_status
		$this->proforma_status->EditCustomAttributes = "";
		$this->proforma_status->EditValue = $this->proforma_status->Options(FALSE);

		// auction_status
		$this->auction_status->EditCustomAttributes = "";
		$this->auction_status->EditValue = $this->auction_status->Options(TRUE);

		// enter_bid
		$this->enter_bid->EditAttrs["class"] = "form-control";
		$this->enter_bid->EditCustomAttributes = "";
		$this->enter_bid->EditValue = $this->enter_bid->CurrentValue;
		$this->enter_bid->PlaceHolder = ew_RemoveHtml($this->enter_bid->FldCaption());

		// last_bid
		$this->last_bid->EditAttrs["class"] = "form-control";
		$this->last_bid->EditCustomAttributes = "";
		$this->last_bid->EditValue = $this->last_bid->CurrentValue;
		$this->last_bid->PlaceHolder = ew_RemoveHtml($this->last_bid->FldCaption());
		if (strval($this->last_bid->EditValue) <> "" && is_numeric($this->last_bid->EditValue)) $this->last_bid->EditValue = ew_FormatNumber($this->last_bid->EditValue, -2, -1, -2, 0);

		// highest_bid
		$this->highest_bid->EditAttrs["class"] = "form-control";
		$this->highest_bid->EditCustomAttributes = "";
		$this->highest_bid->EditValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->PlaceHolder = ew_RemoveHtml($this->highest_bid->FldCaption());
		if (strval($this->highest_bid->EditValue) <> "" && is_numeric($this->highest_bid->EditValue)) $this->highest_bid->EditValue = ew_FormatNumber($this->highest_bid->EditValue, -2, -1, -2, 0);

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
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->jenis->Exportable) $Doc->ExportCaption($this->jenis);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->netto->Exportable) $Doc->ExportCaption($this->netto);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->open_bid->Exportable) $Doc->ExportCaption($this->open_bid);
					if ($this->currency->Exportable) $Doc->ExportCaption($this->currency);
					if ($this->bid_step->Exportable) $Doc->ExportCaption($this->bid_step);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
					if ($this->winner_id->Exportable) $Doc->ExportCaption($this->winner_id);
					if ($this->sold_bid->Exportable) $Doc->ExportCaption($this->sold_bid);
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->proforma_status->Exportable) $Doc->ExportCaption($this->proforma_status);
					if ($this->auction_status->Exportable) $Doc->ExportCaption($this->auction_status);
				} else {
					if ($this->lot_number->Exportable) $Doc->ExportCaption($this->lot_number);
					if ($this->chop->Exportable) $Doc->ExportCaption($this->chop);
					if ($this->estate->Exportable) $Doc->ExportCaption($this->estate);
					if ($this->grade->Exportable) $Doc->ExportCaption($this->grade);
					if ($this->jenis->Exportable) $Doc->ExportCaption($this->jenis);
					if ($this->sack->Exportable) $Doc->ExportCaption($this->sack);
					if ($this->netto->Exportable) $Doc->ExportCaption($this->netto);
					if ($this->gross->Exportable) $Doc->ExportCaption($this->gross);
					if ($this->open_bid->Exportable) $Doc->ExportCaption($this->open_bid);
					if ($this->currency->Exportable) $Doc->ExportCaption($this->currency);
					if ($this->bid_step->Exportable) $Doc->ExportCaption($this->bid_step);
					if ($this->rate->Exportable) $Doc->ExportCaption($this->rate);
					if ($this->winner_id->Exportable) $Doc->ExportCaption($this->winner_id);
					if ($this->sold_bid->Exportable) $Doc->ExportCaption($this->sold_bid);
					if ($this->proforma_number->Exportable) $Doc->ExportCaption($this->proforma_number);
					if ($this->proforma_amount->Exportable) $Doc->ExportCaption($this->proforma_amount);
					if ($this->proforma_status->Exportable) $Doc->ExportCaption($this->proforma_status);
					if ($this->auction_status->Exportable) $Doc->ExportCaption($this->auction_status);
					if ($this->enter_bid->Exportable) $Doc->ExportCaption($this->enter_bid);
					if ($this->last_bid->Exportable) $Doc->ExportCaption($this->last_bid);
					if ($this->highest_bid->Exportable) $Doc->ExportCaption($this->highest_bid);
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
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->jenis->Exportable) $Doc->ExportField($this->jenis);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->netto->Exportable) $Doc->ExportField($this->netto);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->open_bid->Exportable) $Doc->ExportField($this->open_bid);
						if ($this->currency->Exportable) $Doc->ExportField($this->currency);
						if ($this->bid_step->Exportable) $Doc->ExportField($this->bid_step);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
						if ($this->winner_id->Exportable) $Doc->ExportField($this->winner_id);
						if ($this->sold_bid->Exportable) $Doc->ExportField($this->sold_bid);
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->proforma_status->Exportable) $Doc->ExportField($this->proforma_status);
						if ($this->auction_status->Exportable) $Doc->ExportField($this->auction_status);
					} else {
						if ($this->lot_number->Exportable) $Doc->ExportField($this->lot_number);
						if ($this->chop->Exportable) $Doc->ExportField($this->chop);
						if ($this->estate->Exportable) $Doc->ExportField($this->estate);
						if ($this->grade->Exportable) $Doc->ExportField($this->grade);
						if ($this->jenis->Exportable) $Doc->ExportField($this->jenis);
						if ($this->sack->Exportable) $Doc->ExportField($this->sack);
						if ($this->netto->Exportable) $Doc->ExportField($this->netto);
						if ($this->gross->Exportable) $Doc->ExportField($this->gross);
						if ($this->open_bid->Exportable) $Doc->ExportField($this->open_bid);
						if ($this->currency->Exportable) $Doc->ExportField($this->currency);
						if ($this->bid_step->Exportable) $Doc->ExportField($this->bid_step);
						if ($this->rate->Exportable) $Doc->ExportField($this->rate);
						if ($this->winner_id->Exportable) $Doc->ExportField($this->winner_id);
						if ($this->sold_bid->Exportable) $Doc->ExportField($this->sold_bid);
						if ($this->proforma_number->Exportable) $Doc->ExportField($this->proforma_number);
						if ($this->proforma_amount->Exportable) $Doc->ExportField($this->proforma_amount);
						if ($this->proforma_status->Exportable) $Doc->ExportField($this->proforma_status);
						if ($this->auction_status->Exportable) $Doc->ExportField($this->auction_status);
						if ($this->enter_bid->Exportable) $Doc->ExportField($this->enter_bid);
						if ($this->last_bid->Exportable) $Doc->ExportField($this->last_bid);
						if ($this->highest_bid->Exportable) $Doc->ExportField($this->highest_bid);
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
		if (preg_match('/^x(\d)*_currency$/', $id)) {
			$conn = &$this->Connection();
			$sSqlWrk = "SELECT `bid_step` AS FIELD0 FROM `tbl_currency`";
			$sWhereWrk = "(`id_cur` = " . ew_QuotedValue($val, EW_DATATYPE_STRING, $this->DBID) . ")";
			$this->currency->LookupFilters = array();
			$this->Lookup_Selecting($this->currency, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($rs = ew_LoadRecordset($sSqlWrk, $conn)) {
				while ($rs && !$rs->EOF) {
					$ar = array();
					$this->bid_step->setDbValue($rs->fields[0]);
					$this->RowType == EW_ROWTYPE_EDIT;
					$this->RenderEditRow();
					$ar[] = ($this->bid_step->AutoFillOriginalValue) ? $this->bid_step->CurrentValue : $this->bid_step->EditValue;
					$rowcnt += 1;
					$rsarr[] = $ar;
					$rs->MoveNext();
				}
				$rs->Close();
			}
		}

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
