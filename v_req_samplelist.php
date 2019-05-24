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

$v_req_sample_list = NULL; // Initialize page object first

class cv_req_sample_list extends cv_req_sample {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_req_sample';

	// Page object name
	var $PageObjName = 'v_req_sample_list';

	// Grid form hidden field names
	var $FormName = 'fv_req_samplelist';
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

		// Table object (v_req_sample)
		if (!isset($GLOBALS["v_req_sample"]) || get_class($GLOBALS["v_req_sample"]) == "cv_req_sample") {
			$GLOBALS["v_req_sample"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_req_sample"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_req_sampleadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_req_sampledelete.php";
		$this->MultiUpdateUrl = "v_req_sampleupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_req_samplelistsrch";

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
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

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

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fv_req_samplelistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->req_date->AdvancedSearch->ToJson(), ","); // Field req_date
		$sFilterList = ew_Concat($sFilterList, $this->FullName->AdvancedSearch->ToJson(), ","); // Field FullName
		$sFilterList = ew_Concat($sFilterList, $this->auc_number->AdvancedSearch->ToJson(), ","); // Field auc_number
		$sFilterList = ew_Concat($sFilterList, $this->lot_number->AdvancedSearch->ToJson(), ","); // Field lot_number
		$sFilterList = ew_Concat($sFilterList, $this->chop->AdvancedSearch->ToJson(), ","); // Field chop
		$sFilterList = ew_Concat($sFilterList, $this->grade->AdvancedSearch->ToJson(), ","); // Field grade
		$sFilterList = ew_Concat($sFilterList, $this->estate->AdvancedSearch->ToJson(), ","); // Field estate
		$sFilterList = ew_Concat($sFilterList, $this->sent_date->AdvancedSearch->ToJson(), ","); // Field sent_date
		$sFilterList = ew_Concat($sFilterList, $this->sudah_dikirim->AdvancedSearch->ToJson(), ","); // Field sudah_dikirim
		$sFilterList = ew_Concat($sFilterList, $this->row_id->AdvancedSearch->ToJson(), ","); // Field row_id
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv_req_samplelistsrch", $filters);

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

		// Field req_date
		$this->req_date->AdvancedSearch->SearchValue = @$filter["x_req_date"];
		$this->req_date->AdvancedSearch->SearchOperator = @$filter["z_req_date"];
		$this->req_date->AdvancedSearch->SearchCondition = @$filter["v_req_date"];
		$this->req_date->AdvancedSearch->SearchValue2 = @$filter["y_req_date"];
		$this->req_date->AdvancedSearch->SearchOperator2 = @$filter["w_req_date"];
		$this->req_date->AdvancedSearch->Save();

		// Field FullName
		$this->FullName->AdvancedSearch->SearchValue = @$filter["x_FullName"];
		$this->FullName->AdvancedSearch->SearchOperator = @$filter["z_FullName"];
		$this->FullName->AdvancedSearch->SearchCondition = @$filter["v_FullName"];
		$this->FullName->AdvancedSearch->SearchValue2 = @$filter["y_FullName"];
		$this->FullName->AdvancedSearch->SearchOperator2 = @$filter["w_FullName"];
		$this->FullName->AdvancedSearch->Save();

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

		// Field estate
		$this->estate->AdvancedSearch->SearchValue = @$filter["x_estate"];
		$this->estate->AdvancedSearch->SearchOperator = @$filter["z_estate"];
		$this->estate->AdvancedSearch->SearchCondition = @$filter["v_estate"];
		$this->estate->AdvancedSearch->SearchValue2 = @$filter["y_estate"];
		$this->estate->AdvancedSearch->SearchOperator2 = @$filter["w_estate"];
		$this->estate->AdvancedSearch->Save();

		// Field sent_date
		$this->sent_date->AdvancedSearch->SearchValue = @$filter["x_sent_date"];
		$this->sent_date->AdvancedSearch->SearchOperator = @$filter["z_sent_date"];
		$this->sent_date->AdvancedSearch->SearchCondition = @$filter["v_sent_date"];
		$this->sent_date->AdvancedSearch->SearchValue2 = @$filter["y_sent_date"];
		$this->sent_date->AdvancedSearch->SearchOperator2 = @$filter["w_sent_date"];
		$this->sent_date->AdvancedSearch->Save();

		// Field sudah_dikirim
		$this->sudah_dikirim->AdvancedSearch->SearchValue = @$filter["x_sudah_dikirim"];
		$this->sudah_dikirim->AdvancedSearch->SearchOperator = @$filter["z_sudah_dikirim"];
		$this->sudah_dikirim->AdvancedSearch->SearchCondition = @$filter["v_sudah_dikirim"];
		$this->sudah_dikirim->AdvancedSearch->SearchValue2 = @$filter["y_sudah_dikirim"];
		$this->sudah_dikirim->AdvancedSearch->SearchOperator2 = @$filter["w_sudah_dikirim"];
		$this->sudah_dikirim->AdvancedSearch->Save();

		// Field row_id
		$this->row_id->AdvancedSearch->SearchValue = @$filter["x_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator = @$filter["z_row_id"];
		$this->row_id->AdvancedSearch->SearchCondition = @$filter["v_row_id"];
		$this->row_id->AdvancedSearch->SearchValue2 = @$filter["y_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator2 = @$filter["w_row_id"];
		$this->row_id->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->req_date, $Default, FALSE); // req_date
		$this->BuildSearchSql($sWhere, $this->FullName, $Default, FALSE); // FullName
		$this->BuildSearchSql($sWhere, $this->auc_number, $Default, FALSE); // auc_number
		$this->BuildSearchSql($sWhere, $this->lot_number, $Default, FALSE); // lot_number
		$this->BuildSearchSql($sWhere, $this->chop, $Default, FALSE); // chop
		$this->BuildSearchSql($sWhere, $this->grade, $Default, FALSE); // grade
		$this->BuildSearchSql($sWhere, $this->estate, $Default, FALSE); // estate
		$this->BuildSearchSql($sWhere, $this->sent_date, $Default, FALSE); // sent_date
		$this->BuildSearchSql($sWhere, $this->sudah_dikirim, $Default, FALSE); // sudah_dikirim
		$this->BuildSearchSql($sWhere, $this->row_id, $Default, FALSE); // row_id

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->req_date->AdvancedSearch->Save(); // req_date
			$this->FullName->AdvancedSearch->Save(); // FullName
			$this->auc_number->AdvancedSearch->Save(); // auc_number
			$this->lot_number->AdvancedSearch->Save(); // lot_number
			$this->chop->AdvancedSearch->Save(); // chop
			$this->grade->AdvancedSearch->Save(); // grade
			$this->estate->AdvancedSearch->Save(); // estate
			$this->sent_date->AdvancedSearch->Save(); // sent_date
			$this->sudah_dikirim->AdvancedSearch->Save(); // sudah_dikirim
			$this->row_id->AdvancedSearch->Save(); // row_id
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = $Fld->FldParm();
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1)
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->FullName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->auc_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->chop, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->grade, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->estate, $arKeywords, $type);
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
		if ($this->req_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->FullName->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->auc_number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->lot_number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->chop->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->grade->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sent_date->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sudah_dikirim->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->row_id->AdvancedSearch->IssetSession())
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

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->req_date->AdvancedSearch->UnsetSession();
		$this->FullName->AdvancedSearch->UnsetSession();
		$this->auc_number->AdvancedSearch->UnsetSession();
		$this->lot_number->AdvancedSearch->UnsetSession();
		$this->chop->AdvancedSearch->UnsetSession();
		$this->grade->AdvancedSearch->UnsetSession();
		$this->estate->AdvancedSearch->UnsetSession();
		$this->sent_date->AdvancedSearch->UnsetSession();
		$this->sudah_dikirim->AdvancedSearch->UnsetSession();
		$this->row_id->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->req_date->AdvancedSearch->Load();
		$this->FullName->AdvancedSearch->Load();
		$this->auc_number->AdvancedSearch->Load();
		$this->lot_number->AdvancedSearch->Load();
		$this->chop->AdvancedSearch->Load();
		$this->grade->AdvancedSearch->Load();
		$this->estate->AdvancedSearch->Load();
		$this->sent_date->AdvancedSearch->Load();
		$this->sudah_dikirim->AdvancedSearch->Load();
		$this->row_id->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->req_date); // req_date
			$this->UpdateSort($this->FullName); // FullName
			$this->UpdateSort($this->auc_number); // auc_number
			$this->UpdateSort($this->lot_number); // lot_number
			$this->UpdateSort($this->chop); // chop
			$this->UpdateSort($this->grade); // grade
			$this->UpdateSort($this->estate); // estate
			$this->UpdateSort($this->sent_date); // sent_date
			$this->UpdateSort($this->sudah_dikirim); // sudah_dikirim
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
				$this->req_date->setSort("DESC");
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
				$this->req_date->setSort("");
				$this->FullName->setSort("");
				$this->auc_number->setSort("");
				$this->lot_number->setSort("");
				$this->chop->setSort("");
				$this->grade->setSort("");
				$this->estate->setSort("");
				$this->sent_date->setSort("");
				$this->sudah_dikirim->setSort("");
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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

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

		// "sequence"
		$item = &$this->ListOptions->Add("sequence");
		$item->CssClass = "text-nowrap";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE; // Always on left
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

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"v_req_sample\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,btn:'SaveBtn',url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_req_samplelistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_req_samplelistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_req_samplelist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_req_samplelistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// req_date

		$this->req_date->AdvancedSearch->SearchValue = @$_GET["x_req_date"];
		if ($this->req_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->req_date->AdvancedSearch->SearchOperator = @$_GET["z_req_date"];

		// FullName
		$this->FullName->AdvancedSearch->SearchValue = @$_GET["x_FullName"];
		if ($this->FullName->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->FullName->AdvancedSearch->SearchOperator = @$_GET["z_FullName"];

		// auc_number
		$this->auc_number->AdvancedSearch->SearchValue = @$_GET["x_auc_number"];
		if ($this->auc_number->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->auc_number->AdvancedSearch->SearchOperator = @$_GET["z_auc_number"];

		// lot_number
		$this->lot_number->AdvancedSearch->SearchValue = @$_GET["x_lot_number"];
		if ($this->lot_number->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->lot_number->AdvancedSearch->SearchOperator = @$_GET["z_lot_number"];

		// chop
		$this->chop->AdvancedSearch->SearchValue = @$_GET["x_chop"];
		if ($this->chop->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->chop->AdvancedSearch->SearchOperator = @$_GET["z_chop"];

		// grade
		$this->grade->AdvancedSearch->SearchValue = @$_GET["x_grade"];
		if ($this->grade->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->grade->AdvancedSearch->SearchOperator = @$_GET["z_grade"];

		// estate
		$this->estate->AdvancedSearch->SearchValue = @$_GET["x_estate"];
		if ($this->estate->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->estate->AdvancedSearch->SearchOperator = @$_GET["z_estate"];

		// sent_date
		$this->sent_date->AdvancedSearch->SearchValue = @$_GET["x_sent_date"];
		if ($this->sent_date->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->sent_date->AdvancedSearch->SearchOperator = @$_GET["z_sent_date"];

		// sudah_dikirim
		$this->sudah_dikirim->AdvancedSearch->SearchValue = @$_GET["x_sudah_dikirim"];
		if ($this->sudah_dikirim->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->sudah_dikirim->AdvancedSearch->SearchOperator = @$_GET["z_sudah_dikirim"];
		if (is_array($this->sudah_dikirim->AdvancedSearch->SearchValue)) $this->sudah_dikirim->AdvancedSearch->SearchValue = implode(",", $this->sudah_dikirim->AdvancedSearch->SearchValue);
		if (is_array($this->sudah_dikirim->AdvancedSearch->SearchValue2)) $this->sudah_dikirim->AdvancedSearch->SearchValue2 = implode(",", $this->sudah_dikirim->AdvancedSearch->SearchValue2);

		// row_id
		$this->row_id->AdvancedSearch->SearchValue = @$_GET["x_row_id"];
		if ($this->row_id->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->row_id->AdvancedSearch->SearchOperator = @$_GET["z_row_id"];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// req_date

		$this->req_date->CellCssStyle = "white-space: nowrap;";

		// FullName
		$this->FullName->CellCssStyle = "white-space: nowrap;";

		// auc_number
		// lot_number

		$this->lot_number->CellCssStyle = "white-space: nowrap;";

		// chop
		$this->chop->CellCssStyle = "white-space: nowrap;";

		// grade
		$this->grade->CellCssStyle = "white-space: nowrap;";

		// estate
		// sent_date
		// sudah_dikirim

		$this->sudah_dikirim->CellCssStyle = "white-space: nowrap;";

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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// req_date
			$this->req_date->EditAttrs["class"] = "form-control";
			$this->req_date->EditCustomAttributes = "";
			$this->req_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->req_date->AdvancedSearch->SearchValue, 2), 2));
			$this->req_date->PlaceHolder = ew_RemoveHtml($this->req_date->FldCaption());

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = ew_HtmlEncode($this->FullName->AdvancedSearch->SearchValue);
			$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

			// auc_number
			$this->auc_number->EditAttrs["class"] = "form-control";
			$this->auc_number->EditCustomAttributes = "";
			$this->auc_number->EditValue = ew_HtmlEncode($this->auc_number->AdvancedSearch->SearchValue);
			$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

			// lot_number
			$this->lot_number->EditAttrs["class"] = "form-control";
			$this->lot_number->EditCustomAttributes = "";
			$this->lot_number->EditValue = ew_HtmlEncode($this->lot_number->AdvancedSearch->SearchValue);
			$this->lot_number->PlaceHolder = ew_RemoveHtml($this->lot_number->FldCaption());

			// chop
			$this->chop->EditAttrs["class"] = "form-control";
			$this->chop->EditCustomAttributes = "";
			$this->chop->EditValue = ew_HtmlEncode($this->chop->AdvancedSearch->SearchValue);
			$this->chop->PlaceHolder = ew_RemoveHtml($this->chop->FldCaption());

			// grade
			$this->grade->EditAttrs["class"] = "form-control";
			$this->grade->EditCustomAttributes = "";
			$this->grade->EditValue = ew_HtmlEncode($this->grade->AdvancedSearch->SearchValue);
			$this->grade->PlaceHolder = ew_RemoveHtml($this->grade->FldCaption());

			// estate
			$this->estate->EditAttrs["class"] = "form-control";
			$this->estate->EditCustomAttributes = "";
			$this->estate->EditValue = ew_HtmlEncode($this->estate->AdvancedSearch->SearchValue);
			$this->estate->PlaceHolder = ew_RemoveHtml($this->estate->FldCaption());

			// sent_date
			$this->sent_date->EditAttrs["class"] = "form-control";
			$this->sent_date->EditCustomAttributes = "";
			$this->sent_date->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->sent_date->AdvancedSearch->SearchValue, 0), 8));
			$this->sent_date->PlaceHolder = ew_RemoveHtml($this->sent_date->FldCaption());

			// sudah_dikirim
			$this->sudah_dikirim->EditCustomAttributes = "";
			$this->sudah_dikirim->EditValue = $this->sudah_dikirim->Options(FALSE);
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->req_date->AdvancedSearch->Load();
		$this->FullName->AdvancedSearch->Load();
		$this->auc_number->AdvancedSearch->Load();
		$this->lot_number->AdvancedSearch->Load();
		$this->chop->AdvancedSearch->Load();
		$this->grade->AdvancedSearch->Load();
		$this->estate->AdvancedSearch->Load();
		$this->sent_date->AdvancedSearch->Load();
		$this->sudah_dikirim->AdvancedSearch->Load();
		$this->row_id->AdvancedSearch->Load();
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
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		if ($pageId == "list") {
			switch ($fld->FldVar) {
			}
		} elseif ($pageId == "extbs") {
			switch ($fld->FldVar) {
			}
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

		$this->ListOptions->Items["edit"]->Body = "<a href=tr_req_sampleedit.php?row_id=". $this->row_id->CurrentValue . "><img src='phpimages/btn_edit.jpg' border='0'></a>";	
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
if (!isset($v_req_sample_list)) $v_req_sample_list = new cv_req_sample_list();

// Page init
$v_req_sample_list->Page_Init();

// Page main
$v_req_sample_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_req_sample_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_req_samplelist = new ew_Form("fv_req_samplelist", "list");
fv_req_samplelist.FormKeyCountName = '<?php echo $v_req_sample_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_req_samplelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_req_samplelist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_req_samplelist.Lists["x_sudah_dikirim[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_req_samplelist.Lists["x_sudah_dikirim[]"].Options = <?php echo json_encode($v_req_sample_list->sudah_dikirim->Options()) ?>;

// Form object for search
var CurrentSearchForm = fv_req_samplelistsrch = new ew_Form("fv_req_samplelistsrch");

// Validate function for search
fv_req_samplelistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fv_req_samplelistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_req_samplelistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_req_samplelistsrch.Lists["x_sudah_dikirim[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_req_samplelistsrch.Lists["x_sudah_dikirim[]"].Options = <?php echo json_encode($v_req_sample_list->sudah_dikirim->Options()) ?>;

// Init search panel as collapsed
if (fv_req_samplelistsrch) fv_req_samplelistsrch.InitSearchPanel = true;
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
<?php if ($v_req_sample_list->TotalRecs > 0 && $v_req_sample_list->ExportOptions->Visible()) { ?>
<?php $v_req_sample_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v_req_sample_list->SearchOptions->Visible()) { ?>
<?php $v_req_sample_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v_req_sample_list->FilterOptions->Visible()) { ?>
<?php $v_req_sample_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v_req_sample_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_req_sample_list->TotalRecs <= 0)
			$v_req_sample_list->TotalRecs = $v_req_sample->ListRecordCount();
	} else {
		if (!$v_req_sample_list->Recordset && ($v_req_sample_list->Recordset = $v_req_sample_list->LoadRecordset()))
			$v_req_sample_list->TotalRecs = $v_req_sample_list->Recordset->RecordCount();
	}
	$v_req_sample_list->StartRec = 1;
	if ($v_req_sample_list->DisplayRecs <= 0 || ($v_req_sample->Export <> "" && $v_req_sample->ExportAll)) // Display all records
		$v_req_sample_list->DisplayRecs = $v_req_sample_list->TotalRecs;
	if (!($v_req_sample->Export <> "" && $v_req_sample->ExportAll))
		$v_req_sample_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_req_sample_list->Recordset = $v_req_sample_list->LoadRecordset($v_req_sample_list->StartRec-1, $v_req_sample_list->DisplayRecs);

	// Set no record found message
	if ($v_req_sample->CurrentAction == "" && $v_req_sample_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_req_sample_list->setWarningMessage(ew_DeniedMsg());
		if ($v_req_sample_list->SearchWhere == "0=101")
			$v_req_sample_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_req_sample_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_req_sample_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($v_req_sample->Export == "" && $v_req_sample->CurrentAction == "") { ?>
<form name="fv_req_samplelistsrch" id="fv_req_samplelistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v_req_sample_list->SearchWhere <> "") ? " in" : ""; ?>
<div id="fv_req_samplelistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_req_sample">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$v_req_sample_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$v_req_sample->RowType = EW_ROWTYPE_SEARCH;

// Render row
$v_req_sample->ResetAttrs();
$v_req_sample_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($v_req_sample->sudah_dikirim->Visible) { // sudah_dikirim ?>
	<div id="xsc_sudah_dikirim" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $v_req_sample->sudah_dikirim->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_sudah_dikirim" id="z_sudah_dikirim" value="="></span>
		<span class="ewSearchField">
<?php
$selwrk = (ew_ConvertToBool($v_req_sample->sudah_dikirim->AdvancedSearch->SearchValue)) ? " checked" : "";
?>
<input type="checkbox" data-table="v_req_sample" data-field="x_sudah_dikirim" name="x_sudah_dikirim[]" id="x_sudah_dikirim[]" value="1"<?php echo $selwrk ?><?php echo $v_req_sample->sudah_dikirim->EditAttributes() ?>>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v_req_sample_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v_req_sample_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v_req_sample_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v_req_sample_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v_req_sample_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v_req_sample_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v_req_sample_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $v_req_sample_list->ShowPageHeader(); ?>
<?php
$v_req_sample_list->ShowMessage();
?>
<?php if ($v_req_sample_list->TotalRecs > 0 || $v_req_sample->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_req_sample_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_req_sample">
<div class="box-header ewGridUpperPanel">
<?php if ($v_req_sample->CurrentAction <> "gridadd" && $v_req_sample->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_req_sample_list->Pager)) $v_req_sample_list->Pager = new cPrevNextPager($v_req_sample_list->StartRec, $v_req_sample_list->DisplayRecs, $v_req_sample_list->TotalRecs, $v_req_sample_list->AutoHidePager) ?>
<?php if ($v_req_sample_list->Pager->RecordCount > 0 && $v_req_sample_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_req_sample_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_req_sample_list->PageUrl() ?>start=<?php echo $v_req_sample_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_req_sample_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_req_sample_list->PageUrl() ?>start=<?php echo $v_req_sample_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_req_sample_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_req_sample_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_req_sample_list->PageUrl() ?>start=<?php echo $v_req_sample_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_req_sample_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_req_sample_list->PageUrl() ?>start=<?php echo $v_req_sample_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_req_sample_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_req_sample_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_req_sample_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_req_sample_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_req_sample_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($v_req_sample_list->TotalRecs > 0 && (!$v_req_sample_list->AutoHidePageSizeSelector || $v_req_sample_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="v_req_sample">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($v_req_sample_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($v_req_sample_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($v_req_sample_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($v_req_sample_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($v_req_sample->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_req_sample_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fv_req_samplelist" id="fv_req_samplelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_req_sample_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_req_sample_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_req_sample">
<div id="gmp_v_req_sample" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_req_sample_list->TotalRecs > 0 || $v_req_sample->CurrentAction == "gridedit") { ?>
<table id="tbl_v_req_samplelist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_req_sample_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_req_sample_list->RenderListOptions();

// Render list options (header, left)
$v_req_sample_list->ListOptions->Render("header", "left");
?>
<?php if ($v_req_sample->req_date->Visible) { // req_date ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->req_date) == "") { ?>
		<th data-name="req_date" class="<?php echo $v_req_sample->req_date->HeaderCellClass() ?>"><div id="elh_v_req_sample_req_date" class="v_req_sample_req_date"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->req_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="req_date" class="<?php echo $v_req_sample->req_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->req_date) ?>',1);"><div id="elh_v_req_sample_req_date" class="v_req_sample_req_date">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->req_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->req_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->req_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->FullName->Visible) { // FullName ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->FullName) == "") { ?>
		<th data-name="FullName" class="<?php echo $v_req_sample->FullName->HeaderCellClass() ?>"><div id="elh_v_req_sample_FullName" class="v_req_sample_FullName"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->FullName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="FullName" class="<?php echo $v_req_sample->FullName->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->FullName) ?>',1);"><div id="elh_v_req_sample_FullName" class="v_req_sample_FullName">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->FullName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->FullName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->FullName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->auc_number->Visible) { // auc_number ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->auc_number) == "") { ?>
		<th data-name="auc_number" class="<?php echo $v_req_sample->auc_number->HeaderCellClass() ?>"><div id="elh_v_req_sample_auc_number" class="v_req_sample_auc_number"><div class="ewTableHeaderCaption"><?php echo $v_req_sample->auc_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_number" class="<?php echo $v_req_sample->auc_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->auc_number) ?>',1);"><div id="elh_v_req_sample_auc_number" class="v_req_sample_auc_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->auc_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->auc_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->auc_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->lot_number->Visible) { // lot_number ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_req_sample->lot_number->HeaderCellClass() ?>"><div id="elh_v_req_sample_lot_number" class="v_req_sample_lot_number"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_req_sample->lot_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->lot_number) ?>',1);"><div id="elh_v_req_sample_lot_number" class="v_req_sample_lot_number">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->chop->Visible) { // chop ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_req_sample->chop->HeaderCellClass() ?>"><div id="elh_v_req_sample_chop" class="v_req_sample_chop"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_req_sample->chop->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->chop) ?>',1);"><div id="elh_v_req_sample_chop" class="v_req_sample_chop">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->chop->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->grade->Visible) { // grade ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_req_sample->grade->HeaderCellClass() ?>"><div id="elh_v_req_sample_grade" class="v_req_sample_grade"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_req_sample->grade->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->grade) ?>',1);"><div id="elh_v_req_sample_grade" class="v_req_sample_grade">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->grade->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->estate->Visible) { // estate ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $v_req_sample->estate->HeaderCellClass() ?>"><div id="elh_v_req_sample_estate" class="v_req_sample_estate"><div class="ewTableHeaderCaption"><?php echo $v_req_sample->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $v_req_sample->estate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->estate) ?>',1);"><div id="elh_v_req_sample_estate" class="v_req_sample_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->estate->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->sent_date->Visible) { // sent_date ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->sent_date) == "") { ?>
		<th data-name="sent_date" class="<?php echo $v_req_sample->sent_date->HeaderCellClass() ?>"><div id="elh_v_req_sample_sent_date" class="v_req_sample_sent_date"><div class="ewTableHeaderCaption"><?php echo $v_req_sample->sent_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sent_date" class="<?php echo $v_req_sample->sent_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->sent_date) ?>',1);"><div id="elh_v_req_sample_sent_date" class="v_req_sample_sent_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->sent_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->sent_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->sent_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_req_sample->sudah_dikirim->Visible) { // sudah_dikirim ?>
	<?php if ($v_req_sample->SortUrl($v_req_sample->sudah_dikirim) == "") { ?>
		<th data-name="sudah_dikirim" class="<?php echo $v_req_sample->sudah_dikirim->HeaderCellClass() ?>"><div id="elh_v_req_sample_sudah_dikirim" class="v_req_sample_sudah_dikirim"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_req_sample->sudah_dikirim->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sudah_dikirim" class="<?php echo $v_req_sample->sudah_dikirim->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_req_sample->SortUrl($v_req_sample->sudah_dikirim) ?>',1);"><div id="elh_v_req_sample_sudah_dikirim" class="v_req_sample_sudah_dikirim">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_req_sample->sudah_dikirim->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_req_sample->sudah_dikirim->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_req_sample->sudah_dikirim->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_req_sample_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_req_sample->ExportAll && $v_req_sample->Export <> "") {
	$v_req_sample_list->StopRec = $v_req_sample_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_req_sample_list->TotalRecs > $v_req_sample_list->StartRec + $v_req_sample_list->DisplayRecs - 1)
		$v_req_sample_list->StopRec = $v_req_sample_list->StartRec + $v_req_sample_list->DisplayRecs - 1;
	else
		$v_req_sample_list->StopRec = $v_req_sample_list->TotalRecs;
}
$v_req_sample_list->RecCnt = $v_req_sample_list->StartRec - 1;
if ($v_req_sample_list->Recordset && !$v_req_sample_list->Recordset->EOF) {
	$v_req_sample_list->Recordset->MoveFirst();
	$bSelectLimit = $v_req_sample_list->UseSelectLimit;
	if (!$bSelectLimit && $v_req_sample_list->StartRec > 1)
		$v_req_sample_list->Recordset->Move($v_req_sample_list->StartRec - 1);
} elseif (!$v_req_sample->AllowAddDeleteRow && $v_req_sample_list->StopRec == 0) {
	$v_req_sample_list->StopRec = $v_req_sample->GridAddRowCount;
}

// Initialize aggregate
$v_req_sample->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_req_sample->ResetAttrs();
$v_req_sample_list->RenderRow();
while ($v_req_sample_list->RecCnt < $v_req_sample_list->StopRec) {
	$v_req_sample_list->RecCnt++;
	if (intval($v_req_sample_list->RecCnt) >= intval($v_req_sample_list->StartRec)) {
		$v_req_sample_list->RowCnt++;

		// Set up key count
		$v_req_sample_list->KeyCount = $v_req_sample_list->RowIndex;

		// Init row class and style
		$v_req_sample->ResetAttrs();
		$v_req_sample->CssClass = "";
		if ($v_req_sample->CurrentAction == "gridadd") {
		} else {
			$v_req_sample_list->LoadRowValues($v_req_sample_list->Recordset); // Load row values
		}
		$v_req_sample->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_req_sample->RowAttrs = array_merge($v_req_sample->RowAttrs, array('data-rowindex'=>$v_req_sample_list->RowCnt, 'id'=>'r' . $v_req_sample_list->RowCnt . '_v_req_sample', 'data-rowtype'=>$v_req_sample->RowType));

		// Render row
		$v_req_sample_list->RenderRow();

		// Render list options
		$v_req_sample_list->RenderListOptions();
?>
	<tr<?php echo $v_req_sample->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_req_sample_list->ListOptions->Render("body", "left", $v_req_sample_list->RowCnt);
?>
	<?php if ($v_req_sample->req_date->Visible) { // req_date ?>
		<td data-name="req_date"<?php echo $v_req_sample->req_date->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_req_date" class="v_req_sample_req_date">
<span<?php echo $v_req_sample->req_date->ViewAttributes() ?>>
<?php echo $v_req_sample->req_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->FullName->Visible) { // FullName ?>
		<td data-name="FullName"<?php echo $v_req_sample->FullName->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_FullName" class="v_req_sample_FullName">
<span<?php echo $v_req_sample->FullName->ViewAttributes() ?>>
<?php echo $v_req_sample->FullName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->auc_number->Visible) { // auc_number ?>
		<td data-name="auc_number"<?php echo $v_req_sample->auc_number->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_auc_number" class="v_req_sample_auc_number">
<span<?php echo $v_req_sample->auc_number->ViewAttributes() ?>>
<?php echo $v_req_sample->auc_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_req_sample->lot_number->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_lot_number" class="v_req_sample_lot_number">
<span<?php echo $v_req_sample->lot_number->ViewAttributes() ?>>
<?php echo $v_req_sample->lot_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_req_sample->chop->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_chop" class="v_req_sample_chop">
<span<?php echo $v_req_sample->chop->ViewAttributes() ?>>
<?php echo $v_req_sample->chop->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_req_sample->grade->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_grade" class="v_req_sample_grade">
<span<?php echo $v_req_sample->grade->ViewAttributes() ?>>
<?php echo $v_req_sample->grade->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $v_req_sample->estate->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_estate" class="v_req_sample_estate">
<span<?php echo $v_req_sample->estate->ViewAttributes() ?>>
<?php echo $v_req_sample->estate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->sent_date->Visible) { // sent_date ?>
		<td data-name="sent_date"<?php echo $v_req_sample->sent_date->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_sent_date" class="v_req_sample_sent_date">
<span<?php echo $v_req_sample->sent_date->ViewAttributes() ?>>
<?php echo $v_req_sample->sent_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_req_sample->sudah_dikirim->Visible) { // sudah_dikirim ?>
		<td data-name="sudah_dikirim"<?php echo $v_req_sample->sudah_dikirim->CellAttributes() ?>>
<span id="el<?php echo $v_req_sample_list->RowCnt ?>_v_req_sample_sudah_dikirim" class="v_req_sample_sudah_dikirim">
<span<?php echo $v_req_sample->sudah_dikirim->ViewAttributes() ?>>
<?php if (ew_ConvertToBool($v_req_sample->sudah_dikirim->CurrentValue)) { ?>
<input type="checkbox" value="<?php echo $v_req_sample->sudah_dikirim->ListViewValue() ?>" disabled checked>
<?php } else { ?>
<input type="checkbox" value="<?php echo $v_req_sample->sudah_dikirim->ListViewValue() ?>" disabled>
<?php } ?>
</span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_req_sample_list->ListOptions->Render("body", "right", $v_req_sample_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_req_sample->CurrentAction <> "gridadd")
		$v_req_sample_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_req_sample->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_req_sample_list->Recordset)
	$v_req_sample_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($v_req_sample_list->TotalRecs == 0 && $v_req_sample->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_req_sample_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_req_samplelistsrch.FilterList = <?php echo $v_req_sample_list->GetFilterList() ?>;
fv_req_samplelistsrch.Init();
fv_req_samplelist.Init();
</script>
<?php
$v_req_sample_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_req_sample_list->Page_Terminate();
?>
