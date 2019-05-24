<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(36, "mi_home_php", $Language->MenuPhrase("36", "MenuText"), "home.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}home.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(12, "mi_v_tr_lelang_master", $Language->MenuPhrase("12", "MenuText"), "v_tr_lelang_masterlist.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_tr_lelang_master'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(14, "mi_v_proforma", $Language->MenuPhrase("14", "MenuText"), "v_proformalist.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_proforma'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(33, "mi_v_bid_histories", $Language->MenuPhrase("33", "MenuText"), "v_bid_historieslist.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_bid_histories'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(34, "mi_v_payment_histories", $Language->MenuPhrase("34", "MenuText"), "v_payment_historieslist.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_payment_histories'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mci_Setup", $Language->MenuPhrase("7", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(3, "mi_tr_lelang_master", $Language->MenuPhrase("3", "MenuText"), "tr_lelang_masterlist.php", 7, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}tr_lelang_master'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(41, "mi_tr_home", $Language->MenuPhrase("41", "MenuText"), "tr_homelist.php", 7, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}tr_home'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(21, "mci_Auction", $Language->MenuPhrase("21", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(38, "mi_v_auction_list_admin", $Language->MenuPhrase("38", "MenuText"), "v_auction_list_adminlist.php", 21, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_auction_list_admin'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(32, "mi_v_req_sample", $Language->MenuPhrase("32", "MenuText"), "v_req_samplelist.php", 21, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_req_sample'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(37, "mi_v_payment_confirmation", $Language->MenuPhrase("37", "MenuText"), "v_payment_confirmationlist.php", 21, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}v_payment_confirmation'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mci_Administrator", $Language->MenuPhrase("6", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_members", $Language->MenuPhrase("1", "MenuText"), "memberslist.php", 6, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}members'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10, "mi_tbl_faq", $Language->MenuPhrase("10", "MenuText"), "tbl_faqlist.php", -1, "", AllowListMenu('{DFE89B97-9D22-437D-AA4F-59294E95069A}tbl_faq'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
