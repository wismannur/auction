<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "v_tr_lelang_iteminfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php include_once "v_tr_lelang_masterinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$v_tr_lelang_item_list = NULL; // Initialize page object first

class cv_tr_lelang_item_list extends cv_tr_lelang_item {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_tr_lelang_item';

	// Page object name
	var $PageObjName = 'v_tr_lelang_item_list';

	// Grid form hidden field names
	var $FormName = 'fv_tr_lelang_itemlist';
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

		// Table object (v_tr_lelang_item)
		if (!isset($GLOBALS["v_tr_lelang_item"]) || get_class($GLOBALS["v_tr_lelang_item"]) == "cv_tr_lelang_item") {
			$GLOBALS["v_tr_lelang_item"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["v_tr_lelang_item"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "v_tr_lelang_itemadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "v_tr_lelang_itemdelete.php";
		$this->MultiUpdateUrl = "v_tr_lelang_itemupdate.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Table object (v_tr_lelang_master)
		if (!isset($GLOBALS['v_tr_lelang_master'])) $GLOBALS['v_tr_lelang_master'] = new cv_tr_lelang_master();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'v_tr_lelang_item', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fv_tr_lelang_itemlistsrch";

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
		$this->req_sample->SetVisibility();
		$this->lot_number->SetVisibility();
		$this->chop->SetVisibility();
		$this->estate->SetVisibility();
		$this->grade->SetVisibility();
		$this->jenis->SetVisibility();
		$this->sack->SetVisibility();
		$this->gross->SetVisibility();
		$this->open_bid->SetVisibility();
		$this->bid_step->SetVisibility();
		$this->currency->SetVisibility();
		$this->last_bid->SetVisibility();
		$this->highest_bid->SetVisibility();
		$this->bid_val->SetVisibility();
		$this->btn_bid->SetVisibility();
		$this->auction_status->SetVisibility();
		$this->winner_id->SetVisibility();
		$this->check_list->SetVisibility();

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
		global $EW_EXPORT, $v_tr_lelang_item;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($v_tr_lelang_item);
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
	var $DisplayRecs = 0;
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
			$this->DisplayRecs = 0; // Load default
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "v_tr_lelang_master") {
			global $v_tr_lelang_master;
			$rsmaster = $v_tr_lelang_master->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("v_tr_lelang_masterlist.php"); // Return to master page
			} else {
				$v_tr_lelang_master->LoadListRowValues($rsmaster);
				$v_tr_lelang_master->RowType = EW_ROWTYPE_MASTER; // Master row
				$v_tr_lelang_master->RenderListRow();
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

	// Exit inline mode
	function ClearInlineMode() {
		$this->gross->FormValue = ""; // Clear form value
		$this->open_bid->FormValue = ""; // Clear form value
		$this->bid_step->FormValue = ""; // Clear form value
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
		if ($objForm->HasValue("x_req_sample") && $objForm->HasValue("o_req_sample") && $this->req_sample->CurrentValue <> $this->req_sample->OldValue)
			return FALSE;
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
		if ($objForm->HasValue("x_gross") && $objForm->HasValue("o_gross") && $this->gross->CurrentValue <> $this->gross->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_open_bid") && $objForm->HasValue("o_open_bid") && $this->open_bid->CurrentValue <> $this->open_bid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_bid_step") && $objForm->HasValue("o_bid_step") && $this->bid_step->CurrentValue <> $this->bid_step->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_currency") && $objForm->HasValue("o_currency") && $this->currency->CurrentValue <> $this->currency->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_last_bid") && $objForm->HasValue("o_last_bid") && $this->last_bid->CurrentValue <> $this->last_bid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_highest_bid") && $objForm->HasValue("o_highest_bid") && $this->highest_bid->CurrentValue <> $this->highest_bid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_bid_val") && $objForm->HasValue("o_bid_val") && $this->bid_val->CurrentValue <> $this->bid_val->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_btn_bid") && $objForm->HasValue("o_btn_bid") && $this->btn_bid->CurrentValue <> $this->btn_bid->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_auction_status") && $objForm->HasValue("o_auction_status") && $this->auction_status->CurrentValue <> $this->auction_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_winner_id") && $objForm->HasValue("o_winner_id") && $this->winner_id->CurrentValue <> $this->winner_id->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_check_list") && $objForm->HasValue("o_check_list") && $this->check_list->CurrentValue <> $this->check_list->OldValue)
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
			$this->UpdateSort($this->row_id); // row_id
			$this->UpdateSort($this->req_sample); // req_sample
			$this->UpdateSort($this->lot_number); // lot_number
			$this->UpdateSort($this->chop); // chop
			$this->UpdateSort($this->estate); // estate
			$this->UpdateSort($this->grade); // grade
			$this->UpdateSort($this->jenis); // jenis
			$this->UpdateSort($this->sack); // sack
			$this->UpdateSort($this->gross); // gross
			$this->UpdateSort($this->open_bid); // open_bid
			$this->UpdateSort($this->bid_step); // bid_step
			$this->UpdateSort($this->currency); // currency
			$this->UpdateSort($this->last_bid); // last_bid
			$this->UpdateSort($this->highest_bid); // highest_bid
			$this->UpdateSort($this->bid_val); // bid_val
			$this->UpdateSort($this->btn_bid); // btn_bid
			$this->UpdateSort($this->auction_status); // auction_status
			$this->UpdateSort($this->winner_id); // winner_id
			$this->UpdateSort($this->check_list); // check_list
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
				$this->row_id->setSort("");
				$this->req_sample->setSort("");
				$this->lot_number->setSort("");
				$this->chop->setSort("");
				$this->estate->setSort("");
				$this->grade->setSort("");
				$this->jenis->setSort("");
				$this->sack->setSort("");
				$this->gross->setSort("");
				$this->open_bid->setSort("");
				$this->bid_step->setSort("");
				$this->currency->setSort("");
				$this->last_bid->setSort("");
				$this->highest_bid->setSort("");
				$this->bid_val->setSort("");
				$this->btn_bid->setSort("");
				$this->auction_status->setSort("");
				$this->winner_id->setSort("");
				$this->check_list->setSort("");
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
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fv_tr_lelang_itemlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fv_tr_lelang_itemlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fv_tr_lelang_itemlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
					$item->Visible = FALSE;
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
					$item->Visible = FALSE;
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
		$this->req_sample->CurrentValue = NULL;
		$this->req_sample->OldValue = $this->req_sample->CurrentValue;
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
		$this->rate->CurrentValue = NULL;
		$this->rate->OldValue = $this->rate->CurrentValue;
		$this->open_bid->CurrentValue = NULL;
		$this->open_bid->OldValue = $this->open_bid->CurrentValue;
		$this->bid_step->CurrentValue = NULL;
		$this->bid_step->OldValue = $this->bid_step->CurrentValue;
		$this->currency->CurrentValue = NULL;
		$this->currency->OldValue = $this->currency->CurrentValue;
		$this->enter_bid->CurrentValue = NULL;
		$this->enter_bid->OldValue = $this->enter_bid->CurrentValue;
		$this->last_bid->CurrentValue = NULL;
		$this->last_bid->OldValue = $this->last_bid->CurrentValue;
		$this->highest_bid->CurrentValue = NULL;
		$this->highest_bid->OldValue = $this->highest_bid->CurrentValue;
		$this->bid_val->CurrentValue = NULL;
		$this->bid_val->OldValue = $this->bid_val->CurrentValue;
		$this->btn_bid->CurrentValue = NULL;
		$this->btn_bid->OldValue = $this->btn_bid->CurrentValue;
		$this->auction_status->CurrentValue = NULL;
		$this->auction_status->OldValue = $this->auction_status->CurrentValue;
		$this->winner_id->CurrentValue = NULL;
		$this->winner_id->OldValue = $this->winner_id->CurrentValue;
		$this->check_list->CurrentValue = NULL;
		$this->check_list->OldValue = $this->check_list->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->row_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->row_id->setFormValue($objForm->GetValue("x_row_id"));
		if (!$this->req_sample->FldIsDetailKey) {
			$this->req_sample->setFormValue($objForm->GetValue("x_req_sample"));
		}
		$this->req_sample->setOldValue($objForm->GetValue("o_req_sample"));
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
		if (!$this->gross->FldIsDetailKey) {
			$this->gross->setFormValue($objForm->GetValue("x_gross"));
		}
		$this->gross->setOldValue($objForm->GetValue("o_gross"));
		if (!$this->open_bid->FldIsDetailKey) {
			$this->open_bid->setFormValue($objForm->GetValue("x_open_bid"));
		}
		$this->open_bid->setOldValue($objForm->GetValue("o_open_bid"));
		if (!$this->bid_step->FldIsDetailKey) {
			$this->bid_step->setFormValue($objForm->GetValue("x_bid_step"));
		}
		$this->bid_step->setOldValue($objForm->GetValue("o_bid_step"));
		if (!$this->currency->FldIsDetailKey) {
			$this->currency->setFormValue($objForm->GetValue("x_currency"));
		}
		$this->currency->setOldValue($objForm->GetValue("o_currency"));
		if (!$this->last_bid->FldIsDetailKey) {
			$this->last_bid->setFormValue($objForm->GetValue("x_last_bid"));
		}
		$this->last_bid->setOldValue($objForm->GetValue("o_last_bid"));
		if (!$this->highest_bid->FldIsDetailKey) {
			$this->highest_bid->setFormValue($objForm->GetValue("x_highest_bid"));
		}
		$this->highest_bid->setOldValue($objForm->GetValue("o_highest_bid"));
		if (!$this->bid_val->FldIsDetailKey) {
			$this->bid_val->setFormValue($objForm->GetValue("x_bid_val"));
		}
		$this->bid_val->setOldValue($objForm->GetValue("o_bid_val"));
		if (!$this->btn_bid->FldIsDetailKey) {
			$this->btn_bid->setFormValue($objForm->GetValue("x_btn_bid"));
		}
		$this->btn_bid->setOldValue($objForm->GetValue("o_btn_bid"));
		if (!$this->auction_status->FldIsDetailKey) {
			$this->auction_status->setFormValue($objForm->GetValue("x_auction_status"));
		}
		$this->auction_status->setOldValue($objForm->GetValue("o_auction_status"));
		if (!$this->winner_id->FldIsDetailKey) {
			$this->winner_id->setFormValue($objForm->GetValue("x_winner_id"));
		}
		$this->winner_id->setOldValue($objForm->GetValue("o_winner_id"));
		if (!$this->check_list->FldIsDetailKey) {
			$this->check_list->setFormValue($objForm->GetValue("x_check_list"));
		}
		$this->check_list->setOldValue($objForm->GetValue("o_check_list"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->row_id->CurrentValue = $this->row_id->FormValue;
		$this->req_sample->CurrentValue = $this->req_sample->FormValue;
		$this->lot_number->CurrentValue = $this->lot_number->FormValue;
		$this->chop->CurrentValue = $this->chop->FormValue;
		$this->estate->CurrentValue = $this->estate->FormValue;
		$this->grade->CurrentValue = $this->grade->FormValue;
		$this->jenis->CurrentValue = $this->jenis->FormValue;
		$this->sack->CurrentValue = $this->sack->FormValue;
		$this->gross->CurrentValue = $this->gross->FormValue;
		$this->open_bid->CurrentValue = $this->open_bid->FormValue;
		$this->bid_step->CurrentValue = $this->bid_step->FormValue;
		$this->currency->CurrentValue = $this->currency->FormValue;
		$this->last_bid->CurrentValue = $this->last_bid->FormValue;
		$this->highest_bid->CurrentValue = $this->highest_bid->FormValue;
		$this->bid_val->CurrentValue = $this->bid_val->FormValue;
		$this->btn_bid->CurrentValue = $this->btn_bid->FormValue;
		$this->auction_status->CurrentValue = $this->auction_status->FormValue;
		$this->winner_id->CurrentValue = $this->winner_id->FormValue;
		$this->check_list->CurrentValue = $this->check_list->FormValue;
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
		$this->req_sample->setDbValue($row['req_sample']);
		$this->lot_number->setDbValue($row['lot_number']);
		$this->chop->setDbValue($row['chop']);
		$this->estate->setDbValue($row['estate']);
		$this->grade->setDbValue($row['grade']);
		$this->jenis->setDbValue($row['jenis']);
		$this->sack->setDbValue($row['sack']);
		$this->netto->setDbValue($row['netto']);
		$this->gross->setDbValue($row['gross']);
		$this->rate->setDbValue($row['rate']);
		$this->open_bid->setDbValue($row['open_bid']);
		$this->bid_step->setDbValue($row['bid_step']);
		$this->currency->setDbValue($row['currency']);
		$this->enter_bid->setDbValue($row['enter_bid']);
		$this->last_bid->setDbValue($row['last_bid']);
		$this->highest_bid->setDbValue($row['highest_bid']);
		$this->bid_val->setDbValue($row['bid_val']);
		$this->btn_bid->setDbValue($row['btn_bid']);
		$this->auction_status->setDbValue($row['auction_status']);
		$this->winner_id->setDbValue($row['winner_id']);
		$this->check_list->setDbValue($row['check_list']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['row_id'] = $this->row_id->CurrentValue;
		$row['master_id'] = $this->master_id->CurrentValue;
		$row['req_sample'] = $this->req_sample->CurrentValue;
		$row['lot_number'] = $this->lot_number->CurrentValue;
		$row['chop'] = $this->chop->CurrentValue;
		$row['estate'] = $this->estate->CurrentValue;
		$row['grade'] = $this->grade->CurrentValue;
		$row['jenis'] = $this->jenis->CurrentValue;
		$row['sack'] = $this->sack->CurrentValue;
		$row['netto'] = $this->netto->CurrentValue;
		$row['gross'] = $this->gross->CurrentValue;
		$row['rate'] = $this->rate->CurrentValue;
		$row['open_bid'] = $this->open_bid->CurrentValue;
		$row['bid_step'] = $this->bid_step->CurrentValue;
		$row['currency'] = $this->currency->CurrentValue;
		$row['enter_bid'] = $this->enter_bid->CurrentValue;
		$row['last_bid'] = $this->last_bid->CurrentValue;
		$row['highest_bid'] = $this->highest_bid->CurrentValue;
		$row['bid_val'] = $this->bid_val->CurrentValue;
		$row['btn_bid'] = $this->btn_bid->CurrentValue;
		$row['auction_status'] = $this->auction_status->CurrentValue;
		$row['winner_id'] = $this->winner_id->CurrentValue;
		$row['check_list'] = $this->check_list->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->row_id->DbValue = $row['row_id'];
		$this->master_id->DbValue = $row['master_id'];
		$this->req_sample->DbValue = $row['req_sample'];
		$this->lot_number->DbValue = $row['lot_number'];
		$this->chop->DbValue = $row['chop'];
		$this->estate->DbValue = $row['estate'];
		$this->grade->DbValue = $row['grade'];
		$this->jenis->DbValue = $row['jenis'];
		$this->sack->DbValue = $row['sack'];
		$this->netto->DbValue = $row['netto'];
		$this->gross->DbValue = $row['gross'];
		$this->rate->DbValue = $row['rate'];
		$this->open_bid->DbValue = $row['open_bid'];
		$this->bid_step->DbValue = $row['bid_step'];
		$this->currency->DbValue = $row['currency'];
		$this->enter_bid->DbValue = $row['enter_bid'];
		$this->last_bid->DbValue = $row['last_bid'];
		$this->highest_bid->DbValue = $row['highest_bid'];
		$this->bid_val->DbValue = $row['bid_val'];
		$this->btn_bid->DbValue = $row['btn_bid'];
		$this->auction_status->DbValue = $row['auction_status'];
		$this->winner_id->DbValue = $row['winner_id'];
		$this->check_list->DbValue = $row['check_list'];
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
		if ($this->gross->FormValue == $this->gross->CurrentValue && is_numeric(ew_StrToFloat($this->gross->CurrentValue)))
			$this->gross->CurrentValue = ew_StrToFloat($this->gross->CurrentValue);

		// Convert decimal values if posted back
		if ($this->open_bid->FormValue == $this->open_bid->CurrentValue && is_numeric(ew_StrToFloat($this->open_bid->CurrentValue)))
			$this->open_bid->CurrentValue = ew_StrToFloat($this->open_bid->CurrentValue);

		// Convert decimal values if posted back
		if ($this->bid_step->FormValue == $this->bid_step->CurrentValue && is_numeric(ew_StrToFloat($this->bid_step->CurrentValue)))
			$this->bid_step->CurrentValue = ew_StrToFloat($this->bid_step->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// row_id
		// master_id
		// req_sample
		// lot_number
		// chop
		// estate
		// grade
		// jenis
		// sack
		// netto
		// gross
		// rate
		// open_bid
		// bid_step
		// currency
		// enter_bid
		// last_bid
		// highest_bid
		// bid_val
		// btn_bid
		// auction_status
		// winner_id
		// check_list

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// row_id
		$this->row_id->ViewValue = $this->row_id->CurrentValue;
		$this->row_id->ViewCustomAttributes = "";

		// req_sample
		$this->req_sample->ViewValue = $this->req_sample->CurrentValue;
		$this->req_sample->ViewCustomAttributes = "";

		// lot_number
		$this->lot_number->ViewValue = $this->lot_number->CurrentValue;
		$this->lot_number->CellCssStyle .= "text-align: center;";
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
		$this->open_bid->ViewCustomAttributes = "";

		// bid_step
		$this->bid_step->ViewValue = $this->bid_step->CurrentValue;
		$this->bid_step->ViewCustomAttributes = "";

		// currency
		if (strval($this->currency->CurrentValue) <> "") {
			$this->currency->ViewValue = $this->currency->OptionCaption($this->currency->CurrentValue);
		} else {
			$this->currency->ViewValue = NULL;
		}
		$this->currency->ViewCustomAttributes = "";

		// last_bid
		$this->last_bid->ViewValue = $this->last_bid->CurrentValue;
		$this->last_bid->ViewCustomAttributes = "";

		// highest_bid
		$this->highest_bid->ViewValue = $this->highest_bid->CurrentValue;
		$this->highest_bid->ViewCustomAttributes = "";

		// bid_val
		$this->bid_val->ViewValue = $this->bid_val->CurrentValue;
		$this->bid_val->CellCssStyle .= "text-align: right;";
		$this->bid_val->ViewCustomAttributes = "";

		// btn_bid
		$this->btn_bid->ViewValue = $this->btn_bid->CurrentValue;
		$this->btn_bid->ViewCustomAttributes = "";

		// auction_status
		if (strval($this->auction_status->CurrentValue) <> "") {
			$this->auction_status->ViewValue = $this->auction_status->OptionCaption($this->auction_status->CurrentValue);
		} else {
			$this->auction_status->ViewValue = NULL;
		}
		$this->auction_status->CellCssStyle .= "text-align: center;";
		$this->auction_status->ViewCustomAttributes = "";

		// winner_id
		if (strval($this->winner_id->CurrentValue) <> "") {
			$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->winner_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `user_id`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
		$sWhereWrk = "";
		$this->winner_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->winner_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->winner_id->ViewValue = $this->winner_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->winner_id->ViewValue = $this->winner_id->CurrentValue;
			}
		} else {
			$this->winner_id->ViewValue = NULL;
		}
		$this->winner_id->ViewCustomAttributes = "";

		// check_list
		$this->check_list->ViewCustomAttributes = "";

			// row_id
			$this->row_id->LinkCustomAttributes = "";
			$this->row_id->HrefValue = "";
			$this->row_id->TooltipValue = "";

			// req_sample
			$this->req_sample->LinkCustomAttributes = "";
			$this->req_sample->HrefValue = "";
			$this->req_sample->TooltipValue = "";

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

			// gross
			$this->gross->LinkCustomAttributes = "";
			$this->gross->HrefValue = "";
			$this->gross->TooltipValue = "";

			// open_bid
			$this->open_bid->LinkCustomAttributes = "";
			$this->open_bid->HrefValue = "";
			$this->open_bid->TooltipValue = "";

			// bid_step
			$this->bid_step->LinkCustomAttributes = "";
			$this->bid_step->HrefValue = "";
			$this->bid_step->TooltipValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";
			$this->currency->TooltipValue = "";

			// last_bid
			$this->last_bid->LinkCustomAttributes = "";
			$this->last_bid->HrefValue = "";
			$this->last_bid->TooltipValue = "";

			// highest_bid
			$this->highest_bid->LinkCustomAttributes = "";
			$this->highest_bid->HrefValue = "";
			$this->highest_bid->TooltipValue = "";

			// bid_val
			$this->bid_val->LinkCustomAttributes = "";
			$this->bid_val->HrefValue = "";
			$this->bid_val->TooltipValue = "";

			// btn_bid
			$this->btn_bid->LinkCustomAttributes = "";
			$this->btn_bid->HrefValue = "";
			$this->btn_bid->TooltipValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";
			$this->auction_status->TooltipValue = "";

			// winner_id
			$this->winner_id->LinkCustomAttributes = "";
			$this->winner_id->HrefValue = "";
			$this->winner_id->TooltipValue = "";

			// check_list
			$this->check_list->LinkCustomAttributes = "";
			$this->check_list->HrefValue = "";
			$this->check_list->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// row_id
			// req_sample

			$this->req_sample->EditAttrs["class"] = "form-control";
			$this->req_sample->EditCustomAttributes = "";
			$this->req_sample->EditValue = ew_HtmlEncode($this->req_sample->CurrentValue);
			$this->req_sample->PlaceHolder = ew_RemoveHtml($this->req_sample->FldCaption());

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
			$this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -1, -2, 0);
			$this->open_bid->OldValue = $this->open_bid->EditValue;
			}

			// bid_step
			$this->bid_step->EditAttrs["class"] = "form-control";
			$this->bid_step->EditCustomAttributes = "";
			$this->bid_step->EditValue = ew_HtmlEncode($this->bid_step->CurrentValue);
			$this->bid_step->PlaceHolder = ew_RemoveHtml($this->bid_step->FldCaption());
			if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) {
			$this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);
			$this->bid_step->OldValue = $this->bid_step->EditValue;
			}

			// currency
			$this->currency->EditCustomAttributes = "";
			$this->currency->EditValue = $this->currency->Options(TRUE);

			// last_bid
			$this->last_bid->EditAttrs["class"] = "form-control";
			$this->last_bid->EditCustomAttributes = "";
			$this->last_bid->EditValue = ew_HtmlEncode($this->last_bid->CurrentValue);
			$this->last_bid->PlaceHolder = ew_RemoveHtml($this->last_bid->FldCaption());

			// highest_bid
			$this->highest_bid->EditAttrs["class"] = "form-control";
			$this->highest_bid->EditCustomAttributes = "";
			$this->highest_bid->EditValue = ew_HtmlEncode($this->highest_bid->CurrentValue);
			$this->highest_bid->PlaceHolder = ew_RemoveHtml($this->highest_bid->FldCaption());

			// bid_val
			$this->bid_val->EditAttrs["class"] = "form-control";
			$this->bid_val->EditCustomAttributes = "";
			$this->bid_val->EditValue = ew_HtmlEncode($this->bid_val->CurrentValue);
			$this->bid_val->PlaceHolder = ew_RemoveHtml($this->bid_val->FldCaption());

			// btn_bid
			$this->btn_bid->EditAttrs["class"] = "form-control";
			$this->btn_bid->EditCustomAttributes = "";
			$this->btn_bid->EditValue = ew_HtmlEncode($this->btn_bid->CurrentValue);
			$this->btn_bid->PlaceHolder = ew_RemoveHtml($this->btn_bid->FldCaption());

			// auction_status
			$this->auction_status->EditCustomAttributes = "";
			$this->auction_status->EditValue = $this->auction_status->Options(FALSE);

			// winner_id
			$this->winner_id->EditAttrs["class"] = "form-control";
			$this->winner_id->EditCustomAttributes = "";
			if (trim(strval($this->winner_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->winner_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `user_id`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `members`";
			$sWhereWrk = "";
			$this->winner_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow($GLOBALS["v_tr_lelang_item"]->CurrentAction)) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->winner_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->winner_id->EditValue = $arwrk;

			// check_list
			$this->check_list->EditCustomAttributes = "";

			// Add refer script
			// row_id

			$this->row_id->LinkCustomAttributes = "";
			$this->row_id->HrefValue = "";

			// req_sample
			$this->req_sample->LinkCustomAttributes = "";
			$this->req_sample->HrefValue = "";

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

			// gross
			$this->gross->LinkCustomAttributes = "";
			$this->gross->HrefValue = "";

			// open_bid
			$this->open_bid->LinkCustomAttributes = "";
			$this->open_bid->HrefValue = "";

			// bid_step
			$this->bid_step->LinkCustomAttributes = "";
			$this->bid_step->HrefValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";

			// last_bid
			$this->last_bid->LinkCustomAttributes = "";
			$this->last_bid->HrefValue = "";

			// highest_bid
			$this->highest_bid->LinkCustomAttributes = "";
			$this->highest_bid->HrefValue = "";

			// bid_val
			$this->bid_val->LinkCustomAttributes = "";
			$this->bid_val->HrefValue = "";

			// btn_bid
			$this->btn_bid->LinkCustomAttributes = "";
			$this->btn_bid->HrefValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";

			// winner_id
			$this->winner_id->LinkCustomAttributes = "";
			$this->winner_id->HrefValue = "";

			// check_list
			$this->check_list->LinkCustomAttributes = "";
			$this->check_list->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// row_id
			$this->row_id->EditAttrs["class"] = "form-control";
			$this->row_id->EditCustomAttributes = "";
			$this->row_id->EditValue = $this->row_id->CurrentValue;
			$this->row_id->ViewCustomAttributes = "";

			// req_sample
			$this->req_sample->EditAttrs["class"] = "form-control";
			$this->req_sample->EditCustomAttributes = "";
			$this->req_sample->EditValue = ew_HtmlEncode($this->req_sample->CurrentValue);
			$this->req_sample->PlaceHolder = ew_RemoveHtml($this->req_sample->FldCaption());

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
			$this->open_bid->EditValue = ew_FormatNumber($this->open_bid->EditValue, -2, -1, -2, 0);
			$this->open_bid->OldValue = $this->open_bid->EditValue;
			}

			// bid_step
			$this->bid_step->EditAttrs["class"] = "form-control";
			$this->bid_step->EditCustomAttributes = "";
			$this->bid_step->EditValue = ew_HtmlEncode($this->bid_step->CurrentValue);
			$this->bid_step->PlaceHolder = ew_RemoveHtml($this->bid_step->FldCaption());
			if (strval($this->bid_step->EditValue) <> "" && is_numeric($this->bid_step->EditValue)) {
			$this->bid_step->EditValue = ew_FormatNumber($this->bid_step->EditValue, -2, -1, -2, 0);
			$this->bid_step->OldValue = $this->bid_step->EditValue;
			}

			// currency
			$this->currency->EditCustomAttributes = "";
			$this->currency->EditValue = $this->currency->Options(TRUE);

			// last_bid
			$this->last_bid->EditAttrs["class"] = "form-control";
			$this->last_bid->EditCustomAttributes = "";
			$this->last_bid->EditValue = ew_HtmlEncode($this->last_bid->CurrentValue);
			$this->last_bid->PlaceHolder = ew_RemoveHtml($this->last_bid->FldCaption());

			// highest_bid
			$this->highest_bid->EditAttrs["class"] = "form-control";
			$this->highest_bid->EditCustomAttributes = "";
			$this->highest_bid->EditValue = ew_HtmlEncode($this->highest_bid->CurrentValue);
			$this->highest_bid->PlaceHolder = ew_RemoveHtml($this->highest_bid->FldCaption());

			// bid_val
			$this->bid_val->EditAttrs["class"] = "form-control";
			$this->bid_val->EditCustomAttributes = "";
			$this->bid_val->EditValue = ew_HtmlEncode($this->bid_val->CurrentValue);
			$this->bid_val->PlaceHolder = ew_RemoveHtml($this->bid_val->FldCaption());

			// btn_bid
			$this->btn_bid->EditAttrs["class"] = "form-control";
			$this->btn_bid->EditCustomAttributes = "";
			$this->btn_bid->EditValue = ew_HtmlEncode($this->btn_bid->CurrentValue);
			$this->btn_bid->PlaceHolder = ew_RemoveHtml($this->btn_bid->FldCaption());

			// auction_status
			$this->auction_status->EditCustomAttributes = "";
			$this->auction_status->EditValue = $this->auction_status->Options(FALSE);

			// winner_id
			$this->winner_id->EditAttrs["class"] = "form-control";
			$this->winner_id->EditCustomAttributes = "";
			if (trim(strval($this->winner_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`user_id`" . ew_SearchString("=", $this->winner_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `user_id`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `members`";
			$sWhereWrk = "";
			$this->winner_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow($GLOBALS["v_tr_lelang_item"]->CurrentAction)) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$this->Lookup_Selecting($this->winner_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->winner_id->EditValue = $arwrk;

			// check_list
			$this->check_list->EditCustomAttributes = "";

			// Edit refer script
			// row_id

			$this->row_id->LinkCustomAttributes = "";
			$this->row_id->HrefValue = "";

			// req_sample
			$this->req_sample->LinkCustomAttributes = "";
			$this->req_sample->HrefValue = "";

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

			// gross
			$this->gross->LinkCustomAttributes = "";
			$this->gross->HrefValue = "";

			// open_bid
			$this->open_bid->LinkCustomAttributes = "";
			$this->open_bid->HrefValue = "";

			// bid_step
			$this->bid_step->LinkCustomAttributes = "";
			$this->bid_step->HrefValue = "";

			// currency
			$this->currency->LinkCustomAttributes = "";
			$this->currency->HrefValue = "";

			// last_bid
			$this->last_bid->LinkCustomAttributes = "";
			$this->last_bid->HrefValue = "";

			// highest_bid
			$this->highest_bid->LinkCustomAttributes = "";
			$this->highest_bid->HrefValue = "";

			// bid_val
			$this->bid_val->LinkCustomAttributes = "";
			$this->bid_val->HrefValue = "";

			// btn_bid
			$this->btn_bid->LinkCustomAttributes = "";
			$this->btn_bid->HrefValue = "";

			// auction_status
			$this->auction_status->LinkCustomAttributes = "";
			$this->auction_status->HrefValue = "";

			// winner_id
			$this->winner_id->LinkCustomAttributes = "";
			$this->winner_id->HrefValue = "";

			// check_list
			$this->check_list->LinkCustomAttributes = "";
			$this->check_list->HrefValue = "";
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
		if (!ew_CheckInteger($this->lot_number->FormValue)) {
			ew_AddMessage($gsFormError, $this->lot_number->FldErrMsg());
		}
		if (!ew_CheckInteger($this->sack->FormValue)) {
			ew_AddMessage($gsFormError, $this->sack->FldErrMsg());
		}
		if (!ew_CheckNumber($this->gross->FormValue)) {
			ew_AddMessage($gsFormError, $this->gross->FldErrMsg());
		}
		if (!ew_CheckNumber($this->open_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->open_bid->FldErrMsg());
		}
		if (!ew_CheckNumber($this->bid_step->FormValue)) {
			ew_AddMessage($gsFormError, $this->bid_step->FldErrMsg());
		}
		if (!ew_CheckNumber($this->last_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->last_bid->FldErrMsg());
		}
		if (!ew_CheckNumber($this->highest_bid->FormValue)) {
			ew_AddMessage($gsFormError, $this->highest_bid->FldErrMsg());
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

			// req_sample
			$this->req_sample->SetDbValueDef($rsnew, $this->req_sample->CurrentValue, "", $this->req_sample->ReadOnly);

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

			// gross
			$this->gross->SetDbValueDef($rsnew, $this->gross->CurrentValue, NULL, $this->gross->ReadOnly);

			// open_bid
			$this->open_bid->SetDbValueDef($rsnew, $this->open_bid->CurrentValue, NULL, $this->open_bid->ReadOnly);

			// bid_step
			$this->bid_step->SetDbValueDef($rsnew, $this->bid_step->CurrentValue, NULL, $this->bid_step->ReadOnly);

			// currency
			$this->currency->SetDbValueDef($rsnew, $this->currency->CurrentValue, NULL, $this->currency->ReadOnly);

			// last_bid
			$this->last_bid->SetDbValueDef($rsnew, $this->last_bid->CurrentValue, "", $this->last_bid->ReadOnly);

			// highest_bid
			$this->highest_bid->SetDbValueDef($rsnew, $this->highest_bid->CurrentValue, "", $this->highest_bid->ReadOnly);

			// bid_val
			$this->bid_val->SetDbValueDef($rsnew, $this->bid_val->CurrentValue, "", $this->bid_val->ReadOnly);

			// btn_bid
			$this->btn_bid->SetDbValueDef($rsnew, $this->btn_bid->CurrentValue, "", $this->btn_bid->ReadOnly);

			// auction_status
			$this->auction_status->SetDbValueDef($rsnew, $this->auction_status->CurrentValue, NULL, $this->auction_status->ReadOnly);

			// winner_id
			$this->winner_id->SetDbValueDef($rsnew, $this->winner_id->CurrentValue, NULL, $this->winner_id->ReadOnly);

			// check_list
			$this->check_list->SetDbValueDef($rsnew, $this->check_list->CurrentValue, "", $this->check_list->ReadOnly);

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
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// req_sample
		$this->req_sample->SetDbValueDef($rsnew, $this->req_sample->CurrentValue, "", FALSE);

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

		// gross
		$this->gross->SetDbValueDef($rsnew, $this->gross->CurrentValue, NULL, FALSE);

		// open_bid
		$this->open_bid->SetDbValueDef($rsnew, $this->open_bid->CurrentValue, NULL, FALSE);

		// bid_step
		$this->bid_step->SetDbValueDef($rsnew, $this->bid_step->CurrentValue, NULL, FALSE);

		// currency
		$this->currency->SetDbValueDef($rsnew, $this->currency->CurrentValue, NULL, strval($this->currency->CurrentValue) == "");

		// last_bid
		$this->last_bid->SetDbValueDef($rsnew, $this->last_bid->CurrentValue, "", FALSE);

		// highest_bid
		$this->highest_bid->SetDbValueDef($rsnew, $this->highest_bid->CurrentValue, "", FALSE);

		// bid_val
		$this->bid_val->SetDbValueDef($rsnew, $this->bid_val->CurrentValue, "", FALSE);

		// btn_bid
		$this->btn_bid->SetDbValueDef($rsnew, $this->btn_bid->CurrentValue, "", FALSE);

		// auction_status
		$this->auction_status->SetDbValueDef($rsnew, $this->auction_status->CurrentValue, NULL, strval($this->auction_status->CurrentValue) == "");

		// winner_id
		$this->winner_id->SetDbValueDef($rsnew, $this->winner_id->CurrentValue, NULL, FALSE);

		// check_list
		$this->check_list->SetDbValueDef($rsnew, $this->check_list->CurrentValue, "", FALSE);

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
			if ($sMasterTblVar == "v_tr_lelang_master") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_row_id"] <> "") {
					$GLOBALS["v_tr_lelang_master"]->row_id->setQueryStringValue($_GET["fk_row_id"]);
					$this->master_id->setQueryStringValue($GLOBALS["v_tr_lelang_master"]->row_id->QueryStringValue);
					$this->master_id->setSessionValue($this->master_id->QueryStringValue);
					if (!is_numeric($GLOBALS["v_tr_lelang_master"]->row_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "v_tr_lelang_master") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_row_id"] <> "") {
					$GLOBALS["v_tr_lelang_master"]->row_id->setFormValue($_POST["fk_row_id"]);
					$this->master_id->setFormValue($GLOBALS["v_tr_lelang_master"]->row_id->FormValue);
					$this->master_id->setSessionValue($this->master_id->FormValue);
					if (!is_numeric($GLOBALS["v_tr_lelang_master"]->row_id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "v_tr_lelang_master") {
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
		case "x_winner_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `user_id` AS `LinkFld`, `CompanyName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `members`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow($GLOBALS["v_tr_lelang_item"]->CurrentAction)) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`user_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->winner_id, $sWhereWrk); // Call Lookup Selecting
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
		//echo "Page Load";
		//Untuk menandai record
		//Language()->setPhrase("CustomActionCompleted", "Bid succesfully added...");
		//$this->CustomActions["inputbid"] = "Bid";

		if (CurrentUserLevel() == 0) {
			$this->bid_val->Visible = FALSE;
			$this->btn_bid->Visible = FALSE;
		}
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
if (!isset($v_tr_lelang_item_list)) $v_tr_lelang_item_list = new cv_tr_lelang_item_list();

// Page init
$v_tr_lelang_item_list->Page_Init();

// Page main
$v_tr_lelang_item_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$v_tr_lelang_item_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fv_tr_lelang_itemlist = new ew_Form("fv_tr_lelang_itemlist", "list");
fv_tr_lelang_itemlist.FormKeyCountName = '<?php echo $v_tr_lelang_item_list->FormKeyCountName ?>';

// Validate form
fv_tr_lelang_itemlist.Validate = function() {
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
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->lot_number->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sack");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->sack->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_gross");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->gross->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_open_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->open_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_bid_step");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->bid_step->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_last_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->last_bid->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_highest_bid");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($v_tr_lelang_item->highest_bid->FldErrMsg()) ?>");

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
fv_tr_lelang_itemlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "req_sample", false)) return false;
	if (ew_ValueChanged(fobj, infix, "lot_number", false)) return false;
	if (ew_ValueChanged(fobj, infix, "chop", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estate", false)) return false;
	if (ew_ValueChanged(fobj, infix, "grade", false)) return false;
	if (ew_ValueChanged(fobj, infix, "jenis", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sack", false)) return false;
	if (ew_ValueChanged(fobj, infix, "gross", false)) return false;
	if (ew_ValueChanged(fobj, infix, "open_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_step", false)) return false;
	if (ew_ValueChanged(fobj, infix, "currency", false)) return false;
	if (ew_ValueChanged(fobj, infix, "last_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "highest_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "bid_val", false)) return false;
	if (ew_ValueChanged(fobj, infix, "btn_bid", false)) return false;
	if (ew_ValueChanged(fobj, infix, "auction_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "winner_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "check_list[]", false)) return false;
	return true;
}

// Form_CustomValidate event
fv_tr_lelang_itemlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fv_tr_lelang_itemlist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fv_tr_lelang_itemlist.Lists["x_currency"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_tr_lelang_itemlist.Lists["x_currency"].Options = <?php echo json_encode($v_tr_lelang_item_list->currency->Options()) ?>;
fv_tr_lelang_itemlist.Lists["x_auction_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fv_tr_lelang_itemlist.Lists["x_auction_status"].Options = <?php echo json_encode($v_tr_lelang_item_list->auction_status->Options()) ?>;
fv_tr_lelang_itemlist.Lists["x_winner_id"] = {"LinkField":"x_user_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_CompanyName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"members"};
fv_tr_lelang_itemlist.Lists["x_winner_id"].Data = "<?php echo $v_tr_lelang_item_list->winner_id->LookupFilterQuery(FALSE, "list") ?>";

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
<div class="ewToolbar">
<?php if ($v_tr_lelang_item_list->TotalRecs > 0 && $v_tr_lelang_item_list->ExportOptions->Visible()) { ?>
<?php $v_tr_lelang_item_list->ExportOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php if (($v_tr_lelang_item->Export == "") || (EW_EXPORT_MASTER_RECORD && $v_tr_lelang_item->Export == "print")) { ?>
<?php
if ($v_tr_lelang_item_list->DbMasterFilter <> "" && $v_tr_lelang_item->getCurrentMasterTable() == "v_tr_lelang_master") {
	if ($v_tr_lelang_item_list->MasterRecordExists) {
?>
<?php include_once "v_tr_lelang_mastermaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($v_tr_lelang_item->CurrentAction == "gridadd") {
	$v_tr_lelang_item->CurrentFilter = "0=1";
	$v_tr_lelang_item_list->StartRec = 1;
	$v_tr_lelang_item_list->DisplayRecs = $v_tr_lelang_item->GridAddRowCount;
	$v_tr_lelang_item_list->TotalRecs = $v_tr_lelang_item_list->DisplayRecs;
	$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item_list->DisplayRecs;
} else {
	$bSelectLimit = $v_tr_lelang_item_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($v_tr_lelang_item_list->TotalRecs <= 0)
			$v_tr_lelang_item_list->TotalRecs = $v_tr_lelang_item->ListRecordCount();
	} else {
		if (!$v_tr_lelang_item_list->Recordset && ($v_tr_lelang_item_list->Recordset = $v_tr_lelang_item_list->LoadRecordset()))
			$v_tr_lelang_item_list->TotalRecs = $v_tr_lelang_item_list->Recordset->RecordCount();
	}
	$v_tr_lelang_item_list->StartRec = 1;
	if ($v_tr_lelang_item_list->DisplayRecs <= 0 || ($v_tr_lelang_item->Export <> "" && $v_tr_lelang_item->ExportAll)) // Display all records
		$v_tr_lelang_item_list->DisplayRecs = $v_tr_lelang_item_list->TotalRecs;
	if (!($v_tr_lelang_item->Export <> "" && $v_tr_lelang_item->ExportAll))
		$v_tr_lelang_item_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$v_tr_lelang_item_list->Recordset = $v_tr_lelang_item_list->LoadRecordset($v_tr_lelang_item_list->StartRec-1, $v_tr_lelang_item_list->DisplayRecs);

	// Set no record found message
	if ($v_tr_lelang_item->CurrentAction == "" && $v_tr_lelang_item_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$v_tr_lelang_item_list->setWarningMessage(ew_DeniedMsg());
		if ($v_tr_lelang_item_list->SearchWhere == "0=101")
			$v_tr_lelang_item_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$v_tr_lelang_item_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$v_tr_lelang_item_list->RenderOtherOptions();
?>
<?php $v_tr_lelang_item_list->ShowPageHeader(); ?>
<?php
$v_tr_lelang_item_list->ShowMessage();
?>
<?php if ($v_tr_lelang_item_list->TotalRecs > 0 || $v_tr_lelang_item->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($v_tr_lelang_item_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> v_tr_lelang_item">
<form name="fv_tr_lelang_itemlist" id="fv_tr_lelang_itemlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($v_tr_lelang_item_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $v_tr_lelang_item_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="v_tr_lelang_item">
<?php if ($v_tr_lelang_item->getCurrentMasterTable() == "v_tr_lelang_master" && $v_tr_lelang_item->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="v_tr_lelang_master">
<input type="hidden" name="fk_row_id" value="<?php echo $v_tr_lelang_item->master_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_v_tr_lelang_item" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($v_tr_lelang_item_list->TotalRecs > 0 || $v_tr_lelang_item->CurrentAction == "gridedit") { ?>
<table id="tbl_v_tr_lelang_itemlist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$v_tr_lelang_item_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$v_tr_lelang_item_list->RenderListOptions();

// Render list options (header, left)
$v_tr_lelang_item_list->ListOptions->Render("header", "left");
?>
<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->row_id) == "") { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_item->row_id->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->row_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="row_id" class="<?php echo $v_tr_lelang_item->row_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->row_id) ?>',1);"><div id="elh_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->row_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->row_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->row_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->req_sample) == "") { ?>
		<th data-name="req_sample" class="<?php echo $v_tr_lelang_item->req_sample->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->req_sample->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="req_sample" class="<?php echo $v_tr_lelang_item->req_sample->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->req_sample) ?>',1);"><div id="elh_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->req_sample->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->req_sample->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->req_sample->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->lot_number) == "") { ?>
		<th data-name="lot_number" class="<?php echo $v_tr_lelang_item->lot_number->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->lot_number->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="lot_number" class="<?php echo $v_tr_lelang_item->lot_number->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->lot_number) ?>',1);"><div id="elh_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->lot_number->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->lot_number->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->lot_number->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->chop) == "") { ?>
		<th data-name="chop" class="<?php echo $v_tr_lelang_item->chop->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->chop->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="chop" class="<?php echo $v_tr_lelang_item->chop->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->chop) ?>',1);"><div id="elh_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->chop->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->chop->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->chop->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->estate) == "") { ?>
		<th data-name="estate" class="<?php echo $v_tr_lelang_item->estate->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->estate->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estate" class="<?php echo $v_tr_lelang_item->estate->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->estate) ?>',1);"><div id="elh_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->estate->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->estate->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->estate->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->grade) == "") { ?>
		<th data-name="grade" class="<?php echo $v_tr_lelang_item->grade->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->grade->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="grade" class="<?php echo $v_tr_lelang_item->grade->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->grade) ?>',1);"><div id="elh_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->grade->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->grade->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->grade->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->jenis) == "") { ?>
		<th data-name="jenis" class="<?php echo $v_tr_lelang_item->jenis->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->jenis->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jenis" class="<?php echo $v_tr_lelang_item->jenis->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->jenis) ?>',1);"><div id="elh_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->jenis->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->jenis->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->jenis->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->sack) == "") { ?>
		<th data-name="sack" class="<?php echo $v_tr_lelang_item->sack->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->sack->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sack" class="<?php echo $v_tr_lelang_item->sack->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->sack) ?>',1);"><div id="elh_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->sack->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->sack->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->sack->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->gross) == "") { ?>
		<th data-name="gross" class="<?php echo $v_tr_lelang_item->gross->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->gross->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gross" class="<?php echo $v_tr_lelang_item->gross->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->gross) ?>',1);"><div id="elh_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->gross->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->gross->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->gross->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->open_bid) == "") { ?>
		<th data-name="open_bid" class="<?php echo $v_tr_lelang_item->open_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->open_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="open_bid" class="<?php echo $v_tr_lelang_item->open_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->open_bid) ?>',1);"><div id="elh_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->open_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->open_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->open_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_step) == "") { ?>
		<th data-name="bid_step" class="<?php echo $v_tr_lelang_item->bid_step->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_step->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_step" class="<?php echo $v_tr_lelang_item->bid_step->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_step) ?>',1);"><div id="elh_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_step->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->bid_step->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->bid_step->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->currency) == "") { ?>
		<th data-name="currency" class="<?php echo $v_tr_lelang_item->currency->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->currency->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="currency" class="<?php echo $v_tr_lelang_item->currency->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->currency) ?>',1);"><div id="elh_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->currency->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->currency->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->currency->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->last_bid) == "") { ?>
		<th data-name="last_bid" class="<?php echo $v_tr_lelang_item->last_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->last_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="last_bid" class="<?php echo $v_tr_lelang_item->last_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->last_bid) ?>',1);"><div id="elh_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->last_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->last_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->last_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->highest_bid) == "") { ?>
		<th data-name="highest_bid" class="<?php echo $v_tr_lelang_item->highest_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->highest_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="highest_bid" class="<?php echo $v_tr_lelang_item->highest_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->highest_bid) ?>',1);"><div id="elh_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->highest_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->highest_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->highest_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_val) == "") { ?>
		<th data-name="bid_val" class="<?php echo $v_tr_lelang_item->bid_val->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_val->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="bid_val" class="<?php echo $v_tr_lelang_item->bid_val->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->bid_val) ?>',1);"><div id="elh_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->bid_val->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->bid_val->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->bid_val->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->btn_bid) == "") { ?>
		<th data-name="btn_bid" class="<?php echo $v_tr_lelang_item->btn_bid->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->btn_bid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="btn_bid" class="<?php echo $v_tr_lelang_item->btn_bid->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->btn_bid) ?>',1);"><div id="elh_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->btn_bid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->btn_bid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->btn_bid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->auction_status) == "") { ?>
		<th data-name="auction_status" class="<?php echo $v_tr_lelang_item->auction_status->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->auction_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="auction_status" class="<?php echo $v_tr_lelang_item->auction_status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->auction_status) ?>',1);"><div id="elh_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->auction_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->auction_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->auction_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->winner_id) == "") { ?>
		<th data-name="winner_id" class="<?php echo $v_tr_lelang_item->winner_id->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->winner_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="winner_id" class="<?php echo $v_tr_lelang_item->winner_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->winner_id) ?>',1);"><div id="elh_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->winner_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->winner_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->winner_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
	<?php if ($v_tr_lelang_item->SortUrl($v_tr_lelang_item->check_list) == "") { ?>
		<th data-name="check_list" class="<?php echo $v_tr_lelang_item->check_list->HeaderCellClass() ?>"><div id="elh_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list"><div class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->check_list->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="check_list" class="<?php echo $v_tr_lelang_item->check_list->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $v_tr_lelang_item->SortUrl($v_tr_lelang_item->check_list) ?>',1);"><div id="elh_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $v_tr_lelang_item->check_list->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($v_tr_lelang_item->check_list->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($v_tr_lelang_item->check_list->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$v_tr_lelang_item_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($v_tr_lelang_item->ExportAll && $v_tr_lelang_item->Export <> "") {
	$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item_list->TotalRecs;
} else {

	// Set the last record to display
	if ($v_tr_lelang_item_list->TotalRecs > $v_tr_lelang_item_list->StartRec + $v_tr_lelang_item_list->DisplayRecs - 1)
		$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item_list->StartRec + $v_tr_lelang_item_list->DisplayRecs - 1;
	else
		$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($v_tr_lelang_item_list->FormKeyCountName) && ($v_tr_lelang_item->CurrentAction == "gridadd" || $v_tr_lelang_item->CurrentAction == "gridedit" || $v_tr_lelang_item->CurrentAction == "F")) {
		$v_tr_lelang_item_list->KeyCount = $objForm->GetValue($v_tr_lelang_item_list->FormKeyCountName);
		$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item_list->StartRec + $v_tr_lelang_item_list->KeyCount - 1;
	}
}
$v_tr_lelang_item_list->RecCnt = $v_tr_lelang_item_list->StartRec - 1;
if ($v_tr_lelang_item_list->Recordset && !$v_tr_lelang_item_list->Recordset->EOF) {
	$v_tr_lelang_item_list->Recordset->MoveFirst();
	$bSelectLimit = $v_tr_lelang_item_list->UseSelectLimit;
	if (!$bSelectLimit && $v_tr_lelang_item_list->StartRec > 1)
		$v_tr_lelang_item_list->Recordset->Move($v_tr_lelang_item_list->StartRec - 1);
} elseif (!$v_tr_lelang_item->AllowAddDeleteRow && $v_tr_lelang_item_list->StopRec == 0) {
	$v_tr_lelang_item_list->StopRec = $v_tr_lelang_item->GridAddRowCount;
}

// Initialize aggregate
$v_tr_lelang_item->RowType = EW_ROWTYPE_AGGREGATEINIT;
$v_tr_lelang_item->ResetAttrs();
$v_tr_lelang_item_list->RenderRow();
if ($v_tr_lelang_item->CurrentAction == "gridadd")
	$v_tr_lelang_item_list->RowIndex = 0;
if ($v_tr_lelang_item->CurrentAction == "gridedit")
	$v_tr_lelang_item_list->RowIndex = 0;
while ($v_tr_lelang_item_list->RecCnt < $v_tr_lelang_item_list->StopRec) {
	$v_tr_lelang_item_list->RecCnt++;
	if (intval($v_tr_lelang_item_list->RecCnt) >= intval($v_tr_lelang_item_list->StartRec)) {
		$v_tr_lelang_item_list->RowCnt++;
		if ($v_tr_lelang_item->CurrentAction == "gridadd" || $v_tr_lelang_item->CurrentAction == "gridedit" || $v_tr_lelang_item->CurrentAction == "F") {
			$v_tr_lelang_item_list->RowIndex++;
			$objForm->Index = $v_tr_lelang_item_list->RowIndex;
			if ($objForm->HasValue($v_tr_lelang_item_list->FormActionName))
				$v_tr_lelang_item_list->RowAction = strval($objForm->GetValue($v_tr_lelang_item_list->FormActionName));
			elseif ($v_tr_lelang_item->CurrentAction == "gridadd")
				$v_tr_lelang_item_list->RowAction = "insert";
			else
				$v_tr_lelang_item_list->RowAction = "";
		}

		// Set up key count
		$v_tr_lelang_item_list->KeyCount = $v_tr_lelang_item_list->RowIndex;

		// Init row class and style
		$v_tr_lelang_item->ResetAttrs();
		$v_tr_lelang_item->CssClass = "";
		if ($v_tr_lelang_item->CurrentAction == "gridadd") {
			$v_tr_lelang_item_list->LoadRowValues(); // Load default values
		} else {
			$v_tr_lelang_item_list->LoadRowValues($v_tr_lelang_item_list->Recordset); // Load row values
		}
		$v_tr_lelang_item->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($v_tr_lelang_item->CurrentAction == "gridadd") // Grid add
			$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
		if ($v_tr_lelang_item->CurrentAction == "gridadd" && $v_tr_lelang_item->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$v_tr_lelang_item_list->RestoreCurrentRowFormValues($v_tr_lelang_item_list->RowIndex); // Restore form values
		if ($v_tr_lelang_item->CurrentAction == "gridedit") { // Grid edit
			if ($v_tr_lelang_item->EventCancelled) {
				$v_tr_lelang_item_list->RestoreCurrentRowFormValues($v_tr_lelang_item_list->RowIndex); // Restore form values
			}
			if ($v_tr_lelang_item_list->RowAction == "insert")
				$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$v_tr_lelang_item->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($v_tr_lelang_item->CurrentAction == "gridedit" && ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT || $v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) && $v_tr_lelang_item->EventCancelled) // Update failed
			$v_tr_lelang_item_list->RestoreCurrentRowFormValues($v_tr_lelang_item_list->RowIndex); // Restore form values
		if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) // Edit row
			$v_tr_lelang_item_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$v_tr_lelang_item->RowAttrs = array_merge($v_tr_lelang_item->RowAttrs, array('data-rowindex'=>$v_tr_lelang_item_list->RowCnt, 'id'=>'r' . $v_tr_lelang_item_list->RowCnt . '_v_tr_lelang_item', 'data-rowtype'=>$v_tr_lelang_item->RowType));

		// Render row
		$v_tr_lelang_item_list->RenderRow();

		// Render list options
		$v_tr_lelang_item_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($v_tr_lelang_item_list->RowAction <> "delete" && $v_tr_lelang_item_list->RowAction <> "insertdelete" && !($v_tr_lelang_item_list->RowAction == "insert" && $v_tr_lelang_item->CurrentAction == "F" && $v_tr_lelang_item_list->EmptyRow())) {
?>
	<tr<?php echo $v_tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_tr_lelang_item_list->ListOptions->Render("body", "left", $v_tr_lelang_item_list->RowCnt);
?>
	<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
		<td data-name="row_id"<?php echo $v_tr_lelang_item->row_id->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_row_id" class="form-group v_tr_lelang_item_row_id">
<span<?php echo $v_tr_lelang_item->row_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $v_tr_lelang_item->row_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->CurrentValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_row_id" class="v_tr_lelang_item_row_id">
<span<?php echo $v_tr_lelang_item->row_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->row_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
		<td data-name="req_sample"<?php echo $v_tr_lelang_item->req_sample->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_req_sample" class="v_tr_lelang_item_req_sample">
<span<?php echo $v_tr_lelang_item->req_sample->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->req_sample->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number"<?php echo $v_tr_lelang_item->lot_number->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_lot_number" class="v_tr_lelang_item_lot_number">
<span<?php echo $v_tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->lot_number->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop"<?php echo $v_tr_lelang_item->chop->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_chop" class="v_tr_lelang_item_chop">
<span<?php echo $v_tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->chop->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate"<?php echo $v_tr_lelang_item->estate->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_estate" class="v_tr_lelang_item_estate">
<span<?php echo $v_tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->estate->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade"<?php echo $v_tr_lelang_item->grade->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_grade" class="v_tr_lelang_item_grade">
<span<?php echo $v_tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->grade->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis"<?php echo $v_tr_lelang_item->jenis->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_jenis" class="v_tr_lelang_item_jenis">
<span<?php echo $v_tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->jenis->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack"<?php echo $v_tr_lelang_item->sack->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_sack" class="v_tr_lelang_item_sack">
<span<?php echo $v_tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->sack->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross"<?php echo $v_tr_lelang_item->gross->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_gross" class="v_tr_lelang_item_gross">
<span<?php echo $v_tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->gross->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid"<?php echo $v_tr_lelang_item->open_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_open_bid" class="v_tr_lelang_item_open_bid">
<span<?php echo $v_tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->open_bid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step"<?php echo $v_tr_lelang_item->bid_step->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_step" class="v_tr_lelang_item_bid_step">
<span<?php echo $v_tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->bid_step->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency"<?php echo $v_tr_lelang_item->currency->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_currency" class="v_tr_lelang_item_currency">
<span<?php echo $v_tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->currency->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
		<td data-name="last_bid"<?php echo $v_tr_lelang_item->last_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_last_bid" class="v_tr_lelang_item_last_bid">
<span<?php echo $v_tr_lelang_item->last_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->last_bid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
		<td data-name="highest_bid"<?php echo $v_tr_lelang_item->highest_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_highest_bid" class="v_tr_lelang_item_highest_bid">
<span<?php echo $v_tr_lelang_item->highest_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->highest_bid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
		<td data-name="bid_val"<?php echo $v_tr_lelang_item->bid_val->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_bid_val" class="v_tr_lelang_item_bid_val">
<span<?php echo $v_tr_lelang_item->bid_val->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->bid_val->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
		<td data-name="btn_bid"<?php echo $v_tr_lelang_item->btn_bid->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_btn_bid" class="v_tr_lelang_item_btn_bid">
<span<?php echo $v_tr_lelang_item->btn_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->btn_bid->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
		<td data-name="auction_status"<?php echo $v_tr_lelang_item->auction_status->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_auction_status") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_auction_status") ?>
</div></div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_auction_status" class="v_tr_lelang_item_auction_status">
<span<?php echo $v_tr_lelang_item->auction_status->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->auction_status->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
		<td data-name="winner_id"<?php echo $v_tr_lelang_item->winner_id->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id") ?>
</select>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id") ?>
</select>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_winner_id" class="v_tr_lelang_item_winner_id">
<span<?php echo $v_tr_lelang_item->winner_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
		<td data-name="check_list"<?php echo $v_tr_lelang_item->check_list->CellAttributes() ?>>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_check_list[]") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_check_list[]") ?>
</div></div>
</span>
<?php } ?>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $v_tr_lelang_item_list->RowCnt ?>_v_tr_lelang_item_check_list" class="v_tr_lelang_item_check_list">
<span<?php echo $v_tr_lelang_item->check_list->ViewAttributes() ?>>
<?php echo $v_tr_lelang_item->check_list->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_tr_lelang_item_list->ListOptions->Render("body", "right", $v_tr_lelang_item_list->RowCnt);
?>
	</tr>
<?php if ($v_tr_lelang_item->RowType == EW_ROWTYPE_ADD || $v_tr_lelang_item->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fv_tr_lelang_itemlist.UpdateOpts(<?php echo $v_tr_lelang_item_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($v_tr_lelang_item->CurrentAction <> "gridadd")
		if (!$v_tr_lelang_item_list->Recordset->EOF) $v_tr_lelang_item_list->Recordset->MoveNext();
}
?>
<?php
	if ($v_tr_lelang_item->CurrentAction == "gridadd" || $v_tr_lelang_item->CurrentAction == "gridedit") {
		$v_tr_lelang_item_list->RowIndex = '$rowindex$';
		$v_tr_lelang_item_list->LoadRowValues();

		// Set row properties
		$v_tr_lelang_item->ResetAttrs();
		$v_tr_lelang_item->RowAttrs = array_merge($v_tr_lelang_item->RowAttrs, array('data-rowindex'=>$v_tr_lelang_item_list->RowIndex, 'id'=>'r0_v_tr_lelang_item', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($v_tr_lelang_item->RowAttrs["class"], "ewTemplate");
		$v_tr_lelang_item->RowType = EW_ROWTYPE_ADD;

		// Render row
		$v_tr_lelang_item_list->RenderRow();

		// Render list options
		$v_tr_lelang_item_list->RenderListOptions();
		$v_tr_lelang_item_list->StartRowCnt = 0;
?>
	<tr<?php echo $v_tr_lelang_item->RowAttributes() ?>>
<?php

// Render list options (body, left)
$v_tr_lelang_item_list->ListOptions->Render("body", "left", $v_tr_lelang_item_list->RowIndex);
?>
	<?php if ($v_tr_lelang_item->row_id->Visible) { // row_id ?>
		<td data-name="row_id">
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_row_id" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_row_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->row_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->req_sample->Visible) { // req_sample ?>
		<td data-name="req_sample">
<span id="el$rowindex$_v_tr_lelang_item_req_sample" class="form-group v_tr_lelang_item_req_sample">
<input type="text" data-table="v_tr_lelang_item" data-field="x_req_sample" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->req_sample->EditValue ?>"<?php echo $v_tr_lelang_item->req_sample->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_req_sample" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_req_sample" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->req_sample->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<td data-name="lot_number">
<span id="el$rowindex$_v_tr_lelang_item_lot_number" class="form-group v_tr_lelang_item_lot_number">
<input type="text" data-table="v_tr_lelang_item" data-field="x_lot_number" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->lot_number->EditValue ?>"<?php echo $v_tr_lelang_item->lot_number->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_lot_number" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_lot_number" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->lot_number->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->chop->Visible) { // chop ?>
		<td data-name="chop">
<span id="el$rowindex$_v_tr_lelang_item_chop" class="form-group v_tr_lelang_item_chop">
<input type="text" data-table="v_tr_lelang_item" data-field="x_chop" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->chop->EditValue ?>"<?php echo $v_tr_lelang_item->chop->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_chop" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_chop" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->chop->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->estate->Visible) { // estate ?>
		<td data-name="estate">
<span id="el$rowindex$_v_tr_lelang_item_estate" class="form-group v_tr_lelang_item_estate">
<input type="text" data-table="v_tr_lelang_item" data-field="x_estate" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->estate->EditValue ?>"<?php echo $v_tr_lelang_item->estate->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_estate" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_estate" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->estate->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->grade->Visible) { // grade ?>
		<td data-name="grade">
<span id="el$rowindex$_v_tr_lelang_item_grade" class="form-group v_tr_lelang_item_grade">
<input type="text" data-table="v_tr_lelang_item" data-field="x_grade" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->grade->EditValue ?>"<?php echo $v_tr_lelang_item->grade->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_grade" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_grade" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->grade->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->jenis->Visible) { // jenis ?>
		<td data-name="jenis">
<span id="el$rowindex$_v_tr_lelang_item_jenis" class="form-group v_tr_lelang_item_jenis">
<input type="text" data-table="v_tr_lelang_item" data-field="x_jenis" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->jenis->EditValue ?>"<?php echo $v_tr_lelang_item->jenis->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_jenis" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_jenis" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->jenis->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->sack->Visible) { // sack ?>
		<td data-name="sack">
<span id="el$rowindex$_v_tr_lelang_item_sack" class="form-group v_tr_lelang_item_sack">
<input type="text" data-table="v_tr_lelang_item" data-field="x_sack" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->sack->EditValue ?>"<?php echo $v_tr_lelang_item->sack->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_sack" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_sack" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->sack->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->gross->Visible) { // gross ?>
		<td data-name="gross">
<span id="el$rowindex$_v_tr_lelang_item_gross" class="form-group v_tr_lelang_item_gross">
<input type="text" data-table="v_tr_lelang_item" data-field="x_gross" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->gross->EditValue ?>"<?php echo $v_tr_lelang_item->gross->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_gross" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_gross" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->gross->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<td data-name="open_bid">
<span id="el$rowindex$_v_tr_lelang_item_open_bid" class="form-group v_tr_lelang_item_open_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_open_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->open_bid->EditValue ?>"<?php echo $v_tr_lelang_item->open_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_open_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_open_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->open_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<td data-name="bid_step">
<span id="el$rowindex$_v_tr_lelang_item_bid_step" class="form-group v_tr_lelang_item_bid_step">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_step" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_step->EditValue ?>"<?php echo $v_tr_lelang_item->bid_step->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_step" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_step" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_step->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->currency->Visible) { // currency ?>
		<td data-name="currency">
<span id="el$rowindex$_v_tr_lelang_item_currency" class="form-group v_tr_lelang_item_currency">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" aria-expanded="false"<?php if ($v_tr_lelang_item->currency->ReadOnly) { ?> readonly<?php } else { ?>data-toggle="dropdown"<?php } ?>>
		<?php echo $v_tr_lelang_item->currency->ViewValue ?>
	</span>
	<?php if (!$v_tr_lelang_item->currency->ReadOnly) { ?>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<?php } ?>
	<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php echo $v_tr_lelang_item->currency->RadioButtonListHtml(TRUE, "x{$v_tr_lelang_item_list->RowIndex}_currency") ?>
		</div>
	</div>
	<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_currency" data-value-separator="<?php echo $v_tr_lelang_item->currency->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" value="{value}"<?php echo $v_tr_lelang_item->currency->EditAttributes() ?>></div>
</div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_currency" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_currency" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->currency->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->last_bid->Visible) { // last_bid ?>
		<td data-name="last_bid">
<span id="el$rowindex$_v_tr_lelang_item_last_bid" class="form-group v_tr_lelang_item_last_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_last_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->last_bid->EditValue ?>"<?php echo $v_tr_lelang_item->last_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_last_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_last_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->last_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->highest_bid->Visible) { // highest_bid ?>
		<td data-name="highest_bid">
<span id="el$rowindex$_v_tr_lelang_item_highest_bid" class="form-group v_tr_lelang_item_highest_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->highest_bid->EditValue ?>"<?php echo $v_tr_lelang_item->highest_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_highest_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_highest_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->highest_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->bid_val->Visible) { // bid_val ?>
		<td data-name="bid_val">
<span id="el$rowindex$_v_tr_lelang_item_bid_val" class="form-group v_tr_lelang_item_bid_val">
<input type="text" data-table="v_tr_lelang_item" data-field="x_bid_val" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" size="20" maxlength="20" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->bid_val->EditValue ?>"<?php echo $v_tr_lelang_item->bid_val->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_bid_val" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_bid_val" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->bid_val->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->btn_bid->Visible) { // btn_bid ?>
		<td data-name="btn_bid">
<span id="el$rowindex$_v_tr_lelang_item_btn_bid" class="form-group v_tr_lelang_item_btn_bid">
<input type="text" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" size="30" placeholder="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->getPlaceHolder()) ?>" value="<?php echo $v_tr_lelang_item->btn_bid->EditValue ?>"<?php echo $v_tr_lelang_item->btn_bid->EditAttributes() ?>>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_btn_bid" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_btn_bid" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->btn_bid->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->auction_status->Visible) { // auction_status ?>
		<td data-name="auction_status">
<span id="el$rowindex$_v_tr_lelang_item_auction_status" class="form-group v_tr_lelang_item_auction_status">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" class="ewTemplate"><input type="radio" data-table="v_tr_lelang_item" data-field="x_auction_status" data-value-separator="<?php echo $v_tr_lelang_item->auction_status->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" value="{value}"<?php echo $v_tr_lelang_item->auction_status->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->auction_status->RadioButtonListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_auction_status") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_auction_status" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_auction_status" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->auction_status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->winner_id->Visible) { // winner_id ?>
		<td data-name="winner_id">
<span id="el$rowindex$_v_tr_lelang_item_winner_id" class="form-group v_tr_lelang_item_winner_id">
<select data-table="v_tr_lelang_item" data-field="x_winner_id" data-value-separator="<?php echo $v_tr_lelang_item->winner_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id"<?php echo $v_tr_lelang_item->winner_id->EditAttributes() ?>>
<?php echo $v_tr_lelang_item->winner_id->SelectOptionListHtml("x<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id") ?>
</select>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_winner_id" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_winner_id" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->winner_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($v_tr_lelang_item->check_list->Visible) { // check_list ?>
		<td data-name="check_list">
<span id="el$rowindex$_v_tr_lelang_item_check_list" class="form-group v_tr_lelang_item_check_list">
<div id="tp_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" class="ewTemplate"><input type="checkbox" data-table="v_tr_lelang_item" data-field="x_check_list" data-value-separator="<?php echo $v_tr_lelang_item->check_list->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" id="x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" value="{value}"<?php echo $v_tr_lelang_item->check_list->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $v_tr_lelang_item->check_list->CheckBoxListHtml(FALSE, "x{$v_tr_lelang_item_list->RowIndex}_check_list[]") ?>
</div></div>
</span>
<input type="hidden" data-table="v_tr_lelang_item" data-field="x_check_list" name="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" id="o<?php echo $v_tr_lelang_item_list->RowIndex ?>_check_list[]" value="<?php echo ew_HtmlEncode($v_tr_lelang_item->check_list->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$v_tr_lelang_item_list->ListOptions->Render("body", "right", $v_tr_lelang_item_list->RowIndex);
?>
<script type="text/javascript">
fv_tr_lelang_itemlist.UpdateOpts(<?php echo $v_tr_lelang_item_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($v_tr_lelang_item->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $v_tr_lelang_item_list->FormKeyCountName ?>" id="<?php echo $v_tr_lelang_item_list->FormKeyCountName ?>" value="<?php echo $v_tr_lelang_item_list->KeyCount ?>">
<?php echo $v_tr_lelang_item_list->MultiSelectKey ?>
<?php } ?>
<?php if ($v_tr_lelang_item->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $v_tr_lelang_item_list->FormKeyCountName ?>" id="<?php echo $v_tr_lelang_item_list->FormKeyCountName ?>" value="<?php echo $v_tr_lelang_item_list->KeyCount ?>">
<?php echo $v_tr_lelang_item_list->MultiSelectKey ?>
<?php } ?>
<?php if ($v_tr_lelang_item->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($v_tr_lelang_item_list->Recordset)
	$v_tr_lelang_item_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($v_tr_lelang_item->CurrentAction <> "gridadd" && $v_tr_lelang_item->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($v_tr_lelang_item_list->Pager)) $v_tr_lelang_item_list->Pager = new cPrevNextPager($v_tr_lelang_item_list->StartRec, $v_tr_lelang_item_list->DisplayRecs, $v_tr_lelang_item_list->TotalRecs, $v_tr_lelang_item_list->AutoHidePager) ?>
<?php if ($v_tr_lelang_item_list->Pager->RecordCount > 0 && $v_tr_lelang_item_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($v_tr_lelang_item_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $v_tr_lelang_item_list->PageUrl() ?>start=<?php echo $v_tr_lelang_item_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($v_tr_lelang_item_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $v_tr_lelang_item_list->PageUrl() ?>start=<?php echo $v_tr_lelang_item_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $v_tr_lelang_item_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($v_tr_lelang_item_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $v_tr_lelang_item_list->PageUrl() ?>start=<?php echo $v_tr_lelang_item_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($v_tr_lelang_item_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $v_tr_lelang_item_list->PageUrl() ?>start=<?php echo $v_tr_lelang_item_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $v_tr_lelang_item_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($v_tr_lelang_item_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $v_tr_lelang_item_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $v_tr_lelang_item_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $v_tr_lelang_item_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_tr_lelang_item_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($v_tr_lelang_item_list->TotalRecs == 0 && $v_tr_lelang_item->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($v_tr_lelang_item_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fv_tr_lelang_itemlist.Init();
</script>
<?php
$v_tr_lelang_item_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

$("#btnAction").after('&nbsp;&nbsp;<button class="btn btn-default ewButton" name="btnMyNewButton" id="btnMyNewButton" type="Button">My New Button</button>');
</script>
<?php include_once "footer.php" ?>
<?php
$v_tr_lelang_item_list->Page_Terminate();
?>
