<?php

// row_id
// auc_date
// session_number
// t_start_bid
// t_close_bid
// auc_number
// start_bid
// close_bid
// auc_place
// auc_notes
// total_sack
// total_gross
// btn_cetak_catalog
// auc_status
// rate

?>
<?php if ($v_tr_lelang_master->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_v_tr_lelang_mastermaster" class="table ewViewTable ewMasterTable ewVertical hidden">
	<tbody>
<?php if ($v_tr_lelang_master->row_id->Visible) { // row_id ?>
		<tr id="r_row_id">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_row_id" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->row_id->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->row_id->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_row_id" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_row_id">
<span<?php echo $v_tr_lelang_master->row_id->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->row_id->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_date->Visible) { // auc_date ?>
		<tr id="r_auc_date">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_auc_date" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->auc_date->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->auc_date->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_auc_date" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_auc_date">
<span<?php echo $v_tr_lelang_master->auc_date->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_date->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->session_number->Visible) { // session_number ?>
		<tr id="r_session_number">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_session_number" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->session_number->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->session_number->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_session_number" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_session_number">
<span<?php echo $v_tr_lelang_master->session_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->session_number->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->t_start_bid->Visible) { // t_start_bid ?>
		<tr id="r_t_start_bid">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_t_start_bid" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->t_start_bid->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->t_start_bid->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_t_start_bid" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_t_start_bid">
<span<?php echo $v_tr_lelang_master->t_start_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->t_start_bid->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->t_close_bid->Visible) { // t_close_bid ?>
		<tr id="r_t_close_bid">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_t_close_bid" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->t_close_bid->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->t_close_bid->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_t_close_bid" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_t_close_bid">
<span<?php echo $v_tr_lelang_master->t_close_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->t_close_bid->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_number->Visible) { // auc_number ?>
		<tr id="r_auc_number">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_auc_number" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->auc_number->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->auc_number->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_auc_number" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_auc_number">
<span<?php echo $v_tr_lelang_master->auc_number->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_number->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->start_bid->Visible) { // start_bid ?>
		<tr id="r_start_bid">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_start_bid" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->start_bid->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->start_bid->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_start_bid" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_start_bid">
<span<?php echo $v_tr_lelang_master->start_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->start_bid->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->close_bid->Visible) { // close_bid ?>
		<tr id="r_close_bid">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_close_bid" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->close_bid->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->close_bid->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_close_bid" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_close_bid">
<span<?php echo $v_tr_lelang_master->close_bid->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->close_bid->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_place->Visible) { // auc_place ?>
		<tr id="r_auc_place">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_auc_place" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->auc_place->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->auc_place->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_auc_place" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_auc_place">
<span<?php echo $v_tr_lelang_master->auc_place->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_place->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_notes->Visible) { // auc_notes ?>
		<tr id="r_auc_notes">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_auc_notes" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->auc_notes->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->auc_notes->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_auc_notes" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_auc_notes">
<span<?php echo $v_tr_lelang_master->auc_notes->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_notes->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->total_sack->Visible) { // total_sack ?>
		<tr id="r_total_sack">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_total_sack" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->total_sack->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->total_sack->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_total_sack" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_total_sack">
<span<?php echo $v_tr_lelang_master->total_sack->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->total_sack->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->total_gross->Visible) { // total_gross ?>
		<tr id="r_total_gross">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_total_gross" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->total_gross->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->total_gross->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_total_gross" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_total_gross">
<span<?php echo $v_tr_lelang_master->total_gross->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->total_gross->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->btn_cetak_catalog->Visible) { // btn_cetak_catalog ?>
		<tr id="r_btn_cetak_catalog">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_btn_cetak_catalog" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->btn_cetak_catalog->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->btn_cetak_catalog->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_btn_cetak_catalog" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_btn_cetak_catalog">
<span<?php echo $v_tr_lelang_master->btn_cetak_catalog->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->btn_cetak_catalog->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->auc_status->Visible) { // auc_status ?>
		<tr id="r_auc_status">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_auc_status" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->auc_status->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->auc_status->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_auc_status" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_auc_status">
<span<?php echo $v_tr_lelang_master->auc_status->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->auc_status->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
<?php if ($v_tr_lelang_master->rate->Visible) { // rate ?>
		<tr id="r_rate">
			<td class="col-sm-2"><script id="tpc_v_tr_lelang_master_rate" class="v_tr_lelang_mastermaster" type="text/html"><span><?php echo $v_tr_lelang_master->rate->FldCaption() ?></span></script></td>
			<td<?php echo $v_tr_lelang_master->rate->CellAttributes() ?>>
<script id="tpx_v_tr_lelang_master_rate" class="v_tr_lelang_mastermaster" type="text/html">
<span id="el_v_tr_lelang_master_rate">
<span<?php echo $v_tr_lelang_master->rate->ViewAttributes() ?>>
<?php echo $v_tr_lelang_master->rate->ListViewValue() ?></span>
</span>
</script>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<div id="tpd_v_tr_lelang_mastermaster" class="ewCustomTemplate"></div>
<script id="tpm_v_tr_lelang_mastermaster" type="text/html">
<div id="ct_v_tr_lelang_master_master"><div class="col-sm-12 v-tr-lelang-item" style="">
	<div class="row custom_message_lost">
		<div class=" panel-custom">
			<h4>Connection with Server Disconect, Please Refresh this Page Browser.</h4>
		</div>
	</div>
	<div class="row">
		<div class="custom-width-1 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item"><?php echo $v_tr_lelang_master->auc_number->FldCaption() ?></div>
			<div class="col-sm-12 content-v-tr-lelang-item">{{include tmpl="#tpx_v_tr_lelang_master_auc_number"/}}</div>
		</div>
		<div class="custom-width-2 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item">Server Time</div>
			<div class="col-sm-12 content-v-tr-lelang-item">
				<span class="" id="date_lelang"></span><br />
				<span class="" id="time_lelang"></span>
			</div>
		</div>
		<div class="custom-width-3 panel-custom">
			<div class="col-sm-6">
				<div class="row">
					<div class="tittle-v-tr-lelang-item"><?php echo $v_tr_lelang_master->start_bid->FldCaption() ?></div>
					<div class="start-bid-v-tr-lelang-item">{{include tmpl="#tpx_v_tr_lelang_master_start_bid"/}}</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="tittle-v-tr-lelang-item"><?php echo $v_tr_lelang_master->close_bid->FldCaption() ?></div>
					<div class="close-bid-v-tr-lelang-item">{{include tmpl="#tpx_v_tr_lelang_master_close_bid"/}}</div>
				</div>
			</div>
		</div>
		<div class="custom-width-4 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item"> Time Left </div>
			<div class="col-sm-12 netto-item content-v-tr-lelang-item">
				<span id="countDown">
					<span></span>
				</span>
				<div id="auc_status" style="display: none;">{{include tmpl="#tpx_v_tr_lelang_master_auc_status"/}}</div>
				<div id="row_id_lelang_item" style="display: none;">{{include tmpl="#tpx_v_tr_lelang_master_row_id"/}}</div>
			</div>
		</div>
		<div class="custom-width-5 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item"> <?php echo $v_tr_lelang_master->total_sack->FldCaption() ?> </div>
			<div class="col-sm-12 sack-item content-v-tr-lelang-item"> {{include tmpl="#tpx_v_tr_lelang_master_total_sack"/}} </div>
		</div>
		<!-- <div class="custom-width-5 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item"> <?php echo $v_tr_lelang_master->total_netto->FldCaption() ?> </div>
			<div class="col-sm-12 netto-item content-v-tr-lelang-item"> {{include tmpl="#tpx_v_tr_lelang_master_total_netto"/}} </div>
		</div> -->
		<div class="custom-width-6 panel-custom">
			<div class="col-sm-12 tittle-v-tr-lelang-item"> <?php echo $v_tr_lelang_master->total_gross->FldCaption() ?> </div>
			<div class="col-sm-12 gross-item content-v-tr-lelang-item"> {{include tmpl="#tpx_v_tr_lelang_master_total_gross"/}} </div>
		</div>
	</div>
	<div class="row field-br custom_auc_notes ">
		<div class="custom_auc_notes_width_1 panel-custom">
			<div class="col-sm-2 tittle-v-tr-lelang-item"><?php echo $v_tr_lelang_master->auc_notes->FldCaption() ?></div>
			<div class="col-sm-10">{{include tmpl="#tpx_v_tr_lelang_master_auc_notes"/}}</div>
		</div>
		<div class="custom_auc_notes_width_2 panel-custom">
			<div class="col-sm-3 tittle-v-tr-lelang-item"><?php echo $v_tr_lelang_master->rate->FldCaption() ?></div>
			<div class="col-sm-9 rate-item ">{{include tmpl="#tpx_v_tr_lelang_master_rate"/}}</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalBid" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title" id="myModalLabel">BID</h3>
		</div>
		<div class="modal-body">
			<div id="modal-bid">
				<div class="col-sm-12">
					<div class="col-sm-12 panel-custom">
						<div class="col-sm-12 tittle-time-bid">Server Time</div>
						<div class="col-sm-12 content-v-tr-lelang-item">
							<span class="" id="date_lelang_bid"></span><br />
							<span class="" id="time_lelang_bid"></span>
						</div>
					</div>
					<div class="row field-br">
						<div class="col-sm-3 tittle-bid">Nilai Bid</div>
						<div class="col-sm-9">
							<div class="input-group" >
								<input type="text" id="bid_value" class="form-control"/>
								<span class="input-group-btn">
									<button id="bidUp" type="button" class="btn btn-default btn-sm" style="font-size: 12px; height: 20px; padding: 0 10px;">
										<i class="fa fa-angle-up" aria-hidden="true"></i>
									</button><br>
									<button id="bidDown" type="button" class="btn btn-default btn-sm" style="font-size: 12px; height: 20px; padding: 0 10px;">
										<i class="fa fa-angle-down" aria-hidden="true"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" onclick="addBid()">Save</button>
		</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalReqSample" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title" id="myModalLabel">Request Sample</h3>
		</div>
		<div class="modal-body">
			<div class="message-req-sample">
				<h4>Anda Yakin ingin mengajukan permintaan sample teh?.</h4>
			</div>
			<br>
			<div class="ewMessageDialog success-req-sample" style="display: none;">
				<div class="alert alert-success ewSuccess">
					<!-- <button type="button" class="close" data-dismiss="alert">×</button> -->
					<h4>Permintaan sampel teh akan segera kami kirim, terimakasih.</h4>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="spinner-border text-danger spinner_req" role="status" style="display: none; margin-right: 10px;">
				<span class="sr-only">Loading...</span>
			</div>
			<button id="addReqSample" type="button" class="btn btn-primary" onclick="addReqSample()" >
				Submit
			</button>
			<button id="cancelReqSample" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>			
		</div>
		</div>
	</div>
</div>
<div id="loader-wrapper">
	<div id="loader"></div>
	<div class="loader-section section-left"></div>
	<div class="loader-section section-right"></div>
</div>
</div>
</script>
<script type="text/javascript">
ewVar.templateData = { rows: <?php echo ew_ArrayToJson($v_tr_lelang_master->Rows) ?> };
ew_ApplyTemplate("tpd_v_tr_lelang_mastermaster", "tpm_v_tr_lelang_mastermaster", "v_tr_lelang_mastermaster", "<?php echo $v_tr_lelang_master->CustomExport ?>", ewVar.templateData.rows[0]);
jQuery("script.v_tr_lelang_mastermaster_js").each(function(){ew_AddScript(this.text);});
</script>
<?php } ?>
