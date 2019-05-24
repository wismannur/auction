<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_auction_dateinfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_auction_date_list = NULL; // Initialize page object first

class cv_auction_date_list extends cv_auction_date {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_auction_date';

	// Page object name
	var $PageObjName = 'v_auction_date_list';

	// Grid form hidden field names
	var $FormName = 'fv_auction_datelist';
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

		// Table object (v_auction_date)
		if (!isset($GLOBALS["v_auction_date"]) || get_class($GLOBALS["v_auction_date"]) == "cv_auction_date") {
			$GLOBALS["v_auction_date"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_auction_date"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_auction_dateadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_auction_datedelete.php";
		$this->MultiUpdateUrl = "v_auction_dateupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_auction_date', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_auction_datelistsrch";

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

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} elseif (@$_GET["cmd"] == "json") {
			$this->Export = $_GET["cmd"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->auc_date->SetVisibility();
		$this->SUM28tr_lelang_master_total_sack29->SetVisibility();
		$this->SUM28tr_lelang_master_total_netto29->SetVisibility();
		$this->SUM28tr_lelang_master_total_gross29->SetVisibility();
		$this->COUNT28tr_lelang_item_chop29->SetVisibility();

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
		global $EW_EXPORT, $v_auction_date;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_auction_date);
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

			// Set up sorting order
			$this->SetupSortOrder();
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

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array_keys($EW_EXPORT))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
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
		if (count($arrKeyFlds) >= 0) {
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->auc_date); // auc_date
			$this->UpdateSort($this->SUM28tr_lelang_master_total_sack29); // SUM(tr_lelang_master.total_sack)
			$this->UpdateSort($this->SUM28tr_lelang_master_total_netto29); // SUM(tr_lelang_master.total_netto)
			$this->UpdateSort($this->SUM28tr_lelang_master_total_gross29); // SUM(tr_lelang_master.total_gross)
			$this->UpdateSort($this->COUNT28tr_lelang_item_chop29); // COUNT(tr_lelang_item.chop)
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->auc_date->setSort("");
				$this->SUM28tr_lelang_master_total_sack29->setSort("");
				$this->SUM28tr_lelang_master_total_netto29->setSort("");
				$this->SUM28tr_lelang_master_total_gross29->setSort("");
				$this->COUNT28tr_lelang_item_chop29->setSort("");
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

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_auction_datelistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_auction_datelistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_auction_datelist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->auc_date->setDbValue($row['auc_date']);
		$this->SUM28tr_lelang_master_total_sack29->setDbValue($row['SUM(tr_lelang_master.total_sack)']);
		$this->SUM28tr_lelang_master_total_netto29->setDbValue($row['SUM(tr_lelang_master.total_netto)']);
		$this->SUM28tr_lelang_master_total_gross29->setDbValue($row['SUM(tr_lelang_master.total_gross)']);
		$this->COUNT28tr_lelang_item_chop29->setDbValue($row['COUNT(tr_lelang_item.chop)']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['auc_date'] = NULL;
		$row['SUM(tr_lelang_master.total_sack)'] = NULL;
		$row['SUM(tr_lelang_master.total_netto)'] = NULL;
		$row['SUM(tr_lelang_master.total_gross)'] = NULL;
		$row['COUNT(tr_lelang_item.chop)'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->auc_date->DbValue = $row['auc_date'];
		$this->SUM28tr_lelang_master_total_sack29->DbValue = $row['SUM(tr_lelang_master.total_sack)'];
		$this->SUM28tr_lelang_master_total_netto29->DbValue = $row['SUM(tr_lelang_master.total_netto)'];
		$this->SUM28tr_lelang_master_total_gross29->DbValue = $row['SUM(tr_lelang_master.total_gross)'];
		$this->COUNT28tr_lelang_item_chop29->DbValue = $row['COUNT(tr_lelang_item.chop)'];
	}

	// Load old record
	function LoadOldRecord() {
		return FALSE;
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
		if ($this->SUM28tr_lelang_master_total_sack29->FormValue == $this->SUM28tr_lelang_master_total_sack29->CurrentValue && is_numeric(ew_StrToFloat($this->SUM28tr_lelang_master_total_sack29->CurrentValue)))
			$this->SUM28tr_lelang_master_total_sack29->CurrentValue = ew_StrToFloat($this->SUM28tr_lelang_master_total_sack29->CurrentValue);

		// Convert decimal values if posted back
		if ($this->SUM28tr_lelang_master_total_netto29->FormValue == $this->SUM28tr_lelang_master_total_netto29->CurrentValue && is_numeric(ew_StrToFloat($this->SUM28tr_lelang_master_total_netto29->CurrentValue)))
			$this->SUM28tr_lelang_master_total_netto29->CurrentValue = ew_StrToFloat($this->SUM28tr_lelang_master_total_netto29->CurrentValue);

		// Convert decimal values if posted back
		if ($this->SUM28tr_lelang_master_total_gross29->FormValue == $this->SUM28tr_lelang_master_total_gross29->CurrentValue && is_numeric(ew_StrToFloat($this->SUM28tr_lelang_master_total_gross29->CurrentValue)))
			$this->SUM28tr_lelang_master_total_gross29->CurrentValue = ew_StrToFloat($this->SUM28tr_lelang_master_total_gross29->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// auc_date
		// SUM(tr_lelang_master.total_sack)
		// SUM(tr_lelang_master.total_netto)
		// SUM(tr_lelang_master.total_gross)
		// COUNT(tr_lelang_item.chop)

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// auc_date
		$this->auc_date->ViewValue = $this->auc_date->CurrentValue;
		$this->auc_date->ViewValue = ew_FormatDateTime($this->auc_date->ViewValue, 2);
		$this->auc_date->CellCssStyle .= "text-align: center;";
		$this->auc_date->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_sack)
		$this->SUM28tr_lelang_master_total_sack29->ViewValue = $this->SUM28tr_lelang_master_total_sack29->CurrentValue;
		$this->SUM28tr_lelang_master_total_sack29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_sack29->ViewValue, 0, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_sack29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_sack29->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_netto)
		$this->SUM28tr_lelang_master_total_netto29->ViewValue = $this->SUM28tr_lelang_master_total_netto29->CurrentValue;
		$this->SUM28tr_lelang_master_total_netto29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_netto29->ViewValue, 2, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_netto29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_netto29->ViewCustomAttributes = "";

		// SUM(tr_lelang_master.total_gross)
		$this->SUM28tr_lelang_master_total_gross29->ViewValue = $this->SUM28tr_lelang_master_total_gross29->CurrentValue;
		$this->SUM28tr_lelang_master_total_gross29->ViewValue = ew_FormatNumber($this->SUM28tr_lelang_master_total_gross29->ViewValue, 2, -2, -2, -2);
		$this->SUM28tr_lelang_master_total_gross29->CellCssStyle .= "text-align: center;";
		$this->SUM28tr_lelang_master_total_gross29->ViewCustomAttributes = "";

		// COUNT(tr_lelang_item.chop)
		$this->COUNT28tr_lelang_item_chop29->ViewValue = $this->COUNT28tr_lelang_item_chop29->CurrentValue;
		$this->COUNT28tr_lelang_item_chop29->ViewValue = ew_FormatNumber($this->COUNT28tr_lelang_item_chop29->ViewValue, 0, -2, -2, -2);
		$this->COUNT28tr_lelang_item_chop29->CellCssStyle .= "text-align: center;";
		$this->COUNT28tr_lelang_item_chop29->ViewCustomAttributes = "";

			// auc_date
			$this->auc_date->LinkCustomAttributes = "";
			$this->auc_date->HrefValue = "";
			$this->auc_date->TooltipValue = "";

			// SUM(tr_lelang_master.total_sack)
			$this->SUM28tr_lelang_master_total_sack29->LinkCustomAttributes = "";
			$this->SUM28tr_lelang_master_total_sack29->HrefValue = "";
			$this->SUM28tr_lelang_master_total_sack29->TooltipValue = "";

			// SUM(tr_lelang_master.total_netto)
			$this->SUM28tr_lelang_master_total_netto29->LinkCustomAttributes = "";
			$this->SUM28tr_lelang_master_total_netto29->HrefValue = "";
			$this->SUM28tr_lelang_master_total_netto29->TooltipValue = "";

			// SUM(tr_lelang_master.total_gross)
			$this->SUM28tr_lelang_master_total_gross29->LinkCustomAttributes = "";
			$this->SUM28tr_lelang_master_total_gross29->HrefValue = "";
			$this->SUM28tr_lelang_master_total_gross29->TooltipValue = "";

			// COUNT(tr_lelang_item.chop)
			$this->COUNT28tr_lelang_item_chop29->LinkCustomAttributes = "";
			$this->COUNT28tr_lelang_item_chop29->HrefValue = "";
			$this->COUNT28tr_lelang_item_chop29->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = FALSE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = FALSE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = FALSE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_v_auction_date\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_v_auction_date',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fv_auction_datelist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = FALSE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->ListRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetupStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
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
if (!isset($v_auction_date_list)) $v_auction_date_list = new cv_auction_date_list();

// Page init
$v_auction_date_list->Page_Init();

// Page main
$v_auction_date_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_auction_date_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($v_auction_date->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_auction_datelist = new ew_Form("fv_auction_datelist", "list");
fv_auction_datelist.FormKeyCountName = '<?php echo $v_auction_date_list->FormKeyCountName ?>';

// Form_CustomValidate event
fv_auction_datelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_auction_datelist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

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
<?php } ?>
<?php if ($v_auction_date->Export == "") { ?>
<div class="ewToolbar">
<?php if ($v_auction_date_list->TotalRecs > 0 && $v_auction_date_list->ExportOptions->Visible()) { ?>
<?php $v_auction_date_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $v_auction_date_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_auction_date_list->TotalRecs <= 0)
			$v_auction_date_list->TotalRecs = $v_auction_date->ListRecordCount();
	} else {
		if (!$v_auction_date_list->Recordset && ($v_auction_date_list->Recordset = $v_auction_date_list->LoadRecordset()))
			$v_auction_date_list->TotalRecs = $v_auction_date_list->Recordset->RecordCount();
	}
	$v_auction_date_list->StartRec = 1;
	if ($v_auction_date_list->DisplayRecs <= 0 || ($v_auction_date->Export <> "" && $v_auction_date->ExportAll)) // Display all records
		$v_auction_date_list->DisplayRecs = $v_auction_date_list->TotalRecs;
	if (!($v_auction_date->Export <> "" && $v_auction_date->ExportAll))
		$v_auction_date_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_auction_date_list->Recordset = $v_auction_date_list->LoadRecordset($v_auction_date_list->StartRec-1, $v_auction_date_list->DisplayRecs);

	// Set no record found message
	if ($v_auction_date->CurrentAction == "" && $v_auction_date_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_auction_date_list->setWarningMessage(ew_DeniedMsg());
		if ($v_auction_date_list->SearchWhere == "0=101")
			$v_auction_date_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_auction_date_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$v_auction_date_list->RenderOtherOptions();
?>
<?php $v_auction_date_list->ShowPageHeader(); ?>
<?php
$v_auction_date_list->ShowMessage();
?>
<?php if ($v_auction_date_list->TotalRecs > 0 || $v_auction_date->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_auction_date_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_auction_date">
<?php if ($v_auction_date->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($v_auction_date->CurrentAction <> "gridadd" && $v_auction_date->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_auction_date_list->Pager)) $v_auction_date_list->Pager = new cPrevNextPager($v_auction_date_list->StartRec, $v_auction_date_list->DisplayRecs, $v_auction_date_list->TotalRecs, $v_auction_date_list->AutoHidePager) ?>
<?php if ($v_auction_date_list->Pager->RecordCount > 0 && $v_auction_date_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_auction_date_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_auction_date_list->PageUrl() ?>start=<?php echo $v_auction_date_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_auction_date_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_auction_date_list->PageUrl() ?>start=<?php echo $v_auction_date_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_auction_date_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_auction_date_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_auction_date_list->PageUrl() ?>start=<?php echo $v_auction_date_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_auction_date_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_auction_date_list->PageUrl() ?>start=<?php echo $v_auction_date_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_auction_date_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_auction_date_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_auction_date_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_auction_date_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_auction_date_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($v_auction_date_list->TotalRecs > 0 && (!$v_auction_date_list->AutoHidePageSizeSelector || $v_auction_date_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="v_auction_date">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($v_auction_date_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($v_auction_date_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($v_auction_date_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($v_auction_date_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($v_auction_date->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_auction_date_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fv_auction_datelist" id="fv_auction_datelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_auction_date_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_auction_date_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_auction_date">
<div id="gmp_v_auction_date" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_auction_date_list->TotalRecs > 0 || $v_auction_date->CurrentAction == "gridedit") { ?>
<table id="tbl_v_auction_datelist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_auction_date_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_auction_date_list->RenderListOptions();

// Render list options (header, left)
$v_auction_date_list->ListOptions->Render("header", "left");
?>
<?php if ($v_auction_date->auc_date->Visible) { // auc_date ?>
	<?php if ($v_auction_date->SortUrl($v_auction_date->auc_date) == "") { ?>
		<th data-name="auc_date" class="<?php echo $v_auction_date->auc_date->HeaderCellClass() ?>"><div id="elh_v_auction_date_auc_date" class="v_auction_date_auc_date"><div class="ewTableHeaderCaption"><?php echo $v_auction_date->auc_date->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auc_date" class="<?php echo $v_auction_date->auc_date->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_date->SortUrl($v_auction_date->auc_date) ?>',1);"><div id="elh_v_auction_date_auc_date" class="v_auction_date_auc_date">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_date->auc_date->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_date->auc_date->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_date->auc_date->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_date->SUM28tr_lelang_master_total_sack29->Visible) { // SUM(tr_lelang_master.total_sack) ?>
	<?php if ($v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_sack29) == "") { ?>
		<th data-name="SUM28tr_lelang_master_total_sack29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->HeaderCellClass() ?>"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_sack29" class="v_auction_date_SUM28tr_lelang_master_total_sack29"><div class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SUM28tr_lelang_master_total_sack29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_sack29) ?>',1);"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_sack29" class="v_auction_date_SUM28tr_lelang_master_total_sack29">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_date->SUM28tr_lelang_master_total_sack29->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_date->SUM28tr_lelang_master_total_sack29->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_date->SUM28tr_lelang_master_total_netto29->Visible) { // SUM(tr_lelang_master.total_netto) ?>
	<?php if ($v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_netto29) == "") { ?>
		<th data-name="SUM28tr_lelang_master_total_netto29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->HeaderCellClass() ?>"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_netto29" class="v_auction_date_SUM28tr_lelang_master_total_netto29"><div class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SUM28tr_lelang_master_total_netto29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_netto29) ?>',1);"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_netto29" class="v_auction_date_SUM28tr_lelang_master_total_netto29">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_date->SUM28tr_lelang_master_total_netto29->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_date->SUM28tr_lelang_master_total_netto29->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_date->SUM28tr_lelang_master_total_gross29->Visible) { // SUM(tr_lelang_master.total_gross) ?>
	<?php if ($v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_gross29) == "") { ?>
		<th data-name="SUM28tr_lelang_master_total_gross29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->HeaderCellClass() ?>"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_gross29" class="v_auction_date_SUM28tr_lelang_master_total_gross29"><div class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SUM28tr_lelang_master_total_gross29" class="<?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_date->SortUrl($v_auction_date->SUM28tr_lelang_master_total_gross29) ?>',1);"><div id="elh_v_auction_date_SUM28tr_lelang_master_total_gross29" class="v_auction_date_SUM28tr_lelang_master_total_gross29">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_date->SUM28tr_lelang_master_total_gross29->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_date->SUM28tr_lelang_master_total_gross29->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_auction_date->COUNT28tr_lelang_item_chop29->Visible) { // COUNT(tr_lelang_item.chop) ?>
	<?php if ($v_auction_date->SortUrl($v_auction_date->COUNT28tr_lelang_item_chop29) == "") { ?>
		<th data-name="COUNT28tr_lelang_item_chop29" class="<?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->HeaderCellClass() ?>"><div id="elh_v_auction_date_COUNT28tr_lelang_item_chop29" class="v_auction_date_COUNT28tr_lelang_item_chop29"><div class="ewTableHeaderCaption"><?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="COUNT28tr_lelang_item_chop29" class="<?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_auction_date->SortUrl($v_auction_date->COUNT28tr_lelang_item_chop29) ?>',1);"><div id="elh_v_auction_date_COUNT28tr_lelang_item_chop29" class="v_auction_date_COUNT28tr_lelang_item_chop29">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_auction_date->COUNT28tr_lelang_item_chop29->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_auction_date->COUNT28tr_lelang_item_chop29->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_auction_date_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_auction_date->ExportAll && $v_auction_date->Export <> "") {
	$v_auction_date_list->StopRec = $v_auction_date_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_auction_date_list->TotalRecs > $v_auction_date_list->StartRec + $v_auction_date_list->DisplayRecs - 1)
		$v_auction_date_list->StopRec = $v_auction_date_list->StartRec + $v_auction_date_list->DisplayRecs - 1;
	else
		$v_auction_date_list->StopRec = $v_auction_date_list->TotalRecs;
}
$v_auction_date_list->RecCnt = $v_auction_date_list->StartRec - 1;
if ($v_auction_date_list->Recordset && !$v_auction_date_list->Recordset->EOF) {
	$v_auction_date_list->Recordset->MoveFirst();
	$bSelectLimit = $v_auction_date_list->UseSelectLimit;
	if (!$bSelectLimit && $v_auction_date_list->StartRec > 1)
		$v_auction_date_list->Recordset->Move($v_auction_date_list->StartRec - 1);
} elseif (!$v_auction_date->AllowAddDeleteRow && $v_auction_date_list->StopRec == 0) {
	$v_auction_date_list->StopRec = $v_auction_date->GridAddRowCount;
}

// Initialize aggregate
$v_auction_date->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_auction_date->ResetAttrs();
$v_auction_date_list->RenderRow();
while ($v_auction_date_list->RecCnt < $v_auction_date_list->StopRec) {
	$v_auction_date_list->RecCnt++;
	if (intval($v_auction_date_list->RecCnt) >= intval($v_auction_date_list->StartRec)) {
		$v_auction_date_list->RowCnt++;

		// Set up key count
		$v_auction_date_list->KeyCount = $v_auction_date_list->RowIndex;

		// Init row class and style
		$v_auction_date->ResetAttrs();
		$v_auction_date->CssClass = "";
		if ($v_auction_date->CurrentAction == "gridadd") {
		} else {
			$v_auction_date_list->LoadRowValues($v_auction_date_list->Recordset); // Load row values
		}
		$v_auction_date->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$v_auction_date->RowAttrs = array_merge($v_auction_date->RowAttrs, array('data-rowindex'=>$v_auction_date_list->RowCnt, 'id'=>'r' . $v_auction_date_list->RowCnt . '_v_auction_date', 'data-rowtype'=>$v_auction_date->RowType));

		// Render row
		$v_auction_date_list->RenderRow();

		// Render list options
		$v_auction_date_list->RenderListOptions();
?>
	<tr<?php echo $v_auction_date->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_auction_date_list->ListOptions->Render("body", "left", $v_auction_date_list->RowCnt);
?>
	<?php if ($v_auction_date->auc_date->Visible) { // auc_date ?>
		<td data-name="auc_date"<?php echo $v_auction_date->auc_date->CellAttributes() ?>>
<span id="el<?php echo $v_auction_date_list->RowCnt ?>_v_auction_date_auc_date" class="v_auction_date_auc_date">
<span<?php echo $v_auction_date->auc_date->ViewAttributes() ?>>
<?php echo $v_auction_date->auc_date->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_date->SUM28tr_lelang_master_total_sack29->Visible) { // SUM(tr_lelang_master.total_sack) ?>
		<td data-name="SUM28tr_lelang_master_total_sack29"<?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->CellAttributes() ?>>
<span id="el<?php echo $v_auction_date_list->RowCnt ?>_v_auction_date_SUM28tr_lelang_master_total_sack29" class="v_auction_date_SUM28tr_lelang_master_total_sack29">
<span<?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->ViewAttributes() ?>>
<?php echo $v_auction_date->SUM28tr_lelang_master_total_sack29->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_date->SUM28tr_lelang_master_total_netto29->Visible) { // SUM(tr_lelang_master.total_netto) ?>
		<td data-name="SUM28tr_lelang_master_total_netto29"<?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->CellAttributes() ?>>
<span id="el<?php echo $v_auction_date_list->RowCnt ?>_v_auction_date_SUM28tr_lelang_master_total_netto29" class="v_auction_date_SUM28tr_lelang_master_total_netto29">
<span<?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->ViewAttributes() ?>>
<?php echo $v_auction_date->SUM28tr_lelang_master_total_netto29->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_date->SUM28tr_lelang_master_total_gross29->Visible) { // SUM(tr_lelang_master.total_gross) ?>
		<td data-name="SUM28tr_lelang_master_total_gross29"<?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->CellAttributes() ?>>
<span id="el<?php echo $v_auction_date_list->RowCnt ?>_v_auction_date_SUM28tr_lelang_master_total_gross29" class="v_auction_date_SUM28tr_lelang_master_total_gross29">
<span<?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->ViewAttributes() ?>>
<?php echo $v_auction_date->SUM28tr_lelang_master_total_gross29->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($v_auction_date->COUNT28tr_lelang_item_chop29->Visible) { // COUNT(tr_lelang_item.chop) ?>
		<td data-name="COUNT28tr_lelang_item_chop29"<?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->CellAttributes() ?>>
<span id="el<?php echo $v_auction_date_list->RowCnt ?>_v_auction_date_COUNT28tr_lelang_item_chop29" class="v_auction_date_COUNT28tr_lelang_item_chop29">
<span<?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->ViewAttributes() ?>>
<?php echo $v_auction_date->COUNT28tr_lelang_item_chop29->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_auction_date_list->ListOptions->Render("body", "right", $v_auction_date_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($v_auction_date->CurrentAction <> "gridadd")
		$v_auction_date_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_auction_date->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_auction_date_list->Recordset)
	$v_auction_date_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($v_auction_date_list->TotalRecs == 0 && $v_auction_date->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_auction_date_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($v_auction_date->Export == "") { ?>
<script type="text/javascript">
fv_auction_datelist.Init();
</script>
<?php } ?>
<?php
$v_auction_date_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($v_auction_date->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$v_auction_date_list->Page_Terminate();
?>
