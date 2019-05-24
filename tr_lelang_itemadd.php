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

$tr_lelang_item_add = NULL; // Initialize page object first

class ctr_lelang_item_add extends ctr_lelang_item {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_item';

	// Page object name
	var $PageObjName = 'tr_lelang_item_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
		$this->proforma_number->SetVisibility();
		$this->proforma_amount->SetVisibility();
		$this->auction_status->SetVisibility();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "tr_lelang_itemview.php")
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

		// Set up master/detail parameters
		$this->SetupMasterParms();

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
					$this->Page_Terminate("tr_lelang_itemlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = "tr_lelang_itemlist.php";
					if (ew_GetPageName($sReturnUrl) == "tr_lelang_itemlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "tr_lelang_itemview.php")
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
		$this->lot_number->CurrentValue = NULL;
		$this->lot_number->OldValue = $this->lot_number->CurrentValue;
		$this->chop->CurrentValue = NULL;
		$this->chop->OldValue = $this->chop->CurrentValue;
		$this->estate->CurrentValue = NULL;
		$this->estate->OldValue = $this->estate->CurrentValue;
		$this->grade->CurrentValue = NULL;
		$this->grade->OldValue = $this->grade->CurrentValue;
		$this->jenis->CurrentValue = NULL;
		$this->jenis->OldValue = $this->jenis->CurrentValue;
		$this->sack->CurrentValue = 0;
		$this->netto->CurrentValue = 0 ;
		$this->gross->CurrentValue = 0;
		$this->open_bid->CurrentValue = 0;
		$this->currency->CurrentValue = 'USC';
		$this->bid_step->CurrentValue = 1;
		$this->rate->CurrentValue = 1;
		$this->winner_id->CurrentValue = NULL;
		$this->winner_id->OldValue = $this->winner_id->CurrentValue;
		$this->sold_bid->CurrentValue = 0;
		$this->proforma_number->CurrentValue = NULL;
		$this->proforma_number->OldValue = $this->proforma_number->CurrentValue;
		$this->proforma_amount->CurrentValue = 0;
		$this->proforma_status->CurrentValue = NULL;
		$this->proforma_status->OldValue = $this->proforma_status->CurrentValue;
		$this->auction_status->CurrentValue = 'WD';
		$this->enter_bid->CurrentValue = NULL;
		$this->enter_bid->OldValue = $this->enter_bid->CurrentValue;
		$this->last_bid->CurrentValue = NULL;
		$this->last_bid->OldValue = $this->last_bid->CurrentValue;
		$this->highest_bid->CurrentValue = NULL;
		$this->highest_bid->OldValue = $this->highest_bid->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->lot_number->FldIsDetailKey) {
			$this->lot_number->setFormValue($objForm->GetValue("x_lot_number"));
		}
		if (!$this->chop->FldIsDetailKey) {
			$this->chop->setFormValue($objForm->GetValue("x_chop"));
		}
		if (!$this->estate->FldIsDetailKey) {
			$this->estate->setFormValue($objForm->GetValue("x_estate"));
		}
		if (!$this->grade->FldIsDetailKey) {
			$this->grade->setFormValue($objForm->GetValue("x_grade"));
		}
		if (!$this->jenis->FldIsDetailKey) {
			$this->jenis->setFormValue($objForm->GetValue("x_jenis"));
		}
		if (!$this->sack->FldIsDetailKey) {
			$this->sack->setFormValue($objForm->GetValue("x_sack"));
		}
		if (!$this->netto->FldIsDetailKey) {
			$this->netto->setFormValue($objForm->GetValue("x_netto"));
		}
		if (!$this->gross->FldIsDetailKey) {
			$this->gross->setFormValue($objForm->GetValue("x_gross"));
		}
		if (!$this->open_bid->FldIsDetailKey) {
			$this->open_bid->setFormValue($objForm->GetValue("x_open_bid"));
		}
		if (!$this->currency->FldIsDetailKey) {
			$this->currency->setFormValue($objForm->GetValue("x_currency"));
		}
		if (!$this->bid_step->FldIsDetailKey) {
			$this->bid_step->setFormValue($objForm->GetValue("x_bid_step"));
		}
		if (!$this->rate->FldIsDetailKey) {
			$this->rate->setFormValue($objForm->GetValue("x_rate"));
		}
		if (!$this->proforma_number->FldIsDetailKey) {
			$this->proforma_number->setFormValue($objForm->GetValue("x_proforma_number"));
		}
		if (!$this->proforma_amount->FldIsDetailKey) {
			$this->proforma_amount->setFormValue($objForm->GetValue("x_proforma_amount"));
		}
		if (!$this->auction_status->FldIsDetailKey) {
			$this->auction_status->setFormValue($objForm->GetValue("x_auction_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->lot_number->CurrentValue = $this->lot_number->FormValue;
		$this->chop->CurrentValue = $this->chop->FormValue;
		$this->estate->CurrentValue = $this->estate->FormValue;
		$this->grade->CurrentValue = $this->grade->FormValue;
		$this->jenis->CurrentValue = $this->jenis->FormValue;
		$this->sack->CurrentValue = $this->sack->FormValue;
		$this->netto->CurrentValue = $this->netto->FormValue;
		$this->gross->CurrentValue = $this->gross->FormValue;
		$this->open_bid->CurrentValue = $this->open_bid->FormValue;
		$this->currency->CurrentValue = $this->currency->FormValue;
		$this->bid_step->CurrentValue = $this->bid_step->FormValue;
		$this->rate->CurrentValue = $this->rate->FormValue;
		$this->proforma_number->CurrentValue = $this->proforma_number->FormValue;
		$this->proforma_amount->CurrentValue = $this->proforma_amount->FormValue;
		$this->auction_status->CurrentValue = $this->auction_status->FormValue;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['row_id'] = $this->row_id->CurrentValue;
		$row['master_id'] = $this->master_id->CurrentValue;
		$row['lot_number'] = $this->lot_number->CurrentValue;
		$row['chop'] = $this->chop->CurrentValue;
		$row['estate'] = $this->estate->CurrentValue;
		$row['grade'] = $this->grade->CurrentValue;
		$row['jenis'] = $this->jenis->CurrentValue;
		$row['sack'] = $this->sack->CurrentValue;
		$row['netto'] = $this->netto->CurrentValue;
		$row['gross'] = $this->gross->CurrentValue;
		$row['open_bid'] = $this->open_bid->CurrentValue;
		$row['currency'] = $this->currency->CurrentValue;
		$row['bid_step'] = $this->bid_step->CurrentValue;
		$row['rate'] = $this->rate->CurrentValue;
		$row['winner_id'] = $this->winner_id->CurrentValue;
		$row['sold_bid'] = $this->sold_bid->CurrentValue;
		$row['proforma_number'] = $this->proforma_number->CurrentValue;
		$row['proforma_amount'] = $this->proforma_amount->CurrentValue;
		$row['proforma_status'] = $this->proforma_status->CurrentValue;
		$row['auction_status'] = $this->auction_status->CurrentValue;
		$row['enter_bid'] = $this->enter_bid->CurrentValue;
		$row['last_bid'] = $this->last_bid->CurrentValue;
		$row['highest_bid'] = $this->highest_bid->CurrentValue;
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

		// Convert decimal values if posted back
		if ($this->proforma_amount->FormValue == $this->proforma_amount->CurrentValue && is_numeric(ew_StrToFloat($this->proforma_amount->CurrentValue)))
			$this->proforma_amount->CurrentValue = ew_StrToFloat($this->proforma_amount->CurrentValue);

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

			// proforma_number
			$this->proforma_number->LinkCustomAttributes = "";
			$this->proforma_number->HrefValue = "";
			$this->proforma_number->TooltipValue = "";

			// proforma_amount
			$this->proforma_amount->LinkCustomAttributes = "";
			$this->proforma_amount->HrefValue = "";
			$this->proforma_amount->TooltipValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";
			$this->auction_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// estate
			$this->estate->EditAttrs["class"] = "form-control";
			$this->estate->EditCustomAttributes = "";
			$this->estate->EditValue = ew_HtmlEncode($this->estate->CurrentValue);
			$this->estate->PlaceHolder = ew_RemoveHtml($this->estate->FldCaption());

			// grade
			$this->grade->EditAttrs["class"] = "form-control";
			$this->grade->EditCustomAttributes = "";
			$this->grade->EditValue = ew_HtmlEncode($this->grade->CurrentValue);
			$this->grade->PlaceHolder = ew_RemoveHtml($this->grade->FldCaption());

			// jenis
			$this->jenis->EditAttrs["class"] = "form-control";
			$this->jenis->EditCustomAttributes = "";
			$this->jenis->EditValue = ew_HtmlEncode($this->jenis->CurrentValue);
			$this->jenis->PlaceHolder = ew_RemoveHtml($this->jenis->FldCaption());

			// sack
			$this->sack->EditAttrs["class"] = "form-control";
			$this->sack->EditCustomAttributes = "";
			$this->sack->EditValue = ew_HtmlEncode($this->sack->CurrentValue);
			$this->sack->PlaceHolder = ew_RemoveHtml($this->sack->FldCaption());

			// netto
			$this->netto->EditAttrs["class"] = "form-control";
			$this->netto->EditCustomAttributes = "";
			$this->netto->EditValue = ew_HtmlEncode($this->netto->CurrentValue);
			$this->netto->PlaceHolder = ew_RemoveHtml($this->netto->FldCaption());
			if (strval($this->netto->EditValue) <> "" && is_numeric($this->netto->EditValue)) $this->netto->EditValue = ew_FormatNumber($this->netto->EditValue, -2, -2, -2, -2);

			// gross
			$this->gross->EditAttrs["class"] = "form-control";
			$this->gross->EditCustomAttributes = "";
			$this->gross->EditValue = ew_HtmlEncode($this->gross->CurrentValue);
			$this->gross->PlaceHolder = ew_RemoveHtml($this->gross->FldCaption());
			if (strval($this->gross->EditValue) <> "" && is_numeric($this->gross->EditValue)) $this->gross->EditValue = ew_FormatNumber($this->gross->EditValue, -2, -2, -2, -2);

			// open_bid
			$this->open_bid->EditAttrs["class"] = "form-control";
			$this->open_bid->EditCustomAttributes = "";
			$this->open_bid->EditValue = ew_HtmlEncode($this->open_bid->CurrentValue);
			$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());
			if (strval($this->open_bid->EditValue) <> "" && is_numeric($this->open_bid->EditValue)) $this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -2, -2, -2);

			// currency
			$this->currency->EditCustomAttributes = "";
			if (trim(strval($this->currency->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id_cur`" . ew_SearchString("=", $this->currency->CurrentValue, EW_DATATYPE_STRING, "");
			}
			$sSqlWrk = "SELECT `id_cur`, `currency` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tbl_currency`";
			$sWhereWrk = "";
			$this->currency->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->currency, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
				$this->currency->ViewValue = $this->currency->DisplayValue($arwrk);
			} else {
				$this->currency->ViewValue = $Language->Phrase("PleaseSelect");
			}
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->currency->EditValue = $arwrk;

			// bid_step
			$this->bid_step->EditAttrs["class"] = "form-control";
			$this->bid_step->EditCustomAttributes = "";
			$this->bid_step->EditValue = ew_HtmlEncode($this->bid_step->CurrentValue);
			$this->bid_step->PlaceHolder = ew_RemoveHtml($this->bid_step->FldCaption());
			if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) $this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);

			// rate
			$this->rate->EditAttrs["class"] = "form-control";
			$this->rate->EditCustomAttributes = "";
			$this->rate->EditValue = ew_HtmlEncode($this->rate->CurrentValue);
			$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
			if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) $this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);

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
			if (strval($this->proforma_amount->EditValue) <> "" && is_numeric($this->proforma_amount->EditValue)) $this->proforma_amount->EditValue = ew_FormatNumber($this->proforma_amount->EditValue, -2, -1, -2, 0);

			// auction_status
			$this->auction_status->EditCustomAttributes = "";
			$this->auction_status->EditValue = $this->auction_status->Options(TRUE);

			// Add refer script
			// lot_number

			$this->lot_number->LinkCustomAttributes = "";
			$this->lot_number->HrefValue = "";

			// chop
			$this->chop->LinkCustomAttributes = "";
			$this->chop->HrefValue = "";

			// estate
			$this->estate->LinkCustomAttributes = "";
			$this->estate->HrefValue = "";

			// grade
			$this->grade->LinkCustomAttributes = "";
			$this->grade->HrefValue = "";

			// jenis
			$this->jenis->LinkCustomAttributes = "";
			$this->jenis->HrefValue = "";

			// sack
			$this->sack->LinkCustomAttributes = "";
			$this->sack->HrefValue = "";

			// netto
			$this->netto->LinkCustomAttributes = "";
			$this->netto->HrefValue = "";

			// gross
			$this->gross->LinkCustomAttributes = "";
			$this->gross->HrefValue = "";

			// open_bid
			$this->open_bid->LinkCustomAttributes = "";
			$this->open_bid->HrefValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";

			// bid_step
			$this->bid_step->LinkCustomAttributes = "";
			$this->bid_step->HrefValue = "";

			// rate
			$this->rate->LinkCustomAttributes = "";
			$this->rate->HrefValue = "";

			// proforma_number
			$this->proforma_number->LinkCustomAttributes = "";
			$this->proforma_number->HrefValue = "";

			// proforma_amount
			$this->proforma_amount->LinkCustomAttributes = "";
			$this->proforma_amount->HrefValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";
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
		if (!$this->lot_number->FldIsDetailKey && !is_null($this->lot_number->FormValue) && $this->lot_number->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->lot_number->FldCaption(), $this->lot_number->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->lot_number->FormValue)) {
			ew_AddMessage($gsFormError, $this->lot_number->FldErrMsg());
		}
		if (!$this->chop->FldIsDetailKey && !is_null($this->chop->FormValue) && $this->chop->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->chop->FldCaption(), $this->chop->ReqErrMsg));
		}
		if (!$this->grade->FldIsDetailKey && !is_null($this->grade->FormValue) && $this->grade->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->grade->FldCaption(), $this->grade->ReqErrMsg));
		}
		if (!$this->sack->FldIsDetailKey && !is_null($this->sack->FormValue) && $this->sack->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sack->FldCaption(), $this->sack->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sack->FormValue)) {
			ew_AddMessage($gsFormError, $this->sack->FldErrMsg());
		}
		if (!$this->netto->FldIsDetailKey && !is_null($this->netto->FormValue) && $this->netto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->netto->FldCaption(), $this->netto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->netto->FormValue)) {
			ew_AddMessage($gsFormError, $this->netto->FldErrMsg());
		}
		if (!ew_CheckNumber($this->gross->FormValue)) {
			ew_AddMessage($gsFormError, $this->gross->FldErrMsg());
		}
		if (!$this->open_bid->FldIsDetailKey && !is_null($this->open_bid->FormValue) && $this->open_bid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->open_bid->FldCaption(), $this->open_bid->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->open_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->open_bid->FldErrMsg());
		}
		if (!$this->bid_step->FldIsDetailKey && !is_null($this->bid_step->FormValue) && $this->bid_step->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->bid_step->FldCaption(), $this->bid_step->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->bid_step->FormValue)) {
			ew_AddMessage($gsFormError, $this->bid_step->FldErrMsg());
		}
		if (!ew_CheckNumber($this->rate->FormValue)) {
			ew_AddMessage($gsFormError, $this->rate->FldErrMsg());
		}
		if (!ew_CheckNumber($this->proforma_amount->FormValue)) {
			ew_AddMessage($gsFormError, $this->proforma_amount->FldErrMsg());
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

		// Check referential integrity for master table 'tr_lelang_master'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_tr_lelang_master();
		if ($this->master_id->getSessionValue() <> "") {
			$sMasterFilter = str_replace("@row_id@", ew_AdjustSql($this->master_id->getSessionValue(), "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["tr_lelang_master"])) $GLOBALS["tr_lelang_master"] = new ctr_lelang_master();
			$rsmaster = $GLOBALS["tr_lelang_master"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "tr_lelang_master", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// lot_number
		$this->lot_number->SetDbValueDef($rsnew, $this->lot_number->CurrentValue, NULL, FALSE);

		// chop
		$this->chop->SetDbValueDef($rsnew, $this->chop->CurrentValue, NULL, FALSE);

		// estate
		$this->estate->SetDbValueDef($rsnew, $this->estate->CurrentValue, NULL, FALSE);

		// grade
		$this->grade->SetDbValueDef($rsnew, $this->grade->CurrentValue, NULL, FALSE);

		// jenis
		$this->jenis->SetDbValueDef($rsnew, $this->jenis->CurrentValue, NULL, FALSE);

		// sack
		$this->sack->SetDbValueDef($rsnew, $this->sack->CurrentValue, NULL, FALSE);

		// netto
		$this->netto->SetDbValueDef($rsnew, $this->netto->CurrentValue, NULL, FALSE);

		// gross
		$this->gross->SetDbValueDef($rsnew, $this->gross->CurrentValue, NULL, FALSE);

		// open_bid
		$this->open_bid->SetDbValueDef($rsnew, $this->open_bid->CurrentValue, NULL, FALSE);

		// currency
		$this->currency->SetDbValueDef($rsnew, $this->currency->CurrentValue, NULL, strval($this->currency->CurrentValue) == "");

		// bid_step
		$this->bid_step->SetDbValueDef($rsnew, $this->bid_step->CurrentValue, NULL, FALSE);

		// rate
		$this->rate->SetDbValueDef($rsnew, $this->rate->CurrentValue, NULL, strval($this->rate->CurrentValue) == "");

		// proforma_number
		$this->proforma_number->SetDbValueDef($rsnew, $this->proforma_number->CurrentValue, NULL, FALSE);

		// proforma_amount
		$this->proforma_amount->SetDbValueDef($rsnew, $this->proforma_amount->CurrentValue, NULL, FALSE);

		// auction_status
		$this->auction_status->SetDbValueDef($rsnew, $this->auction_status->CurrentValue, NULL, strval($this->auction_status->CurrentValue) == "");

		// master_id
		if ($this->master_id->getSessionValue() <> "") {
			$rsnew['master_id'] = $this->master_id->getSessionValue();
		}

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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_currency":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `id_cur` AS `LinkFld`, `currency` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tbl_currency`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`id_cur` IN ({filter_value})', "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->currency, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($tr_lelang_item_add)) $tr_lelang_item_add = new ctr_lelang_item_add();

// Page init
$tr_lelang_item_add->Page_Init();

// Page main
$tr_lelang_item_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_item_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = ftr_lelang_itemadd = new ew_Form("ftr_lelang_itemadd", "add");

// Validate form
ftr_lelang_itemadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_lot_number");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->lot_number->FldCaption(), $tr_lelang_item->lot_number->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_lot_number");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->lot_number->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_chop");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->chop->FldCaption(), $tr_lelang_item->chop->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_grade");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->grade->FldCaption(), $tr_lelang_item->grade->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->sack->FldCaption(), $tr_lelang_item->sack->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->sack->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_netto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->netto->FldCaption(), $tr_lelang_item->netto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_netto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->netto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gross");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->gross->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->open_bid->FldCaption(), $tr_lelang_item->open_bid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->open_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_item->bid_step->FldCaption(), $tr_lelang_item->bid_step->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->bid_step->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rate");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->rate->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_proforma_amount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_item->proforma_amount->FldErrMsg()) ?>");

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
ftr_lelang_itemadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_itemadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_itemadd.Lists["x_currency"] = {"LinkField":"x_id_cur","Ajax":true,"AutoFill":true,"DisplayFields":["x_currency","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tbl_currency"};
ftr_lelang_itemadd.Lists["x_currency"].Data = "<?php echo $tr_lelang_item_add->currency->LookupFilterQuery(FALSE, "add") ?>";
ftr_lelang_itemadd.Lists["x_auction_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_lelang_itemadd.Lists["x_auction_status"].Options = <?php echo json_encode($tr_lelang_item_add->auction_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_lelang_item_add->ShowPageHeader(); ?>
<?php
$tr_lelang_item_add->ShowMessage();
?>
<form name="ftr_lelang_itemadd" id="ftr_lelang_itemadd" class="<?php echo $tr_lelang_item_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_lelang_item_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_lelang_item_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_lelang_item">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($tr_lelang_item_add->IsModal) ?>">
<?php if ($tr_lelang_item->getCurrentMasterTable() == "tr_lelang_master") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tr_lelang_master">
<input type="hidden" name="fk_row_id" value="<?php echo $tr_lelang_item->master_id->getSessionValue() ?>">
<?php } ?>
<?php if (!$tr_lelang_item_add->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
<div class="ewAddDiv"><!-- page* -->
<?php } else { ?>
<table id="tbl_tr_lelang_itemadd" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable"><!-- table* -->
<?php } ?>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_lot_number" class="form-group">
		<label id="elh_tr_lelang_item_lot_number" for="x_lot_number" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->lot_number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<span id="el_tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->lot_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_lot_number">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_lot_number"><?php echo $tr_lelang_item->lot_number->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<span id="el_tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x_lot_number" id="x_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->lot_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_chop" class="form-group">
		<label id="elh_tr_lelang_item_chop" for="x_chop" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->chop->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<span id="el_tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x_chop" id="x_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->chop->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_chop">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_chop"><?php echo $tr_lelang_item->chop->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<span id="el_tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x_chop" id="x_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->chop->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_estate" class="form-group">
		<label id="elh_tr_lelang_item_estate" for="x_estate" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->estate->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<span id="el_tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x_estate" id="x_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->estate->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_estate">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_estate"><?php echo $tr_lelang_item->estate->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<span id="el_tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x_estate" id="x_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->estate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_grade" class="form-group">
		<label id="elh_tr_lelang_item_grade" for="x_grade" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->grade->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<span id="el_tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x_grade" id="x_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->grade->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_grade">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_grade"><?php echo $tr_lelang_item->grade->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<span id="el_tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x_grade" id="x_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->grade->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_jenis" class="form-group">
		<label id="elh_tr_lelang_item_jenis" for="x_jenis" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->jenis->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<span id="el_tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x_jenis" id="x_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->jenis->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_jenis">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_jenis"><?php echo $tr_lelang_item->jenis->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<span id="el_tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x_jenis" id="x_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->jenis->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_sack" class="form-group">
		<label id="elh_tr_lelang_item_sack" for="x_sack" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->sack->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<span id="el_tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x_sack" id="x_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->sack->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_sack">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_sack"><?php echo $tr_lelang_item->sack->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<span id="el_tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x_sack" id="x_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->sack->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_netto" class="form-group">
		<label id="elh_tr_lelang_item_netto" for="x_netto" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->netto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<span id="el_tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x_netto" id="x_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->netto->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_netto">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_netto"><?php echo $tr_lelang_item->netto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<span id="el_tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x_netto" id="x_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->netto->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_gross" class="form-group">
		<label id="elh_tr_lelang_item_gross" for="x_gross" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->gross->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<span id="el_tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x_gross" id="x_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->gross->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_gross">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_gross"><?php echo $tr_lelang_item->gross->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<span id="el_tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x_gross" id="x_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->gross->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_open_bid" class="form-group">
		<label id="elh_tr_lelang_item_open_bid" for="x_open_bid" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->open_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<span id="el_tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x_open_bid" id="x_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->open_bid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_open_bid">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_open_bid"><?php echo $tr_lelang_item->open_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<span id="el_tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x_open_bid" id="x_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->open_bid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_currency" class="form-group">
		<label id="elh_tr_lelang_item_currency" for="x_currency" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->currency->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<span id="el_tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x_currency") ?>
		</div>
	</div>
	<div id="tp_x_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x_currency" id="x_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x_currency" id="ln_x_currency" value="x_bid_step">
</span>
<?php echo $tr_lelang_item->currency->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_currency">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_currency"><?php echo $tr_lelang_item->currency->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<span id="el_tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x_currency") ?>
		</div>
	</div>
	<div id="tp_x_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x_currency" id="x_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x_currency" id="ln_x_currency" value="x_bid_step">
</span>
<?php echo $tr_lelang_item->currency->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_bid_step" class="form-group">
		<label id="elh_tr_lelang_item_bid_step" for="x_bid_step" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->bid_step->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<span id="el_tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x_bid_step" id="x_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->bid_step->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_bid_step">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_bid_step"><?php echo $tr_lelang_item->bid_step->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<span id="el_tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x_bid_step" id="x_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->bid_step->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_rate" class="form-group">
		<label id="elh_tr_lelang_item_rate" for="x_rate" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->rate->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<span id="el_tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x_rate" id="x_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->rate->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_rate">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_rate"><?php echo $tr_lelang_item->rate->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<span id="el_tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x_rate" id="x_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->rate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->proforma_number->Visible) { // proforma_number ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_proforma_number" class="form-group">
		<label id="elh_tr_lelang_item_proforma_number" for="x_proforma_number" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->proforma_number->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->proforma_number->CellAttributes() ?>>
<span id="el_tr_lelang_item_proforma_number">
<input type="text" data-table="tr_lelang_item" data-field="x_proforma_number" name="x_proforma_number" id="x_proforma_number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->proforma_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->proforma_number->EditValue ?>"<?php echo $tr_lelang_item->proforma_number->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->proforma_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_proforma_number">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_proforma_number"><?php echo $tr_lelang_item->proforma_number->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->proforma_number->CellAttributes() ?>>
<span id="el_tr_lelang_item_proforma_number">
<input type="text" data-table="tr_lelang_item" data-field="x_proforma_number" name="x_proforma_number" id="x_proforma_number" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->proforma_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->proforma_number->EditValue ?>"<?php echo $tr_lelang_item->proforma_number->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->proforma_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->proforma_amount->Visible) { // proforma_amount ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_proforma_amount" class="form-group">
		<label id="elh_tr_lelang_item_proforma_amount" for="x_proforma_amount" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->proforma_amount->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->proforma_amount->CellAttributes() ?>>
<span id="el_tr_lelang_item_proforma_amount">
<input type="text" data-table="tr_lelang_item" data-field="x_proforma_amount" name="x_proforma_amount" id="x_proforma_amount" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->proforma_amount->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->proforma_amount->EditValue ?>"<?php echo $tr_lelang_item->proforma_amount->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->proforma_amount->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_proforma_amount">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_proforma_amount"><?php echo $tr_lelang_item->proforma_amount->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->proforma_amount->CellAttributes() ?>>
<span id="el_tr_lelang_item_proforma_amount">
<input type="text" data-table="tr_lelang_item" data-field="x_proforma_amount" name="x_proforma_amount" id="x_proforma_amount" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->proforma_amount->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->proforma_amount->EditValue ?>"<?php echo $tr_lelang_item->proforma_amount->EditAttributes() ?>>
</span>
<?php echo $tr_lelang_item->proforma_amount->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->auction_status->Visible) { // auction_status ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
	<div id="r_auction_status" class="form-group">
		<label id="elh_tr_lelang_item_auction_status" for="x_auction_status" class="<?php echo $tr_lelang_item_add->LeftColumnClass ?>"><?php echo $tr_lelang_item->auction_status->FldCaption() ?></label>
		<div class="<?php echo $tr_lelang_item_add->RightColumnClass ?>"><div<?php echo $tr_lelang_item->auction_status->CellAttributes() ?>>
<span id="el_tr_lelang_item_auction_status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->auction_status->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->auction_status->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->auction_status->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_auction_status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->auction_status->RadioButtonListHtml(TRUE, "x_auction_status") ?>
		</div>
	</div>
	<div id="tp_x_auction_status" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x_auction_status" id="x_auction_status" value="{value}"<?php echo $tr_lelang_item->auction_status->EditAttributes() ?>></div>
</div>
</span>
<?php echo $tr_lelang_item->auction_status->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auction_status">
		<td class="col-sm-2"><span id="elh_tr_lelang_item_auction_status"><?php echo $tr_lelang_item->auction_status->FldCaption() ?></span></td>
		<td<?php echo $tr_lelang_item->auction_status->CellAttributes() ?>>
<span id="el_tr_lelang_item_auction_status">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->auction_status->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->auction_status->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->auction_status->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x_auction_status" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->auction_status->RadioButtonListHtml(TRUE, "x_auction_status") ?>
		</div>
	</div>
	<div id="tp_x_auction_status" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x_auction_status" id="x_auction_status" value="{value}"<?php echo $tr_lelang_item->auction_status->EditAttributes() ?>></div>
</div>
</span>
<?php echo $tr_lelang_item->auction_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item_add->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (strval($tr_lelang_item->master_id->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_master_id" id="x_master_id" value="<?php echo ew_HtmlEncode(strval($tr_lelang_item->master_id->getSessionValue())) ?>">
<?php } ?>
<?php if (!$tr_lelang_item_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tr_lelang_item_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_lelang_item_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$tr_lelang_item_add->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
ftr_lelang_itemadd.Init();
</script>
<?php
$tr_lelang_item_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_lelang_item_add->Page_Terminate();
?>
