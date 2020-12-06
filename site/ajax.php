<?php
include('includes/JSONAPIRequest.php');
if (isset($_POST['startDate'])) {
    //Get COVID-19 stats from https://api.covidtracking.com/v1/us
    $covidAPI = "https://api.covidtracking.com/v1/us";
    $startDate = new DateTime($_POST['startDate']);
    if (isset($_POST['endDate'])) {
        $endDate = new DateTime($_POST['endDate']);
    } else {
        $endDate = new DateTime();
    }
    //Prepare response
    $data = new stdClass();
    $data->stats = array();
    $date = $startDate;
    $nextDay = new DateInterval('P1D');
    while ($date <= $endDate) {
        $dateFormatted = $date->format('Ymd');
        $stats = JSONAPIRequest::get("$covidAPI/$dateFormatted.json");
        $stats = json_decode($stats);
        if (empty($stats->error)) {
            //Add to result
            $stats->date = date('Y-m-d',strtotime($stats->date));
            $data->stats[] = $stats;
        }
        $date = $date->add($nextDay);
    }
    header('Content-type: application/json');
    echo json_encode($data);
}