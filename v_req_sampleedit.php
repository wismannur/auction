<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_req_sampleinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_req_sample_edit = NULL; // Initialize page object first

class cv_req_sample_edit extends cv_req_sample {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_req_sample';

	// Page object name
	var $PageObjName = 'v_req_sample_edit';

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

		// Table object (v_req_sample)
		if (!isset($GLOBALS["v_req_sample"]) || get_class($GLOBALS["v_req_sample"]) == "cv_req_sample") {
			$GLOBALS["v_req_sample"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_req_sample"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_req_sample', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("v_req_samplelist.php"));
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
		$this->req_date->SetVisibility();
		$this->FullName->SetVisibility();
		$this->auc_number->SetVisibility();
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->grade->SetVisibility();
		$this->estate->SetVisibility();
		$this->sent_date->SetVisibility();
		$this->sudah_dikirim->SetVisibility();

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
		global $EW_EXPORT, $v_req_sample;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_req_sample);
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
					if ($pageName == "v_req_sampleview.php")
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
					$this->Page_Terminate("v_req_samplelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "v_req_samplelist.php")
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
		if (!$this->req_date->FldIsDetailKey) {
			$this->req_date->setFormValue($objForm->GetValue("x_req_date"));
			$this->req_date->CurrentValue = ew_UnFormatDateTime($this->req_date->CurrentValue, 2);
		}
		if (!$this->FullName->FldIsDetailKey) {
			$this->FullName->setFormValue($objForm->GetValue("x_FullName"));
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
		if (!$this->grade->FldIsDetailKey) {
			$this->grade->setFormValue($objForm->GetValue("x_grade"));
		}
		if (!$this->estate->FldIsDetailKey) {
			$this->estate->setFormValue($objForm->GetValue("x_estate"));
		}
		if (!$this->sent_date->FldIsDetailKey) {
			$this->sent_date->setFormValue($objForm->GetValue("x_sent_date"));
			$this->sent_date->CurrentValue = ew_UnFormatDateTime($this->sent_date->CurrentValue, 0);
		}
		if (!$this->sudah_dikirim->FldIsDetailKey) {
			$this->sudah_dikirim->setFormValue($objForm->GetValue("x_sudah_dikirim"));
		}
		if (!$this->row_id->FldIsDetailKey)
			$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->row_id->CurrentValue = $this->row_id->FormValue;
		$this->req_date->CurrentValue = $this->req_date->FormValue;
		$this->req_date->CurrentValue = ew_UnFormatDateTime($this->req_date->CurrentValue, 2);
		$this->FullName->CurrentValue = $this->FullName->FormValue;
		$this->auc_number->CurrentValue = $this->auc_number->FormValue;
		$this->lot_number->CurrentValue = $this->lot_number->FormValue;
		$this->chop->CurrentValue = $this->chop->FormValue;
		$this->grade->CurrentValue = $this->grade->FormValue;
		$this->estate->CurrentValue = $this->estate->FormValue;
		$this->sent_date->CurrentValue = $this->sent_date->FormValue;
		$this->sent_date->CurrentValue = ew_UnFormatDateTime($this->sent_date->CurrentValue, 0);
		$this->sudah_dikirim->CurrentValue = $this->sudah_dikirim->FormValue;
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
		$this->req_date->setDbValue($row['req_date']);
		$this->FullName->setDbValue($row['FullName']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->grade->setDbValue($row['grade']);
		$this->estate->setDbValue($row['estate']);
		$this->sent_date->setDbValue($row['sent_date']);
		$this->sudah_dikirim->setDbValue($row['sudah_dikirim']);
		$this->row_id->setDbValue($row['row_id']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['req_date'] = NULL;
		$row['FullName'] = NULL;
		$row['auc_number'] = NULL;
		$row['lot_number'] = NULL;
		$row['chop'] = NULL;
		$row['grade'] = NULL;
		$row['estate'] = NULL;
		$row['sent_date'] = NULL;
		$row['sudah_dikirim'] = NULL;
		$row['row_id'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->req_date->DbValue = $row['req_date'];
		$this->FullName->DbValue = $row['FullName'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->grade->DbValue = $row['grade'];
		$this->estate->DbValue = $row['estate'];
		$this->sent_date->DbValue = $row['sent_date'];
		$this->sudah_dikirim->DbValue = $row['sudah_dikirim'];
		$this->row_id->DbValue = $row['row_id'];
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// req_date
		// FullName
		// auc_number
		// lot_number
		// chop
		// grade
		// estate
		// sent_date
		// sudah_dikirim
		// row_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// req_date
		$this->req_date->ViewValue = $this->req_date->CurrentValue;
		$this->req_date->ViewValue = ew_FormatDateTime($this->req_date->ViewValue, 2);
		$this->req_date->CellCssStyle .= "text-align: center;";
		$this->req_date->ViewCustomAttributes = "";

		// FullName
		$this->FullName->ViewValue = $this->FullName->CurrentValue;
		$this->FullName->ViewCustomAttributes = "";

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
		$this->chop->CellCssStyle .= "text-align: center;";
		$this->chop->ViewCustomAttributes = "";

		// grade
		$this->grade->ViewValue = $this->grade->CurrentValue;
		$this->grade->ViewCustomAttributes = "";

		// estate
		$this->estate->ViewValue = $this->estate->CurrentValue;
		$this->estate->ViewCustomAttributes = "";

		// sent_date
		$this->sent_date->ViewValue = $this->sent_date->CurrentValue;
		$this->sent_date->ViewValue = ew_FormatDateTime($this->sent_date->ViewValue, 0);
		$this->sent_date->CellCssStyle .= "text-align: center;";
		$this->sent_date->ViewCustomAttributes = "";

		// sudah_dikirim
		if (ew_ConvertToBool($this->sudah_dikirim->CurrentValue)) {
			$this->sudah_dikirim->ViewValue = $this->sudah_dikirim->FldTagCaption(2) <> "" ? $this->sudah_dikirim->FldTagCaption(2) : "1";
		} else {
			$this->sudah_dikirim->ViewValue = $this->sudah_dikirim->FldTagCaption(1) <> "" ? $this->sudah_dikirim->FldTagCaption(1) : "0";
		}
		$this->sudah_dikirim->CellCssStyle .= "text-align: center;";
		$this->sudah_dikirim->ViewCustomAttributes = "";

			// req_date
			$this->req_date->LinkCustomAttributes = "";
			$this->req_date->HrefValue = "";
			$this->req_date->TooltipValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";
			$this->FullName->TooltipValue = "";

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

			// grade
			$this->grade->LinkCustomAttributes = "";
			$this->grade->HrefValue = "";
			$this->grade->TooltipValue = "";

			// estate
			$this->estate->LinkCustomAttributes = "";
			$this->estate->HrefValue = "";
			$this->estate->TooltipValue = "";

			// sent_date
			$this->sent_date->LinkCustomAttributes = "";
			$this->sent_date->HrefValue = "";
			$this->sent_date->TooltipValue = "";

			// sudah_dikirim
			$this->sudah_dikirim->LinkCustomAttributes = "";
			$this->sudah_dikirim->HrefValue = "";
			$this->sudah_dikirim->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// req_date
			$this->req_date->EditAttrs["class"] = "form-control";
			$this->req_date->EditCustomAttributes = "";
			$this->req_date->EditValue = $this->req_date->CurrentValue;
			$this->req_date->EditValue = ew_FormatDateTime($this->req_date->EditValue, 2);
			$this->req_date->CellCssStyle .= "text-align: center;";
			$this->req_date->ViewCustomAttributes = "";

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = $this->FullName->CurrentValue;
			$this->FullName->ViewCustomAttributes = "";

			// auc_number
			$this->auc_number->EditAttrs["class"] = "form-control";
			$this->auc_number->EditCustomAttributes = "";
			$this->auc_number->EditValue = $this->auc_number->CurrentValue;
			$this->auc_number->CellCssStyle .= "text-align: center;";
			$this->auc_number->ViewCustomAttributes = "";

			// lot_number
			$this->lot_number->EditAttrs["class"] = "form-control";
			$this->lot_number->EditCustomAttributes = "";
			$this->lot_number->EditValue = $this->lot_number->CurrentValue;
			$this->lot_number->CellCssStyle .= "text-align: center;";
			$this->lot_number->ViewCustomAttributes = "";

			// chop
			$this->chop->EditAttrs["class"] = "form-control";
			$this->chop->EditCustomAttributes = "";
			$this->chop->EditValue = $this->chop->CurrentValue;
			$this->chop->CellCssStyle .= "text-align: center;";
			$this->chop->ViewCustomAttributes = "";

			// grade
			$this->grade->EditAttrs["class"] = "form-control";
			$this->grade->EditCustomAttributes = "";
			$this->grade->EditValue = $this->grade->CurrentValue;
			$this->grade->ViewCustomAttributes = "";

			// estate
			$this->estate->EditAttrs["class"] = "form-control";
			$this->estate->EditCustomAttributes = "";
			$this->estate->EditValue = $this->estate->CurrentValue;
			$this->estate->ViewCustomAttributes = "";

			// sent_date
			$this->sent_date->EditAttrs["class"] = "form-control";
			$this->sent_date->EditCustomAttributes = "";
			$this->sent_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->sent_date->CurrentValue, 8));
			$this->sent_date->PlaceHolder = ew_RemoveHtml($this->sent_date->FldCaption());

			// sudah_dikirim
			$this->sudah_dikirim->EditCustomAttributes = "";
			$this->sudah_dikirim->EditValue = $this->sudah_dikirim->Options(FALSE);

			// Edit refer script
			// req_date

			$this->req_date->LinkCustomAttributes = "";
			$this->req_date->HrefValue = "";
			$this->req_date->TooltipValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";
			$this->FullName->TooltipValue = "";

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

			// grade
			$this->grade->LinkCustomAttributes = "";
			$this->grade->HrefValue = "";
			$this->grade->TooltipValue = "";

			// estate
			$this->estate->LinkCustomAttributes = "";
			$this->estate->HrefValue = "";
			$this->estate->TooltipValue = "";

			// sent_date
			$this->sent_date->LinkCustomAttributes = "";
			$this->sent_date->HrefValue = "";

			// sudah_dikirim
			$this->sudah_dikirim->LinkCustomAttributes = "";
			$this->sudah_dikirim->HrefValue = "";
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
		if (!ew_CheckDateDef($this->sent_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->sent_date->FldErrMsg());
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

			// sent_date
			$this->sent_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->sent_date->CurrentValue, 0), NULL, $this->sent_date->ReadOnly);

			// sudah_dikirim
			$tmpBool = $this->sudah_dikirim->CurrentValue;
			if ($tmpBool <> "1" && $tmpBool <> "0")
				$tmpBool = (!empty($tmpBool)) ? "1" : "0";
			$this->sudah_dikirim->SetDbValueDef($rsnew, $tmpBool, NULL, $this->sudah_dikirim->ReadOnly);

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("v_req_samplelist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($v_req_sample_edit)) $v_req_sample_edit = new cv_req_sample_edit();

// Page init
$v_req_sample_edit->Page_Init();

// Page main
$v_req_sample_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_req_sample_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fv_req_sampleedit = new ew_Form("fv_req_sampleedit", "edit");

// Validate form
fv_req_sampleedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_sent_date");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_req_sample->sent_date->FldErrMsg()) ?>");

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
fv_req_sampleedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_req_sampleedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_req_sampleedit.Lists["x_sudah_dikirim[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_req_sampleedit.Lists["x_sudah_dikirim[]"].Options = <?php echo json_encode($v_req_sample_edit->sudah_dikirim->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $v_req_sample_edit->ShowPageHeader(); ?>
<?php
$v_req_sample_edit->ShowMessage();
?>
<form name="fv_req_sampleedit" id="fv_req_sampleedit" class="<?php echo $v_req_sample_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_req_sample_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_req_sample_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_req_sample">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($v_req_sample_edit->IsModal) ?>">
<?php if (!$v_req_sample_edit->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
<div class="ewEditDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_v_req_sampleedit" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($v_req_sample->req_date->Visible) { // req_date ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_req_date" class="form-group">
		<label id="elh_v_req_sample_req_date" for="x_req_date" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->req_date->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->req_date->CellAttributes() ?>>
<span id="el_v_req_sample_req_date">
<span<?php echo $v_req_sample->req_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->req_date->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_req_date" name="x_req_date" id="x_req_date" value="<?php echo ew_HtmlEncode($v_req_sample->req_date->CurrentValue) ?>">
<?php echo $v_req_sample->req_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_req_date">
		<td class="col-sm-2"><span id="elh_v_req_sample_req_date"><?php echo $v_req_sample->req_date->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->req_date->CellAttributes() ?>>
<span id="el_v_req_sample_req_date">
<span<?php echo $v_req_sample->req_date->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->req_date->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_req_date" name="x_req_date" id="x_req_date" value="<?php echo ew_HtmlEncode($v_req_sample->req_date->CurrentValue) ?>">
<?php echo $v_req_sample->req_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->FullName->Visible) { // FullName ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_v_req_sample_FullName" for="x_FullName" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->FullName->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->FullName->CellAttributes() ?>>
<span id="el_v_req_sample_FullName">
<span<?php echo $v_req_sample->FullName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->FullName->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_FullName" name="x_FullName" id="x_FullName" value="<?php echo ew_HtmlEncode($v_req_sample->FullName->CurrentValue) ?>">
<?php echo $v_req_sample->FullName->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_FullName">
		<td class="col-sm-2"><span id="elh_v_req_sample_FullName"><?php echo $v_req_sample->FullName->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->FullName->CellAttributes() ?>>
<span id="el_v_req_sample_FullName">
<span<?php echo $v_req_sample->FullName->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->FullName->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_FullName" name="x_FullName" id="x_FullName" value="<?php echo ew_HtmlEncode($v_req_sample->FullName->CurrentValue) ?>">
<?php echo $v_req_sample->FullName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->auc_number->Visible) { // auc_number ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_auc_number" class="form-group">
		<label id="elh_v_req_sample_auc_number" for="x_auc_number" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->auc_number->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->auc_number->CellAttributes() ?>>
<span id="el_v_req_sample_auc_number">
<span<?php echo $v_req_sample->auc_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->auc_number->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" value="<?php echo ew_HtmlEncode($v_req_sample->auc_number->CurrentValue) ?>">
<?php echo $v_req_sample->auc_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_number">
		<td class="col-sm-2"><span id="elh_v_req_sample_auc_number"><?php echo $v_req_sample->auc_number->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->auc_number->CellAttributes() ?>>
<span id="el_v_req_sample_auc_number">
<span<?php echo $v_req_sample->auc_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->auc_number->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" value="<?php echo ew_HtmlEncode($v_req_sample->auc_number->CurrentValue) ?>">
<?php echo $v_req_sample->auc_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->lot_number->Visible) { // lot_number ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_lot_number" class="form-group">
		<label id="elh_v_req_sample_lot_number" for="x_lot_number" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->lot_number->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->lot_number->CellAttributes() ?>>
<span id="el_v_req_sample_lot_number">
<span<?php echo $v_req_sample->lot_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->lot_number->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" value="<?php echo ew_HtmlEncode($v_req_sample->lot_number->CurrentValue) ?>">
<?php echo $v_req_sample->lot_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_lot_number">
		<td class="col-sm-2"><span id="elh_v_req_sample_lot_number"><?php echo $v_req_sample->lot_number->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->lot_number->CellAttributes() ?>>
<span id="el_v_req_sample_lot_number">
<span<?php echo $v_req_sample->lot_number->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->lot_number->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" value="<?php echo ew_HtmlEncode($v_req_sample->lot_number->CurrentValue) ?>">
<?php echo $v_req_sample->lot_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->chop->Visible) { // chop ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_chop" class="form-group">
		<label id="elh_v_req_sample_chop" for="x_chop" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->chop->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->chop->CellAttributes() ?>>
<span id="el_v_req_sample_chop">
<span<?php echo $v_req_sample->chop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->chop->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_chop" name="x_chop" id="x_chop" value="<?php echo ew_HtmlEncode($v_req_sample->chop->CurrentValue) ?>">
<?php echo $v_req_sample->chop->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_chop">
		<td class="col-sm-2"><span id="elh_v_req_sample_chop"><?php echo $v_req_sample->chop->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->chop->CellAttributes() ?>>
<span id="el_v_req_sample_chop">
<span<?php echo $v_req_sample->chop->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->chop->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_chop" name="x_chop" id="x_chop" value="<?php echo ew_HtmlEncode($v_req_sample->chop->CurrentValue) ?>">
<?php echo $v_req_sample->chop->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->grade->Visible) { // grade ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_grade" class="form-group">
		<label id="elh_v_req_sample_grade" for="x_grade" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->grade->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->grade->CellAttributes() ?>>
<span id="el_v_req_sample_grade">
<span<?php echo $v_req_sample->grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->grade->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_grade" name="x_grade" id="x_grade" value="<?php echo ew_HtmlEncode($v_req_sample->grade->CurrentValue) ?>">
<?php echo $v_req_sample->grade->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_grade">
		<td class="col-sm-2"><span id="elh_v_req_sample_grade"><?php echo $v_req_sample->grade->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->grade->CellAttributes() ?>>
<span id="el_v_req_sample_grade">
<span<?php echo $v_req_sample->grade->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->grade->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_grade" name="x_grade" id="x_grade" value="<?php echo ew_HtmlEncode($v_req_sample->grade->CurrentValue) ?>">
<?php echo $v_req_sample->grade->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->estate->Visible) { // estate ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_estate" class="form-group">
		<label id="elh_v_req_sample_estate" for="x_estate" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->estate->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->estate->CellAttributes() ?>>
<span id="el_v_req_sample_estate">
<span<?php echo $v_req_sample->estate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->estate->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_estate" name="x_estate" id="x_estate" value="<?php echo ew_HtmlEncode($v_req_sample->estate->CurrentValue) ?>">
<?php echo $v_req_sample->estate->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_estate">
		<td class="col-sm-2"><span id="elh_v_req_sample_estate"><?php echo $v_req_sample->estate->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->estate->CellAttributes() ?>>
<span id="el_v_req_sample_estate">
<span<?php echo $v_req_sample->estate->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_req_sample->estate->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_req_sample" data-field="x_estate" name="x_estate" id="x_estate" value="<?php echo ew_HtmlEncode($v_req_sample->estate->CurrentValue) ?>">
<?php echo $v_req_sample->estate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->sent_date->Visible) { // sent_date ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_sent_date" class="form-group">
		<label id="elh_v_req_sample_sent_date" for="x_sent_date" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->sent_date->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->sent_date->CellAttributes() ?>>
<span id="el_v_req_sample_sent_date">
<input type="text" data-table="v_req_sample" data-field="x_sent_date" name="x_sent_date" id="x_sent_date" placeholder="<?php echo ew_HtmlEncode($v_req_sample->sent_date->getPlaceHolder()) ?>" value="<?php echo $v_req_sample->sent_date->EditValue ?>"<?php echo $v_req_sample->sent_date->EditAttributes() ?>>
</span>
<?php echo $v_req_sample->sent_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_sent_date">
		<td class="col-sm-2"><span id="elh_v_req_sample_sent_date"><?php echo $v_req_sample->sent_date->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->sent_date->CellAttributes() ?>>
<span id="el_v_req_sample_sent_date">
<input type="text" data-table="v_req_sample" data-field="x_sent_date" name="x_sent_date" id="x_sent_date" placeholder="<?php echo ew_HtmlEncode($v_req_sample->sent_date->getPlaceHolder()) ?>" value="<?php echo $v_req_sample->sent_date->EditValue ?>"<?php echo $v_req_sample->sent_date->EditAttributes() ?>>
</span>
<?php echo $v_req_sample->sent_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample->sudah_dikirim->Visible) { // sudah_dikirim ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
	<div id="r_sudah_dikirim" class="form-group">
		<label id="elh_v_req_sample_sudah_dikirim" class="<?php echo $v_req_sample_edit->LeftColumnClass ?>"><?php echo $v_req_sample->sudah_dikirim->FldCaption() ?></label>
		<div class="<?php echo $v_req_sample_edit->RightColumnClass ?>"><div<?php echo $v_req_sample->sudah_dikirim->CellAttributes() ?>>
<span id="el_v_req_sample_sudah_dikirim">
<?php
$selwrk = (ew_ConvertToBool($v_req_sample->sudah_dikirim->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="v_req_sample" data-field="x_sudah_dikirim" name="x_sudah_dikirim[]" id="x_sudah_dikirim[]" value="1"<?php echo $selwrk ?><?php echo $v_req_sample->sudah_dikirim->EditAttributes() ?>>
</span>
<?php echo $v_req_sample->sudah_dikirim->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_sudah_dikirim">
		<td class="col-sm-2"><span id="elh_v_req_sample_sudah_dikirim"><?php echo $v_req_sample->sudah_dikirim->FldCaption() ?></span></td>
		<td<?php echo $v_req_sample->sudah_dikirim->CellAttributes() ?>>
<span id="el_v_req_sample_sudah_dikirim">
<?php
$selwrk = (ew_ConvertToBool($v_req_sample->sudah_dikirim->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="v_req_sample" data-field="x_sudah_dikirim" name="x_sudah_dikirim[]" id="x_sudah_dikirim[]" value="1"<?php echo $selwrk ?><?php echo $v_req_sample->sudah_dikirim->EditAttributes() ?>>
</span>
<?php echo $v_req_sample->sudah_dikirim->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($v_req_sample_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<input type="hidden" data-table="v_req_sample" data-field="x_row_id" name="x_row_id" id="x_row_id" value="<?php echo ew_HtmlEncode($v_req_sample->row_id->CurrentValue) ?>">
<?php if (!$v_req_sample_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $v_req_sample_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $v_req_sample_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$v_req_sample_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
fv_req_sampleedit.Init();
</script>
<?php
$v_req_sample_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_req_sample_edit->Page_Terminate();
?>
