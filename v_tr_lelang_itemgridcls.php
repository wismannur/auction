<?php include_once "v_tr_lelang_iteminfo.php" ?>
<?php include_once "membersinfo.php" ?>
<?php

//
// Page class
//

$v_tr_lelang_item_grid = NULL; // Initialize page object first

class cv_tr_lelang_item_grid extends cv_tr_lelang_item {

	// Page ID
	var $PageID = 'gridcls';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'v_tr_lelang_item';

	// Page object name
	var $PageObjName = 'v_tr_lelang_item_grid';

	// Grid form hidden field names
	var $FormName = 'fv_tr_lelang_itemgrid';
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
		$this->FormActionName .= '_' . $this->FormName;
		$this->FormKeyName .= '_' . $this->FormName;
		$this->FormOldKeyName .= '_' . $this->FormName;
		$this->FormBlankRowName .= '_' . $this->FormName;
		$this->FormKeyCountName .= '_' . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (v_tr_lelang_item)
		if (!isset($GLOBALS["v_tr_lelang_item"]) || get_class($GLOBALS["v_tr_lelang_item"]) == "cv_tr_lelang_item") {
			$GLOBALS["v_tr_lelang_item"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["v_tr_lelang_item"];

		}
		$this->AddUrl = "v_tr_lelang_itemadd.php";

		// Table object (members)
		if (!isset($GLOBALS['members'])) $GLOBALS['members'] = new cmembers();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'gridcls', TRUE);

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

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
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
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url == "")
			return;
		$this->Page_Redirecting($url);

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
	var $ShowOtherOptions = FALSE;
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

			// Handle reset command
			$this->ResetCmd();

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

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
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
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
				$this->LoadOldRecord(); // Load old record
			}
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
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
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
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($objForm->GetValue($this->FormOldKeyName));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $OldKeyName . "\" id=\"" . $OldKeyName . "\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
		if ($this->CurrentMode == "view") { // View mode
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->row_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('row_id');
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$option = &$this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;
		$option->ButtonClass = "btn-sm"; // Class for button group
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && $this->CurrentAction != "F") { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = &$options["addedit"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
				$item = &$option->Add("addblankrow");
				$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
				$item->Visible = FALSE;
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = &$options["addedit"];
			$item = &$option->GetItem("add");
			$this->ShowOtherOptions = $item && $item->Visible;
		}
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
		$objForm->FormName = $this->FormName;
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
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->row_id->CurrentValue = strval($arKeys[0]); // row_id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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
		$this->CopyUrl = $this->GetCopyUrl();
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
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow("gridcls")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
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
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow("gridcls")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
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

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "v_tr_lelang_master") {
				$this->master_id->CurrentValue = $this->master_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "v_tr_lelang_master") {
			$this->master_id->Visible = FALSE;
			if ($GLOBALS["v_tr_lelang_master"]->EventCancelled) $this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (!$GLOBALS["v_tr_lelang_item"]->UserIDAllow("gridcls")) $sWhereWrk = $GLOBALS["members"]->AddUserIDFilter($sWhereWrk);
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
}
?>