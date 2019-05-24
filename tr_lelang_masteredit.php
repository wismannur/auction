<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "tr_lelang_masterinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "tr_lelang_itemgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$tr_lelang_master_edit = NULL; // Initialize page object first

class ctr_lelang_master_edit extends ctr_lelang_master {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_master';

	// Page object name
	var $PageObjName = 'tr_lelang_master_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("tr_lelang_item", $DetailTblVar)) {

					// Process auto fill for detail table 'tr_lelang_item'
					if (preg_match('/^ftr_lelang_item(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["tr_lelang_item_grid"])) $GLOBALS["tr_lelang_item_grid"] = new ctr_lelang_item_grid;
						$GLOBALS["tr_lelang_item_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
		if (@$_POST["customexport"] == "") {

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		}

		// Export
		global $EW_EXPORT, $tr_lelang_master;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
			if (is_array(@$_SESSION[EW_SESSION_TEMP_IMAGES])) // Restore temp images
				$gTmpImages = @$_SESSION[EW_SESSION_TEMP_IMAGES];
			if (@$_POST["data"] <> "")
				$sContent = $_POST["data"];
			$gsExportFile = @$_POST["filename"];
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
	if ($this->CustomExport <> "") { // Save temp images array for custom export
		if (is_array($gTmpImages))
			$_SESSION[EW_SESSION_TEMP_IMAGES] = $gTmpImages;
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
					if ($pageName == "tr_lelang_masterview.php")
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

			// Set up detail parameters
			$this->SetupDetailParms();
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
					$this->Page_Terminate("tr_lelang_masterlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				$sReturnUrl = "tr_lelang_masterlist.php";
				if (ew_GetPageName($sReturnUrl) == "tr_lelang_masterlist.php")
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

					// Set up detail parameters
					$this->SetupDetailParms();
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
		if (!$this->auc_date->FldIsDetailKey) {
			$this->auc_date->setFormValue($objForm->GetValue("x_auc_date"));
			$this->auc_date->CurrentValue = ew_UnFormatDateTime($this->auc_date->CurrentValue, 7);
		}
		if (!$this->auc_number->FldIsDetailKey) {
			$this->auc_number->setFormValue($objForm->GetValue("x_auc_number"));
		}
		if (!$this->auc_place->FldIsDetailKey) {
			$this->auc_place->setFormValue($objForm->GetValue("x_auc_place"));
		}
		if (!$this->start_bid->FldIsDetailKey) {
			$this->start_bid->setFormValue($objForm->GetValue("x_start_bid"));
			$this->start_bid->CurrentValue = ew_UnFormatDateTime($this->start_bid->CurrentValue, 11);
		}
		if (!$this->close_bid->FldIsDetailKey) {
			$this->close_bid->setFormValue($objForm->GetValue("x_close_bid"));
			$this->close_bid->CurrentValue = ew_UnFormatDateTime($this->close_bid->CurrentValue, 11);
		}
		if (!$this->auc_notes->FldIsDetailKey) {
			$this->auc_notes->setFormValue($objForm->GetValue("x_auc_notes"));
		}
		if (!$this->total_sack->FldIsDetailKey) {
			$this->total_sack->setFormValue($objForm->GetValue("x_total_sack"));
		}
		if (!$this->total_netto->FldIsDetailKey) {
			$this->total_netto->setFormValue($objForm->GetValue("x_total_netto"));
		}
		if (!$this->total_gross->FldIsDetailKey) {
			$this->total_gross->setFormValue($objForm->GetValue("x_total_gross"));
		}
		if (!$this->auc_status->FldIsDetailKey) {
			$this->auc_status->setFormValue($objForm->GetValue("x_auc_status"));
		}
		if (!$this->rate->FldIsDetailKey) {
			$this->rate->setFormValue($objForm->GetValue("x_rate"));
		}
		if (!$this->row_id->FldIsDetailKey)
			$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->row_id->CurrentValue = $this->row_id->FormValue;
		$this->auc_date->CurrentValue = $this->auc_date->FormValue;
		$this->auc_date->CurrentValue = ew_UnFormatDateTime($this->auc_date->CurrentValue, 7);
		$this->auc_number->CurrentValue = $this->auc_number->FormValue;
		$this->auc_place->CurrentValue = $this->auc_place->FormValue;
		$this->start_bid->CurrentValue = $this->start_bid->FormValue;
		$this->start_bid->CurrentValue = ew_UnFormatDateTime($this->start_bid->CurrentValue, 11);
		$this->close_bid->CurrentValue = $this->close_bid->FormValue;
		$this->close_bid->CurrentValue = ew_UnFormatDateTime($this->close_bid->CurrentValue, 11);
		$this->auc_notes->CurrentValue = $this->auc_notes->FormValue;
		$this->total_sack->CurrentValue = $this->total_sack->FormValue;
		$this->total_netto->CurrentValue = $this->total_netto->FormValue;
		$this->total_gross->CurrentValue = $this->total_gross->FormValue;
		$this->auc_status->CurrentValue = $this->auc_status->FormValue;
		$this->rate->CurrentValue = $this->rate->FormValue;
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

		if ($this->total_gross->FormValue == $this->total_gross->CurrentValue && is_numeric(ew_StrToFloat($this->total_gross->CurrentValue)))
			$this->total_gross->CurrentValue = ew_StrToFloat($this->total_gross->CurrentValue);

		// Convert decimal values if posted back
		if ($this->rate->FormValue == $this->rate->CurrentValue && is_numeric(ew_StrToFloat($this->rate->CurrentValue)))
			$this->rate->CurrentValue = ew_StrToFloat($this->rate->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// row_id
		// auc_date
		// auc_number
		// auc_place
		// start_bid
		// close_bid
		// auc_notes
		// total_sack
		// total_netto
		// total_gross
		// auc_status
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

			// auc_date
			$this->auc_date->LinkCustomAttributes = "";
			$this->auc_date->HrefValue = "";
			$this->auc_date->TooltipValue = "";

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

			// total_netto
			$this->total_netto->LinkCustomAttributes = "";
			$this->total_netto->HrefValue = "";
			$this->total_netto->TooltipValue = "";

			// total_gross
			$this->total_gross->LinkCustomAttributes = "";
			$this->total_gross->HrefValue = "";
			$this->total_gross->TooltipValue = "";

			// auc_status
			$this->auc_status->LinkCustomAttributes = "";
			$this->auc_status->HrefValue = "";
			$this->auc_status->TooltipValue = "";

			// rate
			$this->rate->LinkCustomAttributes = "";
			$this->rate->HrefValue = "";
			$this->rate->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// auc_date
			$this->auc_date->EditAttrs["class"] = "form-control";
			$this->auc_date->EditCustomAttributes = "";
			$this->auc_date->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->auc_date->CurrentValue, 7));
			$this->auc_date->PlaceHolder = ew_RemoveHtml($this->auc_date->FldCaption());

			// auc_number
			$this->auc_number->EditAttrs["class"] = "form-control";
			$this->auc_number->EditCustomAttributes = "";
			$this->auc_number->EditValue = ew_HtmlEncode($this->auc_number->CurrentValue);
			$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

			// auc_place
			$this->auc_place->EditAttrs["class"] = "form-control";
			$this->auc_place->EditCustomAttributes = "";
			$this->auc_place->EditValue = ew_HtmlEncode($this->auc_place->CurrentValue);
			$this->auc_place->PlaceHolder = ew_RemoveHtml($this->auc_place->FldCaption());

			// start_bid
			$this->start_bid->EditAttrs["class"] = "form-control";
			$this->start_bid->EditCustomAttributes = "";
			$this->start_bid->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->start_bid->CurrentValue, 11));
			$this->start_bid->PlaceHolder = ew_RemoveHtml($this->start_bid->FldCaption());

			// close_bid
			$this->close_bid->EditAttrs["class"] = "form-control";
			$this->close_bid->EditCustomAttributes = "";
			$this->close_bid->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->close_bid->CurrentValue, 11));
			$this->close_bid->PlaceHolder = ew_RemoveHtml($this->close_bid->FldCaption());

			// auc_notes
			$this->auc_notes->EditAttrs["class"] = "form-control";
			$this->auc_notes->EditCustomAttributes = "";
			$this->auc_notes->EditValue = ew_HtmlEncode($this->auc_notes->CurrentValue);
			$this->auc_notes->PlaceHolder = ew_RemoveHtml($this->auc_notes->FldCaption());

			// total_sack
			$this->total_sack->EditAttrs["class"] = "form-control";
			$this->total_sack->EditCustomAttributes = "";
			$this->total_sack->EditValue = ew_HtmlEncode($this->total_sack->CurrentValue);
			$this->total_sack->PlaceHolder = ew_RemoveHtml($this->total_sack->FldCaption());

			// total_netto
			$this->total_netto->EditAttrs["class"] = "form-control";
			$this->total_netto->EditCustomAttributes = "";

			// total_gross
			$this->total_gross->EditAttrs["class"] = "form-control";
			$this->total_gross->EditCustomAttributes = "";
			$this->total_gross->EditValue = ew_HtmlEncode($this->total_gross->CurrentValue);
			$this->total_gross->PlaceHolder = ew_RemoveHtml($this->total_gross->FldCaption());
			if (strval($this->total_gross->EditValue) <> "" && is_numeric($this->total_gross->EditValue)) $this->total_gross->EditValue = ew_FormatNumber($this->total_gross->EditValue, -2, -2, -2, -2);

			// auc_status
			$this->auc_status->EditAttrs["class"] = "form-control";
			$this->auc_status->EditCustomAttributes = "";
			$this->auc_status->EditValue = $this->auc_status->Options(TRUE);

			// rate
			$this->rate->EditAttrs["class"] = "form-control";
			$this->rate->EditCustomAttributes = "";
			$this->rate->EditValue = ew_HtmlEncode($this->rate->CurrentValue);
			$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
			if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) $this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);

			// Edit refer script
			// auc_date

			$this->auc_date->LinkCustomAttributes = "";
			$this->auc_date->HrefValue = "";

			// auc_number
			$this->auc_number->LinkCustomAttributes = "";
			$this->auc_number->HrefValue = "";

			// auc_place
			$this->auc_place->LinkCustomAttributes = "";
			$this->auc_place->HrefValue = "";

			// start_bid
			$this->start_bid->LinkCustomAttributes = "";
			$this->start_bid->HrefValue = "";

			// close_bid
			$this->close_bid->LinkCustomAttributes = "";
			$this->close_bid->HrefValue = "";

			// auc_notes
			$this->auc_notes->LinkCustomAttributes = "";
			$this->auc_notes->HrefValue = "";

			// total_sack
			$this->total_sack->LinkCustomAttributes = "";
			$this->total_sack->HrefValue = "";

			// total_netto
			$this->total_netto->LinkCustomAttributes = "";
			$this->total_netto->HrefValue = "";

			// total_gross
			$this->total_gross->LinkCustomAttributes = "";
			$this->total_gross->HrefValue = "";

			// auc_status
			$this->auc_status->LinkCustomAttributes = "";
			$this->auc_status->HrefValue = "";

			// rate
			$this->rate->LinkCustomAttributes = "";
			$this->rate->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();

		// Save data for Custom Template
		if ($this->RowType == EW_ROWTYPE_VIEW || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_ADD)
			$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckEuroDate($this->auc_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->auc_date->FldErrMsg());
		}
		if (!$this->start_bid->FldIsDetailKey && !is_null($this->start_bid->FormValue) && $this->start_bid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->start_bid->FldCaption(), $this->start_bid->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->start_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->start_bid->FldErrMsg());
		}
		if (!$this->close_bid->FldIsDetailKey && !is_null($this->close_bid->FormValue) && $this->close_bid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->close_bid->FldCaption(), $this->close_bid->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->close_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->close_bid->FldErrMsg());
		}
		if (!ew_CheckInteger($this->total_sack->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_sack->FldErrMsg());
		}
		if (!ew_CheckNumber($this->total_gross->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_gross->FldErrMsg());
		}
		if (!ew_CheckNumber($this->rate->FormValue)) {
			ew_AddMessage($gsFormError, $this->rate->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("tr_lelang_item", $DetailTblVar) && $GLOBALS["tr_lelang_item"]->DetailEdit) {
			if (!isset($GLOBALS["tr_lelang_item_grid"])) $GLOBALS["tr_lelang_item_grid"] = new ctr_lelang_item_grid(); // get detail page object
			$GLOBALS["tr_lelang_item_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// auc_date
			$this->auc_date->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->auc_date->CurrentValue, 7), NULL, $this->auc_date->ReadOnly);

			// auc_number
			$this->auc_number->SetDbValueDef($rsnew, $this->auc_number->CurrentValue, NULL, $this->auc_number->ReadOnly);

			// auc_place
			$this->auc_place->SetDbValueDef($rsnew, $this->auc_place->CurrentValue, NULL, $this->auc_place->ReadOnly);

			// start_bid
			$this->start_bid->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->start_bid->CurrentValue, 11), NULL, $this->start_bid->ReadOnly);

			// close_bid
			$this->close_bid->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->close_bid->CurrentValue, 11), NULL, $this->close_bid->ReadOnly);

			// auc_notes
			$this->auc_notes->SetDbValueDef($rsnew, $this->auc_notes->CurrentValue, NULL, $this->auc_notes->ReadOnly);

			// total_sack
			$this->total_sack->SetDbValueDef($rsnew, $this->total_sack->CurrentValue, NULL, $this->total_sack->ReadOnly);

			// total_netto
			$this->total_netto->SetDbValueDef($rsnew, $this->total_netto->CurrentValue, NULL, $this->total_netto->ReadOnly);

			// total_gross
			$this->total_gross->SetDbValueDef($rsnew, $this->total_gross->CurrentValue, NULL, $this->total_gross->ReadOnly);

			// auc_status
			$this->auc_status->SetDbValueDef($rsnew, $this->auc_status->CurrentValue, NULL, $this->auc_status->ReadOnly);

			// rate
			$this->rate->SetDbValueDef($rsnew, $this->rate->CurrentValue, NULL, $this->rate->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("tr_lelang_item", $DetailTblVar) && $GLOBALS["tr_lelang_item"]->DetailEdit) {
						if (!isset($GLOBALS["tr_lelang_item_grid"])) $GLOBALS["tr_lelang_item_grid"] = new ctr_lelang_item_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "tr_lelang_item"); // Load user level of detail table
						$EditRow = $GLOBALS["tr_lelang_item_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("tr_lelang_item", $DetailTblVar)) {
				if (!isset($GLOBALS["tr_lelang_item_grid"]))
					$GLOBALS["tr_lelang_item_grid"] = new ctr_lelang_item_grid;
				if ($GLOBALS["tr_lelang_item_grid"]->DetailEdit) {
					$GLOBALS["tr_lelang_item_grid"]->CurrentMode = "edit";
					$GLOBALS["tr_lelang_item_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["tr_lelang_item_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["tr_lelang_item_grid"]->setStartRecordNumber(1);
					$GLOBALS["tr_lelang_item_grid"]->master_id->FldIsDetailKey = TRUE;
					$GLOBALS["tr_lelang_item_grid"]->master_id->CurrentValue = $this->row_id->CurrentValue;
					$GLOBALS["tr_lelang_item_grid"]->master_id->setSessionValue($GLOBALS["tr_lelang_item_grid"]->master_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tr_lelang_masterlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tr_lelang_master_edit)) $tr_lelang_master_edit = new ctr_lelang_master_edit();

// Page init
$tr_lelang_master_edit->Page_Init();

// Page main
$tr_lelang_master_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_master_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftr_lelang_masteredit = new ew_Form("ftr_lelang_masteredit", "edit");

// Validate form
ftr_lelang_masteredit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_auc_date");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->auc_date->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_start_bid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_master->start_bid->FldCaption(), $tr_lelang_master->start_bid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_start_bid");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->start_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_close_bid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tr_lelang_master->close_bid->FldCaption(), $tr_lelang_master->close_bid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_close_bid");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->close_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_sack");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->total_sack->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_gross");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->total_gross->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_rate");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($tr_lelang_master->rate->FldErrMsg()) ?>");

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
ftr_lelang_masteredit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_masteredit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_masteredit.Lists["x_auc_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftr_lelang_masteredit.Lists["x_auc_status"].Options = <?php echo json_encode($tr_lelang_master_edit->auc_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $tr_lelang_master_edit->ShowPageHeader(); ?>
<?php
$tr_lelang_master_edit->ShowMessage();
?>
<form name="ftr_lelang_masteredit" id="ftr_lelang_masteredit" class="<?php echo $tr_lelang_master_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_lelang_master_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_lelang_master_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_lelang_master">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($tr_lelang_master_edit->IsModal) ?>">
<div id="tpd_tr_lelang_masteredit" class="ewCustomTemplate"></div>
<script id="tpm_tr_lelang_masteredit" type="text/html">
<div id="ct_tr_lelang_master_edit"><div class="col-sm-12 panel-custom" style="">
	<div class="row">
		<div class="col-sm-5 order-1">
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->auc_number->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_auc_number"/}}</div>
			</div>
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->start_bid->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_start_bid"/}}</div>
			</div>
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->auc_notes->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_auc_notes"/}}</div>
			</div>
		</div>
		<div class="col-sm-7 order-2">
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->auc_place->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_auc_place"/}}</div>
			</div>
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->close_bid->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_close_bid"/}}</div>
			</div>
			<div class="row field-br">
				<div class="col-sm-3 tittle"><?php echo $tr_lelang_master->auc_status->FldCaption() ?></div>
				<div class="col-sm-9">{{include tmpl="#tpx_tr_lelang_master_auc_status"/}}</div>
			</div>
		</div>
	</div>
</div>
<br>
<div class="col-sm-12 panel-custom" style="">
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1">
			<div class="row">
				<div class="col-sm-3 tittle"> <?php echo $tr_lelang_master->total_sack->FldCaption() ?> </div>
				<div class="col-sm-6"> {{include tmpl="#tpx_tr_lelang_master_total_sack"/}} </div>
			</div>
		</div>
		<!--- <div class="col-sm-4">
			<div class="row">
				<div class="col-sm-3 tittle"> <?php echo $tr_lelang_master->total_netto->FldCaption() ?> </div>
				<div class="col-sm-6"> {{include tmpl="#tpx_tr_lelang_master_total_netto"/}} </div>
			</div>
		</div> --->
		<div class="col-sm-5 ">
			<div class="row">
				<div class="col-sm-3 tittle"> <?php echo $tr_lelang_master->total_gross->FldCaption() ?> </div>
				<div class="col-sm-8"> {{include tmpl="#tpx_tr_lelang_master_total_gross"/}} </div>
			</div>
		</div>
	</div>
</div>
</div>
</script>
<?php if (!$tr_lelang_master_edit->IsMobileOrModal) { ?>
<div class="ewDesktop"><!-- desktop -->
<?php } ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
<div class="ewEditDiv hidden"><!-- page* -->
<?php } else { ?>
<table id="tbl_tr_lelang_masteredit" class="table table-striped table-bordered table-hover table-condensed ewDesktopTable hidden"><!-- table* -->
<?php } ?>
<?php if ($tr_lelang_master->auc_date->Visible) { // auc_date ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_auc_date" class="form-group">
		<label id="elh_tr_lelang_master_auc_date" for="x_auc_date" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_auc_date" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_date->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->auc_date->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_date" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_date">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_date" data-format="7" name="x_auc_date" id="x_auc_date" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_date->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_date->EditValue ?>"<?php echo $tr_lelang_master->auc_date->EditAttributes() ?>>
<?php if (!$tr_lelang_master->auc_date->ReadOnly && !$tr_lelang_master->auc_date->Disabled && !isset($tr_lelang_master->auc_date->EditAttrs["readonly"]) && !isset($tr_lelang_master->auc_date->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_auc_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $tr_lelang_master->auc_date->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_date">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_auc_date"><script id="tpc_tr_lelang_master_auc_date" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_date->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->auc_date->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_date" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_date">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_date" data-format="7" name="x_auc_date" id="x_auc_date" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_date->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_date->EditValue ?>"<?php echo $tr_lelang_master->auc_date->EditAttributes() ?>>
<?php if (!$tr_lelang_master->auc_date->ReadOnly && !$tr_lelang_master->auc_date->Disabled && !isset($tr_lelang_master->auc_date->EditAttrs["readonly"]) && !isset($tr_lelang_master->auc_date->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_auc_date", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php echo $tr_lelang_master->auc_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->auc_number->Visible) { // auc_number ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_auc_number" class="form-group">
		<label id="elh_tr_lelang_master_auc_number" for="x_auc_number" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_auc_number" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_number->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->auc_number->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_number" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_number">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" size="15" maxlength="15" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_number->EditValue ?>"<?php echo $tr_lelang_master->auc_number->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_number->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_number">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_auc_number"><script id="tpc_tr_lelang_master_auc_number" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_number->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->auc_number->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_number" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_number">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_number" name="x_auc_number" id="x_auc_number" size="15" maxlength="15" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_number->EditValue ?>"<?php echo $tr_lelang_master->auc_number->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->auc_place->Visible) { // auc_place ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_auc_place" class="form-group">
		<label id="elh_tr_lelang_master_auc_place" for="x_auc_place" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_auc_place" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_place->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->auc_place->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_place" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_place">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_place" name="x_auc_place" id="x_auc_place" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_place->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_place->EditValue ?>"<?php echo $tr_lelang_master->auc_place->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_place->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_place">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_auc_place"><script id="tpc_tr_lelang_master_auc_place" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_place->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->auc_place->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_place" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_place">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_place" name="x_auc_place" id="x_auc_place" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_place->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_place->EditValue ?>"<?php echo $tr_lelang_master->auc_place->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_place->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->start_bid->Visible) { // start_bid ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_start_bid" class="form-group">
		<label id="elh_tr_lelang_master_start_bid" for="x_start_bid" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_start_bid" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->start_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->start_bid->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_start_bid" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_start_bid">
<input type="text" data-table="tr_lelang_master" data-field="x_start_bid" data-format="11" name="x_start_bid" id="x_start_bid" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->start_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->start_bid->EditValue ?>"<?php echo $tr_lelang_master->start_bid->EditAttributes() ?>>
<?php if (!$tr_lelang_master->start_bid->ReadOnly && !$tr_lelang_master->start_bid->Disabled && !isset($tr_lelang_master->start_bid->EditAttrs["readonly"]) && !isset($tr_lelang_master->start_bid->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_start_bid", {"ignoreReadonly":true,"useCurrent":false,"format":11});
</script>
<?php echo $tr_lelang_master->start_bid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_start_bid">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_start_bid"><script id="tpc_tr_lelang_master_start_bid" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->start_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->start_bid->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_start_bid" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_start_bid">
<input type="text" data-table="tr_lelang_master" data-field="x_start_bid" data-format="11" name="x_start_bid" id="x_start_bid" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->start_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->start_bid->EditValue ?>"<?php echo $tr_lelang_master->start_bid->EditAttributes() ?>>
<?php if (!$tr_lelang_master->start_bid->ReadOnly && !$tr_lelang_master->start_bid->Disabled && !isset($tr_lelang_master->start_bid->EditAttrs["readonly"]) && !isset($tr_lelang_master->start_bid->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_start_bid", {"ignoreReadonly":true,"useCurrent":false,"format":11});
</script>
<?php echo $tr_lelang_master->start_bid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->close_bid->Visible) { // close_bid ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_close_bid" class="form-group">
		<label id="elh_tr_lelang_master_close_bid" for="x_close_bid" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_close_bid" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->close_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->close_bid->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_close_bid" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_close_bid">
<input type="text" data-table="tr_lelang_master" data-field="x_close_bid" data-format="11" name="x_close_bid" id="x_close_bid" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->close_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->close_bid->EditValue ?>"<?php echo $tr_lelang_master->close_bid->EditAttributes() ?>>
<?php if (!$tr_lelang_master->close_bid->ReadOnly && !$tr_lelang_master->close_bid->Disabled && !isset($tr_lelang_master->close_bid->EditAttrs["readonly"]) && !isset($tr_lelang_master->close_bid->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_close_bid", {"ignoreReadonly":true,"useCurrent":false,"format":11});
</script>
<?php echo $tr_lelang_master->close_bid->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_close_bid">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_close_bid"><script id="tpc_tr_lelang_master_close_bid" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->close_bid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->close_bid->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_close_bid" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_close_bid">
<input type="text" data-table="tr_lelang_master" data-field="x_close_bid" data-format="11" name="x_close_bid" id="x_close_bid" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->close_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->close_bid->EditValue ?>"<?php echo $tr_lelang_master->close_bid->EditAttributes() ?>>
<?php if (!$tr_lelang_master->close_bid->ReadOnly && !$tr_lelang_master->close_bid->Disabled && !isset($tr_lelang_master->close_bid->EditAttrs["readonly"]) && !isset($tr_lelang_master->close_bid->EditAttrs["disabled"])) { ?>
<?php } ?>
</span>
</script>
<script type="text/html" class="tr_lelang_masteredit_js">
ew_CreateDateTimePicker("ftr_lelang_masteredit", "x_close_bid", {"ignoreReadonly":true,"useCurrent":false,"format":11});
</script>
<?php echo $tr_lelang_master->close_bid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_auc_notes" class="form-group">
		<label id="elh_tr_lelang_master_auc_notes" for="x_auc_notes" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_auc_notes" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_notes->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->auc_notes->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_notes" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_notes">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_notes" name="x_auc_notes" id="x_auc_notes" size="55" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_notes->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_notes->EditValue ?>"<?php echo $tr_lelang_master->auc_notes->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_notes->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_notes">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_auc_notes"><script id="tpc_tr_lelang_master_auc_notes" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_notes->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->auc_notes->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_notes" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_notes">
<input type="text" data-table="tr_lelang_master" data-field="x_auc_notes" name="x_auc_notes" id="x_auc_notes" size="55" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->auc_notes->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->auc_notes->EditValue ?>"<?php echo $tr_lelang_master->auc_notes->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->auc_notes->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->total_sack->Visible) { // total_sack ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_total_sack" class="form-group">
		<label id="elh_tr_lelang_master_total_sack" for="x_total_sack" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_total_sack" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->total_sack->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->total_sack->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_total_sack" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_total_sack">
<input type="text" data-table="tr_lelang_master" data-field="x_total_sack" name="x_total_sack" id="x_total_sack" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->total_sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->total_sack->EditValue ?>"<?php echo $tr_lelang_master->total_sack->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->total_sack->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_total_sack">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_total_sack"><script id="tpc_tr_lelang_master_total_sack" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->total_sack->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->total_sack->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_total_sack" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_total_sack">
<input type="text" data-table="tr_lelang_master" data-field="x_total_sack" name="x_total_sack" id="x_total_sack" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->total_sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->total_sack->EditValue ?>"<?php echo $tr_lelang_master->total_sack->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->total_sack->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->total_gross->Visible) { // total_gross ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_total_gross" class="form-group">
		<label id="elh_tr_lelang_master_total_gross" for="x_total_gross" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_total_gross" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->total_gross->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->total_gross->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_total_gross" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_total_gross">
<input type="text" data-table="tr_lelang_master" data-field="x_total_gross" name="x_total_gross" id="x_total_gross" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->total_gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->total_gross->EditValue ?>"<?php echo $tr_lelang_master->total_gross->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->total_gross->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_total_gross">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_total_gross"><script id="tpc_tr_lelang_master_total_gross" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->total_gross->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->total_gross->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_total_gross" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_total_gross">
<input type="text" data-table="tr_lelang_master" data-field="x_total_gross" name="x_total_gross" id="x_total_gross" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->total_gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->total_gross->EditValue ?>"<?php echo $tr_lelang_master->total_gross->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->total_gross->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->auc_status->Visible) { // auc_status ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_auc_status" class="form-group">
		<label id="elh_tr_lelang_master_auc_status" for="x_auc_status" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_auc_status" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_status->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->auc_status->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_status" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_status">
<select data-table="tr_lelang_master" data-field="x_auc_status" data-value-separator="<?php echo $tr_lelang_master->auc_status->DisplayValueSeparatorAttribute() ?>" id="x_auc_status" name="x_auc_status"<?php echo $tr_lelang_master->auc_status->EditAttributes() ?>>
<?php echo $tr_lelang_master->auc_status->SelectOptionListHtml("x_auc_status") ?>
</select>
</span>
</script>
<?php echo $tr_lelang_master->auc_status->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_auc_status">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_auc_status"><script id="tpc_tr_lelang_master_auc_status" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->auc_status->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->auc_status->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_auc_status" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_auc_status">
<select data-table="tr_lelang_master" data-field="x_auc_status" data-value-separator="<?php echo $tr_lelang_master->auc_status->DisplayValueSeparatorAttribute() ?>" id="x_auc_status" name="x_auc_status"<?php echo $tr_lelang_master->auc_status->EditAttributes() ?>>
<?php echo $tr_lelang_master->auc_status->SelectOptionListHtml("x_auc_status") ?>
</select>
</span>
</script>
<?php echo $tr_lelang_master->auc_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master->rate->Visible) { // rate ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
	<div id="r_rate" class="form-group">
		<label id="elh_tr_lelang_master_rate" for="x_rate" class="<?php echo $tr_lelang_master_edit->LeftColumnClass ?>"><script id="tpc_tr_lelang_master_rate" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->rate->FldCaption() ?></span></script></label>
		<div class="<?php echo $tr_lelang_master_edit->RightColumnClass ?>"><div<?php echo $tr_lelang_master->rate->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_rate" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_rate">
<input type="text" data-table="tr_lelang_master" data-field="x_rate" name="x_rate" id="x_rate" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->rate->EditValue ?>"<?php echo $tr_lelang_master->rate->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->rate->CustomMsg ?></div></div>
	</div>
<?php } else { ?>
	<tr id="r_rate">
		<td class="col-sm-2"><span id="elh_tr_lelang_master_rate"><script id="tpc_tr_lelang_master_rate" class="tr_lelang_masteredit" type="text/html"><span><?php echo $tr_lelang_master->rate->FldCaption() ?></span></script></span></td>
		<td<?php echo $tr_lelang_master->rate->CellAttributes() ?>>
<script id="tpx_tr_lelang_master_rate" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_rate">
<input type="text" data-table="tr_lelang_master" data-field="x_rate" name="x_rate" id="x_rate" size="30" placeholder="<?php echo ew_HtmlEncode($tr_lelang_master->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_master->rate->EditValue ?>"<?php echo $tr_lelang_master->rate->EditAttributes() ?>>
</span>
</script>
<?php echo $tr_lelang_master->rate->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php } ?>
<?php if ($tr_lelang_master_edit->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<script id="tpx_tr_lelang_master_total_netto" class="tr_lelang_masteredit" type="text/html">
<span id="el_tr_lelang_master_total_netto">
<input type="hidden" data-table="tr_lelang_master" data-field="x_total_netto" name="x_total_netto" id="x_total_netto" value="<?php echo ew_HtmlEncode($tr_lelang_master->total_netto->CurrentValue) ?>">
</span>
</script>
<input type="hidden" data-table="tr_lelang_master" data-field="x_row_id" name="x_row_id" id="x_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_master->row_id->CurrentValue) ?>">
<?php
	if (in_array("tr_lelang_item", explode(",", $tr_lelang_master->getCurrentDetailTable())) && $tr_lelang_item->DetailEdit) {
?>
<?php if ($tr_lelang_master->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("tr_lelang_item", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "tr_lelang_itemgrid.php" ?>
<?php } ?>
<?php if (!$tr_lelang_master_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $tr_lelang_master_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tr_lelang_master_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$tr_lelang_master_edit->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
</form>
<script type="text/javascript">
ewVar.templateData = { rows: <?php echo ew_ArrayToJson($tr_lelang_master->Rows) ?> };
ew_ApplyTemplate("tpd_tr_lelang_masteredit", "tpm_tr_lelang_masteredit", "tr_lelang_masteredit", "<?php echo $tr_lelang_master->CustomExport ?>", ewVar.templateData.rows[0]);
jQuery("script.tr_lelang_masteredit_js").each(function(){ew_AddScript(this.text);});
</script>
<script type="text/javascript">
ftr_lelang_masteredit.Init();
</script>
<?php
$tr_lelang_master_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tr_lelang_master_edit->Page_Terminate();
?>
