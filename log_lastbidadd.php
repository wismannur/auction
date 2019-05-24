<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "log_lastbidinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$log_lastbid_add = NULL; // Initialize page object first

class clog_lastbid_add extends clog_lastbid {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'log_lastbid';

	// Page object name
	var $PageObjName = 'log_lastbid_add';

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

		// Table object (log_lastbid)
		if (!isset($GLOBALS["log_lastbid"]) || get_class($GLOBALS["log_lastbid"]) == "clog_lastbid") {
			$GLOBALS["log_lastbid"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["log_lastbid"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'log_lastbid', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("log_lastbidlist.php"));
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
		$this->last_row_id->SetVisibility();
		$this->last_user_id->SetVisibility();
		$this->last_bid->SetVisibility();
		$this->last_time->SetVisibility();

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
		global $EW_EXPORT, $log_lastbid;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($log_lastbid);
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
					if ($pageName == "log_lastbidview.php")
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
			if (@$_GET["last_row_id"] != "") {
				$this->last_row_id->setQueryStringValue($_GET["last_row_id"]);
				$this->setKey("last_row_id", $this->last_row_id->CurrentValue); // Set up key
			} else {
				$this->setKey("last_row_id", ""); // Clear key
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
					$this->Page_Terminate("log_lastbidlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "log_lastbidlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "log_lastbidview.php")
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
	}

	// Load default values
	function LoadDefaultValues() {
		$this->last_row_id->CurrentValue = NULL;
		$this->last_row_id->OldValue = $this->last_row_id->CurrentValue;
		$this->last_user_id->CurrentValue = NULL;
		$this->last_user_id->OldValue = $this->last_user_id->CurrentValue;
		$this->last_bid->CurrentValue = NULL;
		$this->last_bid->OldValue = $this->last_bid->CurrentValue;
		$this->last_time->CurrentValue = NULL;
		$this->last_time->OldValue = $this->last_time->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->last_row_id->FldIsDetailKey) {
			$this->last_row_id->setFormValue($objForm->GetValue("x_last_row_id"));
		}
		if (!$this->last_user_id->FldIsDetailKey) {
			$this->last_user_id->setFormValue($objForm->GetValue("x_last_user_id"));
		}
		if (!$this->last_bid->FldIsDetailKey) {
			$this->last_bid->setFormValue($objForm->GetValue("x_last_bid"));
		}
		if (!$this->last_time->FldIsDetailKey) {
			$this->last_time->setFormValue($objForm->GetValue("x_last_time"));
			$this->last_time->CurrentValue = ew_UnFormatDateTime($this->last_time->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->last_row_id->CurrentValue = $this->last_row_id->FormValue;
		$this->last_user_id->CurrentValue = $this->last_user_id->FormValue;
		$this->last_bid->CurrentValue = $this->last_bid->FormValue;
		$this->last_time->CurrentValue = $this->last_time->FormValue;
		$this->last_time->CurrentValue = ew_UnFormatDateTime($this->last_time->CurrentValue, 0);
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
		$this->last_row_id->setDbValue($row['last_row_id']);
		$this->last_user_id->setDbValue($row['last_user_id']);
		$this->last_bid->setDbValue($row['last_bid']);
		$this->last_time->setDbValue($row['last_time']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['last_row_id'] = $this->last_row_id->CurrentValue;
		$row['last_user_id'] = $this->last_user_id->CurrentValue;
		$row['last_bid'] = $this->last_bid->CurrentValue;
		$row['last_time'] = $this->last_time->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->last_row_id->DbValue = $row['last_row_id'];
		$this->last_user_id->DbValue = $row['last_user_id'];
		$this->last_bid->DbValue = $row['last_bid'];
		$this->last_time->DbValue = $row['last_time'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("last_row_id")) <> "")
			$this->last_row_id->CurrentValue = $this->getKey("last_row_id"); // last_row_id
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

		if ($this->last_bid->FormValue == $this->last_bid->CurrentValue && is_numeric(ew_StrToFloat($this->last_bid->CurrentValue)))
			$this->last_bid->CurrentValue = ew_StrToFloat($this->last_bid->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// last_row_id
		// last_user_id
		// last_bid
		// last_time

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// last_row_id
		$this->last_row_id->ViewValue = $this->last_row_id->CurrentValue;
		$this->last_row_id->ViewCustomAttributes = "";

		// last_user_id
		$this->last_user_id->ViewValue = $this->last_user_id->CurrentValue;
		$this->last_user_id->ViewCustomAttributes = "";

		// last_bid
		$this->last_bid->ViewValue = $this->last_bid->CurrentValue;
		$this->last_bid->ViewCustomAttributes = "";

		// last_time
		$this->last_time->ViewValue = $this->last_time->CurrentValue;
		$this->last_time->ViewValue = ew_FormatDateTime($this->last_time->ViewValue, 0);
		$this->last_time->ViewCustomAttributes = "";

			// last_row_id
			$this->last_row_id->LinkCustomAttributes = "";
			$this->last_row_id->HrefValue = "";
			$this->last_row_id->TooltipValue = "";

			// last_user_id
			$this->last_user_id->LinkCustomAttributes = "";
			$this->last_user_id->HrefValue = "";
			$this->last_user_id->TooltipValue = "";

			// last_bid
			$this->last_bid->LinkCustomAttributes = "";
			$this->last_bid->HrefValue = "";
			$this->last_bid->TooltipValue = "";

			// last_time
			$this->last_time->LinkCustomAttributes = "";
			$this->last_time->HrefValue = "";
			$this->last_time->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// last_row_id
			$this->last_row_id->EditAttrs["class"] = "form-control";
			$this->last_row_id->EditCustomAttributes = "";
			$this->last_row_id->EditValue = ew_HtmlEncode($this->last_row_id->CurrentValue);
			$this->last_row_id->PlaceHolder = ew_RemoveHtml($this->last_row_id->FldCaption());

			// last_user_id
			$this->last_user_id->EditAttrs["class"] = "form-control";
			$this->last_user_id->EditCustomAttributes = "";
			$this->last_user_id->EditValue = ew_HtmlEncode($this->last_user_id->CurrentValue);
			$this->last_user_id->PlaceHolder = ew_RemoveHtml($this->last_user_id->FldCaption());

			// last_bid
			$this->last_bid->EditAttrs["class"] = "form-control";
			$this->last_bid->EditCustomAttributes = "";
			$this->last_bid->EditValue = ew_HtmlEncode($this->last_bid->CurrentValue);
			$this->last_bid->PlaceHolder = ew_RemoveHtml($this->last_bid->FldCaption());
			if (strval($this->last_bid->EditValue) <> "" && is_numeric($this->last_bid->EditValue)) $this->last_bid->EditValue = ew_FormatNumber($this->last_bid->EditValue, -2, -1, -2, 0);

			// last_time
			$this->last_time->EditAttrs["class"] = "form-control";
			$this->last_time->EditCustomAttributes = "";
			$this->last_time->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->last_time->CurrentValue, 8));
			$this->last_time->PlaceHolder = ew_RemoveHtml($this->last_time->FldCaption());

			// Add refer script
			// last_row_id

			$this->last_row_id->LinkCustomAttributes = "";
			$this->last_row_id->HrefValue = "";

			// last_user_id
			$this->last_user_id->LinkCustomAttributes = "";
			$this->last_user_id->HrefValue = "";

			// last_bid
			$this->last_bid->LinkCustomAttributes = "";
			$this->last_bid->HrefValue = "";

			// last_time
			$this->last_time->LinkCustomAttributes = "";
			$this->last_time->HrefValue = "";
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
		if (!$this->last_row_id->FldIsDetailKey && !is_null($this->last_row_id->FormValue) && $this->last_row_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->last_row_id->FldCaption(), $this->last_row_id->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->last_row_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_row_id->FldErrMsg());
		}
		if (!ew_CheckInteger($this->last_user_id->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_user_id->FldErrMsg());
		}
		if (!ew_CheckNumber($this->last_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_bid->FldErrMsg());
		}
		if (!ew_CheckDateDef($this->last_time->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_time->FldErrMsg());
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

		// last_row_id
		$this->last_row_id->SetDbValueDef($rsnew, $this->last_row_id->CurrentValue, 0, FALSE);

		// last_user_id
		$this->last_user_id->SetDbValueDef($rsnew, $this->last_user_id->CurrentValue, NULL, FALSE);

		// last_bid
		$this->last_bid->SetDbValueDef($rsnew, $this->last_bid->CurrentValue, NULL, FALSE);

		// last_time
		$this->last_time->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->last_time->CurrentValue, 0), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['last_row_id']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("log_lastbidlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($log_lastbid_add)) $log_lastbid_add = new clog_lastbid_add();

// Page init
$log_lastbid_add->Page_Init();

// Page main
$log_lastbid_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$log_lastbid_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = flog_lastbidadd = new ew_Form("flog_lastbidadd", "add");

// Validate form
flog_lastbidadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_last_row_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $log_lastbid->last_row_id->FldCaption(), $log_lastbid->last_row_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_last_row_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($log_lastbid->last_row_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_user_id");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($log_lastbid->last_user_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($log_lastbid->last_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_time");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($log_lastbid->last_time->FldErrMsg()) ?>");

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
flog_lastbidadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
flog_lastbidadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $log_lastbid_add->ShowPageHeader(); ?>
<?php
$log_lastbid_add->ShowMessage();
?>
<form name="flog_lastbidadd" id="flog_lastbidadd" class="<?php echo $log_lastbid_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($log_lastbid_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $log_lastbid_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="log_lastbid">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($log_lastbid_add->IsModal) ?>">
<?php if (!$log_lastbid_add->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
<div class="ewAddDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_log_lastbidadd" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($log_lastbid->last_row_id->Visible) { // last_row_id ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
	<div id="r_last_row_id" class="form-group">
		<label id="elh_log_lastbid_last_row_id" for="x_last_row_id" class="<?php echo $log_lastbid_add->LeftColumnClass ?>"><?php echo $log_lastbid->last_row_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $log_lastbid_add->RightColumnClass ?>"><div<?php echo $log_lastbid->last_row_id->CellAttributes() ?>>
<span id="el_log_lastbid_last_row_id">
<input type="text" data-table="log_lastbid" data-field="x_last_row_id" name="x_last_row_id" id="x_last_row_id" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_row_id->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_row_id->EditValue ?>"<?php echo $log_lastbid->last_row_id->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_row_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_last_row_id">
		<td class="col-sm-2"><span id="elh_log_lastbid_last_row_id"><?php echo $log_lastbid->last_row_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $log_lastbid->last_row_id->CellAttributes() ?>>
<span id="el_log_lastbid_last_row_id">
<input type="text" data-table="log_lastbid" data-field="x_last_row_id" name="x_last_row_id" id="x_last_row_id" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_row_id->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_row_id->EditValue ?>"<?php echo $log_lastbid->last_row_id->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_row_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($log_lastbid->last_user_id->Visible) { // last_user_id ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
	<div id="r_last_user_id" class="form-group">
		<label id="elh_log_lastbid_last_user_id" for="x_last_user_id" class="<?php echo $log_lastbid_add->LeftColumnClass ?>"><?php echo $log_lastbid->last_user_id->FldCaption() ?></label>
		<div class="<?php echo $log_lastbid_add->RightColumnClass ?>"><div<?php echo $log_lastbid->last_user_id->CellAttributes() ?>>
<span id="el_log_lastbid_last_user_id">
<input type="text" data-table="log_lastbid" data-field="x_last_user_id" name="x_last_user_id" id="x_last_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_user_id->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_user_id->EditValue ?>"<?php echo $log_lastbid->last_user_id->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_user_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_last_user_id">
		<td class="col-sm-2"><span id="elh_log_lastbid_last_user_id"><?php echo $log_lastbid->last_user_id->FldCaption() ?></span></td>
		<td<?php echo $log_lastbid->last_user_id->CellAttributes() ?>>
<span id="el_log_lastbid_last_user_id">
<input type="text" data-table="log_lastbid" data-field="x_last_user_id" name="x_last_user_id" id="x_last_user_id" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_user_id->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_user_id->EditValue ?>"<?php echo $log_lastbid->last_user_id->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_user_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($log_lastbid->last_bid->Visible) { // last_bid ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
	<div id="r_last_bid" class="form-group">
		<label id="elh_log_lastbid_last_bid" for="x_last_bid" class="<?php echo $log_lastbid_add->LeftColumnClass ?>"><?php echo $log_lastbid->last_bid->FldCaption() ?></label>
		<div class="<?php echo $log_lastbid_add->RightColumnClass ?>"><div<?php echo $log_lastbid->last_bid->CellAttributes() ?>>
<span id="el_log_lastbid_last_bid">
<input type="text" data-table="log_lastbid" data-field="x_last_bid" name="x_last_bid" id="x_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_bid->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_bid->EditValue ?>"<?php echo $log_lastbid->last_bid->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_bid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_last_bid">
		<td class="col-sm-2"><span id="elh_log_lastbid_last_bid"><?php echo $log_lastbid->last_bid->FldCaption() ?></span></td>
		<td<?php echo $log_lastbid->last_bid->CellAttributes() ?>>
<span id="el_log_lastbid_last_bid">
<input type="text" data-table="log_lastbid" data-field="x_last_bid" name="x_last_bid" id="x_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_bid->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_bid->EditValue ?>"<?php echo $log_lastbid->last_bid->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_bid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($log_lastbid->last_time->Visible) { // last_time ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
	<div id="r_last_time" class="form-group">
		<label id="elh_log_lastbid_last_time" for="x_last_time" class="<?php echo $log_lastbid_add->LeftColumnClass ?>"><?php echo $log_lastbid->last_time->FldCaption() ?></label>
		<div class="<?php echo $log_lastbid_add->RightColumnClass ?>"><div<?php echo $log_lastbid->last_time->CellAttributes() ?>>
<span id="el_log_lastbid_last_time">
<input type="text" data-table="log_lastbid" data-field="x_last_time" name="x_last_time" id="x_last_time" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_time->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_time->EditValue ?>"<?php echo $log_lastbid->last_time->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_time->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_last_time">
		<td class="col-sm-2"><span id="elh_log_lastbid_last_time"><?php echo $log_lastbid->last_time->FldCaption() ?></span></td>
		<td<?php echo $log_lastbid->last_time->CellAttributes() ?>>
<span id="el_log_lastbid_last_time">
<input type="text" data-table="log_lastbid" data-field="x_last_time" name="x_last_time" id="x_last_time" placeholder="<?php echo ew_HtmlEncode($log_lastbid->last_time->getPlaceHolder()) ?>" value="<?php echo $log_lastbid->last_time->EditValue ?>"<?php echo $log_lastbid->last_time->EditAttributes() ?>>
</span>
<?php echo $log_lastbid->last_time->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($log_lastbid_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$log_lastbid_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $log_lastbid_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $log_lastbid_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$log_lastbid_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
flog_lastbidadd.Init();
</script>
<?php
$log_lastbid_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$log_lastbid_add->Page_Terminate();
?>
