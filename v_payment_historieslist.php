<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_payment_historiesinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_payment_histories_list = NULL; // Initialize page object first

class cv_payment_histories_list extends cv_payment_histories {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_payment_histories';

	// Page object name
	var $PageObjName = 'v_payment_histories_list';

	// Grid form hidden field names
	var $FormName = 'fv_payment_historieslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Table object (v_payment_histories)
		if (!isset($GLOBALS["v_payment_histories"]) || get_class($GLOBALS["v_payment_histories"]) == "cv_payment_histories") {
			$GLOBALS["v_payment_histories"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_payment_histories"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_payment_historiesadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_payment_historiesdelete.php";
		$this->MultiUpdateUrl = "v_payment_historiesupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_payment_histories', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fv_payment_historieslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->proforma_number->SetVisibility();
		$this->auc_number->SetVisibility();
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->grade->SetVisibility();
		$this->sack->SetVisibility();
		$this->netto->SetVisibility();
		$this->currency->SetVisibility();
		$this->invoice_number->SetVisibility();
		$this->payment_date->SetVisibility();
		$this->payment_amount->SetVisibility();
		$this->currency1->SetVisibility();
		$this->bank_from->SetVisibility();
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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
		global $EW_EXPORT, $v_payment_histories;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_payment_histories);
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->row_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->row_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server" && isset($UserProfile))
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fv_payment_historieslistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->proforma_number->AdvancedSearch->ToJson(), ","); // Field proforma_number
		$sFilterList = ew_Concat($sFilterList, $this->auc_number->AdvancedSearch->ToJson(), ","); // Field auc_number
		$sFilterList = ew_Concat($sFilterList, $this->lot_number->AdvancedSearch->ToJson(), ","); // Field lot_number
		$sFilterList = ew_Concat($sFilterList, $this->chop->AdvancedSearch->ToJson(), ","); // Field chop
		$sFilterList = ew_Concat($sFilterList, $this->grade->AdvancedSearch->ToJson(), ","); // Field grade
		$sFilterList = ew_Concat($sFilterList, $this->sack->AdvancedSearch->ToJson(), ","); // Field sack
		$sFilterList = ew_Concat($sFilterList, $this->netto->AdvancedSearch->ToJson(), ","); // Field netto
		$sFilterList = ew_Concat($sFilterList, $this->proforma_amount->AdvancedSearch->ToJson(), ","); // Field proforma_amount
		$sFilterList = ew_Concat($sFilterList, $this->currency->AdvancedSearch->ToJson(), ","); // Field currency
		$sFilterList = ew_Concat($sFilterList, $this->invoice_number->AdvancedSearch->ToJson(), ","); // Field invoice_number
		$sFilterList = ew_Concat($sFilterList, $this->payment_date->AdvancedSearch->ToJson(), ","); // Field payment_date
		$sFilterList = ew_Concat($sFilterList, $this->payment_amount->AdvancedSearch->ToJson(), ","); // Field payment_amount
		$sFilterList = ew_Concat($sFilterList, $this->currency1->AdvancedSearch->ToJson(), ","); // Field currency1
		$sFilterList = ew_Concat($sFilterList, $this->bank_from->AdvancedSearch->ToJson(), ","); // Field bank_from
		$sFilterList = ew_Concat($sFilterList, $this->confirmed->AdvancedSearch->ToJson(), ","); // Field confirmed
		$sFilterList = ew_Concat($sFilterList, $this->row_id->AdvancedSearch->ToJson(), ","); // Field row_id
		$sFilterList = ew_Concat($sFilterList, $this->user_id->AdvancedSearch->ToJson(), ","); // Field user_id
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv_payment_historieslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field proforma_number
		$this->proforma_number->AdvancedSearch->SearchValue = @$filter["x_proforma_number"];
		$this->proforma_number->AdvancedSearch->SearchOperator = @$filter["z_proforma_number"];
		$this->proforma_number->AdvancedSearch->SearchCondition = @$filter["v_proforma_number"];
		$this->proforma_number->AdvancedSearch->SearchValue2 = @$filter["y_proforma_number"];
		$this->proforma_number->AdvancedSearch->SearchOperator2 = @$filter["w_proforma_number"];
		$this->proforma_number->AdvancedSearch->Save();

		// Field auc_number
		$this->auc_number->AdvancedSearch->SearchValue = @$filter["x_auc_number"];
		$this->auc_number->AdvancedSearch->SearchOperator = @$filter["z_auc_number"];
		$this->auc_number->AdvancedSearch->SearchCondition = @$filter["v_auc_number"];
		$this->auc_number->AdvancedSearch->SearchValue2 = @$filter["y_auc_number"];
		$this->auc_number->AdvancedSearch->SearchOperator2 = @$filter["w_auc_number"];
		$this->auc_number->AdvancedSearch->Save();

		// Field lot_number
		$this->lot_number->AdvancedSearch->SearchValue = @$filter["x_lot_number"];
		$this->lot_number->AdvancedSearch->SearchOperator = @$filter["z_lot_number"];
		$this->lot_number->AdvancedSearch->SearchCondition = @$filter["v_lot_number"];
		$this->lot_number->AdvancedSearch->SearchValue2 = @$filter["y_lot_number"];
		$this->lot_number->AdvancedSearch->SearchOperator2 = @$filter["w_lot_number"];
		$this->lot_number->AdvancedSearch->Save();

		// Field chop
		$this->chop->AdvancedSearch->SearchValue = @$filter["x_chop"];
		$this->chop->AdvancedSearch->SearchOperator = @$filter["z_chop"];
		$this->chop->AdvancedSearch->SearchCondition = @$filter["v_chop"];
		$this->chop->AdvancedSearch->SearchValue2 = @$filter["y_chop"];
		$this->chop->AdvancedSearch->SearchOperator2 = @$filter["w_chop"];
		$this->chop->AdvancedSearch->Save();

		// Field grade
		$this->grade->AdvancedSearch->SearchValue = @$filter["x_grade"];
		$this->grade->AdvancedSearch->SearchOperator = @$filter["z_grade"];
		$this->grade->AdvancedSearch->SearchCondition = @$filter["v_grade"];
		$this->grade->AdvancedSearch->SearchValue2 = @$filter["y_grade"];
		$this->grade->AdvancedSearch->SearchOperator2 = @$filter["w_grade"];
		$this->grade->AdvancedSearch->Save();

		// Field sack
		$this->sack->AdvancedSearch->SearchValue = @$filter["x_sack"];
		$this->sack->AdvancedSearch->SearchOperator = @$filter["z_sack"];
		$this->sack->AdvancedSearch->SearchCondition = @$filter["v_sack"];
		$this->sack->AdvancedSearch->SearchValue2 = @$filter["y_sack"];
		$this->sack->AdvancedSearch->SearchOperator2 = @$filter["w_sack"];
		$this->sack->AdvancedSearch->Save();

		// Field netto
		$this->netto->AdvancedSearch->SearchValue = @$filter["x_netto"];
		$this->netto->AdvancedSearch->SearchOperator = @$filter["z_netto"];
		$this->netto->AdvancedSearch->SearchCondition = @$filter["v_netto"];
		$this->netto->AdvancedSearch->SearchValue2 = @$filter["y_netto"];
		$this->netto->AdvancedSearch->SearchOperator2 = @$filter["w_netto"];
		$this->netto->AdvancedSearch->Save();

		// Field proforma_amount
		$this->proforma_amount->AdvancedSearch->SearchValue = @$filter["x_proforma_amount"];
		$this->proforma_amount->AdvancedSearch->SearchOperator = @$filter["z_proforma_amount"];
		$this->proforma_amount->AdvancedSearch->SearchCondition = @$filter["v_proforma_amount"];
		$this->proforma_amount->AdvancedSearch->SearchValue2 = @$filter["y_proforma_amount"];
		$this->proforma_amount->AdvancedSearch->SearchOperator2 = @$filter["w_proforma_amount"];
		$this->proforma_amount->AdvancedSearch->Save();

		// Field currency
		$this->currency->AdvancedSearch->SearchValue = @$filter["x_currency"];
		$this->currency->AdvancedSearch->SearchOperator = @$filter["z_currency"];
		$this->currency->AdvancedSearch->SearchCondition = @$filter["v_currency"];
		$this->currency->AdvancedSearch->SearchValue2 = @$filter["y_currency"];
		$this->currency->AdvancedSearch->SearchOperator2 = @$filter["w_currency"];
		$this->currency->AdvancedSearch->Save();

		// Field invoice_number
		$this->invoice_number->AdvancedSearch->SearchValue = @$filter["x_invoice_number"];
		$this->invoice_number->AdvancedSearch->SearchOperator = @$filter["z_invoice_number"];
		$this->invoice_number->AdvancedSearch->SearchCondition = @$filter["v_invoice_number"];
		$this->invoice_number->AdvancedSearch->SearchValue2 = @$filter["y_invoice_number"];
		$this->invoice_number->AdvancedSearch->SearchOperator2 = @$filter["w_invoice_number"];
		$this->invoice_number->AdvancedSearch->Save();

		// Field payment_date
		$this->payment_date->AdvancedSearch->SearchValue = @$filter["x_payment_date"];
		$this->payment_date->AdvancedSearch->SearchOperator = @$filter["z_payment_date"];
		$this->payment_date->AdvancedSearch->SearchCondition = @$filter["v_payment_date"];
		$this->payment_date->AdvancedSearch->SearchValue2 = @$filter["y_payment_date"];
		$this->payment_date->AdvancedSearch->SearchOperator2 = @$filter["w_payment_date"];
		$this->payment_date->AdvancedSearch->Save();

		// Field payment_amount
		$this->payment_amount->AdvancedSearch->SearchValue = @$filter["x_payment_amount"];
		$this->payment_amount->AdvancedSearch->SearchOperator = @$filter["z_payment_amount"];
		$this->payment_amount->AdvancedSearch->SearchCondition = @$filter["v_payment_amount"];
		$this->payment_amount->AdvancedSearch->SearchValue2 = @$filter["y_payment_amount"];
		$this->payment_amount->AdvancedSearch->SearchOperator2 = @$filter["w_payment_amount"];
		$this->payment_amount->AdvancedSearch->Save();

		// Field currency1
		$this->currency1->AdvancedSearch->SearchValue = @$filter["x_currency1"];
		$this->currency1->AdvancedSearch->SearchOperator = @$filter["z_currency1"];
		$this->currency1->AdvancedSearch->SearchCondition = @$filter["v_currency1"];
		$this->currency1->AdvancedSearch->SearchValue2 = @$filter["y_currency1"];
		$this->currency1->AdvancedSearch->SearchOperator2 = @$filter["w_currency1"];
		$this->currency1->AdvancedSearch->Save();

		// Field bank_from
		$this->bank_from->AdvancedSearch->SearchValue = @$filter["x_bank_from"];
		$this->bank_from->AdvancedSearch->SearchOperator = @$filter["z_bank_from"];
		$this->bank_from->AdvancedSearch->SearchCondition = @$filter["v_bank_from"];
		$this->bank_from->AdvancedSearch->SearchValue2 = @$filter["y_bank_from"];
		$this->bank_from->AdvancedSearch->SearchOperator2 = @$filter["w_bank_from"];
		$this->bank_from->AdvancedSearch->Save();

		// Field confirmed
		$this->confirmed->AdvancedSearch->SearchValue = @$filter["x_confirmed"];
		$this->confirmed->AdvancedSearch->SearchOperator = @$filter["z_confirmed"];
		$this->confirmed->AdvancedSearch->SearchCondition = @$filter["v_confirmed"];
		$this->confirmed->AdvancedSearch->SearchValue2 = @$filter["y_confirmed"];
		$this->confirmed->AdvancedSearch->SearchOperator2 = @$filter["w_confirmed"];
		$this->confirmed->AdvancedSearch->Save();

		// Field row_id
		$this->row_id->AdvancedSearch->SearchValue = @$filter["x_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator = @$filter["z_row_id"];
		$this->row_id->AdvancedSearch->SearchCondition = @$filter["v_row_id"];
		$this->row_id->AdvancedSearch->SearchValue2 = @$filter["y_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator2 = @$filter["w_row_id"];
		$this->row_id->AdvancedSearch->Save();

		// Field user_id
		$this->user_id->AdvancedSearch->SearchValue = @$filter["x_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator = @$filter["z_user_id"];
		$this->user_id->AdvancedSearch->SearchCondition = @$filter["v_user_id"];
		$this->user_id->AdvancedSearch->SearchValue2 = @$filter["y_user_id"];
		$this->user_id->AdvancedSearch->SearchOperator2 = @$filter["w_user_id"];
		$this->user_id->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->proforma_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->auc_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->chop, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->grade, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->invoice_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->bank_from, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->proforma_number); // proforma_number
			$this->UpdateSort($this->auc_number); // auc_number
			$this->UpdateSort($this->lot_number); // lot_number
			$this->UpdateSort($this->chop); // chop
			$this->UpdateSort($this->grade); // grade
			$this->UpdateSort($this->sack); // sack
			$this->UpdateSort($this->netto); // netto
			$this->UpdateSort($this->currency); // currency
			$this->UpdateSort($this->invoice_number); // invoice_number
			$this->UpdateSort($this->payment_date); // payment_date
			$this->UpdateSort($this->payment_amount); // payment_amount
			$this->UpdateSort($this->currency1); // currency1
			$this->UpdateSort($this->bank_from); // bank_from
			$this->UpdateSort($this->confirmed); // confirmed
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->proforma_number->setSort("");
				$this->auc_number->setSort("");
				$this->lot_number->setSort("");
				$this->chop->setSort("");
				$this->grade->setSort("");
				$this->sack->setSort("");
				$this->netto->setSort("");
				$this->currency->setSort("");
				$this->invoice_number->setSort("");
				$this->payment_date->setSort("");
				$this->payment_amount->setSort("");
				$this->currency1->setSort("");
				$this->bank_from->setSort("");
				$this->confirmed->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->row_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = TRUE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_payment_historieslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_payment_historieslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_payment_historieslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : "";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_payment_historieslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;

		// Hide detail items for dropdown if necessary
		$this->ListOptions->HideDetailItemsForDropDown();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->proforma_number->setDbValue($row['proforma_number']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->grade->setDbValue($row['grade']);
		$this->sack->setDbValue($row['sack']);
		$this->netto->setDbValue($row['netto']);
		$this->proforma_amount->setDbValue($row['proforma_amount']);
		$this->currency->setDbValue($row['currency']);
		$this->invoice_number->setDbValue($row['invoice_number']);
		$this->payment_date->setDbValue($row['payment_date']);
		$this->payment_amount->setDbValue($row['payment_amount']);
		$this->currency1->setDbValue($row['currency1']);
		$this->bank_from->setDbValue($row['bank_from']);
		$this->confirmed->setDbValue($row['confirmed']);
		$this->row_id->setDbValue($row['row_id']);
		$this->user_id->setDbValue($row['user_id']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['proforma_number'] = NULL;
		$row['auc_number'] = NULL;
		$row['lot_number'] = NULL;
		$row['chop'] = NULL;
		$row['grade'] = NULL;
		$row['sack'] = NULL;
		$row['netto'] = NULL;
		$row['proforma_amount'] = NULL;
		$row['currency'] = NULL;
		$row['invoice_number'] = NULL;
		$row['payment_date'] = NULL;
		$row['payment_amount'] = NULL;
		$row['currency1'] = NULL;
		$row['bank_from'] = NULL;
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
		$this->proforma_number->DbValue = $row['proforma_number'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->grade->DbValue = $row['grade'];
		$this->sack->DbValue = $row['sack'];
		$this->netto->DbValue = $row['netto'];
		$this->proforma_amount->DbValue = $row['proforma_amount'];
		$this->currency->DbValue = $row['currency'];
		$this->invoice_number->DbValue = $row['invoice_number'];
		$this->payment_date->DbValue = $row['payment_date'];
		$this->payment_amount->DbValue = $row['payment_amount'];
		$this->currency1->DbValue = $row['currency1'];
		$this->bank_from->DbValue = $row['bank_from'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Convert decimal values if posted back
		if ($this->netto->FormValue == $this->netto->CurrentValue && is_numeric(ew_StrToFloat($this->netto->CurrentValue)))
			$this->netto->CurrentValue = ew_StrToFloat($this->netto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->payment_amount->FormValue == $this->payment_amount->CurrentValue && is_numeric(ew_StrToFloat($this->payment_amount->CurrentValue)))
			$this->payment_amount->CurrentValue = ew_StrToFloat($this->payment_amount->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// proforma_number
		// auc_number
		// lot_number
		// chop
		// grade
		// sack
		// netto
		// proforma_amount
		// currency
		// invoice_number
		// payment_date
		// payment_amount
		// currency1
		// bank_from
		// confirmed
		// row_id
		// user_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// proforma_number
		$this->proforma_number->ViewValue = $this->proforma_number->CurrentValue;
		$this->proforma_number->ViewCustomAttributes = "";

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

		// sack
		$this->sack->ViewValue = $this->sack->CurrentValue;
		$this->sack->ViewValue = ew_FormatNumber($this->sack->ViewValue, 0, -2, -2, -2);
		$this->sack->CellCssStyle .= "text-align: right;";
		$this->sack->ViewCustomAttributes = "";

		// netto
		$this->netto->ViewValue = $this->netto->CurrentValue;
		$this->netto->ViewValue = ew_FormatNumber($this->netto->ViewValue, 2, -2, -2, -2);
		$this->netto->CellCssStyle .= "text-align: right;";
		$this->netto->ViewCustomAttributes = "";

		// proforma_amount
		$this->proforma_amount->ViewValue = $this->proforma_amount->CurrentValue;
		$this->proforma_amount->ViewValue = ew_FormatNumber($this->proforma_amount->ViewValue, 1, -2, -2, -2);
		$this->proforma_amount->CellCssStyle .= "text-align: right;";
		$this->proforma_amount->ViewCustomAttributes = "";

		// currency
		$this->currency->ViewValue = $this->currency->CurrentValue;
		$this->currency->ViewCustomAttributes = "";

		// invoice_number
		$this->invoice_number->ViewValue = $this->invoice_number->CurrentValue;
		$this->invoice_number->CellCssStyle .= "text-align: center;";
		$this->invoice_number->ViewCustomAttributes = "";

		// payment_date
		$this->payment_date->ViewValue = $this->payment_date->CurrentValue;
		$this->payment_date->ViewValue = ew_FormatDateTime($this->payment_date->ViewValue, 2);
		$this->payment_date->CellCssStyle .= "text-align: center;";
		$this->payment_date->ViewCustomAttributes = "";

		// payment_amount
		$this->payment_amount->ViewValue = $this->payment_amount->CurrentValue;
		$this->payment_amount->ViewValue = ew_FormatNumber($this->payment_amount->ViewValue, 2, -2, -2, -2);
		$this->payment_amount->CellCssStyle .= "text-align: right;";
		$this->payment_amount->ViewCustomAttributes = "";

		// currency1
		if (strval($this->currency1->CurrentValue) <> "") {
			$this->currency1->ViewValue = $this->currency1->OptionCaption($this->currency1->CurrentValue);
		} else {
			$this->currency1->ViewValue = NULL;
		}
		$this->currency1->ViewCustomAttributes = "";

		// bank_from
		$this->bank_from->ViewValue = $this->bank_from->CurrentValue;
		$this->bank_from->ViewCustomAttributes = "";

		// confirmed
		if (ew_ConvertToBool($this->confirmed->CurrentValue)) {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(2) <> "" ? $this->confirmed->FldTagCaption(2) : "1";
		} else {
			$this->confirmed->ViewValue = $this->confirmed->FldTagCaption(1) <> "" ? $this->confirmed->FldTagCaption(1) : "0";
		}
		$this->confirmed->CellCssStyle .= "text-align: center;";
		$this->confirmed->ViewCustomAttributes = "";

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// user_id
		$this->user_id->ViewValue = $this->user_id->CurrentValue;
		$this->user_id->ViewCustomAttributes = "";

			// proforma_number
			$this->proforma_number->LinkCustomAttributes = "";
			$this->proforma_number->HrefValue = "";
			$this->proforma_number->TooltipValue = "";

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

			// sack
			$this->sack->LinkCustomAttributes = "";
			$this->sack->HrefValue = "";
			$this->sack->TooltipValue = "";

			// netto
			$this->netto->LinkCustomAttributes = "";
			$this->netto->HrefValue = "";
			$this->netto->TooltipValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";
			$this->currency->TooltipValue = "";

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

			// currency1
			$this->currency1->LinkCustomAttributes = "";
			$this->currency1->HrefValue = "";
			$this->currency1->TooltipValue = "";

			// bank_from
			$this->bank_from->LinkCustomAttributes = "";
			$this->bank_from->HrefValue = "";
			$this->bank_from->TooltipValue = "";

			// confirmed
			$this->confirmed->LinkCustomAttributes = "";
			$this->confirmed->HrefValue = "";
			$this->confirmed->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($v_payment_histories_list)) $v_payment_histories_list = new cv_payment_histories_list();

// Page init
$v_payment_histories_list->Page_Init();

// Page main
$v_payment_histories_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_payment_histories_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_payment_historieslist = new ew_Form("fv_payment_historieslist", "list");
fv_payment_historieslist.FormKeyCountName = '<?php echo $v_payment_histories_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_payment_historieslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_payment_historieslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_payment_historieslist.Lists["x_currency1"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_payment_historieslist.Lists["x_currency1"].Options = <?php echo json_encode($v_payment_histories_list->currency1->Options()) ?>;
fv_payment_historieslist.Lists["x_confirmed[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_payment_historieslist.Lists["x_confirmed[]"].Options = <?php echo json_encode($v_payment_histories_list->confirmed->Options()) ?>;

// Form object for search
var CurrentSearchForm = fv_payment_historieslistsrch = new ew_Form("fv_payment_historieslistsrch");

// Init search panel as collapsed
if (fv_payment_historieslistsrch) fv_payment_historieslistsrch.InitSearchPanel = true;
</script>
<style type="text/css">
.ewTablePreviewRow { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ewTablePreviewRow .ewGrid {
	display: table;
}
</style>
<div id="ewPreview" class="hide"><!-- preview -->
	<div class="nav-tabs-custom"><!-- .nav-tabs-custom -->
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content"><!-- .tab-content -->
			<div class="tab-pane fade"></div>
		</div><!-- /.tab-content -->
	</div><!-- /.nav-tabs-custom -->
</div><!-- /preview -->
<script type="text/javascript" src="phpjs/ewpreview.js"></script>
<script type="text/javascript">
var EW_PREVIEW_PLACEMENT = EW_CSS_FLIP ? "left" : "right";
var EW_PREVIEW_SINGLE_ROW = false;
var EW_PREVIEW_OVERLAY = false;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($v_payment_histories_list->TotalRecs > 0 && $v_payment_histories_list->ExportOptions->Visible()) { ?>
<?php $v_payment_histories_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v_payment_histories_list->SearchOptions->Visible()) { ?>
<?php $v_payment_histories_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v_payment_histories_list->FilterOptions->Visible()) { ?>
<?php $v_payment_histories_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v_payment_histories_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_payment_histories_list->TotalRecs <= 0)
			$v_payment_histories_list->TotalRecs = $v_payment_histories->ListRecordCount();
	} else {
		if (!$v_payment_histories_list->Recordset && ($v_payment_histories_list->Recordset = $v_payment_histories_list->LoadRecordset()))
			$v_payment_histories_list->TotalRecs = $v_payment_histories_list->Recordset->RecordCount();
	}
	$v_payment_histories_list->StartRec = 1;
	if ($v_payment_histories_list->DisplayRecs <= 0 || ($v_payment_histories->Export <> "" && $v_payment_histories->ExportAll)) // Display all records
		$v_payment_histories_list->DisplayRecs = $v_payment_histories_list->TotalRecs;
	if (!($v_payment_histories->Export <> "" && $v_payment_histories->ExportAll))
		$v_payment_histories_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_payment_histories_list->Recordset = $v_payment_histories_list->LoadRecordset($v_payment_histories_list->StartRec-1, $v_payment_histories_list->DisplayRecs);

	// Set no record found message
	if ($v_payment_histories->CurrentAction == "" && $v_payment_histories_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_payment_histories_list->setWarningMessage(ew_DeniedMsg());
		if ($v_payment_histories_list->SearchWhere == "0=101")
			$v_payment_histories_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_payment_histories_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_payment_histories_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($v_payment_histories->Export == "" && $v_payment_histories->CurrentAction == "") { ?>
<form name="fv_payment_historieslistsrch" id="fv_payment_historieslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v_payment_histories_list->SearchWhere <> "") ? " in" : ""; ?>
<div id="fv_payment_historieslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_payment_histories">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v_payment_histories_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v_payment_histories_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v_payment_histories_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v_payment_histories_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v_payment_histories_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v_payment_histories_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v_payment_histories_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $v_payment_histories_list->ShowPageHeader(); ?>
<?php
$v_payment_histories_list->ShowMessage();
?>
<?php if ($v_payment_histories_list->TotalRecs > 0 || $v_payment_histories->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_payment_histories_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_payment_histories">
<div class="box-header ewGridUpperPanel">
<?php if ($v_payment_histories->CurrentAction <> "gridadd" && $v_payment_histories->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_payment_histories_list->Pager)) $v_payment_histories_list->Pager = new cPrevNextPager($v_payment_histories_list->StartRec, $v_payment_histories_list->DisplayRecs, $v_payment_histories_list->TotalRecs, $v_payment_histories_list->AutoHidePager) ?>
<?php if ($v_payment_histories_list->Pager->RecordCount > 0 && $v_payment_histories_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_payment_histories_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_payment_histories_list->PageUrl() ?>start=<?php echo $v_payment_histories_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_payment_histories_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_payment_histories_list->PageUrl() ?>start=<?php echo $v_payment_histories_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_payment_histories_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_payment_histories_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_payment_histories_list->PageUrl() ?>start=<?php echo $v_payment_histories_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_payment_histories_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_payment_histories_list->PageUrl() ?>start=<?php echo $v_payment_histories_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_payment_histories_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_payment_histories_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_payment_histories_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_payment_histories_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_payment_histories_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($v_payment_histories_list->TotalRecs > 0 && (!$v_payment_histories_list->AutoHidePageSizeSelector || $v_payment_histories_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="v_payment_histories">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($v_payment_histories_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($v_payment_histories_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($v_payment_histories_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($v_payment_histories_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($v_payment_histories->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_payment_histories_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fv_payment_historieslist" id="fv_payment_historieslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_payment_histories_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_payment_histories_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_payment_histories">
<div id="gmp_v_payment_histories" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_payment_histories_list->TotalRecs > 0 || $v_payment_histories->CurrentAction == "gridedit") { ?>
<table id="tbl_v_payment_historieslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_payment_histories_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_payment_histories_list->RenderListOptions();

// Render list options (header, left)
$v_payment_histories_list->ListOptions->Render("header", "left");
?>
<?php if ($v_payment_histories->proforma_number->Visible) { // proforma_number ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->proforma_number) == "") { ?>
		<th data-name="proforma_number" class="<?php echo $v_payment_histories->proforma_number->HeaderCellClass() ?>"><div id="elh_v_payment_histories_proforma_number" class="v_payment_histories_proforma_number"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->proforma_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="proforma_number" class="<?php echo $v_payment_histories->proforma_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->proforma_number) ?>',1);"><div id="elh_v_payment_histories_proforma_number" class="v_payment_histories_proforma_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->proforma_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->proforma_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->proforma_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->auc_number->Visible) { // auc_number ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->auc_number) == "") { ?>
		<th data-name="auc_number" class="<?php echo $v_payment_histories->auc_number->HeaderCellClass() ?>"><div id="elh_v_payment_histories_auc_number" class="v_payment_histories_auc_number"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->auc_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_number" class="<?php echo $v_payment_histories->auc_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->auc_number) ?>',1);"><div id="elh_v_payment_histories_auc_number" class="v_payment_histories_auc_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->auc_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->auc_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->auc_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->lot_number->Visible) { // lot_number ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_payment_histories->lot_number->HeaderCellClass() ?>"><div id="elh_v_payment_histories_lot_number" class="v_payment_histories_lot_number"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_payment_histories->lot_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->lot_number) ?>',1);"><div id="elh_v_payment_histories_lot_number" class="v_payment_histories_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->chop->Visible) { // chop ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_payment_histories->chop->HeaderCellClass() ?>"><div id="elh_v_payment_histories_chop" class="v_payment_histories_chop"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_payment_histories->chop->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->chop) ?>',1);"><div id="elh_v_payment_histories_chop" class="v_payment_histories_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->chop->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->grade->Visible) { // grade ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_payment_histories->grade->HeaderCellClass() ?>"><div id="elh_v_payment_histories_grade" class="v_payment_histories_grade"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_payment_histories->grade->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->grade) ?>',1);"><div id="elh_v_payment_histories_grade" class="v_payment_histories_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->grade->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->sack->Visible) { // sack ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $v_payment_histories->sack->HeaderCellClass() ?>"><div id="elh_v_payment_histories_sack" class="v_payment_histories_sack"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $v_payment_histories->sack->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->sack) ?>',1);"><div id="elh_v_payment_histories_sack" class="v_payment_histories_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->netto->Visible) { // netto ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->netto) == "") { ?>
		<th data-name="netto" class="<?php echo $v_payment_histories->netto->HeaderCellClass() ?>"><div id="elh_v_payment_histories_netto" class="v_payment_histories_netto"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->netto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="netto" class="<?php echo $v_payment_histories->netto->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->netto) ?>',1);"><div id="elh_v_payment_histories_netto" class="v_payment_histories_netto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->netto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->netto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->netto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->currency->Visible) { // currency ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->currency) == "") { ?>
		<th data-name="currency" class="<?php echo $v_payment_histories->currency->HeaderCellClass() ?>"><div id="elh_v_payment_histories_currency" class="v_payment_histories_currency"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->currency->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency" class="<?php echo $v_payment_histories->currency->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->currency) ?>',1);"><div id="elh_v_payment_histories_currency" class="v_payment_histories_currency">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->currency->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->currency->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->currency->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->invoice_number->Visible) { // invoice_number ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->invoice_number) == "") { ?>
		<th data-name="invoice_number" class="<?php echo $v_payment_histories->invoice_number->HeaderCellClass() ?>"><div id="elh_v_payment_histories_invoice_number" class="v_payment_histories_invoice_number"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->invoice_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="invoice_number" class="<?php echo $v_payment_histories->invoice_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->invoice_number) ?>',1);"><div id="elh_v_payment_histories_invoice_number" class="v_payment_histories_invoice_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->invoice_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->invoice_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->invoice_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->payment_date->Visible) { // payment_date ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->payment_date) == "") { ?>
		<th data-name="payment_date" class="<?php echo $v_payment_histories->payment_date->HeaderCellClass() ?>"><div id="elh_v_payment_histories_payment_date" class="v_payment_histories_payment_date"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->payment_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="payment_date" class="<?php echo $v_payment_histories->payment_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->payment_date) ?>',1);"><div id="elh_v_payment_histories_payment_date" class="v_payment_histories_payment_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->payment_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->payment_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->payment_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->payment_amount->Visible) { // payment_amount ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->payment_amount) == "") { ?>
		<th data-name="payment_amount" class="<?php echo $v_payment_histories->payment_amount->HeaderCellClass() ?>"><div id="elh_v_payment_histories_payment_amount" class="v_payment_histories_payment_amount"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->payment_amount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="payment_amount" class="<?php echo $v_payment_histories->payment_amount->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->payment_amount) ?>',1);"><div id="elh_v_payment_histories_payment_amount" class="v_payment_histories_payment_amount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->payment_amount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->payment_amount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->payment_amount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->currency1->Visible) { // currency1 ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->currency1) == "") { ?>
		<th data-name="currency1" class="<?php echo $v_payment_histories->currency1->HeaderCellClass() ?>"><div id="elh_v_payment_histories_currency1" class="v_payment_histories_currency1"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->currency1->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency1" class="<?php echo $v_payment_histories->currency1->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->currency1) ?>',1);"><div id="elh_v_payment_histories_currency1" class="v_payment_histories_currency1">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->currency1->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->currency1->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->currency1->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->bank_from->Visible) { // bank_from ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->bank_from) == "") { ?>
		<th data-name="bank_from" class="<?php echo $v_payment_histories->bank_from->HeaderCellClass() ?>"><div id="elh_v_payment_histories_bank_from" class="v_payment_histories_bank_from"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->bank_from->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bank_from" class="<?php echo $v_payment_histories->bank_from->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->bank_from) ?>',1);"><div id="elh_v_payment_histories_bank_from" class="v_payment_histories_bank_from">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->bank_from->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->bank_from->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->bank_from->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_payment_histories->confirmed->Visible) { // confirmed ?>
	<?php if ($v_payment_histories->SortUrl($v_payment_histories->confirmed) == "") { ?>
		<th data-name="confirmed" class="<?php echo $v_payment_histories->confirmed->HeaderCellClass() ?>"><div id="elh_v_payment_histories_confirmed" class="v_payment_histories_confirmed"><div class="ewTableHeaderCaption"><?php echo $v_payment_histories->confirmed->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="confirmed" class="<?php echo $v_payment_histories->confirmed->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_payment_histories->SortUrl($v_payment_histories->confirmed) ?>',1);"><div id="elh_v_payment_histories_confirmed" class="v_payment_histories_confirmed">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_payment_histories->confirmed->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_payment_histories->confirmed->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_payment_histories->confirmed->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_payment_histories_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_payment_histories->ExportAll && $v_payment_histories->Export <> "") {
	$v_payment_histories_list->StopRec = $v_payment_histories_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_payment_histories_list->TotalRecs > $v_payment_histories_list->StartRec + $v_payment_histories_list->DisplayRecs - 1)
		$v_payment_histories_list->StopRec = $v_payment_histories_list->StartRec + $v_payment_histories_list->DisplayRecs - 1;
	else
		$v_payment_histories_list->StopRec = $v_payment_histories_list->TotalRecs;
}
$v_payment_histories_list->RecCnt = $v_payment_histories_list->StartRec - 1;
if ($v_payment_histories_list->Recordset && !$v_payment_histories_list->Recordset->EOF) {
	$v_payment_histories_list->Recordset->MoveFirst();
	$bSelectLimit = $v_payment_histories_list->UseSelectLimit;
	if (!$bSelectLimit && $v_payment_histories_list->StartRec > 1)
		$v_payment_histories_list->Recordset->Move($v_payment_histories_list->StartRec - 1);
} elseif (!$v_payment_histories->AllowAddDeleteRow && $v_payment_histories_list->StopRec == 0) {
	$v_payment_histories_list->StopRec = $v_payment_histories->GridAddRowCount;
}

// Initialize aggregate
$v_payment_histories->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_payment_histories->ResetAttrs();
$v_payment_histories_list->RenderRow();
while ($v_payment_histories_list->RecCnt < $v_payment_histories_list->StopRec) {
	$v_payment_histories_list->RecCnt++;
	if (intval($v_payment_histories_list->RecCnt) >= intval($v_payment_histories_list->StartRec)) {
		$v_payment_histories_list->RowCnt++;

		// Set up key count
		$v_payment_histories_list->KeyCount = $v_payment_histories_list->RowIndex;

		// Init row class and style
		$v_payment_histories->ResetAttrs();
		$v_payment_histories->CssClass = "";
		if ($v_payment_histories->CurrentAction == "gridadd") {
		} else {
			$v_payment_histories_list->LoadRowValues($v_payment_histories_list->Recordset); // Load row values
		}
		$v_payment_histories->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_payment_histories->RowAttrs = array_merge($v_payment_histories->RowAttrs, array('data-rowindex'=>$v_payment_histories_list->RowCnt, 'id'=>'r' . $v_payment_histories_list->RowCnt . '_v_payment_histories', 'data-rowtype'=>$v_payment_histories->RowType));

		// Render row
		$v_payment_histories_list->RenderRow();

		// Render list options
		$v_payment_histories_list->RenderListOptions();
?>
	<tr<?php echo $v_payment_histories->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_payment_histories_list->ListOptions->Render("body", "left", $v_payment_histories_list->RowCnt);
?>
	<?php if ($v_payment_histories->proforma_number->Visible) { // proforma_number ?>
		<td data-name="proforma_number"<?php echo $v_payment_histories->proforma_number->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_proforma_number" class="v_payment_histories_proforma_number">
<span<?php echo $v_payment_histories->proforma_number->ViewAttributes() ?>>
<?php echo $v_payment_histories->proforma_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->auc_number->Visible) { // auc_number ?>
		<td data-name="auc_number"<?php echo $v_payment_histories->auc_number->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_auc_number" class="v_payment_histories_auc_number">
<span<?php echo $v_payment_histories->auc_number->ViewAttributes() ?>>
<?php echo $v_payment_histories->auc_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_payment_histories->lot_number->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_lot_number" class="v_payment_histories_lot_number">
<span<?php echo $v_payment_histories->lot_number->ViewAttributes() ?>>
<?php echo $v_payment_histories->lot_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_payment_histories->chop->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_chop" class="v_payment_histories_chop">
<span<?php echo $v_payment_histories->chop->ViewAttributes() ?>>
<?php echo $v_payment_histories->chop->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_payment_histories->grade->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_grade" class="v_payment_histories_grade">
<span<?php echo $v_payment_histories->grade->ViewAttributes() ?>>
<?php echo $v_payment_histories->grade->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $v_payment_histories->sack->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_sack" class="v_payment_histories_sack">
<span<?php echo $v_payment_histories->sack->ViewAttributes() ?>>
<?php echo $v_payment_histories->sack->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->netto->Visible) { // netto ?>
		<td data-name="netto"<?php echo $v_payment_histories->netto->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_netto" class="v_payment_histories_netto">
<span<?php echo $v_payment_histories->netto->ViewAttributes() ?>>
<?php echo $v_payment_histories->netto->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->currency->Visible) { // currency ?>
		<td data-name="currency"<?php echo $v_payment_histories->currency->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_currency" class="v_payment_histories_currency">
<span<?php echo $v_payment_histories->currency->ViewAttributes() ?>>
<?php echo $v_payment_histories->currency->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->invoice_number->Visible) { // invoice_number ?>
		<td data-name="invoice_number"<?php echo $v_payment_histories->invoice_number->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_invoice_number" class="v_payment_histories_invoice_number">
<span<?php echo $v_payment_histories->invoice_number->ViewAttributes() ?>>
<?php echo $v_payment_histories->invoice_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->payment_date->Visible) { // payment_date ?>
		<td data-name="payment_date"<?php echo $v_payment_histories->payment_date->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_payment_date" class="v_payment_histories_payment_date">
<span<?php echo $v_payment_histories->payment_date->ViewAttributes() ?>>
<?php echo $v_payment_histories->payment_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->payment_amount->Visible) { // payment_amount ?>
		<td data-name="payment_amount"<?php echo $v_payment_histories->payment_amount->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_payment_amount" class="v_payment_histories_payment_amount">
<span<?php echo $v_payment_histories->payment_amount->ViewAttributes() ?>>
<?php echo $v_payment_histories->payment_amount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->currency1->Visible) { // currency1 ?>
		<td data-name="currency1"<?php echo $v_payment_histories->currency1->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_currency1" class="v_payment_histories_currency1">
<span<?php echo $v_payment_histories->currency1->ViewAttributes() ?>>
<?php echo $v_payment_histories->currency1->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->bank_from->Visible) { // bank_from ?>
		<td data-name="bank_from"<?php echo $v_payment_histories->bank_from->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_bank_from" class="v_payment_histories_bank_from">
<span<?php echo $v_payment_histories->bank_from->ViewAttributes() ?>>
<?php echo $v_payment_histories->bank_from->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_payment_histories->confirmed->Visible) { // confirmed ?>
		<td data-name="confirmed"<?php echo $v_payment_histories->confirmed->CellAttributes() ?>>
<span id="el<?php echo $v_payment_histories_list->RowCnt ?>_v_payment_histories_confirmed" class="v_payment_histories_confirmed">
<span<?php echo $v_payment_histories->confirmed->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($v_payment_histories->confirmed->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $v_payment_histories->confirmed->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $v_payment_histories->confirmed->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_payment_histories_list->ListOptions->Render("body", "right", $v_payment_histories_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_payment_histories->CurrentAction <> "gridadd")
		$v_payment_histories_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_payment_histories->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_payment_histories_list->Recordset)
	$v_payment_histories_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($v_payment_histories_list->TotalRecs == 0 && $v_payment_histories->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_payment_histories_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_payment_historieslistsrch.FilterList = <?php echo $v_payment_histories_list->GetFilterList() ?>;
fv_payment_historieslistsrch.Init();
fv_payment_historieslist.Init();
</script>
<?php
$v_payment_histories_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_payment_histories_list->Page_Terminate();
?>
