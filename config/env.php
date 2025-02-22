<?php
// enable us to use Headers
ob_start();

// set sessions
if (!isset($_SESSION)) {
    session_start();
}

// set timezone
date_default_timezone_set("Asia/Bangkok");

// set value
$main_description = "tours management system by shambhala.travel";
$main_keywords = "tours management system";
$main_author = "Blue Planet";
$main_title = "Blue Planet";
$hostPageUrl = $_SERVER["HTTP_HOST"] == 'localhost' ? 'storage' : 'http://' . $_SERVER["HTTP_HOST"] . "/storage";
// $main_document = "<h3>บริษัท SHAMBHALA TRAVEL จํากัด </h3>
// 156/72 หมู่ที 5 ตําบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000 <br>
// เลขทีผู้เสียภาษี 0-8355-64008-01-7 | (สํานักงานใหญ่) <br>
// โทร: 081-691-6501 | info@shambhala.com <br>
// www.shambhala.travel <br>";
$open_rates = 1;
$main_document = "<h3>Blue Planet Holiday Co.,Ltd.</h3>
124/343 หมู่ที่ 5 ตำบลรัษฎา อําเภอเมือง จังหวัดภูเก็ต 83000 <br>
เลขทีผู้เสียภาษี 0-8355-67011-16-7 | (สํานักงานใหญ่) <br>
Tel : 095-686-9666, 061-239-6505, 083-431-8686  | blueplanet803@gmail.com";
