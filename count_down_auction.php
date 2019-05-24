<?php

date_default_timezone_set('Asia/Jakarta');

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

$current_date = "$month/$date/$year $hour:$min:$sec";
// echo strtotime( $_GET['start_bid'] );
// echo strtotime( $_GET['close_bid'] );
// echo time();

$data = array('current_date' => $current_date,
    'start_bid' => strtotime( $_GET['start_bid'] ),
    'close_bid' => strtotime( $_GET['close_bid'] ),
    'time' => time(),
    'date' => $date,
    'month' => $month,
    'year' => $year,
    'hour' => $hour,
    'min' => $min,
    'sec' => $sec
);

echo json_encode($data);

?>