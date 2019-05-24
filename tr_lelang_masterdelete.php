<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tr_lelang_masterinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tr_lelang_master_delete = NULL; // Initialize page object first

class ctr_lelang_master_delete extends ctr_lelang_master {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_master';

	// Page object name
	var $PageObjName = 'tr_lelang_master_delete';

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

		// Table object (tr_lelang_master)
		if (!isset($GLOBALS["tr_lelang_master"]) || get_class($GLOBALS["tr_lelang_master"]) == "ctr_lelang_master") {
			$GLOBALS["tr_lelang_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tr_lelang_master"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tr_lelang_master', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tr_lelang_masterlist.php"));
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
		$this->auc_number->SetVisibility();
		$this->auc_place->SetVisibility();
		$this->start_bid->SetVisibility();
		$this->close_bid->SetVisibility();
		$this->auc_notes->SetVisibility();
		$this->total_sack->SetVisibility();
		$this->total_gross->SetVisibility();
		$this->auc_status->SetVisibility();

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
		global $EW_EXPORT, $tr_lelang_master;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tr_lelang_master);
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("tr_lelang_masterlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tr_lelang_master class, tr_lelang_masterinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("tr_lelang_masterlist.php"); // Return to list
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
		$this->auc_date->setDbValue($row['auc_date']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->auc_place->setDbValue($row['auc_place']);
		$this->start_bid->setDbValue($row['start_bid']);
		$this->close_bid->setDbValue($row['close_bid']);
		$this->auc_notes->setDbValue($row['auc_notes']);
		$this->total_sack->setDbValue($row['total_sack']);
		$this->total_netto->setDbValue($row['total_netto']);
		$this->total_gross->setDbValue($row['total_gross']);
		$this->auc_status->setDbValue($row['auc_status']);
		$this->rate->setDbValue($row['rate']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['row_id'] = NULL;
		$row['auc_date'] = NULL;
		$row['auc_number'] = NULL;
		$row['auc_place'] = NULL;
		$row['start_bid'] = NULL;
		$row['close_bid'] = NULL;
		$row['auc_notes'] = NULL;
		$row['total_sack'] = NULL;
		$row['total_netto'] = NULL;
		$row['total_gross'] = NULL;
		$row['auc_status'] = NULL;
		$row['rate'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->row_id->DbValue = $row['row_id'];
		$this->auc_date->DbValue = $row['auc_date'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->auc_place->DbValue = $row['auc_place'];
		$this->start_bid->DbValue = $row['start_bid'];
		$this->close_bid->DbValue = $row['close_bid'];
		$this->auc_notes->DbValue = $row['auc_notes'];
		$this->total_sack->DbValue = $row['total_sack'];
		$this->total_netto->DbValue = $row['total_netto'];
		$this->total_gross->DbValue = $row['total_gross'];
		$this->auc_status->DbValue = $row['auc_status'];
		$this->rate->DbValue = $row['rate'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->total_gross->FormValue == $this->total_gross->CurrentValue && is_numeric(ew_StrToFloat($this->total_gross->CurrentValue)))
			$this->total_gross->CurrentValue = ew_StrToFloat($this->total_gross->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// total_gross
			$this->total_gross->LinkCustomAttributes = "";
			$this->total_gross->HrefValue = "";
			$this->total_gross->TooltipValue = "";

			// auc_status
			$this->auc_status->LinkCustomAttributes = "";
			$this->auc_status->HrefValue = "";
			$this->auc_status->TooltipValue = "";
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_lelang_masterlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tr_lelang_master_delete)) $tr_lelang_master_delete = new ctr_lelang_master_delete();

// Page init
$tr_lelang_master_delete->Page_Init();

// Page main
$tr_lelang_master_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_master_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftr_lelang_masterdelete = new ew_Form("ftr_lelang_masterdelete", "delete");

// Form_CustomValidate event
ftr_lelang_masterdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_masterdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_masterdelete.Lists["x_auc_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_lelang_masterdelete.Lists["x_auc_status"].Options = <?php echo json_encode($tr_lelang_master_delete->auc_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_lelang_master_delete->ShowPageHeader(); ?>
<?php
$tr_lelang_master_delete->ShowMessage();
?>
<form name="ftr_lelang_masterdelete" id="ftr_lelang_masterdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_lelang_master_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_lelang_master_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_lelang_master">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tr_lelang_master_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tr_lelang_master->auc_number->Visible) { // auc_number ?>
		<th class="<?php echo $tr_lelang_master->auc_number->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_auc_number" class="tr_lelang_master_auc_number"><?php echo $tr_lelang_master->auc_number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->auc_place->Visible) { // auc_place ?>
		<th class="<?php echo $tr_lelang_master->auc_place->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_auc_place" class="tr_lelang_master_auc_place"><?php echo $tr_lelang_master->auc_place->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->start_bid->Visible) { // start_bid ?>
		<th class="<?php echo $tr_lelang_master->start_bid->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_start_bid" class="tr_lelang_master_start_bid"><?php echo $tr_lelang_master->start_bid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->close_bid->Visible) { // close_bid ?>
		<th class="<?php echo $tr_lelang_master->close_bid->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_close_bid" class="tr_lelang_master_close_bid"><?php echo $tr_lelang_master->close_bid->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
		<th class="<?php echo $tr_lelang_master->auc_notes->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_auc_notes" class="tr_lelang_master_auc_notes"><?php echo $tr_lelang_master->auc_notes->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->total_sack->Visible) { // total_sack ?>
		<th class="<?php echo $tr_lelang_master->total_sack->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_total_sack" class="tr_lelang_master_total_sack"><?php echo $tr_lelang_master->total_sack->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->total_gross->Visible) { // total_gross ?>
		<th class="<?php echo $tr_lelang_master->total_gross->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_total_gross" class="tr_lelang_master_total_gross"><?php echo $tr_lelang_master->total_gross->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_lelang_master->auc_status->Visible) { // auc_status ?>
		<th class="<?php echo $tr_lelang_master->auc_status->HeaderCellClass() ?>"><span id="elh_tr_lelang_master_auc_status" class="tr_lelang_master_auc_status"><?php echo $tr_lelang_master->auc_status->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tr_lelang_master_delete->RecCnt = 0;
$i = 0;
while (!$tr_lelang_master_delete->Recordset->EOF) {
	$tr_lelang_master_delete->RecCnt++;
	$tr_lelang_master_delete->RowCnt++;

	// Set row properties
	$tr_lelang_master->ResetAttrs();
	$tr_lelang_master->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tr_lelang_master_delete->LoadRowValues($tr_lelang_master_delete->Recordset);

	// Render row
	$tr_lelang_master_delete->RenderRow();
?>
	<tr<?php echo $tr_lelang_master->RowAttributes() ?>>
<?php if ($tr_lelang_master->auc_number->Visible) { // auc_number ?>
		<td<?php echo $tr_lelang_master->auc_number->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_auc_number" class="tr_lelang_master_auc_number">
<span<?php echo $tr_lelang_master->auc_number->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->auc_place->Visible) { // auc_place ?>
		<td<?php echo $tr_lelang_master->auc_place->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_auc_place" class="tr_lelang_master_auc_place">
<span<?php echo $tr_lelang_master->auc_place->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_place->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->start_bid->Visible) { // start_bid ?>
		<td<?php echo $tr_lelang_master->start_bid->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_start_bid" class="tr_lelang_master_start_bid">
<span<?php echo $tr_lelang_master->start_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_master->start_bid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->close_bid->Visible) { // close_bid ?>
		<td<?php echo $tr_lelang_master->close_bid->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_close_bid" class="tr_lelang_master_close_bid">
<span<?php echo $tr_lelang_master->close_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_master->close_bid->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
		<td<?php echo $tr_lelang_master->auc_notes->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_auc_notes" class="tr_lelang_master_auc_notes">
<span<?php echo $tr_lelang_master->auc_notes->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_notes->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->total_sack->Visible) { // total_sack ?>
		<td<?php echo $tr_lelang_master->total_sack->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_total_sack" class="tr_lelang_master_total_sack">
<span<?php echo $tr_lelang_master->total_sack->ViewAttributes() ?>>
<?php echo $tr_lelang_master->total_sack->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->total_gross->Visible) { // total_gross ?>
		<td<?php echo $tr_lelang_master->total_gross->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_total_gross" class="tr_lelang_master_total_gross">
<span<?php echo $tr_lelang_master->total_gross->ViewAttributes() ?>>
<?php echo $tr_lelang_master->total_gross->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_lelang_master->auc_status->Visible) { // auc_status ?>
		<td<?php echo $tr_lelang_master->auc_status->CellAttributes() ?>>
<span id="el<?php echo $tr_lelang_master_delete->RowCnt ?>_tr_lelang_master_auc_status" class="tr_lelang_master_auc_status">
<span<?php echo $tr_lelang_master->auc_status->ViewAttributes() ?>>
<?php echo $tr_lelang_master->auc_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tr_lelang_master_delete->Recordset->MoveNext();
}
$tr_lelang_master_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_lelang_master_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftr_lelang_masterdelete.Init();
</script>
<?php
$tr_lelang_master_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_lelang_master_delete->Page_Terminate();
?>
