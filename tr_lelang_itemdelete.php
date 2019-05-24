<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tr_lelang_iteminfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "tr_lelang_masterinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tr_lelang_item_delete = NULL; // Initialize page object first

class ctr_lelang_item_delete extends ctr_lelang_item {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_item';

	// Page object name
	var $PageObjName = 'tr_lelang_item_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (tr_lelang_item)
		if (!isset($GLOBALS["tr_lelang_item"]) || get_class($GLOBALS["tr_lelang_item"]) == "ctr_lelang_item") {
			$GLOBALS["tr_lelang_item"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tr_lelang_item"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Table object (tr_lelang_master)
		if (!isset($GLOBALS['tr_lelang_master'])) $GLOBALS['tr_lelang_master'] = new ctr_lelang_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tr_lelang_item', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (members)
		if (!isset($UserTable)) {
			$UserTable = new cmembers();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("tr_lelang_itemlist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Update last accessed time

		if ($UserProfile->IsValidUser(CurrentUserName(), session_id())) {
		} else {
			echo $Language->Phrase("UserProfileCorrupted");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->estate->SetVisibility();
		$this->grade->SetVisibility();
		$this->jenis->SetVisibility();
		$this->sack->SetVisibility();
		$this->netto->SetVisibility();
		$this->gross->SetVisibility();
		$this->open_bid->SetVisibility();
		$this->currency->SetVisibility();
		$this->bid_step->SetVisibility();
		$this->rate->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $tr_lelang_item;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tr_lelang_item);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tr_lelang_itemlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tr_lelang_item class, tr_lelang_iteminfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("tr_lelang_itemlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->row_id->setDbValue($row['row_id']);
		$this->master_id->setDbValue($row['master_id']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->estate->setDbValue($row['estate']);
		$this->grade->setDbValue($row['grade']);
		$this->jenis->setDbValue($row['jenis']);
		$this->sack->setDbValue($row['sack']);
		$this->netto->setDbValue($row['netto']);
		$this->gross->setDbValue($row['gross']);
		$this->open_bid->setDbValue($row['open_bid']);
		$this->currency->setDbValue($row['currency']);
		$this->bid_step->setDbValue($row['bid_step']);
		$this->rate->setDbValue($row['rate']);
		$this->winner_id->setDbValue($row['winner_id']);
		$this->sold_bid->setDbValue($row['sold_bid']);
		$this->proforma_number->setDbValue($row['proforma_number']);
		$this->proforma_amount->setDbValue($row['proforma_amount']);
		$this->proforma_status->setDbValue($row['proforma_status']);
		$this->auction_status->setDbValue($row['auction_status']);
		$this->enter_bid->setDbValue($row['enter_bid']);
		$this->last_bid->setDbValue($row['last_bid']);
		$this->highest_bid->setDbValue($row['highest_bid']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['row_id'] = NULL;
		$row['master_id'] = NULL;
		$row['lot_number'] = NULL;
		$row['chop'] = NULL;
		$row['estate'] = NULL;
		$row['grade'] = NULL;
		$row['jenis'] = NULL;
		$row['sack'] = NULL;
		$row['netto'] = NULL;
		$row['gross'] = NULL;
		$row['open_bid'] = NULL;
		$row['currency'] = NULL;
		$row['bid_step'] = NULL;
		$row['rate'] = NULL;
		$row['winner_id'] = NULL;
		$row['sold_bid'] = NULL;
		$row['proforma_number'] = NULL;
		$row['proforma_amount'] = NULL;
		$row['proforma_status'] = NULL;
		$row['auction_status'] = NULL;
		$row['enter_bid'] = NULL;
		$row['last_bid'] = NULL;
		$row['highest_bid'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->row_id->DbValue = $row['row_id'];
		$this->master_id->DbValue = $row['master_id'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->estate->DbValue = $row['estate'];
		$this->grade->DbValue = $row['grade'];
		$this->jenis->DbValue = $row['jenis'];
		$this->sack->DbValue = $row['sack'];
		$this->netto->DbValue = $row['netto'];
		$this->gross->DbValue = $row['gross'];
		$this->open_bid->DbValue = $row['open_bid'];
		$this->currency->DbValue = $row['currency'];
		$this->bid_step->DbValue = $row['bid_step'];
		$this->rate->DbValue = $row['rate'];
		$this->winner_id->DbValue = $row['winner_id'];
		$this->sold_bid->DbValue = $row['sold_bid'];
		$this->proforma_number->DbValue = $row['proforma_number'];
		$this->proforma_amount->DbValue = $row['proforma_amount'];
		$this->proforma_status->DbValue = $row['proforma_status'];
		$this->auction_status->DbValue = $row['auction_status'];
		$this->enter_bid->DbValue = $row['enter_bid'];
		$this->last_bid->DbValue = $row['last_bid'];
		$this->highest_bid->DbValue = $row['highest_bid'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->netto->FormValue == $this->netto->CurrentValue && is_numeric(ew_StrToFloat($this->netto->CurrentValue)))
			$this->netto->CurrentValue = ew_StrToFloat($this->netto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->gross->FormValue == $this->gross->CurrentValue && is_numeric(ew_StrToFloat($this->gross->CurrentValue)))
			$this->gross->CurrentValue = ew_StrToFloat($this->gross->CurrentValue);

		// Convert decimal values if posted back
		if ($this->open_bid->FormValue == $this->open_bid->CurrentValue && is_numeric(ew_StrToFloat($this->open_bid->CurrentValue)))
			$this->open_bid->CurrentValue = ew_StrToFloat($this->open_bid->CurrentValue);

		// Convert decimal values if posted back
		if ($this->bid_step->FormValue == $this->bid_step->CurrentValue && is_numeric(ew_StrToFloat($this->bid_step->CurrentValue)))
			$this->bid_step->CurrentValue = ew_StrToFloat($this->bid_step->CurrentValue);

		// Convert decimal values if posted back
		if ($this->rate->FormValue == $this->rate->CurrentValue && is_numeric(ew_StrToFloat($this->rate->CurrentValue)))
			$this->rate->CurrentValue = ew_StrToFloat($this->rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['row_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tr_lelang_master") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_row_id"] <> "") {
					$GLOBALS["tr_lelang_master"]->row_id->setQueryStringValue($_GET["fk_row_id"]);
					$this->master_id->setQueryStringValue($GLOBALS["tr_lelang_master"]->row_id->QueryStringValue);
					$this->master_id->setSessionValue($this->master_id->QueryStringValue);
					if (!is_numeric($GLOBALS["tr_lelang_master"]->row_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "tr_lelang_master") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_row_id"] <> "") {
					$GLOBALS["tr_lelang_master"]->row_id->setFormValue($_POST["fk_row_id"]);
					$this->master_id->setFormValue($GLOBALS["tr_lelang_master"]->row_id->FormValue);
					$this->master_id->setSessionValue($this->master_id->FormValue);
					if (!is_numeric($GLOBALS["tr_lelang_master"]->row_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "tr_lelang_master") {
				if ($this->master_id->CurrentValue == "") $this->master_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_lelang_itemlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tr_lelang_item_delete)) $tr_lelang_item_delete = new ctr_lelang_item_delete();

// Page init
$tr_lelang_item_delete->Page_Init();

// Page main
$tr_lelang_item_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_item_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftr_lelang_itemdelete = new ew_Form("ftr_lelang_itemdelete", "delete");

// Form_CustomValidate event
ftr_lelang_itemdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_itemdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_itemdelete.Lists["x_currency"] = {"LinkField":"x_id_cur","Ajax":true,"AutoFill":false,"DisplayFields":["x_currency","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tbl_currency"};
ftr_lelang_itemdelete.Lists["x_currency"].Data = "<?php echo $tr_lelang_item_delete->currency->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_lelang_item_delete->ShowPageHeader(); ?>
<?php
$tr_lelang_item_delete->ShowMessage();
?>
<form name="ftr_lelang_itemdelete" id="ftr_lelang_itemdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_lelang_item_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_lelang_item_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_lelang_item">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tr_lelang_item_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<th class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<th class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_chop" class="tr_lelang_item_chop"><?php echo $tr_lelang_item->chop->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<th class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_estate" class="tr_lelang_item_estate"><?php echo $tr_lelang_item->estate->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<th class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_grade" class="tr_lelang_item_grade"><?php echo $tr_lelang_item->grade->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<th class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_jenis" class="tr_lelang_item_jenis"><?php echo $tr_lelang_item->jenis->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<th class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_sack" class="tr_lelang_item_sack"><?php echo $tr_lelang_item->sack->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<th class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_netto" class="tr_lelang_item_netto"><?php echo $tr_lelang_item->netto->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<th class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_gross" class="tr_lelang_item_gross"><?php echo $tr_lelang_item->gross->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<th class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<th class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_currency" class="tr_lelang_item_currency"><?php echo $tr_lelang_item->currency->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<th class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<th class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><span id="elh_tr_lelang_item_rate" class="tr_lelang_item_rate"><?php echo $tr_lelang_item->rate->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tr_lelang_item_delete->RecCnt = 0;
$i = 0;
while (!$tr_lelang_item_delete->Recordset->EOF) {
	$tr_lelang_item_delete->RecCnt++;
	$tr_lelang_item_delete->RowCnt++;

	// Set row properties
	$tr_lelang_item->ResetAttrs();
	$tr_lelang_item->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tr_lelang_item_delete->LoadRowValues($tr_lelang_item_delete->Recordset);

	// Render row
	$tr_lelang_item_delete->RenderRow();
?>
	<tr<?php echo $tr_lelang_item->RowAttributes() ?>>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number">
<span<?php echo $tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $tr_lelang_item->lot_number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<td<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_chop" class="tr_lelang_item_chop">
<span<?php echo $tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $tr_lelang_item->chop->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<td<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_estate" class="tr_lelang_item_estate">
<span<?php echo $tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->estate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<td<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_grade" class="tr_lelang_item_grade">
<span<?php echo $tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $tr_lelang_item->grade->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<td<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_jenis" class="tr_lelang_item_jenis">
<span<?php echo $tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $tr_lelang_item->jenis->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<td<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_sack" class="tr_lelang_item_sack">
<span<?php echo $tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $tr_lelang_item->sack->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<td<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_netto" class="tr_lelang_item_netto">
<span<?php echo $tr_lelang_item->netto->ViewAttributes() ?>>
<?php echo $tr_lelang_item->netto->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<td<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_gross" class="tr_lelang_item_gross">
<span<?php echo $tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $tr_lelang_item->gross->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid">
<span<?php echo $tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_item->open_bid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<td<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_currency" class="tr_lelang_item_currency">
<span<?php echo $tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $tr_lelang_item->currency->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step">
<span<?php echo $tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $tr_lelang_item->bid_step->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<td<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_item_delete->RowCnt ?>_tr_lelang_item_rate" class="tr_lelang_item_rate">
<span<?php echo $tr_lelang_item->rate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->rate->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tr_lelang_item_delete->Recordset->MoveNext();
}
$tr_lelang_item_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_lelang_item_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftr_lelang_itemdelete.Init();
</script>
<?php
$tr_lelang_item_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_lelang_item_delete->Page_Terminate();
?>
