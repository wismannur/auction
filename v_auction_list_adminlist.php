<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_auction_list_admininfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "v_bid_histories_admingridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_auction_list_admin_list = NULL; // Initialize page object first

class cv_auction_list_admin_list extends cv_auction_list_admin {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_auction_list_admin';

	// Page object name
	var $PageObjName = 'v_auction_list_admin_list';

	// Grid form hidden field names
	var $FormName = 'fv_auction_list_adminlist';
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

		// Table object (v_auction_list_admin)
		if (!isset($GLOBALS["v_auction_list_admin"]) || get_class($GLOBALS["v_auction_list_admin"]) == "cv_auction_list_admin") {
			$GLOBALS["v_auction_list_admin"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_auction_list_admin"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_auction_list_adminadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_auction_list_admindelete.php";
		$this->MultiUpdateUrl = "v_auction_list_adminupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_auction_list_admin', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_auction_list_adminlistsrch";

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
		$this->tanggal->SetVisibility();
		$this->auc_number->SetVisibility();
		$this->start_bid->SetVisibility();
		$this->close_bid->SetVisibility();
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->grade->SetVisibility();
		$this->estate->SetVisibility();
		$this->sack->SetVisibility();
		$this->netto->SetVisibility();
		$this->open_bid->SetVisibility();
		$this->highest_bid->SetVisibility();
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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("v_bid_histories_admin", $DetailTblVar)) {

					// Process auto fill for detail table 'v_bid_histories_admin'
					if (preg_match('/^fv_bid_histories_admin(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["v_bid_histories_admin_grid"])) $GLOBALS["v_bid_histories_admin_grid"] = new cv_bid_histories_admin_grid;
						$GLOBALS["v_bid_histories_admin_grid"]->Page_Init();
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
		global $EW_EXPORT, $v_auction_list_admin;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_auction_list_admin);
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
	var $v_bid_histories_admin_Count;
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fv_auction_list_adminlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->tanggal->AdvancedSearch->ToJson(), ","); // Field tanggal
		$sFilterList = ew_Concat($sFilterList, $this->auc_number->AdvancedSearch->ToJson(), ","); // Field auc_number
		$sFilterList = ew_Concat($sFilterList, $this->start_bid->AdvancedSearch->ToJson(), ","); // Field start_bid
		$sFilterList = ew_Concat($sFilterList, $this->close_bid->AdvancedSearch->ToJson(), ","); // Field close_bid
		$sFilterList = ew_Concat($sFilterList, $this->lot_number->AdvancedSearch->ToJson(), ","); // Field lot_number
		$sFilterList = ew_Concat($sFilterList, $this->chop->AdvancedSearch->ToJson(), ","); // Field chop
		$sFilterList = ew_Concat($sFilterList, $this->grade->AdvancedSearch->ToJson(), ","); // Field grade
		$sFilterList = ew_Concat($sFilterList, $this->estate->AdvancedSearch->ToJson(), ","); // Field estate
		$sFilterList = ew_Concat($sFilterList, $this->sack->AdvancedSearch->ToJson(), ","); // Field sack
		$sFilterList = ew_Concat($sFilterList, $this->netto->AdvancedSearch->ToJson(), ","); // Field netto
		$sFilterList = ew_Concat($sFilterList, $this->open_bid->AdvancedSearch->ToJson(), ","); // Field open_bid
		$sFilterList = ew_Concat($sFilterList, $this->last_bid->AdvancedSearch->ToJson(), ","); // Field last_bid
		$sFilterList = ew_Concat($sFilterList, $this->highest_bid->AdvancedSearch->ToJson(), ","); // Field highest_bid
		$sFilterList = ew_Concat($sFilterList, $this->enter_bid->AdvancedSearch->ToJson(), ","); // Field enter_bid
		$sFilterList = ew_Concat($sFilterList, $this->auction_status->AdvancedSearch->ToJson(), ","); // Field auction_status
		$sFilterList = ew_Concat($sFilterList, $this->gross->AdvancedSearch->ToJson(), ","); // Field gross
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv_auction_list_adminlistsrch", $filters);

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

		// Field tanggal
		$this->tanggal->AdvancedSearch->SearchValue = @$filter["x_tanggal"];
		$this->tanggal->AdvancedSearch->SearchOperator = @$filter["z_tanggal"];
		$this->tanggal->AdvancedSearch->SearchCondition = @$filter["v_tanggal"];
		$this->tanggal->AdvancedSearch->SearchValue2 = @$filter["y_tanggal"];
		$this->tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal"];
		$this->tanggal->AdvancedSearch->Save();

		// Field auc_number
		$this->auc_number->AdvancedSearch->SearchValue = @$filter["x_auc_number"];
		$this->auc_number->AdvancedSearch->SearchOperator = @$filter["z_auc_number"];
		$this->auc_number->AdvancedSearch->SearchCondition = @$filter["v_auc_number"];
		$this->auc_number->AdvancedSearch->SearchValue2 = @$filter["y_auc_number"];
		$this->auc_number->AdvancedSearch->SearchOperator2 = @$filter["w_auc_number"];
		$this->auc_number->AdvancedSearch->Save();

		// Field start_bid
		$this->start_bid->AdvancedSearch->SearchValue = @$filter["x_start_bid"];
		$this->start_bid->AdvancedSearch->SearchOperator = @$filter["z_start_bid"];
		$this->start_bid->AdvancedSearch->SearchCondition = @$filter["v_start_bid"];
		$this->start_bid->AdvancedSearch->SearchValue2 = @$filter["y_start_bid"];
		$this->start_bid->AdvancedSearch->SearchOperator2 = @$filter["w_start_bid"];
		$this->start_bid->AdvancedSearch->Save();

		// Field close_bid
		$this->close_bid->AdvancedSearch->SearchValue = @$filter["x_close_bid"];
		$this->close_bid->AdvancedSearch->SearchOperator = @$filter["z_close_bid"];
		$this->close_bid->AdvancedSearch->SearchCondition = @$filter["v_close_bid"];
		$this->close_bid->AdvancedSearch->SearchValue2 = @$filter["y_close_bid"];
		$this->close_bid->AdvancedSearch->SearchOperator2 = @$filter["w_close_bid"];
		$this->close_bid->AdvancedSearch->Save();

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

		// Field open_bid
		$this->open_bid->AdvancedSearch->SearchValue = @$filter["x_open_bid"];
		$this->open_bid->AdvancedSearch->SearchOperator = @$filter["z_open_bid"];
		$this->open_bid->AdvancedSearch->SearchCondition = @$filter["v_open_bid"];
		$this->open_bid->AdvancedSearch->SearchValue2 = @$filter["y_open_bid"];
		$this->open_bid->AdvancedSearch->SearchOperator2 = @$filter["w_open_bid"];
		$this->open_bid->AdvancedSearch->Save();

		// Field last_bid
		$this->last_bid->AdvancedSearch->SearchValue = @$filter["x_last_bid"];
		$this->last_bid->AdvancedSearch->SearchOperator = @$filter["z_last_bid"];
		$this->last_bid->AdvancedSearch->SearchCondition = @$filter["v_last_bid"];
		$this->last_bid->AdvancedSearch->SearchValue2 = @$filter["y_last_bid"];
		$this->last_bid->AdvancedSearch->SearchOperator2 = @$filter["w_last_bid"];
		$this->last_bid->AdvancedSearch->Save();

		// Field highest_bid
		$this->highest_bid->AdvancedSearch->SearchValue = @$filter["x_highest_bid"];
		$this->highest_bid->AdvancedSearch->SearchOperator = @$filter["z_highest_bid"];
		$this->highest_bid->AdvancedSearch->SearchCondition = @$filter["v_highest_bid"];
		$this->highest_bid->AdvancedSearch->SearchValue2 = @$filter["y_highest_bid"];
		$this->highest_bid->AdvancedSearch->SearchOperator2 = @$filter["w_highest_bid"];
		$this->highest_bid->AdvancedSearch->Save();

		// Field enter_bid
		$this->enter_bid->AdvancedSearch->SearchValue = @$filter["x_enter_bid"];
		$this->enter_bid->AdvancedSearch->SearchOperator = @$filter["z_enter_bid"];
		$this->enter_bid->AdvancedSearch->SearchCondition = @$filter["v_enter_bid"];
		$this->enter_bid->AdvancedSearch->SearchValue2 = @$filter["y_enter_bid"];
		$this->enter_bid->AdvancedSearch->SearchOperator2 = @$filter["w_enter_bid"];
		$this->enter_bid->AdvancedSearch->Save();

		// Field auction_status
		$this->auction_status->AdvancedSearch->SearchValue = @$filter["x_auction_status"];
		$this->auction_status->AdvancedSearch->SearchOperator = @$filter["z_auction_status"];
		$this->auction_status->AdvancedSearch->SearchCondition = @$filter["v_auction_status"];
		$this->auction_status->AdvancedSearch->SearchValue2 = @$filter["y_auction_status"];
		$this->auction_status->AdvancedSearch->SearchOperator2 = @$filter["w_auction_status"];
		$this->auction_status->AdvancedSearch->Save();

		// Field gross
		$this->gross->AdvancedSearch->SearchValue = @$filter["x_gross"];
		$this->gross->AdvancedSearch->SearchOperator = @$filter["z_gross"];
		$this->gross->AdvancedSearch->SearchCondition = @$filter["v_gross"];
		$this->gross->AdvancedSearch->SearchValue2 = @$filter["y_gross"];
		$this->gross->AdvancedSearch->SearchOperator2 = @$filter["w_gross"];
		$this->gross->AdvancedSearch->Save();

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
		$this->BuildSearchSql($sWhere, $this->tanggal, $Default, FALSE); // tanggal
		$this->BuildSearchSql($sWhere, $this->auc_number, $Default, FALSE); // auc_number
		$this->BuildSearchSql($sWhere, $this->start_bid, $Default, FALSE); // start_bid
		$this->BuildSearchSql($sWhere, $this->close_bid, $Default, FALSE); // close_bid
		$this->BuildSearchSql($sWhere, $this->lot_number, $Default, FALSE); // lot_number
		$this->BuildSearchSql($sWhere, $this->chop, $Default, FALSE); // chop
		$this->BuildSearchSql($sWhere, $this->grade, $Default, FALSE); // grade
		$this->BuildSearchSql($sWhere, $this->estate, $Default, FALSE); // estate
		$this->BuildSearchSql($sWhere, $this->sack, $Default, FALSE); // sack
		$this->BuildSearchSql($sWhere, $this->netto, $Default, FALSE); // netto
		$this->BuildSearchSql($sWhere, $this->open_bid, $Default, FALSE); // open_bid
		$this->BuildSearchSql($sWhere, $this->last_bid, $Default, FALSE); // last_bid
		$this->BuildSearchSql($sWhere, $this->highest_bid, $Default, FALSE); // highest_bid
		$this->BuildSearchSql($sWhere, $this->enter_bid, $Default, FALSE); // enter_bid
		$this->BuildSearchSql($sWhere, $this->auction_status, $Default, FALSE); // auction_status
		$this->BuildSearchSql($sWhere, $this->gross, $Default, FALSE); // gross
		$this->BuildSearchSql($sWhere, $this->row_id, $Default, FALSE); // row_id

		// Set up search parm
		if (!$Default && $sWhere <> "" && in_array($this->Command, array("", "reset", "resetall"))) {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->tanggal->AdvancedSearch->Save(); // tanggal
			$this->auc_number->AdvancedSearch->Save(); // auc_number
			$this->start_bid->AdvancedSearch->Save(); // start_bid
			$this->close_bid->AdvancedSearch->Save(); // close_bid
			$this->lot_number->AdvancedSearch->Save(); // lot_number
			$this->chop->AdvancedSearch->Save(); // chop
			$this->grade->AdvancedSearch->Save(); // grade
			$this->estate->AdvancedSearch->Save(); // estate
			$this->sack->AdvancedSearch->Save(); // sack
			$this->netto->AdvancedSearch->Save(); // netto
			$this->open_bid->AdvancedSearch->Save(); // open_bid
			$this->last_bid->AdvancedSearch->Save(); // last_bid
			$this->highest_bid->AdvancedSearch->Save(); // highest_bid
			$this->enter_bid->AdvancedSearch->Save(); // enter_bid
			$this->auction_status->AdvancedSearch->Save(); // auction_status
			$this->gross->AdvancedSearch->Save(); // gross
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
		if ($this->tanggal->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->auc_number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->start_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->close_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->lot_number->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->chop->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->grade->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estate->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->sack->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->netto->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->open_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->last_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->highest_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->enter_bid->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->auction_status->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->gross->AdvancedSearch->IssetSession())
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
		$this->tanggal->AdvancedSearch->UnsetSession();
		$this->auc_number->AdvancedSearch->UnsetSession();
		$this->start_bid->AdvancedSearch->UnsetSession();
		$this->close_bid->AdvancedSearch->UnsetSession();
		$this->lot_number->AdvancedSearch->UnsetSession();
		$this->chop->AdvancedSearch->UnsetSession();
		$this->grade->AdvancedSearch->UnsetSession();
		$this->estate->AdvancedSearch->UnsetSession();
		$this->sack->AdvancedSearch->UnsetSession();
		$this->netto->AdvancedSearch->UnsetSession();
		$this->open_bid->AdvancedSearch->UnsetSession();
		$this->last_bid->AdvancedSearch->UnsetSession();
		$this->highest_bid->AdvancedSearch->UnsetSession();
		$this->enter_bid->AdvancedSearch->UnsetSession();
		$this->auction_status->AdvancedSearch->UnsetSession();
		$this->gross->AdvancedSearch->UnsetSession();
		$this->row_id->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->tanggal->AdvancedSearch->Load();
		$this->auc_number->AdvancedSearch->Load();
		$this->start_bid->AdvancedSearch->Load();
		$this->close_bid->AdvancedSearch->Load();
		$this->lot_number->AdvancedSearch->Load();
		$this->chop->AdvancedSearch->Load();
		$this->grade->AdvancedSearch->Load();
		$this->estate->AdvancedSearch->Load();
		$this->sack->AdvancedSearch->Load();
		$this->netto->AdvancedSearch->Load();
		$this->open_bid->AdvancedSearch->Load();
		$this->last_bid->AdvancedSearch->Load();
		$this->highest_bid->AdvancedSearch->Load();
		$this->enter_bid->AdvancedSearch->Load();
		$this->auction_status->AdvancedSearch->Load();
		$this->gross->AdvancedSearch->Load();
		$this->row_id->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->tanggal); // tanggal
			$this->UpdateSort($this->auc_number); // auc_number
			$this->UpdateSort($this->start_bid); // start_bid
			$this->UpdateSort($this->close_bid); // close_bid
			$this->UpdateSort($this->lot_number); // lot_number
			$this->UpdateSort($this->chop); // chop
			$this->UpdateSort($this->grade); // grade
			$this->UpdateSort($this->estate); // estate
			$this->UpdateSort($this->sack); // sack
			$this->UpdateSort($this->netto); // netto
			$this->UpdateSort($this->open_bid); // open_bid
			$this->UpdateSort($this->highest_bid); // highest_bid
			$this->UpdateSort($this->auction_status); // auction_status
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
				$this->tanggal->setSort("DESC");
				$this->auc_number->setSort("DESC");
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
				$this->tanggal->setSort("");
				$this->auc_number->setSort("");
				$this->start_bid->setSort("");
				$this->close_bid->setSort("");
				$this->lot_number->setSort("");
				$this->chop->setSort("");
				$this->grade->setSort("");
				$this->estate->setSort("");
				$this->sack->setSort("");
				$this->netto->setSort("");
				$this->open_bid->setSort("");
				$this->highest_bid->setSort("");
				$this->auction_status->setSort("");
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

		// "detail_v_bid_histories_admin"
		$item = &$this->ListOptions->Add("detail_v_bid_histories_admin");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'v_bid_histories_admin') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["v_bid_histories_admin_grid"])) $GLOBALS["v_bid_histories_admin_grid"] = new cv_bid_histories_admin_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("v_bid_histories_admin");
		$this->DetailPages = $pages;

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
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_v_bid_histories_admin"
		$oListOpt = &$this->ListOptions->Items["detail_v_bid_histories_admin"];
		if ($Security->AllowList(CurrentProjectID() . 'v_bid_histories_admin')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("v_bid_histories_admin", "TblCaption");
			$body .= "&nbsp;" . str_replace("%c", $this->v_bid_histories_admin_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("v_bid_histories_adminlist.php?" . EW_TABLE_SHOW_MASTER . "=v_auction_list_admin&fk_row_id=" . urlencode(strval($this->row_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_auction_list_adminlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_auction_list_adminlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_auction_list_adminlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_auction_list_adminlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$links = "";
		$btngrps = "";
		$sSqlWrk = "`master_id`=" . ew_AdjustSql($this->row_id->CurrentValue, $this->DBID) . "";

		// Column "detail_v_bid_histories_admin"
		if ($this->DetailPages->Items["v_bid_histories_admin"]->Visible) {
			$link = "";
			$option = &$this->ListOptions->Items["detail_v_bid_histories_admin"];
			$url = "v_bid_histories_adminpreview.php?t=v_auction_list_admin&f=" . ew_Encrypt($sSqlWrk);
			$btngrp = "<div data-table=\"v_bid_histories_admin\" data-url=\"" . $url . "\" class=\"btn-group\">";
			if ($Security->AllowList(CurrentProjectID() . 'v_bid_histories_admin')) {
				$label = $Language->TablePhrase("v_bid_histories_admin", "TblCaption");
				$label .= "&nbsp;" . ew_JsEncode2(str_replace("%c", $this->v_bid_histories_admin_Count, $Language->Phrase("DetailCount")));
				$link = "<li><a href=\"#\" data-toggle=\"tab\" data-table=\"v_bid_histories_admin\" data-url=\"" . $url . "\">" . $label . "</a></li>";
				$links .= $link;
				$detaillnk = ew_JsEncode3("v_bid_histories_adminlist.php?" . EW_TABLE_SHOW_MASTER . "=v_auction_list_admin&fk_row_id=" . urlencode(strval($this->row_id->CurrentValue)) . "");
				$btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . $Language->TablePhrase("v_bid_histories_admin", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "'\">" . $Language->Phrase("MasterDetailListLink") . "</button>";
			}
			if ($GLOBALS["v_bid_histories_admin_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'v_bid_histories_admin')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=v_bid_histories_admin");
				$btngrp .= "<button type=\"button\" class=\"btn btn-default btn-sm\" title=\"" . ew_HtmlTitle($caption) . "\" onclick=\"window.location='" . ew_HtmlEncode($url) . "'\">" . $caption . "</button>";
			}
			$btngrp .= "</div>";
			if ($link <> "") {
				$btngrps .= $btngrp;
				$option->Body .= "<div class=\"hide ewPreview\">" . $link . $btngrp . "</div>";
			}
		}

		// Hide detail items if necessary
		$this->ListOptions->HideDetailItemsForDropDown();

		// Column "preview"
		$option = &$this->ListOptions->GetItem("preview");
		if (!$option) { // Add preview column
			$option = &$this->ListOptions->Add("preview");
			$option->OnLeft = TRUE;
			if ($option->OnLeft) {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox") + 1);
			} else {
				$option->MoveTo($this->ListOptions->ItemPos("checkbox"));
			}
			$option->Visible = !($this->Export <> "" || $this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit");
			$option->ShowInDropDown = FALSE;
			$option->ShowInButtonGroup = FALSE;
		}
		if ($option) {
			$option->Body = "<span class=\"ewPreviewRowBtn ewIcon icon-expand\"></span>";
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}

		// Column "details" (Multiple details)
		$option = &$this->ListOptions->GetItem("details");
		if ($option) {
			$option->Body .= "<div class=\"hide ewPreview\">" . $links . $btngrps . "</div>";
			if ($option->Visible) $option->Visible = $links <> "";
		}
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
		// tanggal

		$this->tanggal->AdvancedSearch->SearchValue = @$_GET["x_tanggal"];
		if ($this->tanggal->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->tanggal->AdvancedSearch->SearchOperator = @$_GET["z_tanggal"];

		// auc_number
		$this->auc_number->AdvancedSearch->SearchValue = @$_GET["x_auc_number"];
		if ($this->auc_number->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->auc_number->AdvancedSearch->SearchOperator = @$_GET["z_auc_number"];

		// start_bid
		$this->start_bid->AdvancedSearch->SearchValue = @$_GET["x_start_bid"];
		if ($this->start_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->start_bid->AdvancedSearch->SearchOperator = @$_GET["z_start_bid"];

		// close_bid
		$this->close_bid->AdvancedSearch->SearchValue = @$_GET["x_close_bid"];
		if ($this->close_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->close_bid->AdvancedSearch->SearchOperator = @$_GET["z_close_bid"];

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

		// sack
		$this->sack->AdvancedSearch->SearchValue = @$_GET["x_sack"];
		if ($this->sack->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->sack->AdvancedSearch->SearchOperator = @$_GET["z_sack"];

		// netto
		$this->netto->AdvancedSearch->SearchValue = @$_GET["x_netto"];
		if ($this->netto->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->netto->AdvancedSearch->SearchOperator = @$_GET["z_netto"];

		// open_bid
		$this->open_bid->AdvancedSearch->SearchValue = @$_GET["x_open_bid"];
		if ($this->open_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->open_bid->AdvancedSearch->SearchOperator = @$_GET["z_open_bid"];

		// last_bid
		$this->last_bid->AdvancedSearch->SearchValue = @$_GET["x_last_bid"];
		if ($this->last_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->last_bid->AdvancedSearch->SearchOperator = @$_GET["z_last_bid"];

		// highest_bid
		$this->highest_bid->AdvancedSearch->SearchValue = @$_GET["x_highest_bid"];
		if ($this->highest_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->highest_bid->AdvancedSearch->SearchOperator = @$_GET["z_highest_bid"];

		// enter_bid
		$this->enter_bid->AdvancedSearch->SearchValue = @$_GET["x_enter_bid"];
		if ($this->enter_bid->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->enter_bid->AdvancedSearch->SearchOperator = @$_GET["z_enter_bid"];

		// auction_status
		$this->auction_status->AdvancedSearch->SearchValue = @$_GET["x_auction_status"];
		if ($this->auction_status->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->auction_status->AdvancedSearch->SearchOperator = @$_GET["z_auction_status"];

		// gross
		$this->gross->AdvancedSearch->SearchValue = @$_GET["x_gross"];
		if ($this->gross->AdvancedSearch->SearchValue <> "" && $this->Command == "") $this->Command = "search";
		$this->gross->AdvancedSearch->SearchOperator = @$_GET["z_gross"];

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
		$this->tanggal->setDbValue($row['tanggal']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->start_bid->setDbValue($row['start_bid']);
		$this->close_bid->setDbValue($row['close_bid']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->grade->setDbValue($row['grade']);
		$this->estate->setDbValue($row['estate']);
		$this->sack->setDbValue($row['sack']);
		$this->netto->setDbValue($row['netto']);
		$this->open_bid->setDbValue($row['open_bid']);
		$this->last_bid->setDbValue($row['last_bid']);
		$this->highest_bid->setDbValue($row['highest_bid']);
		$this->enter_bid->setDbValue($row['enter_bid']);
		$this->auction_status->setDbValue($row['auction_status']);
		$this->gross->setDbValue($row['gross']);
		$this->row_id->setDbValue($row['row_id']);
		if (!isset($GLOBALS["v_bid_histories_admin_grid"])) $GLOBALS["v_bid_histories_admin_grid"] = new cv_bid_histories_admin_grid;
		$sDetailFilter = $GLOBALS["v_bid_histories_admin"]->SqlDetailFilter_v_auction_list_admin();
		$sDetailFilter = str_replace("@master_id@", ew_AdjustSql($this->row_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["v_bid_histories_admin"]->setCurrentMasterTable("v_auction_list_admin");
		$sDetailFilter = $GLOBALS["v_bid_histories_admin"]->ApplyUserIDFilters($sDetailFilter);
		$this->v_bid_histories_admin_Count = $GLOBALS["v_bid_histories_admin"]->LoadRecordCount($sDetailFilter);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['tanggal'] = NULL;
		$row['auc_number'] = NULL;
		$row['start_bid'] = NULL;
		$row['close_bid'] = NULL;
		$row['lot_number'] = NULL;
		$row['chop'] = NULL;
		$row['grade'] = NULL;
		$row['estate'] = NULL;
		$row['sack'] = NULL;
		$row['netto'] = NULL;
		$row['open_bid'] = NULL;
		$row['last_bid'] = NULL;
		$row['highest_bid'] = NULL;
		$row['enter_bid'] = NULL;
		$row['auction_status'] = NULL;
		$row['gross'] = NULL;
		$row['row_id'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->tanggal->DbValue = $row['tanggal'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->start_bid->DbValue = $row['start_bid'];
		$this->close_bid->DbValue = $row['close_bid'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->grade->DbValue = $row['grade'];
		$this->estate->DbValue = $row['estate'];
		$this->sack->DbValue = $row['sack'];
		$this->netto->DbValue = $row['netto'];
		$this->open_bid->DbValue = $row['open_bid'];
		$this->last_bid->DbValue = $row['last_bid'];
		$this->highest_bid->DbValue = $row['highest_bid'];
		$this->enter_bid->DbValue = $row['enter_bid'];
		$this->auction_status->DbValue = $row['auction_status'];
		$this->gross->DbValue = $row['gross'];
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

		// Convert decimal values if posted back
		if ($this->netto->FormValue == $this->netto->CurrentValue && is_numeric(ew_StrToFloat($this->netto->CurrentValue)))
			$this->netto->CurrentValue = ew_StrToFloat($this->netto->CurrentValue);

		// Convert decimal values if posted back
		if ($this->open_bid->FormValue == $this->open_bid->CurrentValue && is_numeric(ew_StrToFloat($this->open_bid->CurrentValue)))
			$this->open_bid->CurrentValue = ew_StrToFloat($this->open_bid->CurrentValue);

		// Convert decimal values if posted back
		if ($this->highest_bid->FormValue == $this->highest_bid->CurrentValue && is_numeric(ew_StrToFloat($this->highest_bid->CurrentValue)))
			$this->highest_bid->CurrentValue = ew_StrToFloat($this->highest_bid->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// tanggal
		// auc_number
		// start_bid
		// close_bid
		// lot_number
		// chop
		// grade
		// estate
		// sack
		// netto
		// open_bid
		// last_bid
		// highest_bid
		// enter_bid
		// auction_status
		// gross
		// row_id

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// tanggal
		$this->tanggal->ViewValue = $this->tanggal->CurrentValue;
		$this->tanggal->ViewValue = ew_FormatDateTime($this->tanggal->ViewValue, 7);
		$this->tanggal->CellCssStyle .= "text-align: center;";
		$this->tanggal->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

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

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->CellCssStyle .= "text-align: center;";
		$this->lot_number->ViewCustomAttributes = "";

		// chop
		$this->chop->ViewValue = $this->chop->CurrentValue;
		$this->chop->ViewCustomAttributes = "";

		// grade
		$this->grade->ViewValue = $this->grade->CurrentValue;
		$this->grade->ViewCustomAttributes = "";

		// estate
		$this->estate->ViewValue = $this->estate->CurrentValue;
		$this->estate->ViewCustomAttributes = "";

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

		// open_bid
		$this->open_bid->ViewValue = $this->open_bid->CurrentValue;
		$this->open_bid->ViewValue = ew_FormatNumber($this->open_bid->ViewValue, 2, -2, -2, -2);
		$this->open_bid->CellCssStyle .= "text-align: right;";
		$this->open_bid->ViewCustomAttributes = "";

		// last_bid
		$this->last_bid->ViewValue = $this->last_bid->CurrentValue;
		$this->last_bid->ViewValue = ew_FormatNumber($this->last_bid->ViewValue, 2, -2, -2, -2);
		$this->last_bid->CellCssStyle .= "text-align: right;";
		$this->last_bid->ViewCustomAttributes = "";

		// highest_bid
		$this->highest_bid->ViewValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->ViewValue = ew_FormatNumber($this->highest_bid->ViewValue, 2, -2, -2, -2);
		$this->highest_bid->CellCssStyle .= "text-align: right;";
		$this->highest_bid->ViewCustomAttributes = "";

		// enter_bid
		$this->enter_bid->ViewValue = $this->enter_bid->CurrentValue;
		$this->enter_bid->ViewValue = ew_FormatNumber($this->enter_bid->ViewValue, 0, -2, -2, -2);
		$this->enter_bid->CellCssStyle .= "text-align: right;";
		$this->enter_bid->ViewCustomAttributes = "";

		// auction_status
		if (strval($this->auction_status->CurrentValue) <> "") {
			$this->auction_status->ViewValue = $this->auction_status->OptionCaption($this->auction_status->CurrentValue);
		} else {
			$this->auction_status->ViewValue = NULL;
		}
		$this->auction_status->CellCssStyle .= "text-align: center;";
		$this->auction_status->ViewCustomAttributes = "";

		// gross
		$this->gross->ViewValue = $this->gross->CurrentValue;
		$this->gross->ViewCustomAttributes = "";

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

			// tanggal
			$this->tanggal->LinkCustomAttributes = "";
			$this->tanggal->HrefValue = "";
			$this->tanggal->TooltipValue = "";

			// auc_number
			$this->auc_number->LinkCustomAttributes = "";
			$this->auc_number->HrefValue = "";
			$this->auc_number->TooltipValue = "";

			// start_bid
			$this->start_bid->LinkCustomAttributes = "";
			$this->start_bid->HrefValue = "";
			$this->start_bid->TooltipValue = "";

			// close_bid
			$this->close_bid->LinkCustomAttributes = "";
			$this->close_bid->HrefValue = "";
			$this->close_bid->TooltipValue = "";

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

			// sack
			$this->sack->LinkCustomAttributes = "";
			$this->sack->HrefValue = "";
			$this->sack->TooltipValue = "";

			// netto
			$this->netto->LinkCustomAttributes = "";
			$this->netto->HrefValue = "";
			$this->netto->TooltipValue = "";

			// open_bid
			$this->open_bid->LinkCustomAttributes = "";
			$this->open_bid->HrefValue = "";
			$this->open_bid->TooltipValue = "";

			// highest_bid
			$this->highest_bid->LinkCustomAttributes = "";
			$this->highest_bid->HrefValue = "";
			$this->highest_bid->TooltipValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";
			$this->auction_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// tanggal
			$this->tanggal->EditAttrs["class"] = "form-control";
			$this->tanggal->EditCustomAttributes = "";
			$this->tanggal->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->tanggal->AdvancedSearch->SearchValue, 7), 7));
			$this->tanggal->PlaceHolder = ew_RemoveHtml($this->tanggal->FldCaption());

			// auc_number
			$this->auc_number->EditAttrs["class"] = "form-control";
			$this->auc_number->EditCustomAttributes = "";
			$this->auc_number->EditValue = ew_HtmlEncode($this->auc_number->AdvancedSearch->SearchValue);
			$this->auc_number->PlaceHolder = ew_RemoveHtml($this->auc_number->FldCaption());

			// start_bid
			$this->start_bid->EditAttrs["class"] = "form-control";
			$this->start_bid->EditCustomAttributes = "";
			$this->start_bid->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->start_bid->AdvancedSearch->SearchValue, 11), 11));
			$this->start_bid->PlaceHolder = ew_RemoveHtml($this->start_bid->FldCaption());

			// close_bid
			$this->close_bid->EditAttrs["class"] = "form-control";
			$this->close_bid->EditCustomAttributes = "";
			$this->close_bid->EditValue = ew_HtmlEncode(ew_FormatDateTime(ew_UnFormatDateTime($this->close_bid->AdvancedSearch->SearchValue, 11), 11));
			$this->close_bid->PlaceHolder = ew_RemoveHtml($this->close_bid->FldCaption());

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

			// sack
			$this->sack->EditAttrs["class"] = "form-control";
			$this->sack->EditCustomAttributes = "";
			$this->sack->EditValue = ew_HtmlEncode($this->sack->AdvancedSearch->SearchValue);
			$this->sack->PlaceHolder = ew_RemoveHtml($this->sack->FldCaption());

			// netto
			$this->netto->EditAttrs["class"] = "form-control";
			$this->netto->EditCustomAttributes = "";
			$this->netto->EditValue = ew_HtmlEncode($this->netto->AdvancedSearch->SearchValue);
			$this->netto->PlaceHolder = ew_RemoveHtml($this->netto->FldCaption());

			// open_bid
			$this->open_bid->EditAttrs["class"] = "form-control";
			$this->open_bid->EditCustomAttributes = "";
			$this->open_bid->EditValue = ew_HtmlEncode($this->open_bid->AdvancedSearch->SearchValue);
			$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());

			// highest_bid
			$this->highest_bid->EditAttrs["class"] = "form-control";
			$this->highest_bid->EditCustomAttributes = "";
			$this->highest_bid->EditValue = ew_HtmlEncode($this->highest_bid->AdvancedSearch->SearchValue);
			$this->highest_bid->PlaceHolder = ew_RemoveHtml($this->highest_bid->FldCaption());

			// auction_status
			$this->auction_status->EditCustomAttributes = "";
			$this->auction_status->EditValue = $this->auction_status->Options(FALSE);
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
		if (!ew_CheckEuroDate($this->tanggal->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->tanggal->FldErrMsg());
		}

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
		$this->tanggal->AdvancedSearch->Load();
		$this->auc_number->AdvancedSearch->Load();
		$this->start_bid->AdvancedSearch->Load();
		$this->close_bid->AdvancedSearch->Load();
		$this->lot_number->AdvancedSearch->Load();
		$this->chop->AdvancedSearch->Load();
		$this->grade->AdvancedSearch->Load();
		$this->estate->AdvancedSearch->Load();
		$this->sack->AdvancedSearch->Load();
		$this->netto->AdvancedSearch->Load();
		$this->open_bid->AdvancedSearch->Load();
		$this->last_bid->AdvancedSearch->Load();
		$this->highest_bid->AdvancedSearch->Load();
		$this->enter_bid->AdvancedSearch->Load();
		$this->auction_status->AdvancedSearch->Load();
		$this->gross->AdvancedSearch->Load();
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
		//$this->ListOptions->Add("tr_bid"); // Replace abclink with your name of the link
		//$this->ListOptions->Items["tr_bid"]->Header = "<b>Bid Transation</b>"; 

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
		//$this->ListOptions->Items["tr_bid"]->Body = "<a href='v_bid_histories_adminlist.php?master_id=".CurrentTable()->row_id->CurrentValue."'>Bid Transaction</a>";

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
if (!isset($v_auction_list_admin_list)) $v_auction_list_admin_list = new cv_auction_list_admin_list();

// Page init
$v_auction_list_admin_list->Page_Init();

// Page main
$v_auction_list_admin_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_auction_list_admin_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_auction_list_adminlist = new ew_Form("fv_auction_list_adminlist", "list");
fv_auction_list_adminlist.FormKeyCountName = '<?php echo $v_auction_list_admin_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_auction_list_adminlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_auction_list_adminlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_auction_list_adminlist.Lists["x_auction_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_auction_list_adminlist.Lists["x_auction_status"].Options = <?php echo json_encode($v_auction_list_admin_list->auction_status->Options()) ?>;

// Form object for search
var CurrentSearchForm = fv_auction_list_adminlistsrch = new ew_Form("fv_auction_list_adminlistsrch");

// Validate function for search
fv_auction_list_adminlistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_tanggal");
	if (elm && !ew_CheckEuroDate(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($v_auction_list_admin->tanggal->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
fv_auction_list_adminlistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_auction_list_adminlistsrch.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Init search panel as collapsed

if (fv_auction_list_adminlistsrch) fv_auction_list_adminlistsrch.InitSearchPanel = true;
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
<?php if ($v_auction_list_admin_list->TotalRecs > 0 && $v_auction_list_admin_list->ExportOptions->Visible()) { ?>
<?php $v_auction_list_admin_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v_auction_list_admin_list->SearchOptions->Visible()) { ?>
<?php $v_auction_list_admin_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v_auction_list_admin_list->FilterOptions->Visible()) { ?>
<?php $v_auction_list_admin_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v_auction_list_admin_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_auction_list_admin_list->TotalRecs <= 0)
			$v_auction_list_admin_list->TotalRecs = $v_auction_list_admin->ListRecordCount();
	} else {
		if (!$v_auction_list_admin_list->Recordset && ($v_auction_list_admin_list->Recordset = $v_auction_list_admin_list->LoadRecordset()))
			$v_auction_list_admin_list->TotalRecs = $v_auction_list_admin_list->Recordset->RecordCount();
	}
	$v_auction_list_admin_list->StartRec = 1;
	if ($v_auction_list_admin_list->DisplayRecs <= 0 || ($v_auction_list_admin->Export <> "" && $v_auction_list_admin->ExportAll)) // Display all records
		$v_auction_list_admin_list->DisplayRecs = $v_auction_list_admin_list->TotalRecs;
	if (!($v_auction_list_admin->Export <> "" && $v_auction_list_admin->ExportAll))
		$v_auction_list_admin_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_auction_list_admin_list->Recordset = $v_auction_list_admin_list->LoadRecordset($v_auction_list_admin_list->StartRec-1, $v_auction_list_admin_list->DisplayRecs);

	// Set no record found message
	if ($v_auction_list_admin->CurrentAction == "" && $v_auction_list_admin_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_auction_list_admin_list->setWarningMessage(ew_DeniedMsg());
		if ($v_auction_list_admin_list->SearchWhere == "0=101")
			$v_auction_list_admin_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_auction_list_admin_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_auction_list_admin_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($v_auction_list_admin->Export == "" && $v_auction_list_admin->CurrentAction == "") { ?>
<form name="fv_auction_list_adminlistsrch" id="fv_auction_list_adminlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v_auction_list_admin_list->SearchWhere <> "") ? " in" : ""; ?>
<div id="fv_auction_list_adminlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_auction_list_admin">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$v_auction_list_admin_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$v_auction_list_admin->RowType = EW_ROWTYPE_SEARCH;

// Render row
$v_auction_list_admin->ResetAttrs();
$v_auction_list_admin_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($v_auction_list_admin->tanggal->Visible) { // tanggal ?>
	<div id="xsc_tanggal" class="ewCell form-group">
		<label for="x_tanggal" class="ewSearchCaption ewLabel"><?php echo $v_auction_list_admin->tanggal->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_tanggal" id="z_tanggal" value="="></span>
		<span class="ewSearchField">
<input type="text" data-table="v_auction_list_admin" data-field="x_tanggal" data-format="7" name="x_tanggal" id="x_tanggal" placeholder="<?php echo ew_HtmlEncode($v_auction_list_admin->tanggal->getPlaceHolder()) ?>" value="<?php echo $v_auction_list_admin->tanggal->EditValue ?>"<?php echo $v_auction_list_admin->tanggal->EditAttributes() ?>>
<?php if (!$v_auction_list_admin->tanggal->ReadOnly && !$v_auction_list_admin->tanggal->Disabled && !isset($v_auction_list_admin->tanggal->EditAttrs["readonly"]) && !isset($v_auction_list_admin->tanggal->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateDateTimePicker("fv_auction_list_adminlistsrch", "x_tanggal", {"ignoreReadonly":true,"useCurrent":false,"format":7});
</script>
<?php } ?>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v_auction_list_admin_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v_auction_list_admin_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v_auction_list_admin_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v_auction_list_admin_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v_auction_list_admin_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v_auction_list_admin_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v_auction_list_admin_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $v_auction_list_admin_list->ShowPageHeader(); ?>
<?php
$v_auction_list_admin_list->ShowMessage();
?>
<?php if ($v_auction_list_admin_list->TotalRecs > 0 || $v_auction_list_admin->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_auction_list_admin_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_auction_list_admin">
<div class="box-header ewGridUpperPanel">
<?php if ($v_auction_list_admin->CurrentAction <> "gridadd" && $v_auction_list_admin->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_auction_list_admin_list->Pager)) $v_auction_list_admin_list->Pager = new cPrevNextPager($v_auction_list_admin_list->StartRec, $v_auction_list_admin_list->DisplayRecs, $v_auction_list_admin_list->TotalRecs, $v_auction_list_admin_list->AutoHidePager) ?>
<?php if ($v_auction_list_admin_list->Pager->RecordCount > 0 && $v_auction_list_admin_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_auction_list_admin_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_auction_list_admin_list->PageUrl() ?>start=<?php echo $v_auction_list_admin_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_auction_list_admin_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_auction_list_admin_list->PageUrl() ?>start=<?php echo $v_auction_list_admin_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_auction_list_admin_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_auction_list_admin_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_auction_list_admin_list->PageUrl() ?>start=<?php echo $v_auction_list_admin_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_auction_list_admin_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_auction_list_admin_list->PageUrl() ?>start=<?php echo $v_auction_list_admin_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_auction_list_admin_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_auction_list_admin_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_auction_list_admin_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_auction_list_admin_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_auction_list_admin_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($v_auction_list_admin_list->TotalRecs > 0 && (!$v_auction_list_admin_list->AutoHidePageSizeSelector || $v_auction_list_admin_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="v_auction_list_admin">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($v_auction_list_admin_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($v_auction_list_admin_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($v_auction_list_admin_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($v_auction_list_admin_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($v_auction_list_admin->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_auction_list_admin_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fv_auction_list_adminlist" id="fv_auction_list_adminlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_auction_list_admin_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_auction_list_admin_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_auction_list_admin">
<div id="gmp_v_auction_list_admin" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_auction_list_admin_list->TotalRecs > 0 || $v_auction_list_admin->CurrentAction == "gridedit") { ?>
<table id="tbl_v_auction_list_adminlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_auction_list_admin_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_auction_list_admin_list->RenderListOptions();

// Render list options (header, left)
$v_auction_list_admin_list->ListOptions->Render("header", "left");
?>
<?php if ($v_auction_list_admin->tanggal->Visible) { // tanggal ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->tanggal) == "") { ?>
		<th data-name="tanggal" class="<?php echo $v_auction_list_admin->tanggal->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_tanggal" class="v_auction_list_admin_tanggal"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->tanggal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tanggal" class="<?php echo $v_auction_list_admin->tanggal->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->tanggal) ?>',1);"><div id="elh_v_auction_list_admin_tanggal" class="v_auction_list_admin_tanggal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->tanggal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->tanggal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->tanggal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->auc_number->Visible) { // auc_number ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->auc_number) == "") { ?>
		<th data-name="auc_number" class="<?php echo $v_auction_list_admin->auc_number->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_auc_number" class="v_auction_list_admin_auc_number"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->auc_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_number" class="<?php echo $v_auction_list_admin->auc_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->auc_number) ?>',1);"><div id="elh_v_auction_list_admin_auc_number" class="v_auction_list_admin_auc_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->auc_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->auc_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->auc_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->start_bid->Visible) { // start_bid ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->start_bid) == "") { ?>
		<th data-name="start_bid" class="<?php echo $v_auction_list_admin->start_bid->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_start_bid" class="v_auction_list_admin_start_bid"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->start_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="start_bid" class="<?php echo $v_auction_list_admin->start_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->start_bid) ?>',1);"><div id="elh_v_auction_list_admin_start_bid" class="v_auction_list_admin_start_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->start_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->start_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->start_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->close_bid->Visible) { // close_bid ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->close_bid) == "") { ?>
		<th data-name="close_bid" class="<?php echo $v_auction_list_admin->close_bid->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_close_bid" class="v_auction_list_admin_close_bid"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->close_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="close_bid" class="<?php echo $v_auction_list_admin->close_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->close_bid) ?>',1);"><div id="elh_v_auction_list_admin_close_bid" class="v_auction_list_admin_close_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->close_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->close_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->close_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->lot_number->Visible) { // lot_number ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_auction_list_admin->lot_number->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_lot_number" class="v_auction_list_admin_lot_number"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_auction_list_admin->lot_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->lot_number) ?>',1);"><div id="elh_v_auction_list_admin_lot_number" class="v_auction_list_admin_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->chop->Visible) { // chop ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_auction_list_admin->chop->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_chop" class="v_auction_list_admin_chop"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_auction_list_admin->chop->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->chop) ?>',1);"><div id="elh_v_auction_list_admin_chop" class="v_auction_list_admin_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->chop->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->grade->Visible) { // grade ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_auction_list_admin->grade->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_grade" class="v_auction_list_admin_grade"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_auction_list_admin->grade->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->grade) ?>',1);"><div id="elh_v_auction_list_admin_grade" class="v_auction_list_admin_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->grade->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->estate->Visible) { // estate ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $v_auction_list_admin->estate->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_estate" class="v_auction_list_admin_estate"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $v_auction_list_admin->estate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->estate) ?>',1);"><div id="elh_v_auction_list_admin_estate" class="v_auction_list_admin_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->estate->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->sack->Visible) { // sack ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $v_auction_list_admin->sack->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_sack" class="v_auction_list_admin_sack"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $v_auction_list_admin->sack->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->sack) ?>',1);"><div id="elh_v_auction_list_admin_sack" class="v_auction_list_admin_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->netto->Visible) { // netto ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->netto) == "") { ?>
		<th data-name="netto" class="<?php echo $v_auction_list_admin->netto->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_netto" class="v_auction_list_admin_netto"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->netto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="netto" class="<?php echo $v_auction_list_admin->netto->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->netto) ?>',1);"><div id="elh_v_auction_list_admin_netto" class="v_auction_list_admin_netto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->netto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->netto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->netto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->open_bid->Visible) { // open_bid ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->open_bid) == "") { ?>
		<th data-name="open_bid" class="<?php echo $v_auction_list_admin->open_bid->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_open_bid" class="v_auction_list_admin_open_bid"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->open_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="open_bid" class="<?php echo $v_auction_list_admin->open_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->open_bid) ?>',1);"><div id="elh_v_auction_list_admin_open_bid" class="v_auction_list_admin_open_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->open_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->open_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->open_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->highest_bid->Visible) { // highest_bid ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->highest_bid) == "") { ?>
		<th data-name="highest_bid" class="<?php echo $v_auction_list_admin->highest_bid->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_highest_bid" class="v_auction_list_admin_highest_bid"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->highest_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="highest_bid" class="<?php echo $v_auction_list_admin->highest_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->highest_bid) ?>',1);"><div id="elh_v_auction_list_admin_highest_bid" class="v_auction_list_admin_highest_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->highest_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->highest_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->highest_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_list_admin->auction_status->Visible) { // auction_status ?>
	<?php if ($v_auction_list_admin->SortUrl($v_auction_list_admin->auction_status) == "") { ?>
		<th data-name="auction_status" class="<?php echo $v_auction_list_admin->auction_status->HeaderCellClass() ?>"><div id="elh_v_auction_list_admin_auction_status" class="v_auction_list_admin_auction_status"><div class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->auction_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auction_status" class="<?php echo $v_auction_list_admin->auction_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_list_admin->SortUrl($v_auction_list_admin->auction_status) ?>',1);"><div id="elh_v_auction_list_admin_auction_status" class="v_auction_list_admin_auction_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_list_admin->auction_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_list_admin->auction_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_list_admin->auction_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_auction_list_admin_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_auction_list_admin->ExportAll && $v_auction_list_admin->Export <> "") {
	$v_auction_list_admin_list->StopRec = $v_auction_list_admin_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_auction_list_admin_list->TotalRecs > $v_auction_list_admin_list->StartRec + $v_auction_list_admin_list->DisplayRecs - 1)
		$v_auction_list_admin_list->StopRec = $v_auction_list_admin_list->StartRec + $v_auction_list_admin_list->DisplayRecs - 1;
	else
		$v_auction_list_admin_list->StopRec = $v_auction_list_admin_list->TotalRecs;
}
$v_auction_list_admin_list->RecCnt = $v_auction_list_admin_list->StartRec - 1;
if ($v_auction_list_admin_list->Recordset && !$v_auction_list_admin_list->Recordset->EOF) {
	$v_auction_list_admin_list->Recordset->MoveFirst();
	$bSelectLimit = $v_auction_list_admin_list->UseSelectLimit;
	if (!$bSelectLimit && $v_auction_list_admin_list->StartRec > 1)
		$v_auction_list_admin_list->Recordset->Move($v_auction_list_admin_list->StartRec - 1);
} elseif (!$v_auction_list_admin->AllowAddDeleteRow && $v_auction_list_admin_list->StopRec == 0) {
	$v_auction_list_admin_list->StopRec = $v_auction_list_admin->GridAddRowCount;
}

// Initialize aggregate
$v_auction_list_admin->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_auction_list_admin->ResetAttrs();
$v_auction_list_admin_list->RenderRow();
while ($v_auction_list_admin_list->RecCnt < $v_auction_list_admin_list->StopRec) {
	$v_auction_list_admin_list->RecCnt++;
	if (intval($v_auction_list_admin_list->RecCnt) >= intval($v_auction_list_admin_list->StartRec)) {
		$v_auction_list_admin_list->RowCnt++;

		// Set up key count
		$v_auction_list_admin_list->KeyCount = $v_auction_list_admin_list->RowIndex;

		// Init row class and style
		$v_auction_list_admin->ResetAttrs();
		$v_auction_list_admin->CssClass = "";
		if ($v_auction_list_admin->CurrentAction == "gridadd") {
		} else {
			$v_auction_list_admin_list->LoadRowValues($v_auction_list_admin_list->Recordset); // Load row values
		}
		$v_auction_list_admin->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_auction_list_admin->RowAttrs = array_merge($v_auction_list_admin->RowAttrs, array('data-rowindex'=>$v_auction_list_admin_list->RowCnt, 'id'=>'r' . $v_auction_list_admin_list->RowCnt . '_v_auction_list_admin', 'data-rowtype'=>$v_auction_list_admin->RowType));

		// Render row
		$v_auction_list_admin_list->RenderRow();

		// Render list options
		$v_auction_list_admin_list->RenderListOptions();
?>
	<tr<?php echo $v_auction_list_admin->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_auction_list_admin_list->ListOptions->Render("body", "left", $v_auction_list_admin_list->RowCnt);
?>
	<?php if ($v_auction_list_admin->tanggal->Visible) { // tanggal ?>
		<td data-name="tanggal"<?php echo $v_auction_list_admin->tanggal->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_tanggal" class="v_auction_list_admin_tanggal">
<span<?php echo $v_auction_list_admin->tanggal->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->tanggal->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->auc_number->Visible) { // auc_number ?>
		<td data-name="auc_number"<?php echo $v_auction_list_admin->auc_number->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_auc_number" class="v_auction_list_admin_auc_number">
<span<?php echo $v_auction_list_admin->auc_number->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->auc_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->start_bid->Visible) { // start_bid ?>
		<td data-name="start_bid"<?php echo $v_auction_list_admin->start_bid->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_start_bid" class="v_auction_list_admin_start_bid">
<span<?php echo $v_auction_list_admin->start_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->start_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->close_bid->Visible) { // close_bid ?>
		<td data-name="close_bid"<?php echo $v_auction_list_admin->close_bid->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_close_bid" class="v_auction_list_admin_close_bid">
<span<?php echo $v_auction_list_admin->close_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->close_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_auction_list_admin->lot_number->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_lot_number" class="v_auction_list_admin_lot_number">
<span<?php echo $v_auction_list_admin->lot_number->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->lot_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_auction_list_admin->chop->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_chop" class="v_auction_list_admin_chop">
<span<?php echo $v_auction_list_admin->chop->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->chop->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_auction_list_admin->grade->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_grade" class="v_auction_list_admin_grade">
<span<?php echo $v_auction_list_admin->grade->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->grade->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $v_auction_list_admin->estate->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_estate" class="v_auction_list_admin_estate">
<span<?php echo $v_auction_list_admin->estate->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->estate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $v_auction_list_admin->sack->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_sack" class="v_auction_list_admin_sack">
<span<?php echo $v_auction_list_admin->sack->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->sack->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->netto->Visible) { // netto ?>
		<td data-name="netto"<?php echo $v_auction_list_admin->netto->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_netto" class="v_auction_list_admin_netto">
<span<?php echo $v_auction_list_admin->netto->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->netto->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid"<?php echo $v_auction_list_admin->open_bid->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_open_bid" class="v_auction_list_admin_open_bid">
<span<?php echo $v_auction_list_admin->open_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->open_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->highest_bid->Visible) { // highest_bid ?>
		<td data-name="highest_bid"<?php echo $v_auction_list_admin->highest_bid->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_highest_bid" class="v_auction_list_admin_highest_bid">
<span<?php echo $v_auction_list_admin->highest_bid->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->highest_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_list_admin->auction_status->Visible) { // auction_status ?>
		<td data-name="auction_status"<?php echo $v_auction_list_admin->auction_status->CellAttributes() ?>>
<span id="el<?php echo $v_auction_list_admin_list->RowCnt ?>_v_auction_list_admin_auction_status" class="v_auction_list_admin_auction_status">
<span<?php echo $v_auction_list_admin->auction_status->ViewAttributes() ?>>
<?php echo $v_auction_list_admin->auction_status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_auction_list_admin_list->ListOptions->Render("body", "right", $v_auction_list_admin_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_auction_list_admin->CurrentAction <> "gridadd")
		$v_auction_list_admin_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_auction_list_admin->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_auction_list_admin_list->Recordset)
	$v_auction_list_admin_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($v_auction_list_admin_list->TotalRecs == 0 && $v_auction_list_admin->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_auction_list_admin_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_auction_list_adminlistsrch.FilterList = <?php echo $v_auction_list_admin_list->GetFilterList() ?>;
fv_auction_list_adminlistsrch.Init();
fv_auction_list_adminlist.Init();
</script>
<?php
$v_auction_list_admin_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_auction_list_admin_list->Page_Terminate();
?>
