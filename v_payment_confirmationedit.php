<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_payment_confirmationinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_payment_confirmation_edit = NULL; // Initialize page object first

class cv_payment_confirmation_edit extends cv_payment_confirmation {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_payment_confirmation';

	// Page object name
	var $PageObjName = 'v_payment_confirmation_edit';

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

		// Table object (v_payment_confirmation)
		if (!isset($GLOBALS["v_payment_confirmation"]) || get_class($GLOBALS["v_payment_confirmation"]) == "cv_payment_confirmation") {
			$GLOBALS["v_payment_confirmation"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_payment_confirmation"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_payment_confirmation', TRUE);

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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("v_payment_confirmationlist.php"));
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
		$this->invoice_number->SetVisibility();
		$this->payment_date->SetVisibility();
		$this->CompanyName->SetVisibility();
		$this->bank_from->SetVisibility();
		$this->payment_amount->SetVisibility();
		$this->curr_pay->SetVisibility();
		$this->proforma_number->SetVisibility();
		$this->proforma_amount->SetVisibility();
		$this->curr_ar->SetVisibility();
		$this->auc_number->SetVisibility();
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->user_id->SetVisibility();

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
		global $EW_EXPORT, $v_payment_confirmation;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_payment_confirmation);
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
					if ($pageName == "v_payment_confirmationview.php")
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_row_id")) {
				$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["row_id"])) {
				$this->row_id->setQueryStringValue($_GET["row_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->row_id->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("v_payment_confirmationlist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "v_payment_confirmationlist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->invoice_number->FldIsDetailKey) {
			$this->invoice_number->setFormValue($objForm->GetValue("x_invoice_number"));
		}
		if (!$this->payment_date->FldIsDetailKey) {
			$this->payment_date->setFormValue($objForm->GetValue("x_payment_date"));
			$this->payment_date->CurrentValue = ew_UnFormatDateTime($this->payment_date->CurrentValue, 7);
		}
		if (!$this->CompanyName->FldIsDetailKey) {
			$this->CompanyName->setFormValue($objForm->GetValue("x_CompanyName"));
		}
		if (!$this->bank_from->FldIsDetailKey) {
			$this->bank_from->setFormValue($objForm->GetValue("x_bank_from"));
		}
		if (!$this->payment_amount->FldIsDetailKey) {
			$this->payment_amount->setFormValue($objForm->GetValue("x_payment_amount"));
		}
		if (!$this->curr_pay->FldIsDetailKey) {
			$this->curr_pay->setFormValue($objForm->GetValue("x_curr_pay"));
		}
		if (!$this->proforma_number->FldIsDetailKey) {
			$this->proforma_number->setFormValue($objForm->GetValue("x_proforma_number"));
		}
		if (!$this->proforma_amount->FldIsDetailKey) {
			$this->proforma_amount->setFormValue($objForm->GetValue("x_proforma_amount"));
		}
		if (!$this->curr_ar->FldIsDetailKey) {
			$this->curr_ar->setFormValue($objForm->GetValue("x_curr_ar"));
		}
		if (!$this->auc_number->FldIsDetailKey) {
			$this->auc_number->setFormValue($objForm->GetValue("x_auc_number"));
		}
		if (!$this->lot_number->FldIsDetailKey) {
			$this->lot_number->setFormValue($objForm->GetValue("x_lot_number"));
		}
		if (!$this->chop->FldIsDetailKey) {
			$this->chop->setFormValue($objForm->GetValue("x_chop"));
		}
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->row_id->FldIsDetailKey)
			$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->row_id->CurrentValue = $this->row_id->FormValue;
		$this->invoice_number->CurrentValue = $this->invoice_number->FormValue;
		$this->payment_date->CurrentValue = $this->payment_date->FormValue;
		$this->payment_date->CurrentValue = ew_UnFormatDateTime($this->payment_date->CurrentValue, 7);
		$this->CompanyName->CurrentValue = $this->CompanyName->FormValue;
		$this->bank_from->CurrentValue = $this->bank_from->FormValue;
		$this->payment_amount->CurrentValue = $this->payment_amount->FormValue;
		$this->curr_pay->CurrentValue = $this->curr_pay->FormValue;
		$this->proforma_number->CurrentValue = $this->proforma_number->FormValue;
		$this->proforma_amount->CurrentValue = $this->proforma_amount->FormValue;
		$this->curr_ar->CurrentValue = $this->curr_ar->FormValue;
		$this->auc_number->CurrentValue = $this->auc_number->FormValue;
		$this->lot_number->CurrentValue = $this->lot_number->FormValue;
		$this->chop->CurrentValue = $this->chop->FormValue;
		$this->user_id->CurrentValue = $this->user_id->FormValue;
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
		$this->invoice_number->setDbValue($row['invoice_number']);
		$this->payment_date->setDbValue($row['payment_date']);
		$this->CompanyName->setDbValue($row['CompanyName']);
		$this->bank_from->setDbValue($row['bank_from']);
		$this->payment_amount->setDbValue($row['payment_amount']);
		$this->curr_pay->setDbValue($row['curr_pay']);
		$this->proforma_number->setDbValue($row['proforma_number']);
		$this->proforma_amount->setDbValue($row['proforma_amount']);
		$this->curr_ar->setDbValue($row['curr_ar']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->confirmed->setDbValue($row['confirmed']);
		$this->row_id->setDbValue($row['row_id']);
		$this->user_id->setDbValue($row['user_id']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['invoice_number'] = NULL;
		$row['payment_date'] = NULL;
		$row['CompanyName'] = NULL;
		$row['bank_from'] = NULL;
		$row['payment_amount'] = NULL;
		$row['curr_pay'] = NULL;
		$row['proforma_number'] = NULL;
		$row['proforma_amount'] = NULL;
		$row['curr_ar'] = NULL;
		$row['auc_number'] = NULL;
		$row['lot_number'] = NULL;
		$row['chop'] = NULL;
		$row['confirmed'] = NULL;
		$row['row_id'] = NULL;
		$row['user_id'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->invoice_number->DbValue = $row['invoice_number'];
		$this->payment_date->DbValue = $row['payment_date'];
		$this->CompanyName->DbValue = $row['CompanyName'];
		$this->bank_from->DbValue = $row['bank_from'];
		$this->payment_amount->DbValue = $row['payment_amount'];
		$this->curr_pay->DbValue = $row['curr_pay'];
		$this->proforma_number->DbValue = $row['proforma_number'];
		$this->proforma_amount->DbValue = $row['proforma_amount'];
		$this->curr_ar->DbValue = $row['curr_ar'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->confirmed->DbValue = $row['confirmed'];
		$this->row_id->DbValue = $row['row_id'];
		$this->user_id->DbValue = $row['user_id'];
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

		// Convert decimal values if posted back
		if ($this->proforma_amount->FormValue == $this->proforma_amount->CurrentValue && is_numeric(ew_StrToFloat($this->proforma_amount->CurrentValue)))
			$this->proforma_amount->CurrentValue = ew_StrToFloat($this->proforma_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// CompanyName
			$this->CompanyName->EditAttrs["class"] = "form-control";
			$this->CompanyName->EditCustomAttributes = "";
			$this->CompanyName->EditValue = ew_HtmlEncode($this->CompanyName->CurrentValue);
			$this->CompanyName->PlaceHolder = ew_RemoveHtml($this->CompanyName->FldCaption());

			// bank_from
			$this->bank_from->EditAttrs["class"] = "form-control";
			$this->bank_from->EditCustomAttributes = "";
			$this->bank_from->EditValue = ew_HtmlEncode($this->bank_from->CurrentValue);
			$this->bank_from->PlaceHolder = ew_RemoveHtml($this->bank_from->FldCaption());

			// payment_amount
			$this->payment_amount->EditAttrs["class"] = "form-control";
			$this->payment_amount->EditCustomAttributes = "";
			$this->payment_amount->EditValue = ew_HtmlEncode($this->payment_amount->CurrentValue);
			$this->payment_amount->PlaceHolder = ew_RemoveHtml($this->payment_amount->FldCaption());
			if (strval($this->payment_amount->EditValue) <> "" && is_numeric($this->payment_amount->EditValue)) $this->payment_amount->EditValue = ew_FormatNumber($this->payment_amount->EditValue, -2, -2, -2, -2);

			// curr_pay
			$this->curr_pay->EditAttrs["class"] = "form-control";
			$this->curr_pay->EditCustomAttributes = "";
			$this->curr_pay->EditValue = ew_HtmlEncode($this->curr_pay->CurrentValue);
			$this->curr_pay->PlaceHolder = ew_RemoveHtml($this->curr_pay->FldCaption());

			// proforma_number
			$this->proforma_number->EditAttrs["class"] = "form-control";
			$this->proforma_number->EditCustomAttributes = "";
			$this->proforma_number->EditValue = ew_HtmlEncode($this->proforma_number->CurrentValue);
			$this->proforma_number->PlaceHolder = ew_RemoveHtml($this->proforma_number->FldCaption());

			// proforma_amount
			$this->proforma_amount->EditAttrs["class"] = "form-control";
			$this->proforma_amount->EditCustomAttributes = "";
			$this->proforma_amount->EditValue = ew_HtmlEncode($this->proforma_amount->CurrentValue);
			$this->proforma_amount->PlaceHolder = ew_RemoveHtml($this->proforma_amount->FldCaption());
			if (strval($this->proforma_amount->EditValue) <> "" && is_numeric($this->proforma_amount->EditValue)) $this->proforma_amount->EditValue = ew_FormatNumber($this->proforma_amount->EditValue, -2, -2, -2, -2);

			// curr_ar
			$this->curr_ar->EditAttrs["class"] = "form-control";
			$this->curr_ar->EditCustomAttributes = "";
			$this->curr_ar->EditValue = ew_HtmlEncode($this->curr_ar->CurrentValue);
			$this->curr_ar->PlaceHolder = ew_RemoveHtml($this->curr_ar->FldCaption());

			// auc_number
			$this->auc_number->EditAttrs["class"] = "form-control";
			$this->auc_number->EditCustomAttributes = "";
			$this->auc_number->EditValue = ew_HtmlEncode($this->auc_number->CurrentValue);
			$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

			// lot_number
			$this->lot_number->EditAttrs["class"] = "form-control";
			$this->lot_number->EditCustomAttributes = "";
			$this->lot_number->EditValue = ew_HtmlEncode($this->lot_number->CurrentValue);
			$this->lot_number->PlaceHolder = ew_RemoveHtml($this->lot_number->FldCaption());

			// chop
			$this->chop->EditAttrs["class"] = "form-control";
			$this->chop->EditCustomAttributes = "";
			$this->chop->EditValue = ew_HtmlEncode($this->chop->CurrentValue);
			$this->chop->PlaceHolder = ew_RemoveHtml($this->chop->FldCaption());

			// user_id
			$this->user_id->EditCustomAttributes = "";
			if (trim(strval($this->user_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->user_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `user_id`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `members`";
			$sWhereWrk = "";
			$this->user_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["v_payment_confirmation"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->user_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->user_id->ViewValue = $this->user_id->DisplayValue($arwrk);
			} else {
				$this->user_id->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->user_id->EditValue = $arwrk;

			// Edit refer script
			// invoice_number

			$this->invoice_number->LinkCustomAttributes = "";
			$this->invoice_number->HrefValue = "";

			// payment_date
			$this->payment_date->LinkCustomAttributes = "";
			$this->payment_date->HrefValue = "";

			// CompanyName
			$this->CompanyName->LinkCustomAttributes = "";
			$this->CompanyName->HrefValue = "";

			// bank_from
			$this->bank_from->LinkCustomAttributes = "";
			$this->bank_from->HrefValue = "";

			// payment_amount
			$this->payment_amount->LinkCustomAttributes = "";
			$this->payment_amount->HrefValue = "";

			// curr_pay
			$this->curr_pay->LinkCustomAttributes = "";
			$this->curr_pay->HrefValue = "";

			// proforma_number
			$this->proforma_number->LinkCustomAttributes = "";
			$this->proforma_number->HrefValue = "";

			// proforma_amount
			$this->proforma_amount->LinkCustomAttributes = "";
			$this->proforma_amount->HrefValue = "";

			// curr_ar
			$this->curr_ar->LinkCustomAttributes = "";
			$this->curr_ar->HrefValue = "";

			// auc_number
			$this->auc_number->LinkCustomAttributes = "";
			$this->auc_number->HrefValue = "";

			// lot_number
			$this->lot_number->LinkCustomAttributes = "";
			$this->lot_number->HrefValue = "";

			// chop
			$this->chop->LinkCustomAttributes = "";
			$this->chop->HrefValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->payment_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->payment_date->FldErrMsg());
		}
		if (!ew_CheckNumber($this->payment_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->payment_amount->FldErrMsg());
		}
		if (!ew_CheckNumber($this->proforma_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->proforma_amount->FldErrMsg());
		}
		if (!$this->auc_number->FldIsDetailKey && !is_null($this->auc_number->FormValue) && $this->auc_number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->auc_number->FldCaption(), $this->auc_number->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->lot_number->FormValue)) {
			ew_AddMessage($gsFormError, $this->lot_number->FldErrMsg());
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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// invoice_number
			$this->invoice_number->SetDbValueDef($rsnew, $this->invoice_number->CurrentValue, NULL, $this->invoice_number->ReadOnly);

			// payment_date
			$this->payment_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->payment_date->CurrentValue, 7), NULL, $this->payment_date->ReadOnly);

			// CompanyName
			$this->CompanyName->SetDbValueDef($rsnew, $this->CompanyName->CurrentValue, NULL, $this->CompanyName->ReadOnly);

			// bank_from
			$this->bank_from->SetDbValueDef($rsnew, $this->bank_from->CurrentValue, NULL, $this->bank_from->ReadOnly);

			// payment_amount
			$this->payment_amount->SetDbValueDef($rsnew, $this->payment_amount->CurrentValue, NULL, $this->payment_amount->ReadOnly);

			// curr_pay
			$this->curr_pay->SetDbValueDef($rsnew, $this->curr_pay->CurrentValue, NULL, $this->curr_pay->ReadOnly);

			// proforma_number
			$this->proforma_number->SetDbValueDef($rsnew, $this->proforma_number->CurrentValue, NULL, $this->proforma_number->ReadOnly);

			// proforma_amount
			$this->proforma_amount->SetDbValueDef($rsnew, $this->proforma_amount->CurrentValue, NULL, $this->proforma_amount->ReadOnly);

			// curr_ar
			$this->curr_ar->SetDbValueDef($rsnew, $this->curr_ar->CurrentValue, NULL, $this->curr_ar->ReadOnly);

			// auc_number
			$this->auc_number->SetDbValueDef($rsnew, $this->auc_number->CurrentValue, NULL, $this->auc_number->ReadOnly);

			// lot_number
			$this->lot_number->SetDbValueDef($rsnew, $this->lot_number->CurrentValue, NULL, $this->lot_number->ReadOnly);

			// chop
			$this->chop->SetDbValueDef($rsnew, $this->chop->CurrentValue, NULL, $this->chop->ReadOnly);

			// user_id
			$this->user_id->SetDbValueDef($rsnew, $this->user_id->CurrentValue, NULL, $this->user_id->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("v_payment_confirmationlist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_user_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `user_id` AS `LinkFld`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			if (!$GLOBALS["v_payment_confirmation"]->UserIDAllow("edit")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`user_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->user_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($v_payment_confirmation_edit)) $v_payment_confirmation_edit = new cv_payment_confirmation_edit();

// Page init
$v_payment_confirmation_edit->Page_Init();

// Page main
$v_payment_confirmation_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_payment_confirmation_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fv_payment_confirmationedit = new ew_Form("fv_payment_confirmationedit", "edit");

// Validate form
fv_payment_confirmationedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_payment_date");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_payment_confirmation->payment_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_payment_amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_payment_confirmation->payment_amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_proforma_amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_payment_confirmation->proforma_amount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_auc_number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $v_payment_confirmation->auc_number->FldCaption(), $v_payment_confirmation->auc_number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_lot_number");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_payment_confirmation->lot_number->FldErrMsg()) ?>");

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
fv_payment_confirmationedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_payment_confirmationedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_payment_confirmationedit.Lists["x_user_id"] = {"LinkField":"x_user_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_CompanyName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"members"};
fv_payment_confirmationedit.Lists["x_user_id"].Data = "<?php echo $v_payment_confirmation_edit->user_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $v_payment_confirmation_edit->ShowPageHeader(); ?>
<?php
$v_payment_confirmation_edit->ShowMessage();
?>
<form name="fv_payment_confirmationedit" id="fv_payment_confirmationedit" class="<?php echo $v_payment_confirmation_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_payment_confirmation_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_payment_confirmation_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_payment_confirmation">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($v_payment_confirmation_edit->IsModal) ?>">
<?php if (!$v_payment_confirmation_edit->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
<div class="ewEditDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_v_payment_confirmationedit" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($v_payment_confirmation->invoice_number->Visible) { // invoice_number ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_invoice_number" class="form-group">
		<label id="elh_v_payment_confirmation_invoice_number" for="x_invoice_number" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->invoice_number->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->invoice_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_invoice_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_invoice_number" name="x_invoice_number" id="x_invoice_number" size="15" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->invoice_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->invoice_number->EditValue ?>"<?php echo $v_payment_confirmation->invoice_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->invoice_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_invoice_number">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_invoice_number"><?php echo $v_payment_confirmation->invoice_number->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->invoice_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_invoice_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_invoice_number" name="x_invoice_number" id="x_invoice_number" size="15" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->invoice_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->invoice_number->EditValue ?>"<?php echo $v_payment_confirmation->invoice_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->invoice_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->payment_date->Visible) { // payment_date ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_payment_date" class="form-group">
		<label id="elh_v_payment_confirmation_payment_date" for="x_payment_date" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->payment_date->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->payment_date->CellAttributes() ?>>
<span id="el_v_payment_confirmation_payment_date">
<input type="text" data-table="v_payment_confirmation" data-field="x_payment_date" data-format="7" name="x_payment_date" id="x_payment_date" size="15" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->payment_date->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->payment_date->EditValue ?>"<?php echo $v_payment_confirmation->payment_date->EditAttributes() ?>>
<?php if (!$v_payment_confirmation->payment_date->ReadOnly && !$v_payment_confirmation->payment_date->Disabled && !isset($v_payment_confirmation->payment_date->EditAttrs["readonly"]) && !isset($v_payment_confirmation->payment_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fv_payment_confirmationedit", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $v_payment_confirmation->payment_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_date">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_payment_date"><?php echo $v_payment_confirmation->payment_date->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->payment_date->CellAttributes() ?>>
<span id="el_v_payment_confirmation_payment_date">
<input type="text" data-table="v_payment_confirmation" data-field="x_payment_date" data-format="7" name="x_payment_date" id="x_payment_date" size="15" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->payment_date->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->payment_date->EditValue ?>"<?php echo $v_payment_confirmation->payment_date->EditAttributes() ?>>
<?php if (!$v_payment_confirmation->payment_date->ReadOnly && !$v_payment_confirmation->payment_date->Disabled && !isset($v_payment_confirmation->payment_date->EditAttrs["readonly"]) && !isset($v_payment_confirmation->payment_date->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fv_payment_confirmationedit", "x_payment_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
<?php echo $v_payment_confirmation->payment_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->CompanyName->Visible) { // CompanyName ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_CompanyName" class="form-group">
		<label id="elh_v_payment_confirmation_CompanyName" for="x_CompanyName" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->CompanyName->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->CompanyName->CellAttributes() ?>>
<span id="el_v_payment_confirmation_CompanyName">
<input type="text" data-table="v_payment_confirmation" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->CompanyName->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->CompanyName->EditValue ?>"<?php echo $v_payment_confirmation->CompanyName->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->CompanyName->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_CompanyName">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_CompanyName"><?php echo $v_payment_confirmation->CompanyName->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->CompanyName->CellAttributes() ?>>
<span id="el_v_payment_confirmation_CompanyName">
<input type="text" data-table="v_payment_confirmation" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->CompanyName->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->CompanyName->EditValue ?>"<?php echo $v_payment_confirmation->CompanyName->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->CompanyName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->bank_from->Visible) { // bank_from ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_bank_from" class="form-group">
		<label id="elh_v_payment_confirmation_bank_from" for="x_bank_from" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->bank_from->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->bank_from->CellAttributes() ?>>
<span id="el_v_payment_confirmation_bank_from">
<input type="text" data-table="v_payment_confirmation" data-field="x_bank_from" name="x_bank_from" id="x_bank_from" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->bank_from->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->bank_from->EditValue ?>"<?php echo $v_payment_confirmation->bank_from->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->bank_from->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bank_from">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_bank_from"><?php echo $v_payment_confirmation->bank_from->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->bank_from->CellAttributes() ?>>
<span id="el_v_payment_confirmation_bank_from">
<input type="text" data-table="v_payment_confirmation" data-field="x_bank_from" name="x_bank_from" id="x_bank_from" size="50" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->bank_from->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->bank_from->EditValue ?>"<?php echo $v_payment_confirmation->bank_from->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->bank_from->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->payment_amount->Visible) { // payment_amount ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_payment_amount" class="form-group">
		<label id="elh_v_payment_confirmation_payment_amount" for="x_payment_amount" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->payment_amount->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->payment_amount->CellAttributes() ?>>
<span id="el_v_payment_confirmation_payment_amount">
<input type="text" data-table="v_payment_confirmation" data-field="x_payment_amount" name="x_payment_amount" id="x_payment_amount" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->payment_amount->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->payment_amount->EditValue ?>"<?php echo $v_payment_confirmation->payment_amount->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->payment_amount->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_payment_amount">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_payment_amount"><?php echo $v_payment_confirmation->payment_amount->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->payment_amount->CellAttributes() ?>>
<span id="el_v_payment_confirmation_payment_amount">
<input type="text" data-table="v_payment_confirmation" data-field="x_payment_amount" name="x_payment_amount" id="x_payment_amount" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->payment_amount->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->payment_amount->EditValue ?>"<?php echo $v_payment_confirmation->payment_amount->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->payment_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->curr_pay->Visible) { // curr_pay ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_curr_pay" class="form-group">
		<label id="elh_v_payment_confirmation_curr_pay" for="x_curr_pay" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->curr_pay->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->curr_pay->CellAttributes() ?>>
<span id="el_v_payment_confirmation_curr_pay">
<input type="text" data-table="v_payment_confirmation" data-field="x_curr_pay" name="x_curr_pay" id="x_curr_pay" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->curr_pay->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->curr_pay->EditValue ?>"<?php echo $v_payment_confirmation->curr_pay->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->curr_pay->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_curr_pay">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_curr_pay"><?php echo $v_payment_confirmation->curr_pay->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->curr_pay->CellAttributes() ?>>
<span id="el_v_payment_confirmation_curr_pay">
<input type="text" data-table="v_payment_confirmation" data-field="x_curr_pay" name="x_curr_pay" id="x_curr_pay" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->curr_pay->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->curr_pay->EditValue ?>"<?php echo $v_payment_confirmation->curr_pay->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->curr_pay->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->proforma_number->Visible) { // proforma_number ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_proforma_number" class="form-group">
		<label id="elh_v_payment_confirmation_proforma_number" for="x_proforma_number" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->proforma_number->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->proforma_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_proforma_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_proforma_number" name="x_proforma_number" id="x_proforma_number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->proforma_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->proforma_number->EditValue ?>"<?php echo $v_payment_confirmation->proforma_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->proforma_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_proforma_number">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_proforma_number"><?php echo $v_payment_confirmation->proforma_number->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->proforma_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_proforma_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_proforma_number" name="x_proforma_number" id="x_proforma_number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->proforma_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->proforma_number->EditValue ?>"<?php echo $v_payment_confirmation->proforma_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->proforma_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->proforma_amount->Visible) { // proforma_amount ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_proforma_amount" class="form-group">
		<label id="elh_v_payment_confirmation_proforma_amount" for="x_proforma_amount" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->proforma_amount->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->proforma_amount->CellAttributes() ?>>
<span id="el_v_payment_confirmation_proforma_amount">
<input type="text" data-table="v_payment_confirmation" data-field="x_proforma_amount" name="x_proforma_amount" id="x_proforma_amount" size="30" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->proforma_amount->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->proforma_amount->EditValue ?>"<?php echo $v_payment_confirmation->proforma_amount->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->proforma_amount->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_proforma_amount">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_proforma_amount"><?php echo $v_payment_confirmation->proforma_amount->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->proforma_amount->CellAttributes() ?>>
<span id="el_v_payment_confirmation_proforma_amount">
<input type="text" data-table="v_payment_confirmation" data-field="x_proforma_amount" name="x_proforma_amount" id="x_proforma_amount" size="30" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->proforma_amount->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->proforma_amount->EditValue ?>"<?php echo $v_payment_confirmation->proforma_amount->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->proforma_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->curr_ar->Visible) { // curr_ar ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_curr_ar" class="form-group">
		<label id="elh_v_payment_confirmation_curr_ar" for="x_curr_ar" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->curr_ar->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->curr_ar->CellAttributes() ?>>
<span id="el_v_payment_confirmation_curr_ar">
<input type="text" data-table="v_payment_confirmation" data-field="x_curr_ar" name="x_curr_ar" id="x_curr_ar" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->curr_ar->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->curr_ar->EditValue ?>"<?php echo $v_payment_confirmation->curr_ar->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->curr_ar->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_curr_ar">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_curr_ar"><?php echo $v_payment_confirmation->curr_ar->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->curr_ar->CellAttributes() ?>>
<span id="el_v_payment_confirmation_curr_ar">
<input type="text" data-table="v_payment_confirmation" data-field="x_curr_ar" name="x_curr_ar" id="x_curr_ar" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->curr_ar->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->curr_ar->EditValue ?>"<?php echo $v_payment_confirmation->curr_ar->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->curr_ar->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->auc_number->Visible) { // auc_number ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_auc_number" class="form-group">
		<label id="elh_v_payment_confirmation_auc_number" for="x_auc_number" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->auc_number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->auc_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_auc_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" size="15" maxlength="15" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->auc_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->auc_number->EditValue ?>"<?php echo $v_payment_confirmation->auc_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->auc_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_number">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_auc_number"><?php echo $v_payment_confirmation->auc_number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $v_payment_confirmation->auc_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_auc_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" size="15" maxlength="15" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->auc_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->auc_number->EditValue ?>"<?php echo $v_payment_confirmation->auc_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->auc_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->lot_number->Visible) { // lot_number ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_lot_number" class="form-group">
		<label id="elh_v_payment_confirmation_lot_number" for="x_lot_number" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->lot_number->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->lot_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_lot_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->lot_number->EditValue ?>"<?php echo $v_payment_confirmation->lot_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->lot_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_lot_number">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_lot_number"><?php echo $v_payment_confirmation->lot_number->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->lot_number->CellAttributes() ?>>
<span id="el_v_payment_confirmation_lot_number">
<input type="text" data-table="v_payment_confirmation" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->lot_number->EditValue ?>"<?php echo $v_payment_confirmation->lot_number->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->lot_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->chop->Visible) { // chop ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_chop" class="form-group">
		<label id="elh_v_payment_confirmation_chop" for="x_chop" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->chop->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->chop->CellAttributes() ?>>
<span id="el_v_payment_confirmation_chop">
<input type="text" data-table="v_payment_confirmation" data-field="x_chop" name="x_chop" id="x_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->chop->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->chop->EditValue ?>"<?php echo $v_payment_confirmation->chop->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->chop->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_chop">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_chop"><?php echo $v_payment_confirmation->chop->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->chop->CellAttributes() ?>>
<span id="el_v_payment_confirmation_chop">
<input type="text" data-table="v_payment_confirmation" data-field="x_chop" name="x_chop" id="x_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_payment_confirmation->chop->getPlaceHolder()) ?>" value="<?php echo $v_payment_confirmation->chop->EditValue ?>"<?php echo $v_payment_confirmation->chop->EditAttributes() ?>>
</span>
<?php echo $v_payment_confirmation->chop->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation->user_id->Visible) { // user_id ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
	<div id="r_user_id" class="form-group">
		<label id="elh_v_payment_confirmation_user_id" for="x_user_id" class="<?php echo $v_payment_confirmation_edit->LeftColumnClass ?>"><?php echo $v_payment_confirmation->user_id->FldCaption() ?></label>
		<div class="<?php echo $v_payment_confirmation_edit->RightColumnClass ?>"><div<?php echo $v_payment_confirmation->user_id->CellAttributes() ?>>
<span id="el_v_payment_confirmation_user_id">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_payment_confirmation->user_id->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_payment_confirmation->user_id->ViewValue ?>
	</span>
	<?php if (!$v_payment_confirmation->user_id->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_user_id" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_payment_confirmation->user_id->RadioButtonListHtml(TRUE, "x_user_id") ?>
		</div>
	</div>
	<div id="tp_x_user_id" class="ewTemplate"><input type="radio" data-table="v_payment_confirmation" data-field="x_user_id" data-value-separator="<?php echo $v_payment_confirmation->user_id->DisplayValueSeparatorAttribute() ?>" name="x_user_id" id="x_user_id" value="{value}"<?php echo $v_payment_confirmation->user_id->EditAttributes() ?>></div>
</div>
</span>
<?php echo $v_payment_confirmation->user_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_user_id">
		<td class="col-sm-2"><span id="elh_v_payment_confirmation_user_id"><?php echo $v_payment_confirmation->user_id->FldCaption() ?></span></td>
		<td<?php echo $v_payment_confirmation->user_id->CellAttributes() ?>>
<span id="el_v_payment_confirmation_user_id">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_payment_confirmation->user_id->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_payment_confirmation->user_id->ViewValue ?>
	</span>
	<?php if (!$v_payment_confirmation->user_id->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_user_id" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_payment_confirmation->user_id->RadioButtonListHtml(TRUE, "x_user_id") ?>
		</div>
	</div>
	<div id="tp_x_user_id" class="ewTemplate"><input type="radio" data-table="v_payment_confirmation" data-field="x_user_id" data-value-separator="<?php echo $v_payment_confirmation->user_id->DisplayValueSeparatorAttribute() ?>" name="x_user_id" id="x_user_id" value="{value}"<?php echo $v_payment_confirmation->user_id->EditAttributes() ?>></div>
</div>
</span>
<?php echo $v_payment_confirmation->user_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_payment_confirmation_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<input type="hidden" data-table="v_payment_confirmation" data-field="x_row_id" name="x_row_id" id="x_row_id" value="<?php echo ew_HtmlEncode($v_payment_confirmation->row_id->CurrentValue) ?>">
<?php if (!$v_payment_confirmation_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $v_payment_confirmation_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $v_payment_confirmation_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$v_payment_confirmation_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
fv_payment_confirmationedit.Init();
</script>
<?php
$v_payment_confirmation_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_payment_confirmation_edit->Page_Terminate();
?>
