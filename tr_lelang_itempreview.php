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

$tr_lelang_item_preview = NULL; // Initialize page object first

class ctr_lelang_item_preview extends ctr_lelang_item {

	// Page ID
	var $PageID = 'preview';

	// Project ID
	var $ProjectID = '{DFE89B97-9D22-437D-AA4F-59294E95069A}';

	// Table name
	var $TableName = 'tr_lelang_item';

	// Page object name
	var $PageObjName = 'tr_lelang_item_preview';

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
			define("EW_PAGE_ID", 'preview', TRUE);

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
		if (is_null($Security)) $Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel(CurrentProjectID() . 'tr_lelang_item');
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			echo ew_DeniedMsg();
			exit();
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

		// Set up list options
		$this->SetupListOptions();
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

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();
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
	var $Recordset;
	var $TotalRecs;
	var $RowCnt;
	var $RecCount;
	var $ListOptions; // List options
	var $OtherOptions; // Other options
	var $Pager;
	var $StartRec = 1;
	var $DisplayRecs = 0;
	var $SortField = "";
	var $SortOrder = "";

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load filter
		$filter = @$_GET["f"];
		$filter = ew_Decrypt($filter);
		if ($filter == "") $filter = "0=1";
		$this->StartRec = intval(@$_GET["start"]) ?: 1;
		$this->SortField = @$_GET["sort"];
		$this->SortOrder = @$_GET["sortorder"];

		// Set up foreign keys from filter
		$this->SetupForeignKeysFromFilter($filter);

		// Call Recordset Selecting event
		$this->Recordset_Selecting($filter);

		// Load recordset
		$filter = $this->ApplyUserIDFilters($filter);
		$this->TotalRecs = $this->LoadRecordCount($filter);
		$sSql = $this->PreviewSQL($filter);
		if ($this->DisplayRecs > 0)
			$this->Recordset = $this->Connection()->SelectLimit($sSql, $this->DisplayRecs, $this->StartRec - 1);
		if (!$this->Recordset)
			$this->Recordset = $this->Connection()->Execute($sSql);
		if ($this->Recordset && !$this->Recordset->EOF) {

			// Call Recordset Selected event
			$this->Recordset_Selected($this->Recordset);
			$this->LoadListRowValues($this->Recordset);
		}
		$this->RenderOtherOptions();
	}

	// Get preview SQL
	function PreviewSQL($filter) {
		$sortField = $this->SortField;
		$sortOrder = $this->SortOrder;
		$sort = "";
		if (array_key_exists($sortField, $this->fields)) {
			$fld = $this->fields[$sortField];
			$sort = $fld->FldExpression;
			if ($sortOrder == "ASC" || $sortOrder == "DESC")
				$sort .= " " . $sortOrder;
		}
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
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

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();
		$masterkeyurl = $this->MasterKeyUrl();

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl($masterkeyurl)) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . " onclick=\"return ew_ConfirmDelete(this);\"" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->GetDeleteUrl()) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];
		$option->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// Add
		$item = &$option->Add("add");
		$item->Visible = $Security->CanAdd();
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->GetItem("add");
		$item->Body = "<a class=\"btn btn-default btn-sm ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->GetAddUrl($this->MasterKeyUrl())) . "\">" . $Language->Phrase("AddLink") . "</a>";
	}

	// Get master foreign key url
	function MasterKeyUrl() {
		$mastertblvar = @$_GET["t"];
		$url = "";
		if ($mastertblvar == "tr_lelang_master") {
			$url = "" . EW_TABLE_SHOW_MASTER . "=tr_lelang_master&fk_row_id=" . urlencode(strval($this->master_id->QueryStringValue)) . "";
		}
		return $url;
	}

	// Set up foreign keys from filter
	function SetupForeignKeysFromFilter($f) {
		$mastertblvar = @$_GET["t"];
		if ($mastertblvar == "tr_lelang_master") {
			$find = "`master_id`=";
			$x = strpos($f, $find);
			if ($x !== FALSE) {
				$x += strlen($find);
				$val = substr($f, $x);
				$val = $this->UnquoteValue($val, "DB");
 				$this->master_id->setQueryStringValue($val);
			}
		}
	}

	// Unquote value
	function UnquoteValue($val, $dbid) {
		if (substr($val,0,1) == "'" && substr($val,strlen($val)-1) == "'") {
			if (ew_GetConnectionType($dbid) == "MYSQL")
				return stripslashes(substr($val, 1, strlen($val)-2));
			else
				return str_replace("''", "'", substr($val, 1, strlen($val)-2));
		} else {
			return $val;
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
}
?>
<?php ew_Header(FALSE, "utf-8") ?>
<?php

// Create page object
if (!isset($tr_lelang_item_preview)) $tr_lelang_item_preview = new ctr_lelang_item_preview();

// Page init
$tr_lelang_item_preview->Page_Init();

// Page main
$tr_lelang_item_preview->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tr_lelang_item_preview->Page_Render();
?>
<?php $tr_lelang_item_preview->ShowPageHeader(); ?>
<div class="box ewGrid tr_lelang_item"><!-- .box -->
<?php if ($tr_lelang_item_preview->TotalRecs > 0) { ?>
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel"><!-- .table-responsive -->
<table class="table ewTable ewPreviewTable"><!-- .table -->
	<thead><!-- Table header -->
		<tr class="ewTableHeader">
<?php

// Render list options
$tr_lelang_item_preview->RenderListOptions();

// Render list options (header, left)
$tr_lelang_item_preview->ListOptions->Render("header", "left");
?>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->lot_number) == "") { ?>
		<th class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->lot_number->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->lot_number->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->lot_number->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->lot_number->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->lot_number->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->chop) == "") { ?>
		<th class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><?php echo $tr_lelang_item->chop->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->chop->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->chop->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->chop->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->chop->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->chop->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->estate) == "") { ?>
		<th class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><?php echo $tr_lelang_item->estate->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->estate->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->estate->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->estate->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->estate->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->estate->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->grade) == "") { ?>
		<th class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><?php echo $tr_lelang_item->grade->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->grade->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->grade->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->grade->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->grade->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->grade->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->jenis) == "") { ?>
		<th class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><?php echo $tr_lelang_item->jenis->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->jenis->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->jenis->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->jenis->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->jenis->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->jenis->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->sack) == "") { ?>
		<th class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><?php echo $tr_lelang_item->sack->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->sack->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->sack->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->sack->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->sack->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->sack->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->netto) == "") { ?>
		<th class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><?php echo $tr_lelang_item->netto->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->netto->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->netto->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->netto->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->netto->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->netto->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->gross) == "") { ?>
		<th class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><?php echo $tr_lelang_item->gross->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->gross->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->gross->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->gross->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->gross->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->gross->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->open_bid) == "") { ?>
		<th class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->open_bid->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->open_bid->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->open_bid->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->open_bid->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->open_bid->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->currency) == "") { ?>
		<th class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><?php echo $tr_lelang_item->currency->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->currency->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->currency->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->currency->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->currency->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->currency->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->bid_step) == "") { ?>
		<th class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->bid_step->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->bid_step->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->bid_step->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->bid_step->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->bid_step->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
	<?php if ($tr_lelang_item->SortUrl($tr_lelang_item->rate) == "") { ?>
		<th class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><?php echo $tr_lelang_item->rate->FldCaption() ?></th>
	<?php } else { ?>
		<th class="<?php echo $tr_lelang_item->rate->HeaderCellClass() ?>"><div class="ewPointer" data-sort="<?php echo $tr_lelang_item->rate->FldName ?>" data-sort-order="<?php echo $tr_lelang_item_preview->SortField == $tr_lelang_item->rate->FldName && $tr_lelang_item_preview->SortOrder == "ASC" ? "DESC" : "ASC" ?>"><div class="ewTableHeaderBtn">
		<span class="ewTableHeaderCaption"><?php echo $tr_lelang_item->rate->FldCaption() ?></span>
		<span class="ewTableHeaderSort"><?php if ($tr_lelang_item_preview->SortField == $tr_lelang_item->rate->FldName) { ?><?php if ($tr_lelang_item_preview->SortOrder == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tr_lelang_item_preview->SortOrder == "DESC") { ?><span class="caret"></span><?php } ?><?php } ?></span>
	</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$tr_lelang_item_preview->ListOptions->Render("header", "right");
?>
		</tr>
	</thead>
	<tbody><!-- Table body -->
<?php
$tr_lelang_item_preview->RecCount = 0;
$tr_lelang_item_preview->RowCnt = 0;
while ($tr_lelang_item_preview->Recordset && !$tr_lelang_item_preview->Recordset->EOF) {

	// Init row class and style
	$tr_lelang_item_preview->RecCount++;
	$tr_lelang_item_preview->RowCnt++;
	$tr_lelang_item_preview->CssStyle = "";
	$tr_lelang_item_preview->LoadListRowValues($tr_lelang_item_preview->Recordset);

	// Render row
	$tr_lelang_item_preview->RowType = EW_ROWTYPE_PREVIEW; // Preview record
	$tr_lelang_item_preview->ResetAttrs();
	$tr_lelang_item_preview->RenderListRow();

	// Render list options
	$tr_lelang_item_preview->RenderListOptions();
?>
	<tr<?php echo $tr_lelang_item_preview->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tr_lelang_item_preview->ListOptions->Render("body", "left", $tr_lelang_item_preview->RowCnt);
?>
<?php if ($tr_lelang_item->lot_number->Visible) { // lot_number ?>
		<!-- lot_number -->
		<td<?php echo $tr_lelang_item->lot_number->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->lot_number->ViewAttributes() ?>>
<?php echo $tr_lelang_item->lot_number->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->chop->Visible) { // chop ?>
		<!-- chop -->
		<td<?php echo $tr_lelang_item->chop->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->chop->ViewAttributes() ?>>
<?php echo $tr_lelang_item->chop->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->estate->Visible) { // estate ?>
		<!-- estate -->
		<td<?php echo $tr_lelang_item->estate->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->estate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->estate->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->grade->Visible) { // grade ?>
		<!-- grade -->
		<td<?php echo $tr_lelang_item->grade->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->grade->ViewAttributes() ?>>
<?php echo $tr_lelang_item->grade->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->jenis->Visible) { // jenis ?>
		<!-- jenis -->
		<td<?php echo $tr_lelang_item->jenis->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->jenis->ViewAttributes() ?>>
<?php echo $tr_lelang_item->jenis->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->sack->Visible) { // sack ?>
		<!-- sack -->
		<td<?php echo $tr_lelang_item->sack->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->sack->ViewAttributes() ?>>
<?php echo $tr_lelang_item->sack->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->netto->Visible) { // netto ?>
		<!-- netto -->
		<td<?php echo $tr_lelang_item->netto->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->netto->ViewAttributes() ?>>
<?php echo $tr_lelang_item->netto->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->gross->Visible) { // gross ?>
		<!-- gross -->
		<td<?php echo $tr_lelang_item->gross->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->gross->ViewAttributes() ?>>
<?php echo $tr_lelang_item->gross->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->open_bid->Visible) { // open_bid ?>
		<!-- open_bid -->
		<td<?php echo $tr_lelang_item->open_bid->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->open_bid->ViewAttributes() ?>>
<?php echo $tr_lelang_item->open_bid->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->currency->Visible) { // currency ?>
		<!-- currency -->
		<td<?php echo $tr_lelang_item->currency->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->currency->ViewAttributes() ?>>
<?php echo $tr_lelang_item->currency->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->bid_step->Visible) { // bid_step ?>
		<!-- bid_step -->
		<td<?php echo $tr_lelang_item->bid_step->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->bid_step->ViewAttributes() ?>>
<?php echo $tr_lelang_item->bid_step->ListViewValue() ?></span>
</td>
<?php } ?>
<?php if ($tr_lelang_item->rate->Visible) { // rate ?>
		<!-- rate -->
		<td<?php echo $tr_lelang_item->rate->CellAttributes() ?>>
<span<?php echo $tr_lelang_item->rate->ViewAttributes() ?>>
<?php echo $tr_lelang_item->rate->ListViewValue() ?></span>
</td>
<?php } ?>
<?php

// Render list options (body, right)
$tr_lelang_item_preview->ListOptions->Render("body", "right", $tr_lelang_item_preview->RowCnt);
?>
	</tr>
<?php
	$tr_lelang_item_preview->Recordset->MoveNext();
}
?>
	</tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<?php } ?>
<div class="box-footer ewGridLowerPanel ewPreviewLowerPanel"><!-- .box-footer -->
<?php if ($tr_lelang_item_preview->TotalRecs > 0) { ?>
<?php if (!isset($tr_lelang_item_preview->Pager)) $tr_lelang_item_preview->Pager = new cPrevNextPager($tr_lelang_item_preview->StartRec, $tr_lelang_item_preview->DisplayRecs, $tr_lelang_item_preview->TotalRecs) ?>
<?php if ($tr_lelang_item_preview->Pager->RecordCount > 0 && $tr_lelang_item_preview->Pager->Visible) { ?>
<div class="ewPager"><div class="ewPrevNext"><div class="btn-group">
<!--first page button-->
	<?php if ($tr_lelang_item_preview->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" data-start="<?php echo $tr_lelang_item_preview->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($tr_lelang_item_preview->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" data-start="<?php echo $tr_lelang_item_preview->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
<!--next page button-->
	<?php if ($tr_lelang_item_preview->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" data-start="<?php echo $tr_lelang_item_preview->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($tr_lelang_item_preview->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" data-start="<?php echo $tr_lelang_item_preview->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div></div></div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $tr_lelang_item_preview->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $tr_lelang_item_preview->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $tr_lelang_item_preview->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php } else { ?>
<div class="ewDetailCount"><?php echo $Language->Phrase("NoRecord") ?></div>
<?php } ?>
<div class="ewPreviewOtherOptions">
<?php
	foreach ($tr_lelang_item_preview->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div><!-- /.box-footer -->
</div><!-- /.box -->
<?php
$tr_lelang_item_preview->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
if ($tr_lelang_item_preview->Recordset)
	$tr_lelang_item_preview->Recordset->Close();

// Output
$content = ob_get_contents();
ob_end_clean();
echo ew_ConvertToUtf8($content);
?>
<?php
$tr_lelang_item_preview->Page_Terminate();
?>
