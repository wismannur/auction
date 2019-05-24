<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$members_add = NULL; // Initialize page object first

class cmembers_add extends cmembers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'members';

	// Page object name
	var $PageObjName = 'members_add';

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

		// Table object (members)
		if (!isset($GLOBALS["members"]) || get_class($GLOBALS["members"]) == "cmembers") {
			$GLOBALS["members"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["members"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'members', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("memberslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
			if (strval($Security->CurrentUserID()) == "") {
				$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
				$this->Page_Terminate(ew_GetUrl("memberslist.php"));
			}
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
		$this->Username->SetVisibility();
		$this->Password->SetVisibility();
		$this->UserLevel->SetVisibility();
		$this->FullName->SetVisibility();
		$this->CompanyName->SetVisibility();
		$this->Title->SetVisibility();
		$this->Address->SetVisibility();
		$this->_Email->SetVisibility();
		$this->Activated->SetVisibility();
		$this->profile->SetVisibility();
		$this->Photo->SetVisibility();

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
		global $EW_EXPORT, $members;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($members);
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
					if ($pageName == "membersview.php")
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
			if (@$_GET["user_id"] != "") {
				$this->user_id->setQueryStringValue($_GET["user_id"]);
				$this->setKey("user_id", $this->user_id->CurrentValue); // Set up key
			} else {
				$this->setKey("user_id", ""); // Clear key
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
					$this->Page_Terminate("memberslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "memberslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "membersview.php")
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
		$this->user_id->CurrentValue = NULL;
		$this->user_id->OldValue = $this->user_id->CurrentValue;
		$this->Username->CurrentValue = NULL;
		$this->Username->OldValue = $this->Username->CurrentValue;
		$this->Password->CurrentValue = NULL;
		$this->Password->OldValue = $this->Password->CurrentValue;
		$this->UserLevel->CurrentValue = NULL;
		$this->UserLevel->OldValue = $this->UserLevel->CurrentValue;
		$this->FullName->CurrentValue = NULL;
		$this->FullName->OldValue = $this->FullName->CurrentValue;
		$this->CompanyName->CurrentValue = NULL;
		$this->CompanyName->OldValue = $this->CompanyName->CurrentValue;
		$this->Title->CurrentValue = NULL;
		$this->Title->OldValue = $this->Title->CurrentValue;
		$this->Address->CurrentValue = NULL;
		$this->Address->OldValue = $this->Address->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Activated->CurrentValue = "N";
		$this->profile->CurrentValue = NULL;
		$this->profile->OldValue = $this->profile->CurrentValue;
		$this->Photo->CurrentValue = NULL;
		$this->Photo->OldValue = $this->Photo->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Username->FldIsDetailKey) {
			$this->Username->setFormValue($objForm->GetValue("x_Username"));
		}
		if (!$this->Password->FldIsDetailKey) {
			$this->Password->setFormValue($objForm->GetValue("x_Password"));
		}
		if (!$this->UserLevel->FldIsDetailKey) {
			$this->UserLevel->setFormValue($objForm->GetValue("x_UserLevel"));
		}
		if (!$this->FullName->FldIsDetailKey) {
			$this->FullName->setFormValue($objForm->GetValue("x_FullName"));
		}
		if (!$this->CompanyName->FldIsDetailKey) {
			$this->CompanyName->setFormValue($objForm->GetValue("x_CompanyName"));
		}
		if (!$this->Title->FldIsDetailKey) {
			$this->Title->setFormValue($objForm->GetValue("x_Title"));
		}
		if (!$this->Address->FldIsDetailKey) {
			$this->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		if (!$this->_Email->FldIsDetailKey) {
			$this->_Email->setFormValue($objForm->GetValue("x__Email"));
		}
		if (!$this->Activated->FldIsDetailKey) {
			$this->Activated->setFormValue($objForm->GetValue("x_Activated"));
		}
		if (!$this->profile->FldIsDetailKey) {
			$this->profile->setFormValue($objForm->GetValue("x_profile"));
		}
		if (!$this->Photo->FldIsDetailKey) {
			$this->Photo->setFormValue($objForm->GetValue("x_Photo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Username->CurrentValue = $this->Username->FormValue;
		$this->Password->CurrentValue = $this->Password->FormValue;
		$this->UserLevel->CurrentValue = $this->UserLevel->FormValue;
		$this->FullName->CurrentValue = $this->FullName->FormValue;
		$this->CompanyName->CurrentValue = $this->CompanyName->FormValue;
		$this->Title->CurrentValue = $this->Title->FormValue;
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Activated->CurrentValue = $this->Activated->FormValue;
		$this->profile->CurrentValue = $this->profile->FormValue;
		$this->Photo->CurrentValue = $this->Photo->FormValue;
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

		// Check if valid user id
		if ($res) {
			$res = $this->ShowOptionLink('add');
			if (!$res) {
				$sUserIdMsg = ew_DeniedMsg();
				$this->setFailureMessage($sUserIdMsg);
			}
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
		$this->user_id->setDbValue($row['user_id']);
		$this->Username->setDbValue($row['Username']);
		$this->Password->setDbValue($row['Password']);
		$this->UserLevel->setDbValue($row['UserLevel']);
		$this->FullName->setDbValue($row['FullName']);
		$this->CompanyName->setDbValue($row['CompanyName']);
		$this->Title->setDbValue($row['Title']);
		$this->Address->setDbValue($row['Address']);
		$this->_Email->setDbValue($row['Email']);
		$this->Activated->setDbValue($row['Activated']);
		$this->profile->setDbValue($row['profile']);
		$this->Photo->setDbValue($row['Photo']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['user_id'] = $this->user_id->CurrentValue;
		$row['Username'] = $this->Username->CurrentValue;
		$row['Password'] = $this->Password->CurrentValue;
		$row['UserLevel'] = $this->UserLevel->CurrentValue;
		$row['FullName'] = $this->FullName->CurrentValue;
		$row['CompanyName'] = $this->CompanyName->CurrentValue;
		$row['Title'] = $this->Title->CurrentValue;
		$row['Address'] = $this->Address->CurrentValue;
		$row['Email'] = $this->_Email->CurrentValue;
		$row['Activated'] = $this->Activated->CurrentValue;
		$row['profile'] = $this->profile->CurrentValue;
		$row['Photo'] = $this->Photo->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->user_id->DbValue = $row['user_id'];
		$this->Username->DbValue = $row['Username'];
		$this->Password->DbValue = $row['Password'];
		$this->UserLevel->DbValue = $row['UserLevel'];
		$this->FullName->DbValue = $row['FullName'];
		$this->CompanyName->DbValue = $row['CompanyName'];
		$this->Title->DbValue = $row['Title'];
		$this->Address->DbValue = $row['Address'];
		$this->_Email->DbValue = $row['Email'];
		$this->Activated->DbValue = $row['Activated'];
		$this->profile->DbValue = $row['profile'];
		$this->Photo->DbValue = $row['Photo'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("user_id")) <> "")
			$this->user_id->CurrentValue = $this->getKey("user_id"); // user_id
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
		// user_id
		// Username
		// Password
		// UserLevel
		// FullName
		// CompanyName
		// Title
		// Address
		// Email
		// Activated
		// profile
		// Photo

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

		// Username
		$this->Username->ViewValue = $this->Username->CurrentValue;
		$this->Username->ViewCustomAttributes = "";

		// Password
		$this->Password->ViewValue = $Language->Phrase("PasswordMask");
		$this->Password->ViewCustomAttributes = "";

		// UserLevel
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->UserLevel->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->UserLevel->LookupFilters = array();
		$lookuptblfilter = "`userlevelid`>= '0'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `userlevelid`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->UserLevel->ViewValue = $this->UserLevel->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->UserLevel->ViewValue = $this->UserLevel->CurrentValue;
			}
		} else {
			$this->UserLevel->ViewValue = NULL;
		}
		} else {
			$this->UserLevel->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->UserLevel->ViewCustomAttributes = "";

		// FullName
		$this->FullName->ViewValue = $this->FullName->CurrentValue;
		$this->FullName->ViewCustomAttributes = "";

		// CompanyName
		$this->CompanyName->ViewValue = $this->CompanyName->CurrentValue;
		$this->CompanyName->ViewCustomAttributes = "";

		// Title
		$this->Title->ViewValue = $this->Title->CurrentValue;
		$this->Title->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// Email
		$this->_Email->ViewValue = $this->_Email->CurrentValue;
		$this->_Email->ViewCustomAttributes = "";

		// Activated
		if (ew_ConvertToBool($this->Activated->CurrentValue)) {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(1) <> "" ? $this->Activated->FldTagCaption(1) : "Y";
		} else {
			$this->Activated->ViewValue = $this->Activated->FldTagCaption(2) <> "" ? $this->Activated->FldTagCaption(2) : "N";
		}
		$this->Activated->CellCssStyle .= "text-align: center;";
		$this->Activated->ViewCustomAttributes = "";

		// profile
		$this->profile->ViewValue = $this->profile->CurrentValue;
		$this->profile->ViewCustomAttributes = "";

		// Photo
		$this->Photo->ViewValue = $this->Photo->CurrentValue;
		$this->Photo->ViewCustomAttributes = "";

			// Username
			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";
			$this->Username->TooltipValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";
			$this->Password->TooltipValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";
			$this->UserLevel->TooltipValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";
			$this->FullName->TooltipValue = "";

			// CompanyName
			$this->CompanyName->LinkCustomAttributes = "";
			$this->CompanyName->HrefValue = "";
			$this->CompanyName->TooltipValue = "";

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";
			$this->Title->TooltipValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";
			$this->Activated->TooltipValue = "";

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";
			$this->profile->TooltipValue = "";

			// Photo
			$this->Photo->LinkCustomAttributes = "";
			$this->Photo->HrefValue = "";
			$this->Photo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Username
			$this->Username->EditAttrs["class"] = "form-control";
			$this->Username->EditCustomAttributes = "";
			$this->Username->EditValue = ew_HtmlEncode($this->Username->CurrentValue);
			$this->Username->PlaceHolder = ew_RemoveHtml($this->Username->FldCaption());

			// Password
			$this->Password->EditAttrs["class"] = "form-control";
			$this->Password->EditCustomAttributes = "";
			$this->Password->EditValue = ew_HtmlEncode($this->Password->CurrentValue);
			$this->Password->PlaceHolder = ew_RemoveHtml($this->Password->FldCaption());

			// UserLevel
			$this->UserLevel->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->UserLevel->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->UserLevel->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->UserLevel->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->UserLevel->LookupFilters = array();
			$lookuptblfilter = "`userlevelid`>= '0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `userlevelid`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->UserLevel->ViewValue = $this->UserLevel->DisplayValue($arwrk);
			} else {
				$this->UserLevel->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->UserLevel->EditValue = $arwrk;
			}

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = ew_HtmlEncode($this->FullName->CurrentValue);
			$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

			// CompanyName
			$this->CompanyName->EditAttrs["class"] = "form-control";
			$this->CompanyName->EditCustomAttributes = "";
			$this->CompanyName->EditValue = ew_HtmlEncode($this->CompanyName->CurrentValue);
			$this->CompanyName->PlaceHolder = ew_RemoveHtml($this->CompanyName->FldCaption());

			// Title
			$this->Title->EditAttrs["class"] = "form-control";
			$this->Title->EditCustomAttributes = "";
			$this->Title->EditValue = ew_HtmlEncode($this->Title->CurrentValue);
			$this->Title->PlaceHolder = ew_RemoveHtml($this->Title->FldCaption());

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->CurrentValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			$this->_Email->EditValue = ew_HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = ew_RemoveHtml($this->_Email->FldCaption());

			// Activated
			$this->Activated->EditCustomAttributes = "";
			$this->Activated->EditValue = $this->Activated->Options(FALSE);

			// profile
			$this->profile->EditAttrs["class"] = "form-control";
			$this->profile->EditCustomAttributes = "";
			$this->profile->EditValue = ew_HtmlEncode($this->profile->CurrentValue);
			$this->profile->PlaceHolder = ew_RemoveHtml($this->profile->FldCaption());

			// Photo
			$this->Photo->EditAttrs["class"] = "form-control";
			$this->Photo->EditCustomAttributes = "";
			$this->Photo->EditValue = ew_HtmlEncode($this->Photo->CurrentValue);
			$this->Photo->PlaceHolder = ew_RemoveHtml($this->Photo->FldCaption());

			// Add refer script
			// Username

			$this->Username->LinkCustomAttributes = "";
			$this->Username->HrefValue = "";

			// Password
			$this->Password->LinkCustomAttributes = "";
			$this->Password->HrefValue = "";

			// UserLevel
			$this->UserLevel->LinkCustomAttributes = "";
			$this->UserLevel->HrefValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";

			// CompanyName
			$this->CompanyName->LinkCustomAttributes = "";
			$this->CompanyName->HrefValue = "";

			// Title
			$this->Title->LinkCustomAttributes = "";
			$this->Title->HrefValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Activated
			$this->Activated->LinkCustomAttributes = "";
			$this->Activated->HrefValue = "";

			// profile
			$this->profile->LinkCustomAttributes = "";
			$this->profile->HrefValue = "";

			// Photo
			$this->Photo->LinkCustomAttributes = "";
			$this->Photo->HrefValue = "";
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
		if (!$this->Username->FldIsDetailKey && !is_null($this->Username->FormValue) && $this->Username->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Username->FldCaption(), $this->Username->ReqErrMsg));
		}
		if (!$this->Password->FldIsDetailKey && !is_null($this->Password->FormValue) && $this->Password->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Password->FldCaption(), $this->Password->ReqErrMsg));
		}
		if (!ew_CheckEmail($this->_Email->FormValue)) {
			ew_AddMessage($gsFormError, $this->_Email->FldErrMsg());
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

		// Check if valid User ID
		$bValidUser = FALSE;
		if ($Security->CurrentUserID() <> "" && !ew_Empty($this->user_id->CurrentValue) && !$Security->IsAdmin()) { // Non system admin
			$bValidUser = $Security->IsValidUserID($this->user_id->CurrentValue);
			if (!$bValidUser) {
				$sUserIdMsg = str_replace("%c", CurrentUserID(), $Language->Phrase("UnAuthorizedUserID"));
				$sUserIdMsg = str_replace("%u", $this->user_id->CurrentValue, $sUserIdMsg);
				$this->setFailureMessage($sUserIdMsg);
				return FALSE;
			}
		}
		if ($this->Username->CurrentValue <> "") { // Check field with unique index
			$sFilter = "(Username = '" . ew_AdjustSql($this->Username->CurrentValue, $this->DBID) . "')";
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->Username->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->Username->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// Username
		$this->Username->SetDbValueDef($rsnew, $this->Username->CurrentValue, "", FALSE);

		// Password
		$this->Password->SetDbValueDef($rsnew, $this->Password->CurrentValue, "", FALSE);

		// UserLevel
		if ($Security->CanAdmin()) { // System admin
		$this->UserLevel->SetDbValueDef($rsnew, $this->UserLevel->CurrentValue, NULL, FALSE);
		}

		// FullName
		$this->FullName->SetDbValueDef($rsnew, $this->FullName->CurrentValue, NULL, FALSE);

		// CompanyName
		$this->CompanyName->SetDbValueDef($rsnew, $this->CompanyName->CurrentValue, NULL, FALSE);

		// Title
		$this->Title->SetDbValueDef($rsnew, $this->Title->CurrentValue, NULL, FALSE);

		// Address
		$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, NULL, FALSE);

		// Email
		$this->_Email->SetDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// Activated
		$tmpBool = $this->Activated->CurrentValue;
		if ($tmpBool <> "Y" && $tmpBool <> "N")
			$tmpBool = (!empty($tmpBool)) ? "Y" : "N";
		$this->Activated->SetDbValueDef($rsnew, $tmpBool, "N", strval($this->Activated->CurrentValue) == "");

		// profile
		$this->profile->SetDbValueDef($rsnew, $this->profile->CurrentValue, NULL, FALSE);

		// Photo
		$this->Photo->SetDbValueDef($rsnew, $this->Photo->CurrentValue, NULL, FALSE);

		// user_id
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

	// Show link optionally based on User ID
	function ShowOptionLink($id = "") {
		global $Security;
		if ($Security->IsLoggedIn() && !$Security->IsAdmin() && !$this->UserIDAllow($id))
			return $Security->IsValidUserID($this->user_id->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("memberslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_UserLevel":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$lookuptblfilter = "`userlevelid`>= '0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->UserLevel, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `userlevelid`";
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
if (!isset($members_add)) $members_add = new cmembers_add();

// Page init
$members_add->Page_Init();

// Page main
$members_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$members_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fmembersadd = new ew_Form("fmembersadd", "add");

// Validate form
fmembersadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Username");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $members->Username->FldCaption(), $members->Username->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Password");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $members->Password->FldCaption(), $members->Password->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "__Email");
			if (elm && !ew_CheckEmail(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($members->_Email->FldErrMsg()) ?>");

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
fmembersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmembersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmembersadd.Lists["x_UserLevel"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
fmembersadd.Lists["x_UserLevel"].Data = "<?php echo $members_add->UserLevel->LookupFilterQuery(FALSE, "add") ?>";
fmembersadd.Lists["x_Activated[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmembersadd.Lists["x_Activated[]"].Options = <?php echo json_encode($members_add->Activated->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $members_add->ShowPageHeader(); ?>
<?php
$members_add->ShowMessage();
?>
<form name="fmembersadd" id="fmembersadd" class="<?php echo $members_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($members_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $members_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="members">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($members_add->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<?php if (!$members_add->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($members_add->IsMobileOrModal) { ?>
<div class="ewAddDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_membersadd" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($members->Username->Visible) { // Username ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Username" class="form-group">
		<label id="elh_members_Username" for="x_Username" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Username->CellAttributes() ?>>
<span id="el_members_Username">
<input type="text" data-table="members" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="35" placeholder="<?php echo ew_HtmlEncode($members->Username->getPlaceHolder()) ?>" value="<?php echo $members->Username->EditValue ?>"<?php echo $members->Username->EditAttributes() ?>>
</span>
<?php echo $members->Username->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Username">
		<td class="col-sm-2"><span id="elh_members_Username"><?php echo $members->Username->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $members->Username->CellAttributes() ?>>
<span id="el_members_Username">
<input type="text" data-table="members" data-field="x_Username" name="x_Username" id="x_Username" size="30" maxlength="35" placeholder="<?php echo ew_HtmlEncode($members->Username->getPlaceHolder()) ?>" value="<?php echo $members->Username->EditValue ?>"<?php echo $members->Username->EditAttributes() ?>>
</span>
<?php echo $members->Username->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->Password->Visible) { // Password ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Password" class="form-group">
		<label id="elh_members_Password" for="x_Password" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Password->CellAttributes() ?>>
<span id="el_members_Password">
<input type="password" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->Password->getPlaceHolder()) ?>"<?php echo $members->Password->EditAttributes() ?>>
</span>
<?php echo $members->Password->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Password">
		<td class="col-sm-2"><span id="elh_members_Password"><?php echo $members->Password->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $members->Password->CellAttributes() ?>>
<span id="el_members_Password">
<input type="password" data-field="x_Password" name="x_Password" id="x_Password" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->Password->getPlaceHolder()) ?>"<?php echo $members->Password->EditAttributes() ?>>
</span>
<?php echo $members->Password->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->UserLevel->Visible) { // UserLevel ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_UserLevel" class="form-group">
		<label id="elh_members_UserLevel" for="x_UserLevel" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->UserLevel->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->UserLevel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_members_UserLevel">
<p class="form-control-static"><?php echo $members->UserLevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_members_UserLevel">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($members->UserLevel->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $members->UserLevel->ViewValue ?>
	</span>
	<?php if (!$members->UserLevel->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_UserLevel" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $members->UserLevel->RadioButtonListHtml(TRUE, "x_UserLevel") ?>
		</div>
	</div>
	<div id="tp_x_UserLevel" class="ewTemplate"><input type="radio" data-table="members" data-field="x_UserLevel" data-value-separator="<?php echo $members->UserLevel->DisplayValueSeparatorAttribute() ?>" name="x_UserLevel" id="x_UserLevel" value="{value}"<?php echo $members->UserLevel->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php echo $members->UserLevel->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_UserLevel">
		<td class="col-sm-2"><span id="elh_members_UserLevel"><?php echo $members->UserLevel->FldCaption() ?></span></td>
		<td<?php echo $members->UserLevel->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_members_UserLevel">
<p class="form-control-static"><?php echo $members->UserLevel->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_members_UserLevel">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($members->UserLevel->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $members->UserLevel->ViewValue ?>
	</span>
	<?php if (!$members->UserLevel->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_UserLevel" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $members->UserLevel->RadioButtonListHtml(TRUE, "x_UserLevel") ?>
		</div>
	</div>
	<div id="tp_x_UserLevel" class="ewTemplate"><input type="radio" data-table="members" data-field="x_UserLevel" data-value-separator="<?php echo $members->UserLevel->DisplayValueSeparatorAttribute() ?>" name="x_UserLevel" id="x_UserLevel" value="{value}"<?php echo $members->UserLevel->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php echo $members->UserLevel->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->FullName->Visible) { // FullName ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_members_FullName" for="x_FullName" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->FullName->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->FullName->CellAttributes() ?>>
<span id="el_members_FullName">
<input type="text" data-table="members" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->FullName->getPlaceHolder()) ?>" value="<?php echo $members->FullName->EditValue ?>"<?php echo $members->FullName->EditAttributes() ?>>
</span>
<?php echo $members->FullName->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_FullName">
		<td class="col-sm-2"><span id="elh_members_FullName"><?php echo $members->FullName->FldCaption() ?></span></td>
		<td<?php echo $members->FullName->CellAttributes() ?>>
<span id="el_members_FullName">
<input type="text" data-table="members" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->FullName->getPlaceHolder()) ?>" value="<?php echo $members->FullName->EditValue ?>"<?php echo $members->FullName->EditAttributes() ?>>
</span>
<?php echo $members->FullName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->CompanyName->Visible) { // CompanyName ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_CompanyName" class="form-group">
		<label id="elh_members_CompanyName" for="x_CompanyName" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->CompanyName->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->CompanyName->CellAttributes() ?>>
<span id="el_members_CompanyName">
<input type="text" data-table="members" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->CompanyName->getPlaceHolder()) ?>" value="<?php echo $members->CompanyName->EditValue ?>"<?php echo $members->CompanyName->EditAttributes() ?>>
</span>
<?php echo $members->CompanyName->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_CompanyName">
		<td class="col-sm-2"><span id="elh_members_CompanyName"><?php echo $members->CompanyName->FldCaption() ?></span></td>
		<td<?php echo $members->CompanyName->CellAttributes() ?>>
<span id="el_members_CompanyName">
<input type="text" data-table="members" data-field="x_CompanyName" name="x_CompanyName" id="x_CompanyName" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->CompanyName->getPlaceHolder()) ?>" value="<?php echo $members->CompanyName->EditValue ?>"<?php echo $members->CompanyName->EditAttributes() ?>>
</span>
<?php echo $members->CompanyName->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->Title->Visible) { // Title ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Title" class="form-group">
		<label id="elh_members_Title" for="x_Title" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Title->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Title->CellAttributes() ?>>
<span id="el_members_Title">
<input type="text" data-table="members" data-field="x_Title" name="x_Title" id="x_Title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->Title->getPlaceHolder()) ?>" value="<?php echo $members->Title->EditValue ?>"<?php echo $members->Title->EditAttributes() ?>>
</span>
<?php echo $members->Title->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Title">
		<td class="col-sm-2"><span id="elh_members_Title"><?php echo $members->Title->FldCaption() ?></span></td>
		<td<?php echo $members->Title->CellAttributes() ?>>
<span id="el_members_Title">
<input type="text" data-table="members" data-field="x_Title" name="x_Title" id="x_Title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->Title->getPlaceHolder()) ?>" value="<?php echo $members->Title->EditValue ?>"<?php echo $members->Title->EditAttributes() ?>>
</span>
<?php echo $members->Title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->Address->Visible) { // Address ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Address" class="form-group">
		<label id="elh_members_Address" for="x_Address" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Address->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Address->CellAttributes() ?>>
<span id="el_members_Address">
<input type="text" data-table="members" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($members->Address->getPlaceHolder()) ?>" value="<?php echo $members->Address->EditValue ?>"<?php echo $members->Address->EditAttributes() ?>>
</span>
<?php echo $members->Address->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Address">
		<td class="col-sm-2"><span id="elh_members_Address"><?php echo $members->Address->FldCaption() ?></span></td>
		<td<?php echo $members->Address->CellAttributes() ?>>
<span id="el_members_Address">
<input type="text" data-table="members" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($members->Address->getPlaceHolder()) ?>" value="<?php echo $members->Address->EditValue ?>"<?php echo $members->Address->EditAttributes() ?>>
</span>
<?php echo $members->Address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->_Email->Visible) { // Email ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r__Email" class="form-group">
		<label id="elh_members__Email" for="x__Email" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->_Email->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->_Email->CellAttributes() ?>>
<span id="el_members__Email">
<input type="text" data-table="members" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->_Email->getPlaceHolder()) ?>" value="<?php echo $members->_Email->EditValue ?>"<?php echo $members->_Email->EditAttributes() ?>>
</span>
<?php echo $members->_Email->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r__Email">
		<td class="col-sm-2"><span id="elh_members__Email"><?php echo $members->_Email->FldCaption() ?></span></td>
		<td<?php echo $members->_Email->CellAttributes() ?>>
<span id="el_members__Email">
<input type="text" data-table="members" data-field="x__Email" name="x__Email" id="x__Email" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($members->_Email->getPlaceHolder()) ?>" value="<?php echo $members->_Email->EditValue ?>"<?php echo $members->_Email->EditAttributes() ?>>
</span>
<?php echo $members->_Email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->Activated->Visible) { // Activated ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Activated" class="form-group">
		<label id="elh_members_Activated" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Activated->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Activated->CellAttributes() ?>>
<span id="el_members_Activated">
<?php
$selwrk = (ew_ConvertToBool($members->Activated->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="members" data-field="x_Activated" name="x_Activated[]" id="x_Activated[]" value="1"<?php echo $selwrk ?><?php echo $members->Activated->EditAttributes() ?>>
</span>
<?php echo $members->Activated->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Activated">
		<td class="col-sm-2"><span id="elh_members_Activated"><?php echo $members->Activated->FldCaption() ?></span></td>
		<td<?php echo $members->Activated->CellAttributes() ?>>
<span id="el_members_Activated">
<?php
$selwrk = (ew_ConvertToBool($members->Activated->CurrentValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="members" data-field="x_Activated" name="x_Activated[]" id="x_Activated[]" value="1"<?php echo $selwrk ?><?php echo $members->Activated->EditAttributes() ?>>
</span>
<?php echo $members->Activated->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->profile->Visible) { // profile ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_profile" class="form-group">
		<label id="elh_members_profile" for="x_profile" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->profile->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->profile->CellAttributes() ?>>
<span id="el_members_profile">
<textarea data-table="members" data-field="x_profile" name="x_profile" id="x_profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($members->profile->getPlaceHolder()) ?>"<?php echo $members->profile->EditAttributes() ?>><?php echo $members->profile->EditValue ?></textarea>
</span>
<?php echo $members->profile->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_profile">
		<td class="col-sm-2"><span id="elh_members_profile"><?php echo $members->profile->FldCaption() ?></span></td>
		<td<?php echo $members->profile->CellAttributes() ?>>
<span id="el_members_profile">
<textarea data-table="members" data-field="x_profile" name="x_profile" id="x_profile" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($members->profile->getPlaceHolder()) ?>"<?php echo $members->profile->EditAttributes() ?>><?php echo $members->profile->EditValue ?></textarea>
</span>
<?php echo $members->profile->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members->Photo->Visible) { // Photo ?>
<?php if ($members_add->IsMobileOrModal) { ?>
	<div id="r_Photo" class="form-group">
		<label id="elh_members_Photo" for="x_Photo" class="<?php echo $members_add->LeftColumnClass ?>"><?php echo $members->Photo->FldCaption() ?></label>
		<div class="<?php echo $members_add->RightColumnClass ?>"><div<?php echo $members->Photo->CellAttributes() ?>>
<span id="el_members_Photo">
<input type="text" data-table="members" data-field="x_Photo" name="x_Photo" id="x_Photo" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($members->Photo->getPlaceHolder()) ?>" value="<?php echo $members->Photo->EditValue ?>"<?php echo $members->Photo->EditAttributes() ?>>
</span>
<?php echo $members->Photo->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_Photo">
		<td class="col-sm-2"><span id="elh_members_Photo"><?php echo $members->Photo->FldCaption() ?></span></td>
		<td<?php echo $members->Photo->CellAttributes() ?>>
<span id="el_members_Photo">
<input type="text" data-table="members" data-field="x_Photo" name="x_Photo" id="x_Photo" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($members->Photo->getPlaceHolder()) ?>" value="<?php echo $members->Photo->EditValue ?>"<?php echo $members->Photo->EditAttributes() ?>>
</span>
<?php echo $members->Photo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($members_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$members_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $members_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $members_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$members_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
fmembersadd.Init();
</script>
<?php
$members_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$members_add->Page_Terminate();
?>
