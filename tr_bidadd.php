<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tr_bidinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tr_bid_add = NULL; // Initialize page object first

class ctr_bid_add extends ctr_bid {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_bid';

	// Page object name
	var $PageObjName = 'tr_bid_add';

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

		// Table object (tr_bid)
		if (!isset($GLOBALS["tr_bid"]) || get_class($GLOBALS["tr_bid"]) == "ctr_bid") {
			$GLOBALS["tr_bid"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tr_bid"];
		}

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tr_bid', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("tr_bidlist.php"));
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
		$this->user_id->SetVisibility();
		$this->bid_time->SetVisibility();
		$this->bid_value->SetVisibility();
		$this->bid_time_ms->SetVisibility();

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
		global $EW_EXPORT, $tr_bid;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tr_bid);
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
					if ($pageName == "tr_bidview.php")
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
					$this->Page_Terminate("tr_bidlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "tr_bidlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tr_bidview.php")
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
		$this->row_id->CurrentValue = NULL;
		$this->row_id->OldValue = $this->row_id->CurrentValue;
		$this->master_id->CurrentValue = NULL;
		$this->master_id->OldValue = $this->master_id->CurrentValue;
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
		$this->bid_time->CurrentValue = ew_CurrentDateTime();
		$this->bid_value->CurrentValue = NULL;
		$this->bid_value->OldValue = $this->bid_value->CurrentValue;
		$this->bid_winner->CurrentValue = "N";
		$this->bid_time_ms->CurrentValue = NULL;
		$this->bid_time_ms->OldValue = $this->bid_time_ms->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->master_id->FldIsDetailKey) {
			$this->master_id->setFormValue($objForm->GetValue("x_master_id"));
		}
		if (!$this->user_id->FldIsDetailKey) {
			$this->user_id->setFormValue($objForm->GetValue("x_user_id"));
		}
		if (!$this->bid_time->FldIsDetailKey) {
			$this->bid_time->setFormValue($objForm->GetValue("x_bid_time"));
			$this->bid_time->CurrentValue = ew_UnFormatDateTime($this->bid_time->CurrentValue, 11);
		}
		if (!$this->bid_value->FldIsDetailKey) {
			$this->bid_value->setFormValue($objForm->GetValue("x_bid_value"));
		}
		if (!$this->bid_time_ms->FldIsDetailKey) {
			$this->bid_time_ms->setFormValue($objForm->GetValue("x_bid_time_ms"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->master_id->CurrentValue = $this->master_id->FormValue;
		$this->user_id->CurrentValue = $this->user_id->FormValue;
		$this->bid_time->CurrentValue = $this->bid_time->FormValue;
		$this->bid_time->CurrentValue = ew_UnFormatDateTime($this->bid_time->CurrentValue, 11);
		$this->bid_value->CurrentValue = $this->bid_value->FormValue;
		$this->bid_time_ms->CurrentValue = $this->bid_time_ms->FormValue;
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
		$this->user_id->setDbValue($row['user_id']);
		$this->bid_time->setDbValue($row['bid_time']);
		$this->bid_value->setDbValue($row['bid_value']);
		$this->bid_winner->setDbValue($row['bid_winner']);
		$this->bid_time_ms->setDbValue($row['bid_time_ms']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['row_id'] = $this->row_id->CurrentValue;
		$row['master_id'] = $this->master_id->CurrentValue;
		$row['user_id'] = $this->user_id->CurrentValue;
		$row['bid_time'] = $this->bid_time->CurrentValue;
		$row['bid_value'] = $this->bid_value->CurrentValue;
		$row['bid_winner'] = $this->bid_winner->CurrentValue;
		$row['bid_time_ms'] = $this->bid_time_ms->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->row_id->DbValue = $row['row_id'];
		$this->master_id->DbValue = $row['master_id'];
		$this->user_id->DbValue = $row['user_id'];
		$this->bid_time->DbValue = $row['bid_time'];
		$this->bid_value->DbValue = $row['bid_value'];
		$this->bid_winner->DbValue = $row['bid_winner'];
		$this->bid_time_ms->DbValue = $row['bid_time_ms'];
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

		if ($this->bid_value->FormValue == $this->bid_value->CurrentValue && is_numeric(ew_StrToFloat($this->bid_value->CurrentValue)))
			$this->bid_value->CurrentValue = ew_StrToFloat($this->bid_value->CurrentValue);

		// Convert decimal values if posted back
		if ($this->bid_time_ms->FormValue == $this->bid_time_ms->CurrentValue && is_numeric(ew_StrToFloat($this->bid_time_ms->CurrentValue)))
			$this->bid_time_ms->CurrentValue = ew_StrToFloat($this->bid_time_ms->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// row_id
		// master_id
		// user_id
		// bid_time
		// bid_value
		// bid_winner
		// bid_time_ms

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// master_id
		$this->master_id->ViewValue = $this->master_id->CurrentValue;
		$this->master_id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		if (strval($this->user_id->CurrentValue) <> "") {
			$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->user_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `user_id`, `FullName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
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

		// bid_time
		$this->bid_time->ViewValue = $this->bid_time->CurrentValue;
		$this->bid_time->ViewValue = ew_FormatDateTime($this->bid_time->ViewValue, 11);
		$this->bid_time->ViewCustomAttributes = "";

		// bid_value
		$this->bid_value->ViewValue = $this->bid_value->CurrentValue;
		$this->bid_value->ViewCustomAttributes = "";

		// bid_time_ms
		$this->bid_time_ms->ViewValue = $this->bid_time_ms->CurrentValue;
		$this->bid_time_ms->ViewCustomAttributes = "";

			// master_id
			$this->master_id->LinkCustomAttributes = "";
			$this->master_id->HrefValue = "";
			$this->master_id->TooltipValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";
			$this->user_id->TooltipValue = "";

			// bid_time
			$this->bid_time->LinkCustomAttributes = "";
			$this->bid_time->HrefValue = "";
			$this->bid_time->TooltipValue = "";

			// bid_value
			$this->bid_value->LinkCustomAttributes = "";
			$this->bid_value->HrefValue = "";
			$this->bid_value->TooltipValue = "";

			// bid_time_ms
			$this->bid_time_ms->LinkCustomAttributes = "";
			$this->bid_time_ms->HrefValue = "";
			$this->bid_time_ms->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// master_id
			$this->master_id->EditAttrs["class"] = "form-control";
			$this->master_id->EditCustomAttributes = "";
			$this->master_id->EditValue = ew_HtmlEncode($this->master_id->CurrentValue);
			$this->master_id->PlaceHolder = ew_RemoveHtml($this->master_id->FldCaption());

			// user_id
			// bid_time
			// bid_value

			$this->bid_value->EditAttrs["class"] = "form-control";
			$this->bid_value->EditCustomAttributes = "";
			$this->bid_value->EditValue = ew_HtmlEncode($this->bid_value->CurrentValue);
			$this->bid_value->PlaceHolder = ew_RemoveHtml($this->bid_value->FldCaption());
			if (strval($this->bid_value->EditValue) <> "" && is_numeric($this->bid_value->EditValue)) $this->bid_value->EditValue = ew_FormatNumber($this->bid_value->EditValue, -2, -1, -2, 0);

			// bid_time_ms
			$this->bid_time_ms->EditAttrs["class"] = "form-control";
			$this->bid_time_ms->EditCustomAttributes = "";
			$this->bid_time_ms->EditValue = ew_HtmlEncode($this->bid_time_ms->CurrentValue);
			$this->bid_time_ms->PlaceHolder = ew_RemoveHtml($this->bid_time_ms->FldCaption());
			if (strval($this->bid_time_ms->EditValue) <> "" && is_numeric($this->bid_time_ms->EditValue)) $this->bid_time_ms->EditValue = ew_FormatNumber($this->bid_time_ms->EditValue, -2, -1, -2, 0);

			// Add refer script
			// master_id

			$this->master_id->LinkCustomAttributes = "";
			$this->master_id->HrefValue = "";

			// user_id
			$this->user_id->LinkCustomAttributes = "";
			$this->user_id->HrefValue = "";

			// bid_time
			$this->bid_time->LinkCustomAttributes = "";
			$this->bid_time->HrefValue = "";

			// bid_value
			$this->bid_value->LinkCustomAttributes = "";
			$this->bid_value->HrefValue = "";

			// bid_time_ms
			$this->bid_time_ms->LinkCustomAttributes = "";
			$this->bid_time_ms->HrefValue = "";
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
		if (!ew_CheckNumber($this->bid_value->FormValue)) {
			ew_AddMessage($gsFormError, $this->bid_value->FldErrMsg());
		}
		if (!ew_CheckNumber($this->bid_time_ms->FormValue)) {
			ew_AddMessage($gsFormError, $this->bid_time_ms->FldErrMsg());
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

		// user_id
		$this->user_id->SetDbValueDef($rsnew, CurrentUserID(), NULL);
		$rsnew['user_id'] = &$this->user_id->DbValue;

		// bid_time
		$this->bid_time->SetDbValueDef($rsnew, ew_CurrentDateTime(), NULL);
		$rsnew['bid_time'] = &$this->bid_time->DbValue;

		// bid_value
		$this->bid_value->SetDbValueDef($rsnew, $this->bid_value->CurrentValue, NULL, FALSE);

		// bid_time_ms
		$this->bid_time_ms->SetDbValueDef($rsnew, $this->bid_time_ms->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_bidlist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_user_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `user_id` AS `LinkFld`, `FullName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
			$sWhereWrk = "{filter}";
			$fld->LookupFilters = array();
			if (!$GLOBALS["tr_bid"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
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
		case "x_user_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `user_id`, `FullName` AS `DispFld` FROM `members`";
			$sWhereWrk = "`FullName` LIKE '{query_value}%'";
			$fld->LookupFilters = array();
			if (!$GLOBALS["tr_bid"]->UserIDAllow("add")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->user_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
if (!isset($tr_bid_add)) $tr_bid_add = new ctr_bid_add();

// Page init
$tr_bid_add->Page_Init();

// Page main
$tr_bid_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_bid_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftr_bidadd = new ew_Form("ftr_bidadd", "add");

// Validate form
ftr_bidadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_bid->master_id->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_value");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_bid->bid_value->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_time_ms");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_bid->bid_time_ms->FldErrMsg()) ?>");

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
ftr_bidadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_bidadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_bidadd.Lists["x_user_id"] = {"LinkField":"x_user_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_FullName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"members"};
ftr_bidadd.Lists["x_user_id"].Data = "<?php echo $tr_bid_add->user_id->LookupFilterQuery(FALSE, "add") ?>";
ftr_bidadd.AutoSuggests["x_user_id"] = <?php echo json_encode(array("data" => "ajax=autosuggest&" . $tr_bid_add->user_id->LookupFilterQuery(TRUE, "add"))) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_bid_add->ShowPageHeader(); ?>
<?php
$tr_bid_add->ShowMessage();
?>
<form name="ftr_bidadd" id="ftr_bidadd" class="<?php echo $tr_bid_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_bid_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_bid_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_bid">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tr_bid_add->IsModal) ?>">
<?php if (!$tr_bid_add->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($tr_bid_add->IsMobileOrModal) { ?>
<div class="ewAddDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_tr_bidadd" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($tr_bid->master_id->Visible) { // master_id ?>
<?php if ($tr_bid_add->IsMobileOrModal) { ?>
	<div id="r_master_id" class="form-group">
		<label id="elh_tr_bid_master_id" for="x_master_id" class="<?php echo $tr_bid_add->LeftColumnClass ?>"><?php echo $tr_bid->master_id->FldCaption() ?></label>
		<div class="<?php echo $tr_bid_add->RightColumnClass ?>"><div<?php echo $tr_bid->master_id->CellAttributes() ?>>
<span id="el_tr_bid_master_id">
<input type="text" data-table="tr_bid" data-field="x_master_id" name="x_master_id" id="x_master_id" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->master_id->getPlaceHolder()) ?>" value="<?php echo $tr_bid->master_id->EditValue ?>"<?php echo $tr_bid->master_id->EditAttributes() ?>>
</span>
<?php echo $tr_bid->master_id->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_master_id">
		<td class="col-sm-2"><span id="elh_tr_bid_master_id"><?php echo $tr_bid->master_id->FldCaption() ?></span></td>
		<td<?php echo $tr_bid->master_id->CellAttributes() ?>>
<span id="el_tr_bid_master_id">
<input type="text" data-table="tr_bid" data-field="x_master_id" name="x_master_id" id="x_master_id" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->master_id->getPlaceHolder()) ?>" value="<?php echo $tr_bid->master_id->EditValue ?>"<?php echo $tr_bid->master_id->EditAttributes() ?>>
</span>
<?php echo $tr_bid->master_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_bid->bid_value->Visible) { // bid_value ?>
<?php if ($tr_bid_add->IsMobileOrModal) { ?>
	<div id="r_bid_value" class="form-group">
		<label id="elh_tr_bid_bid_value" for="x_bid_value" class="<?php echo $tr_bid_add->LeftColumnClass ?>"><?php echo $tr_bid->bid_value->FldCaption() ?></label>
		<div class="<?php echo $tr_bid_add->RightColumnClass ?>"><div<?php echo $tr_bid->bid_value->CellAttributes() ?>>
<span id="el_tr_bid_bid_value">
<input type="text" data-table="tr_bid" data-field="x_bid_value" name="x_bid_value" id="x_bid_value" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->bid_value->getPlaceHolder()) ?>" value="<?php echo $tr_bid->bid_value->EditValue ?>"<?php echo $tr_bid->bid_value->EditAttributes() ?>>
</span>
<?php echo $tr_bid->bid_value->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bid_value">
		<td class="col-sm-2"><span id="elh_tr_bid_bid_value"><?php echo $tr_bid->bid_value->FldCaption() ?></span></td>
		<td<?php echo $tr_bid->bid_value->CellAttributes() ?>>
<span id="el_tr_bid_bid_value">
<input type="text" data-table="tr_bid" data-field="x_bid_value" name="x_bid_value" id="x_bid_value" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->bid_value->getPlaceHolder()) ?>" value="<?php echo $tr_bid->bid_value->EditValue ?>"<?php echo $tr_bid->bid_value->EditAttributes() ?>>
</span>
<?php echo $tr_bid->bid_value->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_bid->bid_time_ms->Visible) { // bid_time_ms ?>
<?php if ($tr_bid_add->IsMobileOrModal) { ?>
	<div id="r_bid_time_ms" class="form-group">
		<label id="elh_tr_bid_bid_time_ms" for="x_bid_time_ms" class="<?php echo $tr_bid_add->LeftColumnClass ?>"><?php echo $tr_bid->bid_time_ms->FldCaption() ?></label>
		<div class="<?php echo $tr_bid_add->RightColumnClass ?>"><div<?php echo $tr_bid->bid_time_ms->CellAttributes() ?>>
<span id="el_tr_bid_bid_time_ms">
<input type="text" data-table="tr_bid" data-field="x_bid_time_ms" name="x_bid_time_ms" id="x_bid_time_ms" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->bid_time_ms->getPlaceHolder()) ?>" value="<?php echo $tr_bid->bid_time_ms->EditValue ?>"<?php echo $tr_bid->bid_time_ms->EditAttributes() ?>>
</span>
<?php echo $tr_bid->bid_time_ms->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bid_time_ms">
		<td class="col-sm-2"><span id="elh_tr_bid_bid_time_ms"><?php echo $tr_bid->bid_time_ms->FldCaption() ?></span></td>
		<td<?php echo $tr_bid->bid_time_ms->CellAttributes() ?>>
<span id="el_tr_bid_bid_time_ms">
<input type="text" data-table="tr_bid" data-field="x_bid_time_ms" name="x_bid_time_ms" id="x_bid_time_ms" size="30" placeholder="<?php echo ew_HtmlEncode($tr_bid->bid_time_ms->getPlaceHolder()) ?>" value="<?php echo $tr_bid->bid_time_ms->EditValue ?>"<?php echo $tr_bid->bid_time_ms->EditAttributes() ?>>
</span>
<?php echo $tr_bid->bid_time_ms->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_bid_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$tr_bid_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tr_bid_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_bid_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$tr_bid_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
ftr_bidadd.Init();
</script>
<?php
$tr_bid_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_bid_add->Page_Terminate();
?>
