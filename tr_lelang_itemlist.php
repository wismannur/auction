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

$tr_lelang_item_list = NULL; // Initialize page object first

class ctr_lelang_item_list extends ctr_lelang_item {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_item';

	// Page object name
	var $PageObjName = 'tr_lelang_item_list';

	// Grid form hidden field names
	var $FormName = 'ftr_lelang_itemlist';
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

		// Table object (tr_lelang_item)
		if (!isset($GLOBALS["tr_lelang_item"]) || get_class($GLOBALS["tr_lelang_item"]) == "ctr_lelang_item") {
			$GLOBALS["tr_lelang_item"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tr_lelang_item"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "tr_lelang_itemadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "tr_lelang_itemdelete.php";
		$this->MultiUpdateUrl = "tr_lelang_itemupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Table object (tr_lelang_master)
		if (!isset($GLOBALS['tr_lelang_master'])) $GLOBALS['tr_lelang_master'] = new ctr_lelang_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption ftr_lelang_itemlistsrch";

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

		// Create form object
		$objForm = new cFormObj();

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

		// Set up master detail parameters
		$this->SetupMasterParms();

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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "tr_lelang_master") {
			global $tr_lelang_master;
			$rsmaster = $tr_lelang_master->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("tr_lelang_masterlist.php"); // Return to master page
			} else {
				$tr_lelang_master->LoadListRowValues($rsmaster);
				$tr_lelang_master->RowType = EW_ROWTYPE_MASTER; // Master row
				$tr_lelang_master->RenderListRow();
				$rsmaster->Close();
			}
		}

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

	// Exit inline mode
	function ClearInlineMode() {
		$this->netto->FormValue = ""; // Clear form value
		$this->gross->FormValue = ""; // Clear form value
		$this->open_bid->FormValue = ""; // Clear form value
		$this->bid_step->FormValue = ""; // Clear form value
		$this->rate->FormValue = ""; // Clear form value
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->row_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_lot_number") && $objForm->HasValue("o_lot_number") && $this->lot_number->CurrentValue <> $this->lot_number->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_chop") && $objForm->HasValue("o_chop") && $this->chop->CurrentValue <> $this->chop->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_estate") && $objForm->HasValue("o_estate") && $this->estate->CurrentValue <> $this->estate->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_grade") && $objForm->HasValue("o_grade") && $this->grade->CurrentValue <> $this->grade->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_jenis") && $objForm->HasValue("o_jenis") && $this->jenis->CurrentValue <> $this->jenis->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_sack") && $objForm->HasValue("o_sack") && $this->sack->CurrentValue <> $this->sack->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_netto") && $objForm->HasValue("o_netto") && $this->netto->CurrentValue <> $this->netto->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_gross") && $objForm->HasValue("o_gross") && $this->gross->CurrentValue <> $this->gross->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_open_bid") && $objForm->HasValue("o_open_bid") && $this->open_bid->CurrentValue <> $this->open_bid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_currency") && $objForm->HasValue("o_currency") && $this->currency->CurrentValue <> $this->currency->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_bid_step") && $objForm->HasValue("o_bid_step") && $this->bid_step->CurrentValue <> $this->bid_step->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_rate") && $objForm->HasValue("o_rate") && $this->rate->CurrentValue <> $this->rate->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->lot_number); // lot_number
			$this->UpdateSort($this->chop); // chop
			$this->UpdateSort($this->estate); // estate
			$this->UpdateSort($this->grade); // grade
			$this->UpdateSort($this->jenis); // jenis
			$this->UpdateSort($this->sack); // sack
			$this->UpdateSort($this->netto); // netto
			$this->UpdateSort($this->gross); // gross
			$this->UpdateSort($this->open_bid); // open_bid
			$this->UpdateSort($this->currency); // currency
			$this->UpdateSort($this->bid_step); // bid_step
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->master_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->lot_number->setSort("");
				$this->chop->setSort("");
				$this->estate->setSort("");
				$this->grade->setSort("");
				$this->jenis->setSort("");
				$this->sack->setSort("");
				$this->netto->setSort("");
				$this->gross->setSort("");
				$this->open_bid->setSort("");
				$this->currency->setSort("");
				$this->bid_step->setSort("");
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

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "sequence"
		$oListOpt = &$this->ListOptions->Items["sequence"];
		$oListOpt->Body = ew_FormatSeqNo($this->RecCnt);

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . " onclick=\"return ew_ConfirmDelete(this);\"" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

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
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->row_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftr_lelang_itemlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftr_lelang_itemlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftr_lelang_itemlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$this->sack->OldValue = $this->sack->CurrentValue;
		$this->netto->CurrentValue = 0 ;
		$this->netto->OldValue = $this->netto->CurrentValue;
		$this->gross->CurrentValue = 0;
		$this->gross->OldValue = $this->gross->CurrentValue;
		$this->open_bid->CurrentValue = 0;
		$this->open_bid->OldValue = $this->open_bid->CurrentValue;
		$this->currency->CurrentValue = 'USC';
		$this->currency->OldValue = $this->currency->CurrentValue;
		$this->bid_step->CurrentValue = 1;
		$this->bid_step->OldValue = $this->bid_step->CurrentValue;
		$this->rate->CurrentValue = 1;
		$this->rate->OldValue = $this->rate->CurrentValue;
		$this->winner_id->CurrentValue = NULL;
		$this->winner_id->OldValue = $this->winner_id->CurrentValue;
		$this->sold_bid->CurrentValue = 0;
		$this->sold_bid->OldValue = $this->sold_bid->CurrentValue;
		$this->proforma_number->CurrentValue = NULL;
		$this->proforma_number->OldValue = $this->proforma_number->CurrentValue;
		$this->proforma_amount->CurrentValue = 0;
		$this->proforma_amount->OldValue = $this->proforma_amount->CurrentValue;
		$this->proforma_status->CurrentValue = NULL;
		$this->proforma_status->OldValue = $this->proforma_status->CurrentValue;
		$this->auction_status->CurrentValue = 'WD';
		$this->auction_status->OldValue = $this->auction_status->CurrentValue;
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
		$this->lot_number->setOldValue($objForm->GetValue("o_lot_number"));
		if (!$this->chop->FldIsDetailKey) {
			$this->chop->setFormValue($objForm->GetValue("x_chop"));
		}
		$this->chop->setOldValue($objForm->GetValue("o_chop"));
		if (!$this->estate->FldIsDetailKey) {
			$this->estate->setFormValue($objForm->GetValue("x_estate"));
		}
		$this->estate->setOldValue($objForm->GetValue("o_estate"));
		if (!$this->grade->FldIsDetailKey) {
			$this->grade->setFormValue($objForm->GetValue("x_grade"));
		}
		$this->grade->setOldValue($objForm->GetValue("o_grade"));
		if (!$this->jenis->FldIsDetailKey) {
			$this->jenis->setFormValue($objForm->GetValue("x_jenis"));
		}
		$this->jenis->setOldValue($objForm->GetValue("o_jenis"));
		if (!$this->sack->FldIsDetailKey) {
			$this->sack->setFormValue($objForm->GetValue("x_sack"));
		}
		$this->sack->setOldValue($objForm->GetValue("o_sack"));
		if (!$this->netto->FldIsDetailKey) {
			$this->netto->setFormValue($objForm->GetValue("x_netto"));
		}
		$this->netto->setOldValue($objForm->GetValue("o_netto"));
		if (!$this->gross->FldIsDetailKey) {
			$this->gross->setFormValue($objForm->GetValue("x_gross"));
		}
		$this->gross->setOldValue($objForm->GetValue("o_gross"));
		if (!$this->open_bid->FldIsDetailKey) {
			$this->open_bid->setFormValue($objForm->GetValue("x_open_bid"));
		}
		$this->open_bid->setOldValue($objForm->GetValue("o_open_bid"));
		if (!$this->currency->FldIsDetailKey) {
			$this->currency->setFormValue($objForm->GetValue("x_currency"));
		}
		$this->currency->setOldValue($objForm->GetValue("o_currency"));
		if (!$this->bid_step->FldIsDetailKey) {
			$this->bid_step->setFormValue($objForm->GetValue("x_bid_step"));
		}
		$this->bid_step->setOldValue($objForm->GetValue("o_bid_step"));
		if (!$this->rate->FldIsDetailKey) {
			$this->rate->setFormValue($objForm->GetValue("x_rate"));
		}
		$this->rate->setOldValue($objForm->GetValue("o_rate"));
		if (!$this->row_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->row_id->CurrentValue = $this->row_id->FormValue;
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
			if (strval($this->netto->EditValue) <> "" && is_numeric($this->netto->EditValue)) {
			$this->netto->EditValue = ew_FormatNumber($this->netto->EditValue, -2, -2, -2, -2);
			$this->netto->OldValue = $this->netto->EditValue;
			}

			// gross
			$this->gross->EditAttrs["class"] = "form-control";
			$this->gross->EditCustomAttributes = "";
			$this->gross->EditValue = ew_HtmlEncode($this->gross->CurrentValue);
			$this->gross->PlaceHolder = ew_RemoveHtml($this->gross->FldCaption());
			if (strval($this->gross->EditValue) <> "" && is_numeric($this->gross->EditValue)) {
			$this->gross->EditValue = ew_FormatNumber($this->gross->EditValue, -2, -2, -2, -2);
			$this->gross->OldValue = $this->gross->EditValue;
			}

			// open_bid
			$this->open_bid->EditAttrs["class"] = "form-control";
			$this->open_bid->EditCustomAttributes = "";
			$this->open_bid->EditValue = ew_HtmlEncode($this->open_bid->CurrentValue);
			$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());
			if (strval($this->open_bid->EditValue) <> "" && is_numeric($this->open_bid->EditValue)) {
			$this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -2, -2, -2);
			$this->open_bid->OldValue = $this->open_bid->EditValue;
			}

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
			if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) {
			$this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);
			$this->bid_step->OldValue = $this->bid_step->EditValue;
			}

			// rate
			$this->rate->EditAttrs["class"] = "form-control";
			$this->rate->EditCustomAttributes = "";
			$this->rate->EditValue = ew_HtmlEncode($this->rate->CurrentValue);
			$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
			if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) {
			$this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);
			$this->rate->OldValue = $this->rate->EditValue;
			}

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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
			if (strval($this->netto->EditValue) <> "" && is_numeric($this->netto->EditValue)) {
			$this->netto->EditValue = ew_FormatNumber($this->netto->EditValue, -2, -2, -2, -2);
			$this->netto->OldValue = $this->netto->EditValue;
			}

			// gross
			$this->gross->EditAttrs["class"] = "form-control";
			$this->gross->EditCustomAttributes = "";
			$this->gross->EditValue = ew_HtmlEncode($this->gross->CurrentValue);
			$this->gross->PlaceHolder = ew_RemoveHtml($this->gross->FldCaption());
			if (strval($this->gross->EditValue) <> "" && is_numeric($this->gross->EditValue)) {
			$this->gross->EditValue = ew_FormatNumber($this->gross->EditValue, -2, -2, -2, -2);
			$this->gross->OldValue = $this->gross->EditValue;
			}

			// open_bid
			$this->open_bid->EditAttrs["class"] = "form-control";
			$this->open_bid->EditCustomAttributes = "";
			$this->open_bid->EditValue = ew_HtmlEncode($this->open_bid->CurrentValue);
			$this->open_bid->PlaceHolder = ew_RemoveHtml($this->open_bid->FldCaption());
			if (strval($this->open_bid->EditValue) <> "" && is_numeric($this->open_bid->EditValue)) {
			$this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -2, -2, -2);
			$this->open_bid->OldValue = $this->open_bid->EditValue;
			}

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
			if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) {
			$this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);
			$this->bid_step->OldValue = $this->bid_step->EditValue;
			}

			// rate
			$this->rate->EditAttrs["class"] = "form-control";
			$this->rate->EditCustomAttributes = "";
			$this->rate->EditValue = ew_HtmlEncode($this->rate->CurrentValue);
			$this->rate->PlaceHolder = ew_RemoveHtml($this->rate->FldCaption());
			if (strval($this->rate->EditValue) <> "" && is_numeric($this->rate->EditValue)) {
			$this->rate->EditValue = ew_FormatNumber($this->rate->EditValue, -2, -1, -2, 0);
			$this->rate->OldValue = $this->rate->EditValue;
			}

			// Edit refer script
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['row_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// lot_number
			$this->lot_number->SetDbValueDef($rsnew, $this->lot_number->CurrentValue, NULL, $this->lot_number->ReadOnly);

			// chop
			$this->chop->SetDbValueDef($rsnew, $this->chop->CurrentValue, NULL, $this->chop->ReadOnly);

			// estate
			$this->estate->SetDbValueDef($rsnew, $this->estate->CurrentValue, NULL, $this->estate->ReadOnly);

			// grade
			$this->grade->SetDbValueDef($rsnew, $this->grade->CurrentValue, NULL, $this->grade->ReadOnly);

			// jenis
			$this->jenis->SetDbValueDef($rsnew, $this->jenis->CurrentValue, NULL, $this->jenis->ReadOnly);

			// sack
			$this->sack->SetDbValueDef($rsnew, $this->sack->CurrentValue, NULL, $this->sack->ReadOnly);

			// netto
			$this->netto->SetDbValueDef($rsnew, $this->netto->CurrentValue, NULL, $this->netto->ReadOnly);

			// gross
			$this->gross->SetDbValueDef($rsnew, $this->gross->CurrentValue, NULL, $this->gross->ReadOnly);

			// open_bid
			$this->open_bid->SetDbValueDef($rsnew, $this->open_bid->CurrentValue, NULL, $this->open_bid->ReadOnly);

			// currency
			$this->currency->SetDbValueDef($rsnew, $this->currency->CurrentValue, NULL, $this->currency->ReadOnly);

			// bid_step
			$this->bid_step->SetDbValueDef($rsnew, $this->bid_step->CurrentValue, NULL, $this->bid_step->ReadOnly);

			// rate
			$this->rate->SetDbValueDef($rsnew, $this->rate->CurrentValue, NULL, $this->rate->ReadOnly);

			// Check referential integrity for master table 'tr_lelang_master'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_tr_lelang_master();
			$KeyValue = isset($rsnew['master_id']) ? $rsnew['master_id'] : $rsold['master_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@row_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
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
				$rs->Close();
				return FALSE;
			}

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
		$item->Body = "<button id=\"emf_tr_lelang_item\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_tr_lelang_item',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftr_lelang_itemlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "tr_lelang_master") {
			global $tr_lelang_master;
			if (!isset($tr_lelang_master)) $tr_lelang_master = new ctr_lelang_master;
			$rsmaster = $tr_lelang_master->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$tr_lelang_master;
					$tr_lelang_master->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

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
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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
if (!isset($tr_lelang_item_list)) $tr_lelang_item_list = new ctr_lelang_item_list();

// Page init
$tr_lelang_item_list->Page_Init();

// Page main
$tr_lelang_item_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_item_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftr_lelang_itemlist = new ew_Form("ftr_lelang_itemlist", "list");
ftr_lelang_itemlist.FormKeyCountName = '<?php echo $tr_lelang_item_list->FormKeyCountName ?>';

// Validate form
ftr_lelang_itemlist.Validate = function() {
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
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
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

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
ftr_lelang_itemlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "lot_number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "chop", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "grade", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jenis", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sack", false)) return false;
	if (ew_ValueChanged(fobj, infix, "netto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gross", false)) return false;
	if (ew_ValueChanged(fobj, infix, "open_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_step", false)) return false;
	if (ew_ValueChanged(fobj, infix, "rate", false)) return false;
	return true;
}

// Form_CustomValidate event
ftr_lelang_itemlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ftr_lelang_itemlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ftr_lelang_itemlist.Lists["x_currency"] = {"LinkField":"x_id_cur","Ajax":true,"AutoFill":true,"DisplayFields":["x_currency","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tbl_currency"};
ftr_lelang_itemlist.Lists["x_currency"].Data = "<?php echo $tr_lelang_item_list->currency->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
</script>
<script type="text/javascript" src="phpjs/ewscrolltable.js"></script>
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
<?php if ($tr_lelang_item->Export == "") { ?>
<div class="ewToolbar">
<?php if ($tr_lelang_item_list->TotalRecs > 0 && $tr_lelang_item_list->ExportOptions->Visible()) { ?>
<?php $tr_lelang_item_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($tr_lelang_item->Export == "") || (EW_EXPORT_MASTER_RECORD && $tr_lelang_item->Export == "print")) { ?>
<?php
if ($tr_lelang_item_list->DbMasterFilter <> "" && $tr_lelang_item->getCurrentMasterTable() == "tr_lelang_master") {
	if ($tr_lelang_item_list->MasterRecordExists) {
?>
<?php include_once "tr_lelang_mastermaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($tr_lelang_item->CurrentAction == "gridadd") {
	$tr_lelang_item->CurrentFilter = "0=1";
	$tr_lelang_item_list->StartRec = 1;
	$tr_lelang_item_list->DisplayRecs = $tr_lelang_item->GridAddRowCount;
	$tr_lelang_item_list->TotalRecs = $tr_lelang_item_list->DisplayRecs;
	$tr_lelang_item_list->StopRec = $tr_lelang_item_list->DisplayRecs;
} else {
	$bSelectLimit = $tr_lelang_item_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($tr_lelang_item_list->TotalRecs <= 0)
			$tr_lelang_item_list->TotalRecs = $tr_lelang_item->ListRecordCount();
	} else {
		if (!$tr_lelang_item_list->Recordset && ($tr_lelang_item_list->Recordset = $tr_lelang_item_list->LoadRecordset()))
			$tr_lelang_item_list->TotalRecs = $tr_lelang_item_list->Recordset->RecordCount();
	}
	$tr_lelang_item_list->StartRec = 1;
	if ($tr_lelang_item_list->DisplayRecs <= 0 || ($tr_lelang_item->Export <> "" && $tr_lelang_item->ExportAll)) // Display all records
		$tr_lelang_item_list->DisplayRecs = $tr_lelang_item_list->TotalRecs;
	if (!($tr_lelang_item->Export <> "" && $tr_lelang_item->ExportAll))
		$tr_lelang_item_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$tr_lelang_item_list->Recordset = $tr_lelang_item_list->LoadRecordset($tr_lelang_item_list->StartRec-1, $tr_lelang_item_list->DisplayRecs);

	// Set no record found message
	if ($tr_lelang_item->CurrentAction == "" && $tr_lelang_item_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$tr_lelang_item_list->setWarningMessage(ew_DeniedMsg());
		if ($tr_lelang_item_list->SearchWhere == "0=101")
			$tr_lelang_item_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tr_lelang_item_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tr_lelang_item_list->RenderOtherOptions();
?>
<?php $tr_lelang_item_list->ShowPageHeader(); ?>
<?php
$tr_lelang_item_list->ShowMessage();
?>
<?php if ($tr_lelang_item_list->TotalRecs > 0 || $tr_lelang_item->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($tr_lelang_item_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> tr_lelang_item">
<?php if ($tr_lelang_item->Export == "") { ?>
<div class="box-header ewGridUpperPanel">
<?php if ($tr_lelang_item->CurrentAction <> "gridadd" && $tr_lelang_item->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($tr_lelang_item_list->Pager)) $tr_lelang_item_list->Pager = new cPrevNextPager($tr_lelang_item_list->StartRec, $tr_lelang_item_list->DisplayRecs, $tr_lelang_item_list->TotalRecs, $tr_lelang_item_list->AutoHidePager) ?>
<?php if ($tr_lelang_item_list->Pager->RecordCount > 0 && $tr_lelang_item_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($tr_lelang_item_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $tr_lelang_item_list->PageUrl() ?>start=<?php echo $tr_lelang_item_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tr_lelang_item_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $tr_lelang_item_list->PageUrl() ?>start=<?php echo $tr_lelang_item_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $tr_lelang_item_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($tr_lelang_item_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $tr_lelang_item_list->PageUrl() ?>start=<?php echo $tr_lelang_item_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tr_lelang_item_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $tr_lelang_item_list->PageUrl() ?>start=<?php echo $tr_lelang_item_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $tr_lelang_item_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($tr_lelang_item_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tr_lelang_item_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tr_lelang_item_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tr_lelang_item_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($tr_lelang_item_list->TotalRecs > 0 && (!$tr_lelang_item_list->AutoHidePageSizeSelector || $tr_lelang_item_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="tr_lelang_item">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="10"<?php if ($tr_lelang_item_list->DisplayRecs == 10) { ?> selected<?php } ?>>10</option>
<option value="20"<?php if ($tr_lelang_item_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="50"<?php if ($tr_lelang_item_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="100"<?php if ($tr_lelang_item_list->DisplayRecs == 100) { ?> selected<?php } ?>>100</option>
<option value="ALL"<?php if ($tr_lelang_item->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tr_lelang_item_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftr_lelang_itemlist" id="ftr_lelang_itemlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tr_lelang_item_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tr_lelang_item_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tr_lelang_item">
<?php if ($tr_lelang_item->getCurrentMasterTable() == "tr_lelang_master" && $tr_lelang_item->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tr_lelang_master">
<input type="hidden" name="fk_row_id" value="<?php echo $tr_lelang_item->master_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_tr_lelang_item" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($tr_lelang_item_list->TotalRecs > 0 || $tr_lelang_item->CurrentAction == "gridedit") { ?>
<table id="tbl_tr_lelang_itemlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$tr_lelang_item_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$tr_lelang_item_list->RenderListOptions();

// Render list options (header, left)
$tr_lelang_item_list->ListOptions->Render("header", "left");
?>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->lot_number) ?>',1);"><div id="elh_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_chop" class="tr_lelang_item_chop"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->chop) ?>',1);"><div id="elh_tr_lelang_item_chop" class="tr_lelang_item_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->chop->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_estate" class="tr_lelang_item_estate"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->estate) ?>',1);"><div id="elh_tr_lelang_item_estate" class="tr_lelang_item_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->estate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_grade" class="tr_lelang_item_grade"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->grade) ?>',1);"><div id="elh_tr_lelang_item_grade" class="tr_lelang_item_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->grade->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->jenis) == "") { ?>
		<th data-name="jenis" class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_jenis" class="tr_lelang_item_jenis"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->jenis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis" class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->jenis) ?>',1);"><div id="elh_tr_lelang_item_jenis" class="tr_lelang_item_jenis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->jenis->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_sack" class="tr_lelang_item_sack"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->sack) ?>',1);"><div id="elh_tr_lelang_item_sack" class="tr_lelang_item_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->netto) == "") { ?>
		<th data-name="netto" class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_netto" class="tr_lelang_item_netto"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->netto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="netto" class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->netto) ?>',1);"><div id="elh_tr_lelang_item_netto" class="tr_lelang_item_netto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->netto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->netto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->netto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->gross) == "") { ?>
		<th data-name="gross" class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_gross" class="tr_lelang_item_gross"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->gross->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gross" class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->gross) ?>',1);"><div id="elh_tr_lelang_item_gross" class="tr_lelang_item_gross">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->gross->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->gross->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->gross->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->open_bid) == "") { ?>
		<th data-name="open_bid" class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="open_bid" class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->open_bid) ?>',1);"><div id="elh_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->open_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->open_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->currency) == "") { ?>
		<th data-name="currency" class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_currency" class="tr_lelang_item_currency"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->currency->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency" class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->currency) ?>',1);"><div id="elh_tr_lelang_item_currency" class="tr_lelang_item_currency">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->currency->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->currency->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->currency->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->bid_step) == "") { ?>
		<th data-name="bid_step" class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_step" class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->bid_step) ?>',1);"><div id="elh_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->bid_step->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->bid_step->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->rate) == "") { ?>
		<th data-name="rate" class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><div id="elh_tr_lelang_item_rate" class="tr_lelang_item_rate"><div class="ewTableHeaderCaption"><?php echo $tr_lelang_item->rate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="rate" class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $tr_lelang_item->SortUrl($tr_lelang_item->rate) ?>',1);"><div id="elh_tr_lelang_item_rate" class="tr_lelang_item_rate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->rate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tr_lelang_item->rate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item->rate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tr_lelang_item_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($tr_lelang_item->ExportAll && $tr_lelang_item->Export <> "") {
	$tr_lelang_item_list->StopRec = $tr_lelang_item_list->TotalRecs;
} else {

	// Set the last record to display
	if ($tr_lelang_item_list->TotalRecs > $tr_lelang_item_list->StartRec + $tr_lelang_item_list->DisplayRecs - 1)
		$tr_lelang_item_list->StopRec = $tr_lelang_item_list->StartRec + $tr_lelang_item_list->DisplayRecs - 1;
	else
		$tr_lelang_item_list->StopRec = $tr_lelang_item_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tr_lelang_item_list->FormKeyCountName) && ($tr_lelang_item->CurrentAction == "gridadd" || $tr_lelang_item->CurrentAction == "gridedit" || $tr_lelang_item->CurrentAction == "F")) {
		$tr_lelang_item_list->KeyCount = $objForm->GetValue($tr_lelang_item_list->FormKeyCountName);
		$tr_lelang_item_list->StopRec = $tr_lelang_item_list->StartRec + $tr_lelang_item_list->KeyCount - 1;
	}
}
$tr_lelang_item_list->RecCnt = $tr_lelang_item_list->StartRec - 1;
if ($tr_lelang_item_list->Recordset && !$tr_lelang_item_list->Recordset->EOF) {
	$tr_lelang_item_list->Recordset->MoveFirst();
	$bSelectLimit = $tr_lelang_item_list->UseSelectLimit;
	if (!$bSelectLimit && $tr_lelang_item_list->StartRec > 1)
		$tr_lelang_item_list->Recordset->Move($tr_lelang_item_list->StartRec - 1);
} elseif (!$tr_lelang_item->AllowAddDeleteRow && $tr_lelang_item_list->StopRec == 0) {
	$tr_lelang_item_list->StopRec = $tr_lelang_item->GridAddRowCount;
}

// Initialize aggregate
$tr_lelang_item->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tr_lelang_item->ResetAttrs();
$tr_lelang_item_list->RenderRow();
if ($tr_lelang_item->CurrentAction == "gridadd")
	$tr_lelang_item_list->RowIndex = 0;
if ($tr_lelang_item->CurrentAction == "gridedit")
	$tr_lelang_item_list->RowIndex = 0;
while ($tr_lelang_item_list->RecCnt < $tr_lelang_item_list->StopRec) {
	$tr_lelang_item_list->RecCnt++;
	if (intval($tr_lelang_item_list->RecCnt) >= intval($tr_lelang_item_list->StartRec)) {
		$tr_lelang_item_list->RowCnt++;
		if ($tr_lelang_item->CurrentAction == "gridadd" || $tr_lelang_item->CurrentAction == "gridedit" || $tr_lelang_item->CurrentAction == "F") {
			$tr_lelang_item_list->RowIndex++;
			$objForm->Index = $tr_lelang_item_list->RowIndex;
			if ($objForm->HasValue($tr_lelang_item_list->FormActionName))
				$tr_lelang_item_list->RowAction = strval($objForm->GetValue($tr_lelang_item_list->FormActionName));
			elseif ($tr_lelang_item->CurrentAction == "gridadd")
				$tr_lelang_item_list->RowAction = "insert";
			else
				$tr_lelang_item_list->RowAction = "";
		}

		// Set up key count
		$tr_lelang_item_list->KeyCount = $tr_lelang_item_list->RowIndex;

		// Init row class and style
		$tr_lelang_item->ResetAttrs();
		$tr_lelang_item->CssClass = "";
		if ($tr_lelang_item->CurrentAction == "gridadd") {
			$tr_lelang_item_list->LoadRowValues(); // Load default values
		} else {
			$tr_lelang_item_list->LoadRowValues($tr_lelang_item_list->Recordset); // Load row values
		}
		$tr_lelang_item->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tr_lelang_item->CurrentAction == "gridadd") // Grid add
			$tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tr_lelang_item->CurrentAction == "gridadd" && $tr_lelang_item->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tr_lelang_item_list->RestoreCurrentRowFormValues($tr_lelang_item_list->RowIndex); // Restore form values
		if ($tr_lelang_item->CurrentAction == "gridedit") { // Grid edit
			if ($tr_lelang_item->EventCancelled) {
				$tr_lelang_item_list->RestoreCurrentRowFormValues($tr_lelang_item_list->RowIndex); // Restore form values
			}
			if ($tr_lelang_item_list->RowAction == "insert")
				$tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tr_lelang_item->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tr_lelang_item->CurrentAction == "gridedit" && ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $tr_lelang_item->RowType == EW_ROWTYPE_ADD) && $tr_lelang_item->EventCancelled) // Update failed
			$tr_lelang_item_list->RestoreCurrentRowFormValues($tr_lelang_item_list->RowIndex); // Restore form values
		if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tr_lelang_item_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$tr_lelang_item->RowAttrs = array_merge($tr_lelang_item->RowAttrs, array('data-rowindex'=>$tr_lelang_item_list->RowCnt, 'id'=>'r' . $tr_lelang_item_list->RowCnt . '_tr_lelang_item', 'data-rowtype'=>$tr_lelang_item->RowType));

		// Render row
		$tr_lelang_item_list->RenderRow();

		// Render list options
		$tr_lelang_item_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tr_lelang_item_list->RowAction <> "delete" && $tr_lelang_item_list->RowAction <> "insertdelete" && !($tr_lelang_item_list->RowAction == "insert" && $tr_lelang_item->CurrentAction == "F" && $tr_lelang_item_list->EmptyRow())) {
?>
	<tr<?php echo $tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tr_lelang_item_list->ListOptions->Render("body", "left", $tr_lelang_item_list->RowCnt);
?>
	<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_lot_number" class="tr_lelang_item_lot_number">
<span<?php echo $tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $tr_lelang_item->lot_number->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->CurrentValue) ?>">
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $tr_lelang_item->CurrentMode == "edit") { ?>
<input type="hidden" data-table="tr_lelang_item" data-field="x_row_id" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($tr_lelang_item->row_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_chop" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_chop" class="tr_lelang_item_chop">
<span<?php echo $tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $tr_lelang_item->chop->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_estate" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_estate" class="tr_lelang_item_estate">
<span<?php echo $tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->estate->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_grade" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_grade" class="tr_lelang_item_grade">
<span<?php echo $tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $tr_lelang_item->grade->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis"<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_jenis" class="tr_lelang_item_jenis">
<span<?php echo $tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $tr_lelang_item->jenis->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_sack" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_sack" class="tr_lelang_item_sack">
<span<?php echo $tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $tr_lelang_item->sack->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<td data-name="netto"<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_netto" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_netto" class="tr_lelang_item_netto">
<span<?php echo $tr_lelang_item->netto->ViewAttributes() ?>>
<?php echo $tr_lelang_item->netto->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross"<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_gross" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_gross" class="tr_lelang_item_gross">
<span<?php echo $tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $tr_lelang_item->gross->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid"<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_open_bid" class="tr_lelang_item_open_bid">
<span<?php echo $tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_item->open_bid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency"<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step">
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step">
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_currency" class="tr_lelang_item_currency">
<span<?php echo $tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $tr_lelang_item->currency->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step"<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_bid_step" class="tr_lelang_item_bid_step">
<span<?php echo $tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $tr_lelang_item->bid_step->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<td data-name="rate"<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_rate" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $tr_lelang_item_list->RowCnt ?>_tr_lelang_item_rate" class="tr_lelang_item_rate">
<span<?php echo $tr_lelang_item->rate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->rate->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tr_lelang_item_list->ListOptions->Render("body", "right", $tr_lelang_item_list->RowCnt);
?>
	</tr>
<?php if ($tr_lelang_item->RowType == EW_ROWTYPE_ADD || $tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftr_lelang_itemlist.UpdateOpts(<?php echo $tr_lelang_item_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tr_lelang_item->CurrentAction <> "gridadd")
		if (!$tr_lelang_item_list->Recordset->EOF) $tr_lelang_item_list->Recordset->MoveNext();
}
?>
<?php
	if ($tr_lelang_item->CurrentAction == "gridadd" || $tr_lelang_item->CurrentAction == "gridedit") {
		$tr_lelang_item_list->RowIndex = '$rowindex$';
		$tr_lelang_item_list->LoadRowValues();

		// Set row properties
		$tr_lelang_item->ResetAttrs();
		$tr_lelang_item->RowAttrs = array_merge($tr_lelang_item->RowAttrs, array('data-rowindex'=>$tr_lelang_item_list->RowIndex, 'id'=>'r0_tr_lelang_item', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tr_lelang_item->RowAttrs["class"], "ewTemplate");
		$tr_lelang_item->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tr_lelang_item_list->RenderRow();

		// Render list options
		$tr_lelang_item_list->RenderListOptions();
		$tr_lelang_item_list->StartRowCnt = 0;
?>
	<tr<?php echo $tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tr_lelang_item_list->ListOptions->Render("body", "left", $tr_lelang_item_list->RowIndex);
?>
	<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number">
<span id="el$rowindex$_tr_lelang_item_lot_number" class="form-group tr_lelang_item_lot_number">
<input type="text" data-table="tr_lelang_item" data-field="x_lot_number" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->lot_number->EditValue ?>"<?php echo $tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_lot_number" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($tr_lelang_item->lot_number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop">
<span id="el$rowindex$_tr_lelang_item_chop" class="form-group tr_lelang_item_chop">
<input type="text" data-table="tr_lelang_item" data-field="x_chop" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_chop" size="10" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->chop->EditValue ?>"<?php echo $tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_chop" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_chop" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($tr_lelang_item->chop->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate">
<span id="el$rowindex$_tr_lelang_item_estate" class="form-group tr_lelang_item_estate">
<input type="text" data-table="tr_lelang_item" data-field="x_estate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_estate" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->estate->EditValue ?>"<?php echo $tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_estate" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_estate" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($tr_lelang_item->estate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade">
<span id="el$rowindex$_tr_lelang_item_grade" class="form-group tr_lelang_item_grade">
<input type="text" data-table="tr_lelang_item" data-field="x_grade" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_grade" size="15" maxlength="100" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->grade->EditValue ?>"<?php echo $tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_grade" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_grade" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($tr_lelang_item->grade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis">
<span id="el$rowindex$_tr_lelang_item_jenis" class="form-group tr_lelang_item_jenis">
<input type="text" data-table="tr_lelang_item" data-field="x_jenis" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" size="15" maxlength="50" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->jenis->EditValue ?>"<?php echo $tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_jenis" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($tr_lelang_item->jenis->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack">
<span id="el$rowindex$_tr_lelang_item_sack" class="form-group tr_lelang_item_sack">
<input type="text" data-table="tr_lelang_item" data-field="x_sack" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_sack" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->sack->EditValue ?>"<?php echo $tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_sack" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_sack" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($tr_lelang_item->sack->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<td data-name="netto">
<span id="el$rowindex$_tr_lelang_item_netto" class="form-group tr_lelang_item_netto">
<input type="text" data-table="tr_lelang_item" data-field="x_netto" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_netto" size="5" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->netto->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->netto->EditValue ?>"<?php echo $tr_lelang_item->netto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_netto" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_netto" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_netto" value="<?php echo ew_HtmlEncode($tr_lelang_item->netto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross">
<span id="el$rowindex$_tr_lelang_item_gross" class="form-group tr_lelang_item_gross">
<input type="text" data-table="tr_lelang_item" data-field="x_gross" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_gross" size="6" maxlength="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->gross->EditValue ?>"<?php echo $tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_gross" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_gross" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($tr_lelang_item->gross->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid">
<span id="el$rowindex$_tr_lelang_item_open_bid" class="form-group tr_lelang_item_open_bid">
<input type="text" data-table="tr_lelang_item" data-field="x_open_bid" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" size="7" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->open_bid->EditValue ?>"<?php echo $tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_open_bid" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($tr_lelang_item->open_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency">
<span id="el$rowindex$_tr_lelang_item_currency" class="form-group tr_lelang_item_currency">
<?php $tr_lelang_item->currency->EditAttrs["onclick"] = "ew_AutoFill(this); " . @$tr_lelang_item->currency->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
<input type="hidden" name="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="ln_x<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step">
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_currency" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_currency" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($tr_lelang_item->currency->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step">
<span id="el$rowindex$_tr_lelang_item_bid_step" class="form-group tr_lelang_item_bid_step">
<input type="text" data-table="tr_lelang_item" data-field="x_bid_step" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" size="6" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->bid_step->EditValue ?>"<?php echo $tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_bid_step" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($tr_lelang_item->bid_step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<td data-name="rate">
<span id="el$rowindex$_tr_lelang_item_rate" class="form-group tr_lelang_item_rate">
<input type="text" data-table="tr_lelang_item" data-field="x_rate" name="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" id="x<?php echo $tr_lelang_item_list->RowIndex ?>_rate" size="10" placeholder="<?php echo ew_HtmlEncode($tr_lelang_item->rate->getPlaceHolder()) ?>" value="<?php echo $tr_lelang_item->rate->EditValue ?>"<?php echo $tr_lelang_item->rate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="tr_lelang_item" data-field="x_rate" name="o<?php echo $tr_lelang_item_list->RowIndex ?>_rate" id="o<?php echo $tr_lelang_item_list->RowIndex ?>_rate" value="<?php echo ew_HtmlEncode($tr_lelang_item->rate->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tr_lelang_item_list->ListOptions->Render("body", "right", $tr_lelang_item_list->RowIndex);
?>
<script type="text/javascript">
ftr_lelang_itemlist.UpdateOpts(<?php echo $tr_lelang_item_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($tr_lelang_item->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tr_lelang_item_list->FormKeyCountName ?>" id="<?php echo $tr_lelang_item_list->FormKeyCountName ?>" value="<?php echo $tr_lelang_item_list->KeyCount ?>">
<?php echo $tr_lelang_item_list->MultiSelectKey ?>
<?php } ?>
<?php if ($tr_lelang_item->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tr_lelang_item_list->FormKeyCountName ?>" id="<?php echo $tr_lelang_item_list->FormKeyCountName ?>" value="<?php echo $tr_lelang_item_list->KeyCount ?>">
<?php echo $tr_lelang_item_list->MultiSelectKey ?>
<?php } ?>
<?php if ($tr_lelang_item->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($tr_lelang_item_list->Recordset)
	$tr_lelang_item_list->Recordset->Close();
?>
</div>
<?php } ?>
<?php if ($tr_lelang_item_list->TotalRecs == 0 && $tr_lelang_item->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tr_lelang_item_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">
ftr_lelang_itemlist.Init();
</script>
<?php } ?>
<?php
$tr_lelang_item_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php if ($tr_lelang_item->Export == "") { ?>
<script type="text/javascript">
ew_ScrollableTable("gmp_tr_lelang_item", "100%", "310px");
</script>
<?php } ?>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$tr_lelang_item_list->Page_Terminate();
?>
