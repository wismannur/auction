<?php

// Global user functions
// Page Loading event
function Page_Loading() {

	//echo "Page Loading";
}

// Page Rendering event
function Page_Rendering() {

	//echo "Page Rendering";
}

// Page Unloaded event
function Page_Unloaded() {

	//echo "Page Unloaded";
}

function GetNextAucNumber($tgl) {
	$sNextCode = "";
	$sLastCode = "";
	$dt = strtotime($tgl);
	$sKey = date("ymd",$dt)."-";
	$value = ew_ExecuteScalar("SELECT MAX(SUBSTR(auc_number,8,3)) FROM tr_lelang_master WHERE SUBSTR(auc_number,1,7) = '".$sKey."'");	
	if ($value != "") {  
		$sLastCode = intval($value) + 1;  
		$sNextCode = $sKey .sprintf('%003s', $sLastCode);  
	} else {  
		$sNextCode = $sKey ."001";
	}
	return $sNextCode;
}

function GetNextPFNumber() {
	$sNextCode = "";
	$sLastCode = "";
	$sKey = "PI" .substr(date("Y"),2,2);
	$value = ew_ExecuteScalar("SELECT MAX(SUBSTR(proforma_number,6,6)) FROM tr_lelang_item WHERE SUBSTR(proforma_number,1,5) = '".$sKey."'");	
	if ($value != "") {  
		$sLastCode = intval($value) + 1;  
		$sNextCode = $sKey .sprintf('%006s', $sLastCode);  
	} else {  
		$sNextCode = $sKey ."000001";
	}
	return $sNextCode;
}
?>
