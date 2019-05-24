<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_tr_lelang_masterinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "v_tr_lelang_itemgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_tr_lelang_master_list = NULL; // Initialize page object first

class cv_tr_lelang_master_list extends cv_tr_lelang_master {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_tr_lelang_master';

	// Page object name
	var $PageObjName = 'v_tr_lelang_master_list';

	// Grid form hidden field names
	var $FormName = 'fv_tr_lelang_masterlist';
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

		// Table object (v_tr_lelang_master)
		if (!isset($GLOBALS["v_tr_lelang_master"]) || get_class($GLOBALS["v_tr_lelang_master"]) == "cv_tr_lelang_master") {
			$GLOBALS["v_tr_lelang_master"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_tr_lelang_master"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_tr_lelang_masteradd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_tr_lelang_masterdelete.php";
		$this->MultiUpdateUrl = "v_tr_lelang_masterupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_tr_lelang_master', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_tr_lelang_masterlistsrch";

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
		$this->row_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->row_id->Visible = FALSE;
		$this->auc_date->SetVisibility();
		$this->session_number->SetVisibility();
		$this->t_start_bid->SetVisibility();
		$this->t_close_bid->SetVisibility();
		$this->auc_number->SetVisibility();
		$this->start_bid->SetVisibility();
		$this->close_bid->SetVisibility();
		$this->auc_place->SetVisibility();
		$this->auc_notes->SetVisibility();
		$this->total_sack->SetVisibility();
		$this->total_gross->SetVisibility();
		$this->btn_cetak_catalog->SetVisibility();
		$this->auc_status->SetVisibility();
		$this->rate->SetVisibility();

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
				if (in_array("v_tr_lelang_item", $DetailTblVar)) {

					// Process auto fill for detail table 'v_tr_lelang_item'
					if (preg_match('/^fv_tr_lelang_item(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["v_tr_lelang_item_grid"])) $GLOBALS["v_tr_lelang_item_grid"] = new cv_tr_lelang_item_grid;
						$GLOBALS["v_tr_lelang_item_grid"]->Page_Init();
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
		global $EW_EXPORT, $v_tr_lelang_master;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_tr_lelang_master);
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
	var $v_tr_lelang_item_Count;
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fv_tr_lelang_masterlistsrch");
		$sFilterList = ew_Concat($sFilterList, $this->row_id->AdvancedSearch->ToJson(), ","); // Field row_id
		$sFilterList = ew_Concat($sFilterList, $this->auc_date->AdvancedSearch->ToJson(), ","); // Field auc_date
		$sFilterList = ew_Concat($sFilterList, $this->session_number->AdvancedSearch->ToJson(), ","); // Field session_number
		$sFilterList = ew_Concat($sFilterList, $this->t_start_bid->AdvancedSearch->ToJson(), ","); // Field t_start_bid
		$sFilterList = ew_Concat($sFilterList, $this->t_close_bid->AdvancedSearch->ToJson(), ","); // Field t_close_bid
		$sFilterList = ew_Concat($sFilterList, $this->auc_number->AdvancedSearch->ToJson(), ","); // Field auc_number
		$sFilterList = ew_Concat($sFilterList, $this->start_bid->AdvancedSearch->ToJson(), ","); // Field start_bid
		$sFilterList = ew_Concat($sFilterList, $this->close_bid->AdvancedSearch->ToJson(), ","); // Field close_bid
		$sFilterList = ew_Concat($sFilterList, $this->auc_place->AdvancedSearch->ToJson(), ","); // Field auc_place
		$sFilterList = ew_Concat($sFilterList, $this->auc_notes->AdvancedSearch->ToJson(), ","); // Field auc_notes
		$sFilterList = ew_Concat($sFilterList, $this->total_sack->AdvancedSearch->ToJson(), ","); // Field total_sack
		$sFilterList = ew_Concat($sFilterList, $this->total_netto->AdvancedSearch->ToJson(), ","); // Field total_netto
		$sFilterList = ew_Concat($sFilterList, $this->total_gross->AdvancedSearch->ToJson(), ","); // Field total_gross
		$sFilterList = ew_Concat($sFilterList, $this->btn_cetak_catalog->AdvancedSearch->ToJson(), ","); // Field btn_cetak_catalog
		$sFilterList = ew_Concat($sFilterList, $this->auc_status->AdvancedSearch->ToJson(), ","); // Field auc_status
		$sFilterList = ew_Concat($sFilterList, $this->rate->AdvancedSearch->ToJson(), ","); // Field rate
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fv_tr_lelang_masterlistsrch", $filters);

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

		// Field row_id
		$this->row_id->AdvancedSearch->SearchValue = @$filter["x_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator = @$filter["z_row_id"];
		$this->row_id->AdvancedSearch->SearchCondition = @$filter["v_row_id"];
		$this->row_id->AdvancedSearch->SearchValue2 = @$filter["y_row_id"];
		$this->row_id->AdvancedSearch->SearchOperator2 = @$filter["w_row_id"];
		$this->row_id->AdvancedSearch->Save();

		// Field auc_date
		$this->auc_date->AdvancedSearch->SearchValue = @$filter["x_auc_date"];
		$this->auc_date->AdvancedSearch->SearchOperator = @$filter["z_auc_date"];
		$this->auc_date->AdvancedSearch->SearchCondition = @$filter["v_auc_date"];
		$this->auc_date->AdvancedSearch->SearchValue2 = @$filter["y_auc_date"];
		$this->auc_date->AdvancedSearch->SearchOperator2 = @$filter["w_auc_date"];
		$this->auc_date->AdvancedSearch->Save();

		// Field session_number
		$this->session_number->AdvancedSearch->SearchValue = @$filter["x_session_number"];
		$this->session_number->AdvancedSearch->SearchOperator = @$filter["z_session_number"];
		$this->session_number->AdvancedSearch->SearchCondition = @$filter["v_session_number"];
		$this->session_number->AdvancedSearch->SearchValue2 = @$filter["y_session_number"];
		$this->session_number->AdvancedSearch->SearchOperator2 = @$filter["w_session_number"];
		$this->session_number->AdvancedSearch->Save();

		// Field t_start_bid
		$this->t_start_bid->AdvancedSearch->SearchValue = @$filter["x_t_start_bid"];
		$this->t_start_bid->AdvancedSearch->SearchOperator = @$filter["z_t_start_bid"];
		$this->t_start_bid->AdvancedSearch->SearchCondition = @$filter["v_t_start_bid"];
		$this->t_start_bid->AdvancedSearch->SearchValue2 = @$filter["y_t_start_bid"];
		$this->t_start_bid->AdvancedSearch->SearchOperator2 = @$filter["w_t_start_bid"];
		$this->t_start_bid->AdvancedSearch->Save();

		// Field t_close_bid
		$this->t_close_bid->AdvancedSearch->SearchValue = @$filter["x_t_close_bid"];
		$this->t_close_bid->AdvancedSearch->SearchOperator = @$filter["z_t_close_bid"];
		$this->t_close_bid->AdvancedSearch->SearchCondition = @$filter["v_t_close_bid"];
		$this->t_close_bid->AdvancedSearch->SearchValue2 = @$filter["y_t_close_bid"];
		$this->t_close_bid->AdvancedSearch->SearchOperator2 = @$filter["w_t_close_bid"];
		$this->t_close_bid->AdvancedSearch->Save();

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

		// Field auc_place
		$this->auc_place->AdvancedSearch->SearchValue = @$filter["x_auc_place"];
		$this->auc_place->AdvancedSearch->SearchOperator = @$filter["z_auc_place"];
		$this->auc_place->AdvancedSearch->SearchCondition = @$filter["v_auc_place"];
		$this->auc_place->AdvancedSearch->SearchValue2 = @$filter["y_auc_place"];
		$this->auc_place->AdvancedSearch->SearchOperator2 = @$filter["w_auc_place"];
		$this->auc_place->AdvancedSearch->Save();

		// Field auc_notes
		$this->auc_notes->AdvancedSearch->SearchValue = @$filter["x_auc_notes"];
		$this->auc_notes->AdvancedSearch->SearchOperator = @$filter["z_auc_notes"];
		$this->auc_notes->AdvancedSearch->SearchCondition = @$filter["v_auc_notes"];
		$this->auc_notes->AdvancedSearch->SearchValue2 = @$filter["y_auc_notes"];
		$this->auc_notes->AdvancedSearch->SearchOperator2 = @$filter["w_auc_notes"];
		$this->auc_notes->AdvancedSearch->Save();

		// Field total_sack
		$this->total_sack->AdvancedSearch->SearchValue = @$filter["x_total_sack"];
		$this->total_sack->AdvancedSearch->SearchOperator = @$filter["z_total_sack"];
		$this->total_sack->AdvancedSearch->SearchCondition = @$filter["v_total_sack"];
		$this->total_sack->AdvancedSearch->SearchValue2 = @$filter["y_total_sack"];
		$this->total_sack->AdvancedSearch->SearchOperator2 = @$filter["w_total_sack"];
		$this->total_sack->AdvancedSearch->Save();

		// Field total_netto
		$this->total_netto->AdvancedSearch->SearchValue = @$filter["x_total_netto"];
		$this->total_netto->AdvancedSearch->SearchOperator = @$filter["z_total_netto"];
		$this->total_netto->AdvancedSearch->SearchCondition = @$filter["v_total_netto"];
		$this->total_netto->AdvancedSearch->SearchValue2 = @$filter["y_total_netto"];
		$this->total_netto->AdvancedSearch->SearchOperator2 = @$filter["w_total_netto"];
		$this->total_netto->AdvancedSearch->Save();

		// Field total_gross
		$this->total_gross->AdvancedSearch->SearchValue = @$filter["x_total_gross"];
		$this->total_gross->AdvancedSearch->SearchOperator = @$filter["z_total_gross"];
		$this->total_gross->AdvancedSearch->SearchCondition = @$filter["v_total_gross"];
		$this->total_gross->AdvancedSearch->SearchValue2 = @$filter["y_total_gross"];
		$this->total_gross->AdvancedSearch->SearchOperator2 = @$filter["w_total_gross"];
		$this->total_gross->AdvancedSearch->Save();

		// Field btn_cetak_catalog
		$this->btn_cetak_catalog->AdvancedSearch->SearchValue = @$filter["x_btn_cetak_catalog"];
		$this->btn_cetak_catalog->AdvancedSearch->SearchOperator = @$filter["z_btn_cetak_catalog"];
		$this->btn_cetak_catalog->AdvancedSearch->SearchCondition = @$filter["v_btn_cetak_catalog"];
		$this->btn_cetak_catalog->AdvancedSearch->SearchValue2 = @$filter["y_btn_cetak_catalog"];
		$this->btn_cetak_catalog->AdvancedSearch->SearchOperator2 = @$filter["w_btn_cetak_catalog"];
		$this->btn_cetak_catalog->AdvancedSearch->Save();

		// Field auc_status
		$this->auc_status->AdvancedSearch->SearchValue = @$filter["x_auc_status"];
		$this->auc_status->AdvancedSearch->SearchOperator = @$filter["z_auc_status"];
		$this->auc_status->AdvancedSearch->SearchCondition = @$filter["v_auc_status"];
		$this->auc_status->AdvancedSearch->SearchValue2 = @$filter["y_auc_status"];
		$this->auc_status->AdvancedSearch->SearchOperator2 = @$filter["w_auc_status"];
		$this->auc_status->AdvancedSearch->Save();

		// Field rate
		$this->rate->AdvancedSearch->SearchValue = @$filter["x_rate"];
		$this->rate->AdvancedSearch->SearchOperator = @$filter["z_rate"];
		$this->rate->AdvancedSearch->SearchCondition = @$filter["v_rate"];
		$this->rate->AdvancedSearch->SearchValue2 = @$filter["y_rate"];
		$this->rate->AdvancedSearch->SearchOperator2 = @$filter["w_rate"];
		$this->rate->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->session_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->auc_number, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->auc_place, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->auc_notes, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->btn_cetak_catalog, $arKeywords, $type);
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
			$this->UpdateSort($this->row_id); // row_id
			$this->UpdateSort($this->auc_date); // auc_date
			$this->UpdateSort($this->session_number); // session_number
			$this->UpdateSort($this->t_start_bid); // t_start_bid
			$this->UpdateSort($this->t_close_bid); // t_close_bid
			$this->UpdateSort($this->auc_number); // auc_number
			$this->UpdateSort($this->start_bid); // start_bid
			$this->UpdateSort($this->close_bid); // close_bid
			$this->UpdateSort($this->auc_place); // auc_place
			$this->UpdateSort($this->auc_notes); // auc_notes
			$this->UpdateSort($this->total_sack); // total_sack
			$this->UpdateSort($this->total_gross); // total_gross
			$this->UpdateSort($this->btn_cetak_catalog); // btn_cetak_catalog
			$this->UpdateSort($this->auc_status); // auc_status
			$this->UpdateSort($this->rate); // rate
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
				$this->row_id->setSort("");
				$this->auc_date->setSort("");
				$this->session_number->setSort("");
				$this->t_start_bid->setSort("");
				$this->t_close_bid->setSort("");
				$this->auc_number->setSort("");
				$this->start_bid->setSort("");
				$this->close_bid->setSort("");
				$this->auc_place->setSort("");
				$this->auc_notes->setSort("");
				$this->total_sack->setSort("");
				$this->total_gross->setSort("");
				$this->btn_cetak_catalog->setSort("");
				$this->auc_status->setSort("");
				$this->rate->setSort("");
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

		// "detail_v_tr_lelang_item"
		$item = &$this->ListOptions->Add("detail_v_tr_lelang_item");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'v_tr_lelang_item') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["v_tr_lelang_item_grid"])) $GLOBALS["v_tr_lelang_item_grid"] = new cv_tr_lelang_item_grid;

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
		$pages->Add("v_tr_lelang_item");
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

		// "detail_v_tr_lelang_item"
		$oListOpt = &$this->ListOptions->Items["detail_v_tr_lelang_item"];
		if ($Security->AllowList(CurrentProjectID() . 'v_tr_lelang_item')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("v_tr_lelang_item", "TblCaption");
			$body .= "&nbsp;" . str_replace("%c", $this->v_tr_lelang_item_Count, $Language->Phrase("DetailCount"));
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("v_tr_lelang_itemlist.php?" . EW_TABLE_SHOW_MASTER . "=v_tr_lelang_master&fk_row_id=" . urlencode(strval($this->row_id->CurrentValue)) . "") . "\">" . $body . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_tr_lelang_masterlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_tr_lelang_masterlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_tr_lelang_masterlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fv_tr_lelang_masterlistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
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
		$this->row_id->setDbValue($row['row_id']);
		$this->auc_date->setDbValue($row['auc_date']);
		$this->session_number->setDbValue($row['session_number']);
		$this->t_start_bid->setDbValue($row['t_start_bid']);
		$this->t_close_bid->setDbValue($row['t_close_bid']);
		$this->auc_number->setDbValue($row['auc_number']);
		$this->start_bid->setDbValue($row['start_bid']);
		$this->close_bid->setDbValue($row['close_bid']);
		$this->auc_place->setDbValue($row['auc_place']);
		$this->auc_notes->setDbValue($row['auc_notes']);
		$this->total_sack->setDbValue($row['total_sack']);
		$this->total_netto->setDbValue($row['total_netto']);
		$this->total_gross->setDbValue($row['total_gross']);
		$this->btn_cetak_catalog->setDbValue($row['btn_cetak_catalog']);
		$this->auc_status->setDbValue($row['auc_status']);
		$this->rate->setDbValue($row['rate']);
		if (!isset($GLOBALS["v_tr_lelang_item_grid"])) $GLOBALS["v_tr_lelang_item_grid"] = new cv_tr_lelang_item_grid;
		$sDetailFilter = $GLOBALS["v_tr_lelang_item"]->SqlDetailFilter_v_tr_lelang_master();
		$sDetailFilter = str_replace("@master_id@", ew_AdjustSql($this->row_id->DbValue, "DB"), $sDetailFilter);
		$GLOBALS["v_tr_lelang_item"]->setCurrentMasterTable("v_tr_lelang_master");
		$sDetailFilter = $GLOBALS["v_tr_lelang_item"]->ApplyUserIDFilters($sDetailFilter);
		$this->v_tr_lelang_item_Count = $GLOBALS["v_tr_lelang_item"]->LoadRecordCount($sDetailFilter);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['row_id'] = NULL;
		$row['auc_date'] = NULL;
		$row['session_number'] = NULL;
		$row['t_start_bid'] = NULL;
		$row['t_close_bid'] = NULL;
		$row['auc_number'] = NULL;
		$row['start_bid'] = NULL;
		$row['close_bid'] = NULL;
		$row['auc_place'] = NULL;
		$row['auc_notes'] = NULL;
		$row['total_sack'] = NULL;
		$row['total_netto'] = NULL;
		$row['total_gross'] = NULL;
		$row['btn_cetak_catalog'] = NULL;
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
		$this->session_number->DbValue = $row['session_number'];
		$this->t_start_bid->DbValue = $row['t_start_bid'];
		$this->t_close_bid->DbValue = $row['t_close_bid'];
		$this->auc_number->DbValue = $row['auc_number'];
		$this->start_bid->DbValue = $row['start_bid'];
		$this->close_bid->DbValue = $row['close_bid'];
		$this->auc_place->DbValue = $row['auc_place'];
		$this->auc_notes->DbValue = $row['auc_notes'];
		$this->total_sack->DbValue = $row['total_sack'];
		$this->total_netto->DbValue = $row['total_netto'];
		$this->total_gross->DbValue = $row['total_gross'];
		$this->btn_cetak_catalog->DbValue = $row['btn_cetak_catalog'];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

		$this->row_id->CellCssStyle = "white-space: nowrap;";

		// auc_date
		$this->auc_date->CellCssStyle = "white-space: nowrap;";

		// session_number
		$this->session_number->CellCssStyle = "white-space: nowrap;";

		// t_start_bid
		$this->t_start_bid->CellCssStyle = "white-space: nowrap;";

		// t_close_bid
		$this->t_close_bid->CellCssStyle = "white-space: nowrap;";

		// auc_number
		$this->auc_number->CellCssStyle = "white-space: nowrap;";

		// start_bid
		// close_bid
		// auc_place
		// auc_notes
		// total_sack

		$this->total_sack->CellCssStyle = "white-space: nowrap;";

		// total_netto
		$this->total_netto->CellCssStyle = "white-space: nowrap;";

		// total_gross
		$this->total_gross->CellCssStyle = "white-space: nowrap;";

		// btn_cetak_catalog
		// auc_status
		// rate

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// auc_date
		$this->auc_date->ViewValue = $this->auc_date->CurrentValue;
		$this->auc_date->ViewValue = ew_FormatDateTime($this->auc_date->ViewValue, 11);
		$this->auc_date->CellCssStyle .= "text-align: center;";
		$this->auc_date->ViewCustomAttributes = "";

		// session_number
		$this->session_number->ViewValue = $this->session_number->CurrentValue;
		$this->session_number->CellCssStyle .= "text-align: center;";
		$this->session_number->ViewCustomAttributes = "";

		// t_start_bid
		$this->t_start_bid->ViewValue = $this->t_start_bid->CurrentValue;
		$this->t_start_bid->ViewValue = ew_FormatDateTime($this->t_start_bid->ViewValue, 3);
		$this->t_start_bid->CellCssStyle .= "text-align: center;";
		$this->t_start_bid->ViewCustomAttributes = "";

		// t_close_bid
		$this->t_close_bid->ViewValue = $this->t_close_bid->CurrentValue;
		$this->t_close_bid->ViewValue = ew_FormatDateTime($this->t_close_bid->ViewValue, 3);
		$this->t_close_bid->CellCssStyle .= "text-align: center;";
		$this->t_close_bid->ViewCustomAttributes = "";

		// auc_number
		$this->auc_number->ViewValue = $this->auc_number->CurrentValue;
		$this->auc_number->CellCssStyle .= "text-align: center;";
		$this->auc_number->ViewCustomAttributes = "";

		// start_bid
		$this->start_bid->ViewValue = $this->start_bid->CurrentValue;
		$this->start_bid->ViewValue = ew_FormatDateTime($this->start_bid->ViewValue, 10);
		$this->start_bid->CellCssStyle .= "text-align: center;";
		$this->start_bid->ViewCustomAttributes = "";

		// close_bid
		$this->close_bid->ViewValue = $this->close_bid->CurrentValue;
		$this->close_bid->ViewValue = ew_FormatDateTime($this->close_bid->ViewValue, 10);
		$this->close_bid->CellCssStyle .= "text-align: center;";
		$this->close_bid->ViewCustomAttributes = "";

		// auc_place
		$this->auc_place->ViewValue = $this->auc_place->CurrentValue;
		$this->auc_place->ViewCustomAttributes = "";

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

		// btn_cetak_catalog
		$this->btn_cetak_catalog->ViewValue = $this->btn_cetak_catalog->CurrentValue;
		$this->btn_cetak_catalog->ViewCustomAttributes = "";

		// auc_status
		$this->auc_status->ViewValue = $this->auc_status->CurrentValue;
		$this->auc_status->ViewCustomAttributes = "";

		// rate
		$this->rate->ViewValue = $this->rate->CurrentValue;
		$this->rate->ViewCustomAttributes = "";

			// row_id
			$this->row_id->LinkCustomAttributes = "";
			$this->row_id->HrefValue = "";
			$this->row_id->TooltipValue = "";

			// auc_date
			$this->auc_date->LinkCustomAttributes = "";
			$this->auc_date->HrefValue = "";
			$this->auc_date->TooltipValue = "";

			// session_number
			$this->session_number->LinkCustomAttributes = "";
			$this->session_number->HrefValue = "";
			$this->session_number->TooltipValue = "";

			// t_start_bid
			$this->t_start_bid->LinkCustomAttributes = "";
			$this->t_start_bid->HrefValue = "";
			$this->t_start_bid->TooltipValue = "";

			// t_close_bid
			$this->t_close_bid->LinkCustomAttributes = "";
			$this->t_close_bid->HrefValue = "";
			$this->t_close_bid->TooltipValue = "";

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

			// auc_place
			$this->auc_place->LinkCustomAttributes = "";
			$this->auc_place->HrefValue = "";
			$this->auc_place->TooltipValue = "";

			// auc_notes
			$this->auc_notes->LinkCustomAttributes = "";
			$this->auc_notes->HrefValue = "";
			$this->auc_notes->TooltipValue = "";

			// total_sack
			$this->total_sack->LinkCustomAttributes = "";
			$this->total_sack->HrefValue = "";
			$this->total_sack->TooltipValue = "";

			// total_gross
			$this->total_gross->LinkCustomAttributes = "";
			$this->total_gross->HrefValue = "";
			$this->total_gross->TooltipValue = "";

			// btn_cetak_catalog
			$this->btn_cetak_catalog->LinkCustomAttributes = "";
			$this->btn_cetak_catalog->HrefValue = "";
			$this->btn_cetak_catalog->TooltipValue = "";

			// auc_status
			$this->auc_status->LinkCustomAttributes = "";
			$this->auc_status->HrefValue = "";
			$this->auc_status->TooltipValue = "";

			// rate
			$this->rate->LinkCustomAttributes = "";
			$this->rate->HrefValue = "";
			$this->rate->TooltipValue = "";
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
		//$this->ListOptions->Items["edit"]->Body = "<a href=v_tr_lelang_masteredit.php?showdetail=v_tr_lelang_item&row_id=". $this->row_id->CurrentValue . "><img src='phpimages/btn_edit.jpg' border='0'></a>";
		//$this->ListOptions->Items["delete"]->Body = "<a href=v_tr_lelang_masterdelete.php?showdetail=v_tr_lelang_item&row_id=". $this->row_id->CurrentValue . "><img src='phpimages/btn_deletes.jpg' border='0'></a>";		

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
if (!isset($v_tr_lelang_master_list)) $v_tr_lelang_master_list = new cv_tr_lelang_master_list();

// Page init
$v_tr_lelang_master_list->Page_Init();

// Page main
$v_tr_lelang_master_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_tr_lelang_master_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_tr_lelang_masterlist = new ew_Form("fv_tr_lelang_masterlist", "list");
fv_tr_lelang_masterlist.FormKeyCountName = '<?php echo $v_tr_lelang_master_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_tr_lelang_masterlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_tr_lelang_masterlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var CurrentSearchForm = fv_tr_lelang_masterlistsrch = new ew_Form("fv_tr_lelang_masterlistsrch");

// Init search panel as collapsed
if (fv_tr_lelang_masterlistsrch) fv_tr_lelang_masterlistsrch.InitSearchPanel = true;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($v_tr_lelang_master_list->TotalRecs > 0 && $v_tr_lelang_master_list->ExportOptions->Visible()) { ?>
<?php $v_tr_lelang_master_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($v_tr_lelang_master_list->SearchOptions->Visible()) { ?>
<?php $v_tr_lelang_master_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($v_tr_lelang_master_list->FilterOptions->Visible()) { ?>
<?php $v_tr_lelang_master_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $v_tr_lelang_master_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_tr_lelang_master_list->TotalRecs <= 0)
			$v_tr_lelang_master_list->TotalRecs = $v_tr_lelang_master->ListRecordCount();
	} else {
		if (!$v_tr_lelang_master_list->Recordset && ($v_tr_lelang_master_list->Recordset = $v_tr_lelang_master_list->LoadRecordset()))
			$v_tr_lelang_master_list->TotalRecs = $v_tr_lelang_master_list->Recordset->RecordCount();
	}
	$v_tr_lelang_master_list->StartRec = 1;
	if ($v_tr_lelang_master_list->DisplayRecs <= 0 || ($v_tr_lelang_master->Export <> "" && $v_tr_lelang_master->ExportAll)) // Display all records
		$v_tr_lelang_master_list->DisplayRecs = $v_tr_lelang_master_list->TotalRecs;
	if (!($v_tr_lelang_master->Export <> "" && $v_tr_lelang_master->ExportAll))
		$v_tr_lelang_master_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_tr_lelang_master_list->Recordset = $v_tr_lelang_master_list->LoadRecordset($v_tr_lelang_master_list->StartRec-1, $v_tr_lelang_master_list->DisplayRecs);

	// Set no record found message
	if ($v_tr_lelang_master->CurrentAction == "" && $v_tr_lelang_master_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_tr_lelang_master_list->setWarningMessage(ew_DeniedMsg());
		if ($v_tr_lelang_master_list->SearchWhere == "0=101")
			$v_tr_lelang_master_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_tr_lelang_master_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_tr_lelang_master_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($v_tr_lelang_master->Export == "" && $v_tr_lelang_master->CurrentAction == "") { ?>
<form name="fv_tr_lelang_masterlistsrch" id="fv_tr_lelang_masterlistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($v_tr_lelang_master_list->SearchWhere <> "") ? " in" : ""; ?>
<div id="fv_tr_lelang_masterlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="v_tr_lelang_master">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($v_tr_lelang_master_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($v_tr_lelang_master_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $v_tr_lelang_master_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($v_tr_lelang_master_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($v_tr_lelang_master_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($v_tr_lelang_master_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($v_tr_lelang_master_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $v_tr_lelang_master_list->ShowPageHeader(); ?>
<?php
$v_tr_lelang_master_list->ShowMessage();
?>
<?php if ($v_tr_lelang_master_list->TotalRecs > 0 || $v_tr_lelang_master->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_tr_lelang_master_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_tr_lelang_master">
<div class="box-header ewGridUpperPanel">
<?php if ($v_tr_lelang_master->CurrentAction <> "gridadd" && $v_tr_lelang_master->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_tr_lelang_master_list->Pager)) $v_tr_lelang_master_list->Pager = new cPrevNextPager($v_tr_lelang_master_list->StartRec, $v_tr_lelang_master_list->DisplayRecs, $v_tr_lelang_master_list->TotalRecs, $v_tr_lelang_master_list->AutoHidePager) ?>
<?php if ($v_tr_lelang_master_list->Pager->RecordCount > 0 && $v_tr_lelang_master_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_tr_lelang_master_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_tr_lelang_master_list->PageUrl() ?>start=<?php echo $v_tr_lelang_master_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_tr_lelang_master_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_tr_lelang_master_list->PageUrl() ?>start=<?php echo $v_tr_lelang_master_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_tr_lelang_master_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_tr_lelang_master_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_tr_lelang_master_list->PageUrl() ?>start=<?php echo $v_tr_lelang_master_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_tr_lelang_master_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_tr_lelang_master_list->PageUrl() ?>start=<?php echo $v_tr_lelang_master_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_tr_lelang_master_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_tr_lelang_master_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_tr_lelang_master_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_tr_lelang_master_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_tr_lelang_master_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($v_tr_lelang_master_list->TotalRecs > 0 && (!$v_tr_lelang_master_list->AutoHidePageSizeSelector || $v_tr_lelang_master_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="v_tr_lelang_master">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($v_tr_lelang_master_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($v_tr_lelang_master_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($v_tr_lelang_master_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($v_tr_lelang_master_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($v_tr_lelang_master->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_tr_lelang_master_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fv_tr_lelang_masterlist" id="fv_tr_lelang_masterlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_tr_lelang_master_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_tr_lelang_master_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_tr_lelang_master">
<div id="gmp_v_tr_lelang_master" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_tr_lelang_master_list->TotalRecs > 0 || $v_tr_lelang_master->CurrentAction == "gridedit") { ?>
<table id="tbl_v_tr_lelang_masterlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_tr_lelang_master_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_tr_lelang_master_list->RenderListOptions();

// Render list options (header, left)
$v_tr_lelang_master_list->ListOptions->Render("header", "left");
?>
<?php if ($v_tr_lelang_master->row_id->Visible) { // row_id ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->row_id) == "") { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_master->row_id->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_row_id" class="v_tr_lelang_master_row_id"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->row_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_master->row_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->row_id) ?>',1);"><div id="elh_v_tr_lelang_master_row_id" class="v_tr_lelang_master_row_id">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->row_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->row_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->row_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_date->Visible) { // auc_date ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_date) == "") { ?>
		<th data-name="auc_date" class="<?php echo $v_tr_lelang_master->auc_date->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_auc_date" class="v_tr_lelang_master_auc_date"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->auc_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_date" class="<?php echo $v_tr_lelang_master->auc_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_date) ?>',1);"><div id="elh_v_tr_lelang_master_auc_date" class="v_tr_lelang_master_auc_date">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->auc_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->auc_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->session_number->Visible) { // session_number ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->session_number) == "") { ?>
		<th data-name="session_number" class="<?php echo $v_tr_lelang_master->session_number->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_session_number" class="v_tr_lelang_master_session_number"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->session_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="session_number" class="<?php echo $v_tr_lelang_master->session_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->session_number) ?>',1);"><div id="elh_v_tr_lelang_master_session_number" class="v_tr_lelang_master_session_number">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->session_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->session_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->session_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->t_start_bid->Visible) { // t_start_bid ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->t_start_bid) == "") { ?>
		<th data-name="t_start_bid" class="<?php echo $v_tr_lelang_master->t_start_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_t_start_bid" class="v_tr_lelang_master_t_start_bid"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->t_start_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="t_start_bid" class="<?php echo $v_tr_lelang_master->t_start_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->t_start_bid) ?>',1);"><div id="elh_v_tr_lelang_master_t_start_bid" class="v_tr_lelang_master_t_start_bid">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->t_start_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->t_start_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->t_start_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->t_close_bid->Visible) { // t_close_bid ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->t_close_bid) == "") { ?>
		<th data-name="t_close_bid" class="<?php echo $v_tr_lelang_master->t_close_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_t_close_bid" class="v_tr_lelang_master_t_close_bid"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->t_close_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="t_close_bid" class="<?php echo $v_tr_lelang_master->t_close_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->t_close_bid) ?>',1);"><div id="elh_v_tr_lelang_master_t_close_bid" class="v_tr_lelang_master_t_close_bid">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->t_close_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->t_close_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->t_close_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_number->Visible) { // auc_number ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_number) == "") { ?>
		<th data-name="auc_number" class="<?php echo $v_tr_lelang_master->auc_number->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_auc_number" class="v_tr_lelang_master_auc_number"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->auc_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_number" class="<?php echo $v_tr_lelang_master->auc_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_number) ?>',1);"><div id="elh_v_tr_lelang_master_auc_number" class="v_tr_lelang_master_auc_number">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_number->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->auc_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->auc_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->start_bid->Visible) { // start_bid ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->start_bid) == "") { ?>
		<th data-name="start_bid" class="<?php echo $v_tr_lelang_master->start_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_start_bid" class="v_tr_lelang_master_start_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->start_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="start_bid" class="<?php echo $v_tr_lelang_master->start_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->start_bid) ?>',1);"><div id="elh_v_tr_lelang_master_start_bid" class="v_tr_lelang_master_start_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->start_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->start_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->start_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->close_bid->Visible) { // close_bid ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->close_bid) == "") { ?>
		<th data-name="close_bid" class="<?php echo $v_tr_lelang_master->close_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_close_bid" class="v_tr_lelang_master_close_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->close_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="close_bid" class="<?php echo $v_tr_lelang_master->close_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->close_bid) ?>',1);"><div id="elh_v_tr_lelang_master_close_bid" class="v_tr_lelang_master_close_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->close_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->close_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->close_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_place->Visible) { // auc_place ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_place) == "") { ?>
		<th data-name="auc_place" class="<?php echo $v_tr_lelang_master->auc_place->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_auc_place" class="v_tr_lelang_master_auc_place"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_place->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_place" class="<?php echo $v_tr_lelang_master->auc_place->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_place) ?>',1);"><div id="elh_v_tr_lelang_master_auc_place" class="v_tr_lelang_master_auc_place">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_place->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->auc_place->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->auc_place->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_notes) == "") { ?>
		<th data-name="auc_notes" class="<?php echo $v_tr_lelang_master->auc_notes->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_auc_notes" class="v_tr_lelang_master_auc_notes"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_notes->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_notes" class="<?php echo $v_tr_lelang_master->auc_notes->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_notes) ?>',1);"><div id="elh_v_tr_lelang_master_auc_notes" class="v_tr_lelang_master_auc_notes">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_notes->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->auc_notes->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->auc_notes->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->total_sack->Visible) { // total_sack ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->total_sack) == "") { ?>
		<th data-name="total_sack" class="<?php echo $v_tr_lelang_master->total_sack->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_total_sack" class="v_tr_lelang_master_total_sack"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->total_sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="total_sack" class="<?php echo $v_tr_lelang_master->total_sack->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->total_sack) ?>',1);"><div id="elh_v_tr_lelang_master_total_sack" class="v_tr_lelang_master_total_sack">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->total_sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->total_sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->total_sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->total_gross->Visible) { // total_gross ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->total_gross) == "") { ?>
		<th data-name="total_gross" class="<?php echo $v_tr_lelang_master->total_gross->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_total_gross" class="v_tr_lelang_master_total_gross"><div class="ewTableHeaderCaption" style="white-space: nowrap;"><?php echo $v_tr_lelang_master->total_gross->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="total_gross" class="<?php echo $v_tr_lelang_master->total_gross->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->total_gross) ?>',1);"><div id="elh_v_tr_lelang_master_total_gross" class="v_tr_lelang_master_total_gross">
			<div class="ewTableHeaderBtn" style="white-space: nowrap;"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->total_gross->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->total_gross->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->total_gross->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->btn_cetak_catalog->Visible) { // btn_cetak_catalog ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->btn_cetak_catalog) == "") { ?>
		<th data-name="btn_cetak_catalog" class="<?php echo $v_tr_lelang_master->btn_cetak_catalog->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_btn_cetak_catalog" class="v_tr_lelang_master_btn_cetak_catalog"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->btn_cetak_catalog->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="btn_cetak_catalog" class="<?php echo $v_tr_lelang_master->btn_cetak_catalog->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->btn_cetak_catalog) ?>',1);"><div id="elh_v_tr_lelang_master_btn_cetak_catalog" class="v_tr_lelang_master_btn_cetak_catalog">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->btn_cetak_catalog->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->btn_cetak_catalog->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->btn_cetak_catalog->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_status->Visible) { // auc_status ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_status) == "") { ?>
		<th data-name="auc_status" class="<?php echo $v_tr_lelang_master->auc_status->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_auc_status" class="v_tr_lelang_master_auc_status"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_status" class="<?php echo $v_tr_lelang_master->auc_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->auc_status) ?>',1);"><div id="elh_v_tr_lelang_master_auc_status" class="v_tr_lelang_master_auc_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->auc_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->auc_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->auc_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_master->rate->Visible) { // rate ?>
	<?php if ($v_tr_lelang_master->SortUrl($v_tr_lelang_master->rate) == "") { ?>
		<th data-name="rate" class="<?php echo $v_tr_lelang_master->rate->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_master_rate" class="v_tr_lelang_master_rate"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->rate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rate" class="<?php echo $v_tr_lelang_master->rate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_master->SortUrl($v_tr_lelang_master->rate) ?>',1);"><div id="elh_v_tr_lelang_master_rate" class="v_tr_lelang_master_rate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_master->rate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_master->rate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_master->rate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_tr_lelang_master_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_tr_lelang_master->ExportAll && $v_tr_lelang_master->Export <> "") {
	$v_tr_lelang_master_list->StopRec = $v_tr_lelang_master_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_tr_lelang_master_list->TotalRecs > $v_tr_lelang_master_list->StartRec + $v_tr_lelang_master_list->DisplayRecs - 1)
		$v_tr_lelang_master_list->StopRec = $v_tr_lelang_master_list->StartRec + $v_tr_lelang_master_list->DisplayRecs - 1;
	else
		$v_tr_lelang_master_list->StopRec = $v_tr_lelang_master_list->TotalRecs;
}
$v_tr_lelang_master_list->RecCnt = $v_tr_lelang_master_list->StartRec - 1;
if ($v_tr_lelang_master_list->Recordset && !$v_tr_lelang_master_list->Recordset->EOF) {
	$v_tr_lelang_master_list->Recordset->MoveFirst();
	$bSelectLimit = $v_tr_lelang_master_list->UseSelectLimit;
	if (!$bSelectLimit && $v_tr_lelang_master_list->StartRec > 1)
		$v_tr_lelang_master_list->Recordset->Move($v_tr_lelang_master_list->StartRec - 1);
} elseif (!$v_tr_lelang_master->AllowAddDeleteRow && $v_tr_lelang_master_list->StopRec == 0) {
	$v_tr_lelang_master_list->StopRec = $v_tr_lelang_master->GridAddRowCount;
}

// Initialize aggregate
$v_tr_lelang_master->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_tr_lelang_master->ResetAttrs();
$v_tr_lelang_master_list->RenderRow();
while ($v_tr_lelang_master_list->RecCnt < $v_tr_lelang_master_list->StopRec) {
	$v_tr_lelang_master_list->RecCnt++;
	if (intval($v_tr_lelang_master_list->RecCnt) >= intval($v_tr_lelang_master_list->StartRec)) {
		$v_tr_lelang_master_list->RowCnt++;

		// Set up key count
		$v_tr_lelang_master_list->KeyCount = $v_tr_lelang_master_list->RowIndex;

		// Init row class and style
		$v_tr_lelang_master->ResetAttrs();
		$v_tr_lelang_master->CssClass = "";
		if ($v_tr_lelang_master->CurrentAction == "gridadd") {
		} else {
			$v_tr_lelang_master_list->LoadRowValues($v_tr_lelang_master_list->Recordset); // Load row values
		}
		$v_tr_lelang_master->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_tr_lelang_master->RowAttrs = array_merge($v_tr_lelang_master->RowAttrs, array('data-rowindex'=>$v_tr_lelang_master_list->RowCnt, 'id'=>'r' . $v_tr_lelang_master_list->RowCnt . '_v_tr_lelang_master', 'data-rowtype'=>$v_tr_lelang_master->RowType));

		// Render row
		$v_tr_lelang_master_list->RenderRow();

		// Render list options
		$v_tr_lelang_master_list->RenderListOptions();
?>
	<tr<?php echo $v_tr_lelang_master->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_tr_lelang_master_list->ListOptions->Render("body", "left", $v_tr_lelang_master_list->RowCnt);
?>
	<?php if ($v_tr_lelang_master->row_id->Visible) { // row_id ?>
		<td data-name="row_id"<?php echo $v_tr_lelang_master->row_id->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_row_id" class="v_tr_lelang_master_row_id">
<span<?php echo $v_tr_lelang_master->row_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->row_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->auc_date->Visible) { // auc_date ?>
		<td data-name="auc_date"<?php echo $v_tr_lelang_master->auc_date->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_auc_date" class="v_tr_lelang_master_auc_date">
<span<?php echo $v_tr_lelang_master->auc_date->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->session_number->Visible) { // session_number ?>
		<td data-name="session_number"<?php echo $v_tr_lelang_master->session_number->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_session_number" class="v_tr_lelang_master_session_number">
<span<?php echo $v_tr_lelang_master->session_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->session_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->t_start_bid->Visible) { // t_start_bid ?>
		<td data-name="t_start_bid"<?php echo $v_tr_lelang_master->t_start_bid->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_t_start_bid" class="v_tr_lelang_master_t_start_bid">
<span<?php echo $v_tr_lelang_master->t_start_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->t_start_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->t_close_bid->Visible) { // t_close_bid ?>
		<td data-name="t_close_bid"<?php echo $v_tr_lelang_master->t_close_bid->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_t_close_bid" class="v_tr_lelang_master_t_close_bid">
<span<?php echo $v_tr_lelang_master->t_close_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->t_close_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->auc_number->Visible) { // auc_number ?>
		<td data-name="auc_number"<?php echo $v_tr_lelang_master->auc_number->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_auc_number" class="v_tr_lelang_master_auc_number">
<span<?php echo $v_tr_lelang_master->auc_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_number->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->start_bid->Visible) { // start_bid ?>
		<td data-name="start_bid"<?php echo $v_tr_lelang_master->start_bid->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_start_bid" class="v_tr_lelang_master_start_bid">
<span<?php echo $v_tr_lelang_master->start_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->start_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->close_bid->Visible) { // close_bid ?>
		<td data-name="close_bid"<?php echo $v_tr_lelang_master->close_bid->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_close_bid" class="v_tr_lelang_master_close_bid">
<span<?php echo $v_tr_lelang_master->close_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->close_bid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->auc_place->Visible) { // auc_place ?>
		<td data-name="auc_place"<?php echo $v_tr_lelang_master->auc_place->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_auc_place" class="v_tr_lelang_master_auc_place">
<span<?php echo $v_tr_lelang_master->auc_place->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_place->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
		<td data-name="auc_notes"<?php echo $v_tr_lelang_master->auc_notes->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_auc_notes" class="v_tr_lelang_master_auc_notes">
<span<?php echo $v_tr_lelang_master->auc_notes->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_notes->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->total_sack->Visible) { // total_sack ?>
		<td data-name="total_sack"<?php echo $v_tr_lelang_master->total_sack->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_total_sack" class="v_tr_lelang_master_total_sack">
<span<?php echo $v_tr_lelang_master->total_sack->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->total_sack->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->total_gross->Visible) { // total_gross ?>
		<td data-name="total_gross"<?php echo $v_tr_lelang_master->total_gross->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_total_gross" class="v_tr_lelang_master_total_gross">
<span<?php echo $v_tr_lelang_master->total_gross->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->total_gross->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->btn_cetak_catalog->Visible) { // btn_cetak_catalog ?>
		<td data-name="btn_cetak_catalog"<?php echo $v_tr_lelang_master->btn_cetak_catalog->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_btn_cetak_catalog" class="v_tr_lelang_master_btn_cetak_catalog">
<span<?php echo $v_tr_lelang_master->btn_cetak_catalog->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->btn_cetak_catalog->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->auc_status->Visible) { // auc_status ?>
		<td data-name="auc_status"<?php echo $v_tr_lelang_master->auc_status->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_auc_status" class="v_tr_lelang_master_auc_status">
<span<?php echo $v_tr_lelang_master->auc_status->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_master->rate->Visible) { // rate ?>
		<td data-name="rate"<?php echo $v_tr_lelang_master->rate->CellAttributes() ?>>
<span id="el<?php echo $v_tr_lelang_master_list->RowCnt ?>_v_tr_lelang_master_rate" class="v_tr_lelang_master_rate">
<span<?php echo $v_tr_lelang_master->rate->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->rate->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_tr_lelang_master_list->ListOptions->Render("body", "right", $v_tr_lelang_master_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_tr_lelang_master->CurrentAction <> "gridadd")
		$v_tr_lelang_master_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_tr_lelang_master->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_tr_lelang_master_list->Recordset)
	$v_tr_lelang_master_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($v_tr_lelang_master_list->TotalRecs == 0 && $v_tr_lelang_master->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_tr_lelang_master_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_tr_lelang_masterlistsrch.FilterList = <?php echo $v_tr_lelang_master_list->GetFilterList() ?>;
fv_tr_lelang_masterlistsrch.Init();
fv_tr_lelang_masterlist.Init();
</script>
<?php
$v_tr_lelang_master_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$v_tr_lelang_master_list->Page_Terminate();
?>
