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

$tr_payment_add = NULL; // Initialize page object first

class ctr_payment_add extends ctr_payment {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_payment';

	// Page object name
	var $PageObjName = 'tr_payment_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdd()) {
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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->master_id->SetVisibility();
		$this->invoice_number->SetVisibility();
		$this->payment_date->SetVisibility();
		$this->payment_amount->SetVisibility();
		$this->currency->SetVisibility();
		$this->bank_from->SetVisibility();
		$this->bank_account->SetVisibility();
		$this->slip_file->SetVisibility();
		$this->notes->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "tr_paymentview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["row_id"] != "") {
				$this->row_id->setQueryStringValue($_GET["row_id"]);
				$this->setKey("row_id", $this->row_id->CurrentValue); // Set up key
			} else {
				$this->setKey("row_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("tr_paymentlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tr_paymentlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tr_paymentview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->slip_file->Upload->Index = $objForm->Index;
		$this->slip_file->Upload->UploadFile();
		$this->slip_file->CurrentValue = $this->slip_file->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->row_id->CurrentValue = NULL;
		$this->row_id->OldValue = $this->row_id->CurrentValue;
		$this->master_id->CurrentValue = NULL;
		$this->master_id->OldValue = $this->master_id->CurrentValue;
		$this->invoice_number->CurrentValue = NULL;
		$this->invoice_number->OldValue = $this->invoice_number->CurrentValue;
		$this->payment_date->CurrentValue = ew_CurrentDate();
		$this->payment_amount->CurrentValue = NULL;
		$this->payment_amount->OldValue = $this->payment_amount->CurrentValue;
		$this->currency->CurrentValue = "IDR";
		$this->bank_from->CurrentValue = NULL;
		$this->bank_from->OldValue = $this->bank_from->CurrentValue;
		$this->bank_account->CurrentValue = NULL;
		$this->bank_account->OldValue = $this->bank_account->CurrentValue;
		$this->rate->CurrentValue = 1;
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
		$this->slip_file->Upload->DbValue = NULL;
		$this->slip_file->OldValue = $this->slip_file->Upload->DbValue;
		$this->slip_file->CurrentValue = NULL; // Clear file related field
		$this->notes->CurrentValue = NULL;
		$this->notes->OldValue = $this->notes->CurrentValue;
		$this->confirmed->CurrentValue = NULL;
		$this->confirmed->OldValue = $this->confirmed->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->master_id->FldIsDetailKey) {
			$this->master_id->setFormValue($objForm->GetValue("x_master_id"));
		}
		if (!$this->invoice_number->FldIsDetailKey) {
			$this->invoice_number->setFormValue($objForm->GetValue("x_invoice_number"));
		}
		if (!$this->payment_date->FldIsDetailKey) {
			$this->payment_date->setFormValue($objForm->GetValue("x_payment_date"));
			$this->payment_date->CurrentValue = ew_UnFormatDateTime($this->payment_date->CurrentValue, 7);
		}
		if (!$this->payment_amount->FldIsDetailKey) {
			$this->payment_amount->setFormValue($objForm->GetValue("x_payment_amount"));
		}
		if (!$this->currency->FldIsDetailKey) {
			$this->currency->setFormValue($objForm->GetValue("x_currency"));
		}
		if (!$this->bank_from->FldIsDetailKey) {
			$this->bank_from->setFormValue($objForm->GetValue("x_bank_from"));
		}
		if (!$this->bank_account->FldIsDetailKey) {
			$this->bank_account->setFormValue($objForm->GetValue("x_bank_account"));
		}
		if (!$this->notes->FldIsDetailKey) {
			$this->notes->setFormValue($objForm->GetValue("x_notes"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->master_id->CurrentValue = $this->master_id->FormValue;
		$this->invoice_number->CurrentValue = $this->invoice_number->FormValue;
		$this->payment_date->CurrentValue = $this->payment_date->FormValue;
		$this->payment_date->CurrentValue = ew_UnFormatDateTime($this->payment_date->CurrentValue, 7);
		$this->payment_amount->CurrentValue = $this->payment_amount->FormValue;
		$this->currency->CurrentValue = $this->currency->FormValue;
		$this->bank_from->CurrentValue = $this->bank_from->FormValue;
		$this->bank_account->CurrentValue = $this->bank_account->FormValue;
		$this->notes->CurrentValue = $this->notes->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['row_id'] = $this->row_id->CurrentValue;
		$row['master_id'] = $this->master_id->CurrentValue;
		$row['invoice_number'] = $this->invoice_number->CurrentValue;
		$row['payment_date'] = $this->payment_date->CurrentValue;
		$row['payment_amount'] = $this->payment_amount->CurrentValue;
		$row['currency'] = $this->currency->CurrentValue;
		$row['bank_from'] = $this->bank_from->CurrentValue;
		$row['bank_account'] = $this->bank_account->CurrentValue;
		$row['rate'] = $this->rate->CurrentValue;
		$row['user_id'] = $this->user_id->CurrentValue;
		$row['slip_file'] = $this->slip_file->Upload->DbValue;
		$row['notes'] = $this->notes->CurrentValue;
		$row['confirmed'] = $this->confirmed->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("row_id")) <> "")
			$this->row_id->CurrentValue = $this->getKey("row_id"); // row_id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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

			// slip_file
			$this->slip_file->LinkCustomAttributes = "";
			$this->slip_file->HrefValue = "";
			$this->slip_file->HrefValue2 = $this->slip_file->UploadPath . $this->slip_file->Upload->DbValue;
			$this->slip_file->TooltipValue = "";

			// notes
			$this->notes->LinkCustomAttributes = "";
			$this->notes->HrefValue = "";
			$this->notes->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// master_id
			$this->master_id->EditAttrs["class"] = "form-control";
			$this->master_id->EditCustomAttributes = "";
			$this->master_id->EditValue = ew_HtmlEncode($this->master_id->CurrentValue);
			$this->master_id->PlaceHolder = ew_RemoveHtml($this->master_id->FldCaption());

			// invoice_number
			$this->invoice_number->EditAttrs["class"] = "form-control";
			$this->invoice_number->EditCustomAttributes = "";
			$this->invoice_number->EditValue = ew_HtmlEncode($this->invoice_number->CurrentValue);
			$this->invoice_number->PlaceHolder = ew_RemoveHtml($this->invoice_number->FldCaption());

			// payment_date
			$this->payment_date->EditAttrs["class"] = "form-control";
			$this->payment_date->EditCustomAttributes = "";
			$this->payment_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->payment_date->CurrentValue, 7));
			$this->payment_date->PlaceHolder = ew_RemoveHtml($this->payment_date->FldCaption());

			// payment_amount
			$this->payment_amount->EditAttrs["class"] = "form-control";
			$this->payment_amount->EditCustomAttributes = "";
			$this->payment_amount->EditValue = ew_HtmlEncode($this->payment_amount->CurrentValue);
			$this->payment_amount->PlaceHolder = ew_RemoveHtml($this->payment_amount->FldCaption());
			if (strval($this->payment_amount->EditValue) <> "" && is_numeric($this->payment_amount->EditValue)) $this->payment_amount->EditValue = ew_FormatNumber($this->payment_amount->EditValue, -2, -1, -2, 0);

			// currency
			$this->currency->EditCustomAttributes = "";
			$this->currency->EditValue = $this->currency->Options(TRUE);

			// bank_from
			$this->bank_from->EditAttrs["class"] = "form-control";
			$this->bank_from->EditCustomAttributes = "";
			$this->bank_from->EditValue = ew_HtmlEncode($this->bank_from->CurrentValue);
			$this->bank_from->PlaceHolder = ew_RemoveHtml($this->bank_from->FldCaption());

			// bank_account
			$this->bank_account->EditAttrs["class"] = "form-control";
			$this->bank_account->EditCustomAttributes = "";
			$this->bank_account->EditValue = ew_HtmlEncode($this->bank_account->CurrentValue);
			$this->bank_account->PlaceHolder = ew_RemoveHtml($this->bank_account->FldCaption());

			// slip_file
			$this->slip_file->EditAttrs["class"] = "form-control";
			$this->slip_file->EditCustomAttributes = "";
			if (!ew_Empty($this->slip_file->Upload->DbValue)) {
				$this->slip_file->EditValue = $this->slip_file->Upload->DbValue;
			} else {
				$this->slip_file->EditValue = "";
			}
			if (!ew_Empty($this->slip_file->CurrentValue))
					$this->slip_file->Upload->FileName = $this->slip_file->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->slip_file);

			// notes
			$this->notes->EditAttrs["class"] = "form-control";
			$this->notes->EditCustomAttributes = "";
			$this->notes->EditValue = ew_HtmlEncode($this->notes->CurrentValue);
			$this->notes->PlaceHolder = ew_RemoveHtml($this->notes->FldCaption());

			// Add refer script
			// master_id

			$this->master_id->LinkCustomAttributes = "";
			$this->master_id->HrefValue = "";

			// invoice_number
			$this->invoice_number->LinkCustomAttributes = "";
			$this->invoice_number->HrefValue = "";

			// payment_date
			$this->payment_date->LinkCustomAttributes = "";
			$this->payment_date->HrefValue = "";

			// payment_amount
			$this->payment_amount->LinkCustomAttributes = "";
			$this->payment_amount->HrefValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";

			// bank_from
			$this->bank_from->LinkCustomAttributes = "";
			$this->bank_from->HrefValue = "";

			// bank_account
			$this->bank_account->LinkCustomAttributes = "";
			$this->bank_account->HrefValue = "";

			// slip_file
			$this->slip_file->LinkCustomAttributes = "";
			$this->slip_file->HrefValue = "";
			$this->slip_file->HrefValue2 = $this->slip_file->UploadPath . $this->slip_file->Upload->DbValue;

			// notes
			$this->notes->LinkCustomAttributes = "";
			$this->notes->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckInteger($this->master_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->master_id->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->payment_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->payment_date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->payment_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->payment_amount->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// master_id
		$this->master_id->SetDbValueDef($rsnew, $this->master_id->CurrentValue, NULL, FALSE);

		// invoice_number
		$this->invoice_number->SetDbValueDef($rsnew, $this->invoice_number->CurrentValue, NULL, FALSE);

		// payment_date
		$this->payment_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->payment_date->CurrentValue, 7), NULL, FALSE);

		// payment_amount
		$this->payment_amount->SetDbValueDef($rsnew, $this->payment_amount->CurrentValue, NULL, FALSE);

		// currency
		$this->currency->SetDbValueDef($rsnew, $this->currency->CurrentValue, NULL, strval($this->currency->CurrentValue) == "");

		// bank_from
		$this->bank_from->SetDbValueDef($rsnew, $this->bank_from->CurrentValue, NULL, FALSE);

		// bank_account
		$this->bank_account->SetDbValueDef($rsnew, $this->bank_account->CurrentValue, NULL, FALSE);

		// slip_file
		if ($this->slip_file->Visible && !$this->slip_file->Upload->KeepFile) {
			$this->slip_file->Upload->DbValue = ""; // No need to delete old file
			if ($this->slip_file->Upload->FileName == "") {
				$rsnew['slip_file'] = NULL;
			} else {
				$rsnew['slip_file'] = $this->slip_file->Upload->FileName;
			}
		}

		// notes
		$this->notes->SetDbValueDef($rsnew, $this->notes->CurrentValue, NULL, FALSE);
		if ($this->slip_file->Visible && !$this->slip_file->Upload->KeepFile) {
			$OldFiles = ew_Empty($this->slip_file->Upload->DbValue) ? array() : array($this->slip_file->Upload->DbValue);
			if (!ew_Empty($this->slip_file->Upload->FileName)) {
				$NewFiles = array($this->slip_file->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->slip_file->Upload->Index < 0) ? $this->slip_file->FldVar : substr($this->slip_file->FldVar, 0, 1) . $this->slip_file->Upload->Index . substr($this->slip_file->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->slip_file->TblVar) . $file)) {
							$file1 = ew_UploadFileNameEx($this->slip_file->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->slip_file->TblVar) . $file1) || file_exists($this->slip_file->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->slip_file->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->slip_file->TblVar) . $file, ew_UploadTempPath($fldvar, $this->slip_file->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->slip_file->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->slip_file->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->slip_file->SetDbValueDef($rsnew, $this->slip_file->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->slip_file->Visible && !$this->slip_file->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->slip_file->Upload->DbValue) ? array() : array($this->slip_file->Upload->DbValue);
					if (!ew_Empty($this->slip_file->Upload->FileName)) {
						$NewFiles = array($this->slip_file->Upload->FileName);
						$NewFiles2 = array($rsnew['slip_file']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->slip_file->Upload->Index < 0) ? $this->slip_file->FldVar : substr($this->slip_file->FldVar, 0, 1) . $this->slip_file->Upload->Index . substr($this->slip_file->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->slip_file->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->slip_file->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
										$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
										return FALSE;
									}
								}
							}
						}
					} else {
						$NewFiles = array();
					}
				}
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// slip_file
		ew_CleanUploadTempPath($this->slip_file, $this->slip_file->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_paymentlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($tr_payment_add)) $tr_payment_add = new ctr_payment_add();

// Page init
$tr_payment_add->Page_Init();

// Page main
$tr_payment_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_payment_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftr_paymentadd = new ew_Form("ftr_paymentadd", "add");

// Validate form
ftr_paymentadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_master_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_payment->master_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_payment_date");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_payment->payment_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_payment_amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_payment->payment_amount->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
ftr_paymentadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_paymentadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_paymentadd.Lists["x_currency"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_paymentadd.Lists["x_currency"].Options = <?php echo json_encode($tr_payment_add->currency->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_payment_add->ShowPageHeader(); ?>
<?php
$tr_payment_add->ShowMessage();
?>
<form name="ftr_paymentadd" id="ftr_paymentadd" class="<?php echo $tr_payment_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_payment_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_payment_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_payment">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tr_payment_add->IsModal) ?>">
<?php if (!$tr_payment_add->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
<div class="ewAddDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_tr_paymentadd" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($tr_payment->master_id->Visible) { // master_id ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_master_id" class="form-group">
		<label id="elh_tr_payment_master_id" for="x_master_id" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->master_id->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->master_id->CellAttributes() ?>>
<span id="el_tr_payment_master_id">
<input type="text" data-table="tr_payment" data-field="x_master_id" name="x_master_id" id="x_master_id" size="30" placeholder="<?php echo ew_HtmlEncode($tr_payment->master_id->getPlaceHolder()) ?>" value="<?php echo $tr_payment->master_id->EditValue ?>"<?php echo $tr_payment->master_id->EditAttributes() ?>>
</span>
<?php echo $tr_payment->master_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_master_id">
		<td class="col-sm-2"><span id="elh_tr_payment_master_id"><?php echo $tr_payment->master_id->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->master_id->CellAttributes() ?>>
<span id="el_tr_payment_master_id">
<input type="text" data-table="tr_payment" data-field="x_master_id" name="x_master_id" id="x_master_id" size="30" placeholder="<?php echo ew_HtmlEncode($tr_payment->master_id->getPlaceHolder()) ?>" value="<?php echo $tr_payment->master_id->EditValue ?>"<?php echo $tr_payment->master_id->EditAttributes() ?>>
</span>
<?php echo $tr_payment->master_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->invoice_number->Visible) { // invoice_number ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_invoice_number" class="form-group">
		<label id="elh_tr_payment_invoice_number" for="x_invoice_number" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->invoice_number->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->invoice_number->CellAttributes() ?>>
<span id="el_tr_payment_invoice_number">
<input type="text" data-table="tr_payment" data-field="x_invoice_number" name="x_invoice_number" id="x_invoice_number" size="15" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_payment->invoice_number->getPlaceHolder()) ?>" value="<?php echo $tr_payment->invoice_number->EditValue ?>"<?php echo $tr_payment->invoice_number->EditAttributes() ?>>
</span>
<?php echo $tr_payment->invoice_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_invoice_number">
		<td class="col-sm-2"><span id="elh_tr_payment_invoice_number"><?php echo $tr_payment->invoice_number->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->invoice_number->CellAttributes() ?>>
<span id="el_tr_payment_invoice_number">
<input type="text" data-table="tr_payment" data-field="x_invoice_number" name="x_invoice_number" id="x_invoice_number" size="15" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_payment->invoice_number->getPlaceHolder()) ?>" value="<?php echo $tr_payment->invoice_number->EditValue ?>"<?php echo $tr_payment->invoice_number->EditAttributes() ?>>
</span>
<?php echo $tr_payment->invoice_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->payment_date->Visible) { // payment_date ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_payment_date" class="form-group">
		<label id="elh_tr_payment_payment_date" for="x_payment_date" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->payment_date->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->payment_date->CellAttributes() ?>>
<span id="el_tr_payment_payment_date">
<input type="text" data-table="tr_payment" data-field="x_payment_date" data-format="7" name="x_payment_date" id="x_payment_date" size="15" placeholder="<?php echo ew_HtmlEncode($tr_payment->payment_date->getPlaceHolder()) ?>" value="<?php echo $tr_payment->payment_date->EditValue ?>"<?php echo $tr_payment->payment_date->EditAttributes() ?>>
<?php if (!$tr_payment->payment_date->ReadOnly && !$tr_payment->payment_date->Disabled && !isset($tr_payment->payment_date->EditAttrs["readonly"]) && !isset($tr_payment->payment_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ftr_paymentadd", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $tr_payment->payment_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_date">
		<td class="col-sm-2"><span id="elh_tr_payment_payment_date"><?php echo $tr_payment->payment_date->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->payment_date->CellAttributes() ?>>
<span id="el_tr_payment_payment_date">
<input type="text" data-table="tr_payment" data-field="x_payment_date" data-format="7" name="x_payment_date" id="x_payment_date" size="15" placeholder="<?php echo ew_HtmlEncode($tr_payment->payment_date->getPlaceHolder()) ?>" value="<?php echo $tr_payment->payment_date->EditValue ?>"<?php echo $tr_payment->payment_date->EditAttributes() ?>>
<?php if (!$tr_payment->payment_date->ReadOnly && !$tr_payment->payment_date->Disabled && !isset($tr_payment->payment_date->EditAttrs["readonly"]) && !isset($tr_payment->payment_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("ftr_paymentadd", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $tr_payment->payment_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->payment_amount->Visible) { // payment_amount ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_payment_amount" class="form-group">
		<label id="elh_tr_payment_payment_amount" for="x_payment_amount" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->payment_amount->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->payment_amount->CellAttributes() ?>>
<span id="el_tr_payment_payment_amount">
<input type="text" data-table="tr_payment" data-field="x_payment_amount" name="x_payment_amount" id="x_payment_amount" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($tr_payment->payment_amount->getPlaceHolder()) ?>" value="<?php echo $tr_payment->payment_amount->EditValue ?>"<?php echo $tr_payment->payment_amount->EditAttributes() ?>>
</span>
<?php echo $tr_payment->payment_amount->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_amount">
		<td class="col-sm-2"><span id="elh_tr_payment_payment_amount"><?php echo $tr_payment->payment_amount->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->payment_amount->CellAttributes() ?>>
<span id="el_tr_payment_payment_amount">
<input type="text" data-table="tr_payment" data-field="x_payment_amount" name="x_payment_amount" id="x_payment_amount" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($tr_payment->payment_amount->getPlaceHolder()) ?>" value="<?php echo $tr_payment->payment_amount->EditValue ?>"<?php echo $tr_payment->payment_amount->EditAttributes() ?>>
</span>
<?php echo $tr_payment->payment_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->currency->Visible) { // currency ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_currency" class="form-group">
		<label id="elh_tr_payment_currency" for="x_currency" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->currency->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->currency->CellAttributes() ?>>
<span id="el_tr_payment_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_payment->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_payment->currency->ViewValue ?>
	</span>
	<?php if (!$tr_payment->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_payment->currency->RadioButtonListHtml(TRUE, "x_currency") ?>
		</div>
	</div>
	<div id="tp_x_currency" class="ewTemplate"><input type="radio" data-table="tr_payment" data-field="x_currency" data-value-separator="<?php echo $tr_payment->currency->DisplayValueSeparatorAttribute() ?>" name="x_currency" id="x_currency" value="{value}"<?php echo $tr_payment->currency->EditAttributes() ?>></div>
</div>
</span>
<?php echo $tr_payment->currency->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_currency">
		<td class="col-sm-2"><span id="elh_tr_payment_currency"><?php echo $tr_payment->currency->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->currency->CellAttributes() ?>>
<span id="el_tr_payment_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_payment->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_payment->currency->ViewValue ?>
	</span>
	<?php if (!$tr_payment->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_payment->currency->RadioButtonListHtml(TRUE, "x_currency") ?>
		</div>
	</div>
	<div id="tp_x_currency" class="ewTemplate"><input type="radio" data-table="tr_payment" data-field="x_currency" data-value-separator="<?php echo $tr_payment->currency->DisplayValueSeparatorAttribute() ?>" name="x_currency" id="x_currency" value="{value}"<?php echo $tr_payment->currency->EditAttributes() ?>></div>
</div>
</span>
<?php echo $tr_payment->currency->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->bank_from->Visible) { // bank_from ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_bank_from" class="form-group">
		<label id="elh_tr_payment_bank_from" for="x_bank_from" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->bank_from->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->bank_from->CellAttributes() ?>>
<span id="el_tr_payment_bank_from">
<input type="text" data-table="tr_payment" data-field="x_bank_from" name="x_bank_from" id="x_bank_from" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_payment->bank_from->getPlaceHolder()) ?>" value="<?php echo $tr_payment->bank_from->EditValue ?>"<?php echo $tr_payment->bank_from->EditAttributes() ?>>
</span>
<?php echo $tr_payment->bank_from->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bank_from">
		<td class="col-sm-2"><span id="elh_tr_payment_bank_from"><?php echo $tr_payment->bank_from->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->bank_from->CellAttributes() ?>>
<span id="el_tr_payment_bank_from">
<input type="text" data-table="tr_payment" data-field="x_bank_from" name="x_bank_from" id="x_bank_from" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_payment->bank_from->getPlaceHolder()) ?>" value="<?php echo $tr_payment->bank_from->EditValue ?>"<?php echo $tr_payment->bank_from->EditAttributes() ?>>
</span>
<?php echo $tr_payment->bank_from->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->bank_account->Visible) { // bank_account ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_bank_account" class="form-group">
		<label id="elh_tr_payment_bank_account" for="x_bank_account" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->bank_account->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->bank_account->CellAttributes() ?>>
<span id="el_tr_payment_bank_account">
<input type="text" data-table="tr_payment" data-field="x_bank_account" name="x_bank_account" id="x_bank_account" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_payment->bank_account->getPlaceHolder()) ?>" value="<?php echo $tr_payment->bank_account->EditValue ?>"<?php echo $tr_payment->bank_account->EditAttributes() ?>>
</span>
<?php echo $tr_payment->bank_account->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bank_account">
		<td class="col-sm-2"><span id="elh_tr_payment_bank_account"><?php echo $tr_payment->bank_account->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->bank_account->CellAttributes() ?>>
<span id="el_tr_payment_bank_account">
<input type="text" data-table="tr_payment" data-field="x_bank_account" name="x_bank_account" id="x_bank_account" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_payment->bank_account->getPlaceHolder()) ?>" value="<?php echo $tr_payment->bank_account->EditValue ?>"<?php echo $tr_payment->bank_account->EditAttributes() ?>>
</span>
<?php echo $tr_payment->bank_account->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->slip_file->Visible) { // slip_file ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_slip_file" class="form-group">
		<label id="elh_tr_payment_slip_file" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->slip_file->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->slip_file->CellAttributes() ?>>
<span id="el_tr_payment_slip_file">
<div id="fd_x_slip_file">
<span title="<?php echo $tr_payment->slip_file->FldTitle() ? $tr_payment->slip_file->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($tr_payment->slip_file->ReadOnly || $tr_payment->slip_file->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="tr_payment" data-field="x_slip_file" name="x_slip_file" id="x_slip_file"<?php echo $tr_payment->slip_file->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_slip_file" id= "fn_x_slip_file" value="<?php echo $tr_payment->slip_file->Upload->FileName ?>">
<input type="hidden" name="fa_x_slip_file" id= "fa_x_slip_file" value="0">
<input type="hidden" name="fs_x_slip_file" id= "fs_x_slip_file" value="255">
<input type="hidden" name="fx_x_slip_file" id= "fx_x_slip_file" value="<?php echo $tr_payment->slip_file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_slip_file" id= "fm_x_slip_file" value="<?php echo $tr_payment->slip_file->UploadMaxFileSize ?>">
</div>
<table id="ft_x_slip_file" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $tr_payment->slip_file->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_slip_file">
		<td class="col-sm-2"><span id="elh_tr_payment_slip_file"><?php echo $tr_payment->slip_file->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->slip_file->CellAttributes() ?>>
<span id="el_tr_payment_slip_file">
<div id="fd_x_slip_file">
<span title="<?php echo $tr_payment->slip_file->FldTitle() ? $tr_payment->slip_file->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($tr_payment->slip_file->ReadOnly || $tr_payment->slip_file->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="tr_payment" data-field="x_slip_file" name="x_slip_file" id="x_slip_file"<?php echo $tr_payment->slip_file->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_slip_file" id= "fn_x_slip_file" value="<?php echo $tr_payment->slip_file->Upload->FileName ?>">
<input type="hidden" name="fa_x_slip_file" id= "fa_x_slip_file" value="0">
<input type="hidden" name="fs_x_slip_file" id= "fs_x_slip_file" value="255">
<input type="hidden" name="fx_x_slip_file" id= "fx_x_slip_file" value="<?php echo $tr_payment->slip_file->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_slip_file" id= "fm_x_slip_file" value="<?php echo $tr_payment->slip_file->UploadMaxFileSize ?>">
</div>
<table id="ft_x_slip_file" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $tr_payment->slip_file->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment->notes->Visible) { // notes ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
	<div id="r_notes" class="form-group">
		<label id="elh_tr_payment_notes" for="x_notes" class="<?php echo $tr_payment_add->LeftColumnClass ?>"><?php echo $tr_payment->notes->FldCaption() ?></label>
		<div class="<?php echo $tr_payment_add->RightColumnClass ?>"><div<?php echo $tr_payment->notes->CellAttributes() ?>>
<span id="el_tr_payment_notes">
<textarea data-table="tr_payment" data-field="x_notes" name="x_notes" id="x_notes" cols="50" rows="4" placeholder="<?php echo ew_HtmlEncode($tr_payment->notes->getPlaceHolder()) ?>"<?php echo $tr_payment->notes->EditAttributes() ?>><?php echo $tr_payment->notes->EditValue ?></textarea>
</span>
<?php echo $tr_payment->notes->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_notes">
		<td class="col-sm-2"><span id="elh_tr_payment_notes"><?php echo $tr_payment->notes->FldCaption() ?></span></td>
		<td<?php echo $tr_payment->notes->CellAttributes() ?>>
<span id="el_tr_payment_notes">
<textarea data-table="tr_payment" data-field="x_notes" name="x_notes" id="x_notes" cols="50" rows="4" placeholder="<?php echo ew_HtmlEncode($tr_payment->notes->getPlaceHolder()) ?>"<?php echo $tr_payment->notes->EditAttributes() ?>><?php echo $tr_payment->notes->EditValue ?></textarea>
</span>
<?php echo $tr_payment->notes->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_payment_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$tr_payment_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tr_payment_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_payment_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$tr_payment_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
ftr_paymentadd.Init();
</script>
<?php
$tr_payment_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_payment_add->Page_Terminate();
?>
