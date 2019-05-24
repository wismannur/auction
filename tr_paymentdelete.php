<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tr_paymentinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tr_payment_delete = NULL; // Initialize page object first

class ctr_payment_delete extends ctr_payment {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_payment';

	// Page object name
	var $PageObjName = 'tr_payment_delete';

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

		// Table object (tr_payment)
		if (!isset($GLOBALS["tr_payment"]) || get_class($GLOBALS["tr_payment"]) == "ctr_payment") {
			$GLOBALS["tr_payment"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tr_payment"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tr_payment', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tr_paymentlist.php"));
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
		$this->invoice_number->SetVisibility();
		$this->payment_date->SetVisibility();
		$this->payment_amount->SetVisibility();
		$this->currency->SetVisibility();
		$this->bank_from->SetVisibility();
		$this->bank_account->SetVisibility();
		$this->confirmed->SetVisibility();

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
		global $EW_EXPORT, $tr_payment;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tr_payment);
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
			$this->Page_Terminate("tr_paymentlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in tr_payment class, tr_paymentinfo.php

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
				$this->Page_Terminate("tr_paymentlist.php"); // Return to list
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
		$this->invoice_number->setDbValue($row['invoice_number']);
		$this->payment_date->setDbValue($row['payment_date']);
		$this->payment_amount->setDbValue($row['payment_amount']);
		$this->currency->setDbValue($row['currency']);
		$this->bank_from->setDbValue($row['bank_from']);
		$this->bank_account->setDbValue($row['bank_account']);
		$this->rate->setDbValue($row['rate']);
		$this->user_id->setDbValue($row['user_id']);
		$this->slip_file->Upload->DbValue = $row['slip_file'];
		$this->slip_file->setDbValue($this->slip_file->Upload->DbValue);
		$this->notes->setDbValue($row['notes']);
		$this->confirmed->setDbValue($row['confirmed']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['row_id'] = NULL;
		$row['master_id'] = NULL;
		$row['invoice_number'] = NULL;
		$row['payment_date'] = NULL;
		$row['payment_amount'] = NULL;
		$row['currency'] = NULL;
		$row['bank_from'] = NULL;
		$row['bank_account'] = NULL;
		$row['rate'] = NULL;
		$row['user_id'] = NULL;
		$row['slip_file'] = NULL;
		$row['notes'] = NULL;
		$row['confirmed'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->row_id->DbValue = $row['row_id'];
		$this->master_id->DbValue = $row['master_id'];
		$this->invoice_number->DbValue = $row['invoice_number'];
		$this->payment_date->DbValue = $row['payment_date'];
		$this->payment_amount->DbValue = $row['payment_amount'];
		$this->currency->DbValue = $row['currency'];
		$this->bank_from->DbValue = $row['bank_from'];
		$this->bank_account->DbValue = $row['bank_account'];
		$this->rate->DbValue = $row['rate'];
		$this->user_id->DbValue = $row['user_id'];
		$this->slip_file->Upload->DbValue = $row['slip_file'];
		$this->notes->DbValue = $row['notes'];
		$this->confirmed->DbValue = $row['confirmed'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->payment_amount->FormValue == $this->payment_amount->CurrentValue && is_numeric(ew_StrToFloat($this->payment_amount->CurrentValue)))
			$this->payment_amount->CurrentValue = ew_StrToFloat($this->payment_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

		// confirmed
		if (ew_ConvertToBool($this->confirmed->CurrentValue)) {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(2) <> "" ? $this->confirmed->FldTagCaption(2) : "1";
		} else {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(1) <> "" ? $this->confirmed->FldTagCaption(1) : "0";
		}
		$this->confirmed->ViewCustomAttributes = "";

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

			// confirmed
			$this->confirmed->LinkCustomAttributes = "";
			$this->confirmed->HrefValue = "";
			$this->confirmed->TooltipValue = "";
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_paymentlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tr_payment_delete)) $tr_payment_delete = new ctr_payment_delete();

// Page init
$tr_payment_delete->Page_Init();

// Page main
$tr_payment_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_payment_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = ftr_paymentdelete = new ew_Form("ftr_paymentdelete", "delete");

// Form_CustomValidate event
ftr_paymentdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_paymentdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_paymentdelete.Lists["x_currency"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_paymentdelete.Lists["x_currency"].Options = <?php echo json_encode($tr_payment_delete->currency->Options()) ?>;
ftr_paymentdelete.Lists["x_confirmed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_paymentdelete.Lists["x_confirmed[]"].Options = <?php echo json_encode($tr_payment_delete->confirmed->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_payment_delete->ShowPageHeader(); ?>
<?php
$tr_payment_delete->ShowMessage();
?>
<form name="ftr_paymentdelete" id="ftr_paymentdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_payment_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_payment_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_payment">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($tr_payment_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($tr_payment->invoice_number->Visible) { // invoice_number ?>
		<th class="<?php echo $tr_payment->invoice_number->HeaderCellClass() ?>"><span id="elh_tr_payment_invoice_number" class="tr_payment_invoice_number"><?php echo $tr_payment->invoice_number->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->payment_date->Visible) { // payment_date ?>
		<th class="<?php echo $tr_payment->payment_date->HeaderCellClass() ?>"><span id="elh_tr_payment_payment_date" class="tr_payment_payment_date"><?php echo $tr_payment->payment_date->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->payment_amount->Visible) { // payment_amount ?>
		<th class="<?php echo $tr_payment->payment_amount->HeaderCellClass() ?>"><span id="elh_tr_payment_payment_amount" class="tr_payment_payment_amount"><?php echo $tr_payment->payment_amount->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->currency->Visible) { // currency ?>
		<th class="<?php echo $tr_payment->currency->HeaderCellClass() ?>"><span id="elh_tr_payment_currency" class="tr_payment_currency"><?php echo $tr_payment->currency->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->bank_from->Visible) { // bank_from ?>
		<th class="<?php echo $tr_payment->bank_from->HeaderCellClass() ?>"><span id="elh_tr_payment_bank_from" class="tr_payment_bank_from"><?php echo $tr_payment->bank_from->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->bank_account->Visible) { // bank_account ?>
		<th class="<?php echo $tr_payment->bank_account->HeaderCellClass() ?>"><span id="elh_tr_payment_bank_account" class="tr_payment_bank_account"><?php echo $tr_payment->bank_account->FldCaption() ?></span></th>
<?php } ?>
<?php if ($tr_payment->confirmed->Visible) { // confirmed ?>
		<th class="<?php echo $tr_payment->confirmed->HeaderCellClass() ?>"><span id="elh_tr_payment_confirmed" class="tr_payment_confirmed"><?php echo $tr_payment->confirmed->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$tr_payment_delete->RecCnt = 0;
$i = 0;
while (!$tr_payment_delete->Recordset->EOF) {
	$tr_payment_delete->RecCnt++;
	$tr_payment_delete->RowCnt++;

	// Set row properties
	$tr_payment->ResetAttrs();
	$tr_payment->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$tr_payment_delete->LoadRowValues($tr_payment_delete->Recordset);

	// Render row
	$tr_payment_delete->RenderRow();
?>
	<tr<?php echo $tr_payment->RowAttributes() ?>>
<?php if ($tr_payment->invoice_number->Visible) { // invoice_number ?>
		<td<?php echo $tr_payment->invoice_number->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_invoice_number" class="tr_payment_invoice_number">
<span<?php echo $tr_payment->invoice_number->ViewAttributes() ?>>
<?php echo $tr_payment->invoice_number->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->payment_date->Visible) { // payment_date ?>
		<td<?php echo $tr_payment->payment_date->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_payment_date" class="tr_payment_payment_date">
<span<?php echo $tr_payment->payment_date->ViewAttributes() ?>>
<?php echo $tr_payment->payment_date->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->payment_amount->Visible) { // payment_amount ?>
		<td<?php echo $tr_payment->payment_amount->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_payment_amount" class="tr_payment_payment_amount">
<span<?php echo $tr_payment->payment_amount->ViewAttributes() ?>>
<?php echo $tr_payment->payment_amount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->currency->Visible) { // currency ?>
		<td<?php echo $tr_payment->currency->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_currency" class="tr_payment_currency">
<span<?php echo $tr_payment->currency->ViewAttributes() ?>>
<?php echo $tr_payment->currency->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->bank_from->Visible) { // bank_from ?>
		<td<?php echo $tr_payment->bank_from->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_bank_from" class="tr_payment_bank_from">
<span<?php echo $tr_payment->bank_from->ViewAttributes() ?>>
<?php echo $tr_payment->bank_from->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->bank_account->Visible) { // bank_account ?>
		<td<?php echo $tr_payment->bank_account->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_bank_account" class="tr_payment_bank_account">
<span<?php echo $tr_payment->bank_account->ViewAttributes() ?>>
<?php echo $tr_payment->bank_account->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($tr_payment->confirmed->Visible) { // confirmed ?>
		<td<?php echo $tr_payment->confirmed->CellAttributes() ?>>
<span id="el<?php echo $tr_payment_delete->RowCnt ?>_tr_payment_confirmed" class="tr_payment_confirmed">
<span<?php echo $tr_payment->confirmed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($tr_payment->confirmed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $tr_payment->confirmed->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $tr_payment->confirmed->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$tr_payment_delete->Recordset->MoveNext();
}
$tr_payment_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_payment_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
ftr_paymentdelete.Init();
</script>
<?php
$tr_payment_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_payment_delete->Page_Terminate();
?>
