<?php

require_once 'controllers/Zone.php';

$zoneObj = new Zone();
$zones = $zoneObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- place list start -->
            <section class="app-supplier-list">
                <!-- place filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="place-search-form" name="place-search-form" method="post" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mx-50 row pt-0 pb-2">
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label for="is_approved">Status</label>
                                    <select class="form-control select2" id="is_approved" name="is_approved">
                                        <option value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- place filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="place-search-table">
                        <table class="place-list-table table table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Province</th>
                                    <th class="cell-fit"></th>
                                </tr>
                            </thead>
                            <?php if ($zones) { ?>
                                <tbody>
                                    <?php
                                    foreach ($zones as $zone) {
                                        $is_approved = $zone['is_approved'] == 1 ? 'Active' : 'Inactive';
                                        $is_approved_class = $zone['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                                        $href = 'href="./?pages=zone/edit&id=' . $zone['id'] . '" style="color:#6E6B7B"';
                                    ?>
                                        <tr>
                                            <td><a <?php echo $href; ?>><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a <?php echo $href; ?>><?php echo !empty($zone['name']) ? !empty($zone['name_th']) ? $zone['name'] . ' (' . $zone['name_th'] . ')' : $zone['name'] : ''; ?></a></td>
                                            <td><a <?php echo $href; ?>><?php echo !empty($zone['pov_nameen']) ? !empty($zone['pov_nameth']) ? $zone['pov_nameen'] . ' (' . $zone['pov_nameth'] . ')' : $zone['pov_nameen'] : ''; ?></a></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- place assistant list ends -->
            <?php
            // $data = array(
            //     array("hotel" => "ARECA RESORT & SPA อาริกา รีสอร์ต แอนด์ สปา", "zones" => "กระทู้"),
            //     array("hotel" => "PRINCE OF SONGKLA UNIVERSITY, PHUKET CAMPUS มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตภูเก็ต", "zones" => "กระทู้"),
            //     array("hotel" => "The Palms Residence เดอะ ปาล์ม เรสซิเดนซ์ ", "zones" => "กระทู้"),
            //     array("hotel" => "The Par Phuket โรงแรมเดอะพาร์ ภูเก็ต", "zones" => "กระทู้"),
            //     array("hotel" => "WESTIN SIRAY BAY RESORT AND SPA PHUKET เดอะ เวสทิน สิเหร่ เบย์ รีสอร์ท แอนด์ สปา ภูเก็ต", "zones" => "เกาะสิเหร่"),
            //     array("hotel" => "The Tide Beachfront  Siray  Phuket เดอะ ไทย์", "zones" => "เกาะสิเหร่"),
            //     array("hotel" => "THE RACHA เดอะ ราชา", "zones" => "ฉลอง"),
            //     array("hotel" => "Anchan Boutique Hotel อัญชัน บูติค โฮเทล", "zones" => "ฉลอง"),
            //     array("hotel" => "Aochalong Villa Resort & Spa อ่าวฉลอง วิลล่า รีสอร์ท แอนด์ วิลล่า", "zones" => "ฉลอง"),
            //     array("hotel" => "Arch39 Beachfront Phuket อาร์ค39 ภูเก็ต บีชฟรอนต์ ภูเก็ต", "zones" => "ฉลอง"),
            //     array("hotel" => "Baba House Hotel โรงแรมบาบ๋าเฮ้าส์", "zones" => "ฉลอง"),
            //     array("hotel" => "COCO VILLE PHUKET RESORT โคโค่วิลล์ ภูเก็ต รีสอร์ท ", "zones" => "ฉลอง"),
            //     array("hotel" => "Phuket Marine Poshtel ภูเก็ต มารีน พอชเทล", "zones" => "ฉลอง"),
            //     array("hotel" => "The Blue Hotel โรงแรมเดอะ บลู ", "zones" => "ฉลอง"),
            //     array("hotel" => "THE ELYSIUM RESIDENCE ดิ เอลิเซียม เรสซิเดนซ์", "zones" => "ฉลอง"),
            //     array("hotel" => "The Lake Chalong Resort Phuket เดอะ เลค ฉลอง รีสอร์ท", "zones" => "ฉลอง"),
            //     array("hotel" => "The Racha เดอะราชา", "zones" => "ฉลอง"),
            //     array("hotel" => "The Thames Pool Access Resort   เดอะ เทมส์ พูลแอคเซส รีสอร์ท", "zones" => "ฉลอง"),
            //     array("hotel" => "Villa Zolitude Resort & Spa  วิลล่า โซนิจูด", "zones" => "ฉลอง"),
            //     array("hotel" => "Vipa House - Phuket  วิภา เฮ้า", "zones" => "ฉลอง"),
            //     array("hotel" => "Wanawalai Luxury Villa วนาวลัย ลักซ์ชัวรี วิลล่า", "zones" => "ฉลอง"),
            //     array("hotel" => "MISSION HILLS PHUKET GOLF RESORT มิชชั่น ฮิลล์ ภูเก็ต กอล์ฟ รีสอร์ท", "zones" => "ถลาง"),
            //     array("hotel" => "NAKA ISLAND นาคา ไอส์แลนด์ ", "zones" => "ถลาง"),
            //     array("hotel" => "SUPALAI SCENIC BAY RESORT & SPA ศุภาลัย ซีนิค เบย์ รีสอร์ท แอนด์ สปา", "zones" => "ถลาง"),
            //     array("hotel" => "THANYAPURA RETREAT ธัญญปุระ รีเทรด", "zones" => "ถลาง"),
            //     array("hotel" => "THANYAPURA SPORTS HOTEL ธัญญปุระ สปอร์ต", "zones" => "ถลาง"),
            //     array("hotel" => "8IK88 RESORT 8IK88 รีสอร์ท", "zones" => "ถลาง"),
            //     array("hotel" => "Boutique Resort บูติค รีสอร์ท", "zones" => "ถลาง"),
            //     array("hotel" => "CASADA SUITTE Pool Villas คาซาดา สวีท พูลวิลลา", "zones" => "ถลาง"),
            //     array("hotel" => "Chandara Resort & Spa จันทร์ดารา รีสอร์ท แอนด์ สปา ", "zones" => "ถลาง"),
            //     array("hotel" => "COMO Point Yamu โคโม พอยท์ ยามู", "zones" => "ถลาง"),
            //     array("hotel" => "Gold chariot โกลด์ ชาริออท", "zones" => "ถลาง"),
            //     array("hotel" => "Hanuman V.I.P Hostel หนุมาน วีไอพี โฮสเทล ", "zones" => "ถลาง"),
            //     array("hotel" => "Poolrada Boutique Hotel พูลรดา บูทีค โฮเทล ", "zones" => "ถลาง"),
            //     array("hotel" => "Rattana Residence Thalang รัตนา เรสซิเดนซ์ ถลาง", "zones" => "ถลาง"),
            //     array("hotel" => "Supalai Scenic Bay Resort And Spa ศุภาลัย ซีนิค เบย์ รีสอร์ท แอนด์ สปา ", "zones" => "ถลาง"),
            //     array("hotel" => "Thanyapura Sports and Health Resort ธัญญปุระ สปอร์ต แอนด์ เฮลท์ รีสอร์ท ", "zones" => "ถลาง"),
            //     array("hotel" => "The Naka Island, A Luxury Collection Resort & Spa, Phuket เดอะ นาคา ไอส์แลนด์ อะ ลักชัวรี คอลเลกชั่น รีสอร์ต แอนด์ สปา ภูเก็ต", "zones" => "ถลาง"),
            //     array("hotel" => "The Rubber Hotel  เดอะ รับเบอร์ โฮเทล", "zones" => "ถลาง"),
            //     array("hotel" => "Villa Amaravida  วิลล่า  อมาราวิดา", "zones" => "ถลาง"),
            //     array("hotel" => "Villa Leelawadee วิลล่า ลีลาวดี", "zones" => "ถลาง"),
            //     array("hotel" => "Villa Padma  วิลล่า พาดม่า", "zones" => "ถลาง"),
            //     array("hotel" => "Villa Sawarin   วิลล่า ซาวาริน", "zones" => "ถลาง"),
            //     array("hotel" => "Yipmunta  ยิปมันตรา", "zones" => "ถลาง"),
            //     array("hotel" => "V Villas Phuket  วี  วิลล่า ภูเก็ต", "zones" => "พันวา"),
            //     array("hotel" => "BOAT LAGOON RESORT โบ๊ทลากูน ภูเก็ต รีสอร์ท", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "CORAL ISLAND RESORT คอรัล ไอส์แลนด์ รีสอร์ท", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "METROPOLE HOTEL, PHUKET โรงแรมเมโทรโพลภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "MILLENNIUM AUTO GROUP CO.,LTD. มิลเลนเนียม ออโต้ กรุ๊ป สาขาภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "NOVOTEL PHUKET CITY PHOKEETHRA โรงแรมโนโวเทล ภูเก็ต ซิตี้ โภคีธรา", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "THE PAGO DESIGN PHUKETโรงแรม เดอะ พาโก้ ดีไซด์ ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "PEARL HOTEL โรงแรมเพิร์ล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "PHUKET MERLIN HOTEL โรงแรม ภูเก็ตเมอร์ลิน", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "RAMADA PLAZA CHAO FAH รามาดา พลาซ่า เจ้าฟ้า", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "RECENTA PHUKET SUANLUANG รีเซนต้า ภูเก็ต สวนหลวง", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "RECENTA STYLE PHUKET TOWN รีเซนต้า สไตล์ ภูเก็ตทาวน์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "RECENTA SUITE PHUKET SUANLUANG รีเซนต้า สวีท ภูเก็ต สวนหลวง", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "ROYAL PHUKET CITY HOTEL โรงแรมรอยัลภูเก็ตซิตี้", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "SEABED GRAND HOTEL PHUKET โรงแรมซีเบด แกรนด์ ภูเก็ต ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "SINO HOUSE ซิโนเฮาส์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "TINT @ PHUKET TOWN เดอะ ทินท์ แอท ภูเก็ตทาวน์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "VILLAGE COCONUT ISLAND เดอะ วิลเลจ โคโคนัท ไอส์แลนด์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "WEB CONNECTION CO.,LTD. เว็บ คอนเน็คชั่น จำกัด", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "99 OLDTOWN BOUTIQUE GUESTHOUSE 99 โอลด์ทาวน์ บูติค เกสต์เฮ้าส์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Ang Pao Hotel อั่งเปา โฮเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Bhukitta Boutique Hotel บูกิตตา บูทีค โฮเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Bloo Hostel Phuket บลู โฮสเทล ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Blu Monkey Bed & Breakfast บลู มังกี้ เบด แอนด์ เบรคฟาสต์ ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Blu Monkey Boutique Phuket Town บลูมังกี้ บูทิก ภูเก็ตทาวน์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Blu Monkey Hub & Hotel Phuket บลูมังกี้ ฮับ แอนด์ โฮเทล ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "BOAT LAGOON RESORT โบ๊ทลากูน ภูเก็ต รีสอร์ท", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Book a Bed Poshtel บุ๊ค อะ เบด พอช เทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "CA Hotel and Residence ซีเอ โฮเทล แอนด์ เรสซิเดนซ์ ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Casa blanca Boutique hotel คาซาบลังกา บูติก โฮเต็ล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Chino Town at Yaowarat Phuket ชิโนทาวน์ แอท เยาวราช ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Chino Town Gallery Alley ชิโนทาวน์ แกลเลอรี แอลลีย์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "CHINOTEL โรงแรม ชิโนเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Courtyard by Marriott Phuket Town คอร์ทยาร์ด แมริออท ภูเก็ต ทาวน์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Ecoloft Hotel อีโคลอฟต์ โฮเต็ล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "FULFILL HOSTEL ฟูลฟิล ภูเก็ต โฮสเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Grand Supicha City Hotel โรงแรมแกรนด์ สุพิชฌาย์ ซิตี้ ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Greenleaf Hostel กรีน ลีฟ โฮสเทล ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "I Pavilion Hotel Phuket โรงแรมไอ พาวิลเลี่ยน ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "ibis Styles Phuket City ไอบิส สไตล์ ภูเก็ต ซีตี้", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Ideo Phuket Hotel โรงแรมไอดีโอ ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "lamoon resotel โรงแรมลามูนรีโซเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Lub Sbuy House Hotel โรงแรม หลับสบายเฮ้าส์ โฮเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Mayfa Hotel โรงแรมเมธ์ฟ้า", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "MEI ZHOU PHUKET HOTEL โรงแรมเหม่ยโจว ภูเก็ต ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Modern Thai Suites Hotel โมเดิร์นไทย สวีท", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "My stays phuket มายสเตย์ ภูเก็ต ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Phuketa Hotel โรงแรมภูคีตา ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "PRIME TOWN POSH & PORT HOTEL PHUKET ไพรม์ ทาวน์ - พอร์ช แอนด์ พอร์ต โฮเต็ล ภูเก็ต ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Ratana Hotel Rassada โรงแรมรัตนา รัษฎา ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Ratana Hotel Sakdidet โรงแรมรัตนา ศักดิเดช", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Rome Place Hotel โรงแรมโรมเพลส ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Seabed Grand Hotel Phuket ซีเบด แกรนด์ โฮเทล ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Sino House Phuket โรงแรมชิโนเฮ้าส์ ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Sino Imperial Phuket  Hotel ชิโน อิมพีเรียล ภูเก็ต โฮเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Sino Inn Phuket Hotel โรงแรมชิโน อินน์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Sleep Sheep Phuket สลีปชีป ภูเก็ต โฮสเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Sound Gallery House ซาวด์ แกลเลอรี เฮาส์ ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "SP Mansion Hotel โรงแรม เอสพี แมนชั่น", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Supicha pool access hotel สุพิชฌาย์ พูล แอคเซส โฮเต็ล ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Arbern Hotel x Bistro ดิ อาร์เบิร์น โฮเทล x บิสโทร", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Besavana Phuket Hotel เดอะ บีสวาน่า ภูเก็ต ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Blanket Hotel เดอะ แบล็งเก็ต โฮเต็ล ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Malika Hotel โรงแรมเดอะ มาลิกา ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Memory At On On Hotel โรงแรมเดอะเมมโมรี แอท ออนออน ", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Pago Design Hotel โรงแรม เดอะ พาโก้ ดีไซด์ ภูเก็ต", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "The Topaz Residence เดอะ โทแพ็ส เรสซิเดนซ์", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "VAPA HOTEL วาปา โฮเทล", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Xinlor House ซินหล่อ เฮ้า", "zones" => "เมืองภูเก็ต"),
            //     array("hotel" => "Hyatt Regency Phuket Resort ไฮแอท รีเจนซี่ ภูเก็ต รีสอร์ท", "zones" => "หาดกมลา"),
            //     array("hotel" => "AQUAMARINE RESORT & VILLA อความารีน รีสอร์ท แอนด์ สปา", "zones" => "หาดกมลา"),
            //     array("hotel" => "AYARA VILLAS ไอยรา วิลล่า", "zones" => "หาดกมลา"),
            //     array("hotel" => "INTERCONTINENTAL PHUKET RESORT อินเตอร์คอนติเนนตัล ภูเก็ต รีสอร์ท", "zones" => "หาดกมลา"),
            //     array("hotel" => "KEEMALA กีมาลา", "zones" => "หาดกมลา"),
            //     array("hotel" => "Andara Resort and Villas อันดาร่า รีสอร์ท แอนด์ วิลล่า", "zones" => "หาดกมลา"),
            //     array("hotel" => "Ayara Kamala Resort & Spa โรงแรมไอยรา กมลา รีสอร์ท แอนด์ สปา", "zones" => "หาดกมลา"),
            //     array("hotel" => "Baanchomview Kamala Hotel บ้านชมวิว กมลา ", "zones" => "หาดกมลา"),
            //     array("hotel" => "Buk inn Hotel โรงแรมบุ๊ค อินน์", "zones" => "หาดกมลา"),
            //     array("hotel" => "Cape Sienna Phuket Gourmet Hotel & Villas เคป เซียนนา กูร์เมต์ โฮเต็ล แอนด์ วิลลา", "zones" => "หาดกมลา"),
            //     array("hotel" => "Chabana Resort ชบาน่า รีสอร์ท ", "zones" => "หาดกมลา"),
            //     array("hotel" => "Hyatt Regency Phuket Resort ไฮแอท รีเจนซี่ ภูเก็ต รีสอร์ท", "zones" => "หาดกมลา"),
            //     array("hotel" => "Kamala Beach Estate กมลา บีช เอสเตท", "zones" => "หาดกมลา"),
            //     array("hotel" => "Kamala Beach Hotel กมลา บีช โฮเต็ล", "zones" => "หาดกมลา"),
            //     array("hotel" => "Kamala Beach Residence กมลา บีช เรสซิเดนซ์", "zones" => "หาดกมลา"),
            //     array("hotel" => "Kamala Resotel กมลา รีโซเทล", "zones" => "หาดกมลา"),
            //     array("hotel" => "Namaka Resort Kamala นามาคา รีสอร์ท กมลา", "zones" => "หาดกมลา"),
            //     array("hotel" => "Novotel Phuket Kamala Beach โรงแรมโนโวเทล ภูเก็ต กมลา บีช", "zones" => "หาดกมลา"),
            //     array("hotel" => "Paresa resort phuket ภารีสา รีสอร์ท ภูเก็ต", "zones" => "หาดกมลา"),
            //     array("hotel" => "The Cool Water เดอะ คูลวอเตอร์ กมลา", "zones" => "หาดกมลา"),
            //     array("hotel" => "The Naka Phuket เดอะ นาคา ภูเก็ต วิลลา ", "zones" => "หาดกมลา"),
            //     array("hotel" => "The Palms Kamala เดอะ ปาล์ม กมลา ", "zones" => "หาดกมลา"),
            //     array("hotel" => "The Pe La Resort เดอะ เพ ลา รีสอร์ท ภูเก็ต ", "zones" => "หาดกมลา"),
            //     array("hotel" => "Villa Analaya  วิลล่า อันลายา", "zones" => "หาดกมลา"),
            //     array("hotel" => "ANDAMAN CANNACIA RESORT & SPA อันดามัน คาเนเซีย รีสอร์ท แอนด์ สปา", "zones" => "หาดกะตะ"),
            //     array("hotel" => "BEYOND RESORT KATA บียอนด์  รีสอร์ท กะตะ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "BOATHOUSE ON KATA BEACH โบทเฮ้าส์ ออน กะตะ บีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "CENTARA KATA RESORT PHUKET เซ็นทารา กะตะ  รีสอร์ท ภูเก็ต", "zones" => "หาดกะตะ"),
            //     array("hotel" => "CLUB MEDITERRANEE คลับเมดิแตร์ราเน", "zones" => "หาดกะตะ"),
            //     array("hotel" => "KATA ROCKS RESORT กะตะ ร็อค รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "KATA SEA BREEZE RESORT กะตะ ซีบรีซ รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "KATATHANI PHUKET BEACH RESORT กะตะธานี ภูเก็ต บีช รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "MALISA VILLA SUITES มะลิษา วิลล่า สวีท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "MOM TRI'S VILLA ROYALE HOTEL หม่อมตรีวิลล่า รอแยล", "zones" => "หาดกะตะ"),
            //     array("hotel" => "NOVOTEL PHUKET KATA AVISTA RESORT AND SPA โรงแรม โนโวเทล ภูเก็ต กะตะ อวิสต้า รีสอร์ท แอนด์ สปา", "zones" => "หาดกะตะ"),
            //     array("hotel" => "ORCHIDACEA RESORT ออร์คิดเดเซีย รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "PEACH HILL RESORT พีช ฮิลล์ รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "THE SIS KATA RESORT เดอะ ซิส กะตะ รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "THE YAMA HOTEL PHUKET เดอะ ยามา โฮเทล ภูเก็ต", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Aurico Kata Resort & Spa ออริโก้กะตะ รีสอร์ท แอนด์ สปา", "zones" => "หาดกะตะ"),
            //     array("hotel" => "DOME KATA RESORT โดม กะตะ รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Ibis Phuket Kata ไอบิส ภูเก็ต กะตะ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Impiana Private Villas Kata Noi อิมเพียน่า ไพรเวท วิลล่า กะตะน้อย", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata Bai D กะตะ บายดี", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata hill sea view กะตะฮิลล์ ซีวิว", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata Leaf Rerost กะตะ ลีฟ รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata Palm Resort & Spa กะตะ ปาล์ม รีสอร์ท แอนด์ สปา", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata Sun Beach โรงแรมกะตะ ซัน บีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "KATA TRANQUIL VILLA กะตะ ทรานควิล วิลล่า", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Katamanda - Villa Amanzi by Elite Havens กะตะมันดา - วิลล่า อะมันซี ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Kata pool side resort Kata beach กะตะ พูลไซด์ รีสอร์ท กะตะ บีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Metadee Concept Hotel โรงแรม เมธาดี คอนเซ็ปต์", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Oneloft Hotel โรงแรมวันลอฟต์ ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Sugar Marina Resort-Fashion-Kata Beach ชูการ์ มารีน่า รีสอร์ท แฟชั่น กะตะ บีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Sugar Marina Resort-Nautical-Kata Beach ชูการ์ มารีน่า รีสอร์ท นอติคอล กะตะ บีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "Sugar Marina Resort-Surf-Kata Beach Phuket ชูการ์ มารีน่า โฮเทล-เซิร์ฟ-กะตะบีช", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Beach Boutique House โรงแรมเดอะ บีช บูติค เฮาส์ ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Beach Heights Resort เดอะ บีช ไฮท์ รีสอร์ท ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Boathouse Phuket เดอะ โบทเฮ้าส์ ภูเก็ต ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Palmery Resort Phuket เดอะ ปาลเมอรี รีสอร์ท", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Sea Galleri by Katathani  เดอะซี แกลอรี่ บาย กะตะธานี", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The Shore at Katathani  เดอะ ชอร์ แอท กะตะธานี", "zones" => "หาดกะตะ"),
            //     array("hotel" => "The SIS Kata  เดอะ ซิส กะตะ", "zones" => "หาดกะตะ"),
            //     array("hotel" => "ACCESS RESORT & VILLAS   แอคเซส รีสอร์ท แอนด์ วิลล่า", "zones" => "หาดกะรน"),
            //     array("hotel" => "ANDAMAN SEAVIEW โรงแรมอันดามันซีวิว", "zones" => "หาดกะรน"),
            //     array("hotel" => "AVISTA GRANDE PHUKET KARON, M GALLERY  อวิสต้า แกรนด์ ภูเก็ต กะรน - เอ็มแกลลอรี", "zones" => "หาดกะรน"),
            //     array("hotel" => "BAAN KARON RESORT บ้านกะรนรีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "BEST WESTERN PHUKET OCEAN RESORT เบสท์เวสเทิร์น ภูเก็ต โอเชียน รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "BEYOND RESORT KARON บียอนด์  รีสอร์ท กะรน", "zones" => "หาดกะรน"),
            //     array("hotel" => "CENTARA GRAND BEACH RESORT PHUKET เซ็นทารา แกรนด์ บีช รีสอร์ท ภูเก็ต", "zones" => "หาดกะรน"),
            //     array("hotel" => "CENTARA KARON RESORT PHUKET เซ็นทารา กะรน  รีสอร์ท ภูเก็ต", "zones" => "หาดกะรน"),
            //     array("hotel" => "CENTARA VILLAS PHUKET เซ็นทารา วิลล่า ภูเก็ต", "zones" => "หาดกะรน"),
            //     array("hotel" => "CHANALAI FLORA RESORT โรงแรมชนาลัย ฟลอร่า รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "DIAMOND COTTAGE RESORT & SPA ไดมอนด์ คอทเทจ รีสอร์ท แอนด์ สปา ", "zones" => "หาดกะรน"),
            //     array("hotel" => "HILTON PHUKET ARCADIA RESORT & SPA โรงแรมฮิลตัน ภูเก็ต อาร์เคเดีย รีสอร์ท แอนด์ สปา", "zones" => "หาดกะรน"),
            //     array("hotel" => "KARON PHUNAKA RESORT  กะรน ภูนาคา รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "KARON PRINCESS HOTEL โรงแรมกะรน พริ้นเซส", "zones" => "หาดกะรน"),
            //     array("hotel" => "KARON SEA SANDS RESORT  กะรน ซีแซนด์ รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "LE MERIDIEN PHUKET BEACH RESORT เลอ เมอริเดียน ภูเก็ต บีช รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "MOVENPICK RESORT & SPA KARON BEACH PHUKET เมอเวนพิค รีสอร์ท แอนด์ สปา กะรน บีช ภูเก็ต", "zones" => "หาดกะรน"),
            //     array("hotel" => "THE OLD PHUKET-KARON BEACH RESORT ดิ โอลด์ ภูเก็ต กะรน บีช รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "RAMADA PHUKET SOUTH SEA รามาดา  ภูเก็ต เซาท์ซี", "zones" => "หาดกะรน"),
            //     array("hotel" => "Avista Grande Phuket Karon Mgallery อวิสต้า แกรนด์ ภูเก็ต กะรน - เอ็มแกลเลอรี่", "zones" => "หาดกะรน"),
            //     array("hotel" => "Baan Karonburi Resort บ้านกะรนบุรี รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "Dome Resort โดม  รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "Hotel IKON Phuket โรงแรมไอคอน ภูเก็ต", "zones" => "หาดกะรน"),
            //     array("hotel" => "KARON LIVINGROOM กะรน ลิฟวิ่ง รูม ", "zones" => "หาดกะรน"),
            //     array("hotel" => "Mandarava Resort and Spa มันดาราวา รีสอร์ท แอนด์ สปา ", "zones" => "หาดกะรน"),
            //     array("hotel" => "Phuket Golden Sand Inn โรงแรม ภูเก็ตโกลเด้นแซนด์อินน์", "zones" => "หาดกะรน"),
            //     array("hotel" => "Phuket Island View Hotel ภูเก็ต ไอส์แลนด์ วิว รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "Phuket Orchid Resort and Spa ภูเก็ต ออร์คิด รีสอร์ท แอนด์ สปา", "zones" => "หาดกะรน"),
            //     array("hotel" => "Sugar Marina Resort-ART-Karon Beach Phuket ชูการ์ มารีน่า รีสอร์ท อาร์ท กะรน บีช", "zones" => "หาดกะรน"),
            //     array("hotel" => "Sugar Palm Grand Hillside โรงแรมชูการ์ ปาล์ม แกรนด์ ฮิลล์ไซด์ ", "zones" => "หาดกะรน"),
            //     array("hotel" => "The Front Village โรงแรมเดอะฟรอนท์ วิลเลจ ", "zones" => "หาดกะรน"),
            //     array("hotel" => "The Melody Phuket เดอะ เมโลดี้ ภูเก็ต โฮเทล ", "zones" => "หาดกะรน"),
            //     array("hotel" => "The Old Phuket Karon Beach Resort ดิ โอลด์ ภูเก็ต กะรน บีช รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "The Spa Resorts (The Village)  เดอะสปา รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "Woraburi Phuket Resort & Spa วรบุรี ภูเก็ต รีสอร์ท", "zones" => "หาดกะรน"),
            //     array("hotel" => "KALIMA RESORT & SPA คาลิมา รีสอร์ท แอนด์ สปา", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "THE NATURE PHUKET โรงแรม เดอะเนเจอร์ ภูเก็ต", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "NOVOTEL PHUKET RESORT โนโวเทล ภูเก็ต รีสอร์ท", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "SUNSET BEACH RESORT ซันเซ็ท บีช รีสอร์ท", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "THAVORN BEACH VILLAGE & SPA ถาวร บีช วิลเลจ รีสอร์ท แอนด์ สปา", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "ZENMAYA OCEANFRONT PHUKET เซ็นมายา โอเชี่ยนฟรอนท์ ภูเก็ต", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "INDOCHINE RESORTS AND VILLAS อินโดจีนรีสอร์ทแอนด์วิลล่า", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "Marina Gallery Resort Kacha kalim Bay มารีนา แกลลอรี รีสอร์ต-คชา-กะหลิมเบย์ ภูเก็ต", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "Wyndham Grand Phuket Kalim Bay วินดอม แกรน ภูเก็ต กะหลิ่ม เบย์", "zones" => "หาดกะหลิม"),
            //     array("hotel" => "Baan Yin Dee Boutique Resort บ้านยินดี บูทิค รีสอร์ท", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "PHUKET MARRIOTT RESORT AND SPA , MERLIN BEACH โรงแรมภูเก็ต แมริออท รีสอร์ทแอนด์สปา เมอร์ลินบีช ", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "ROSEWOOD PHUKET โรสวูด ภูเก็ต", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "Avista Hideaway Phuket Patong, Mgallery อวิสต้า ไฮด์อเวย์ ภูเก็ต ป่าตอง - เอ็มแกลลอรี", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "Baan Yuree Resort บ้าน ยุรี  รีสอร์ท ", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "Crest resort and pool villas เครสท์ รีสอร์ท แอนด์ พูล วิลล่า", "zones" => "หาดไตรตรัง"),
            //     array("hotel" => "ANDAMAN WHITE BEACH RESORT อันดามัน ไวท์ บีช รีสอร์ท", "zones" => "หาดในทอน"),
            //     array("hotel" => "DOUBLE TREE BY HILTON PHUKET BANTHAI RESORT ดับเบิ้ลทรี บาย ฮิลตัน ภูเก็ต บ้านไทย รีสอร์ท", "zones" => "หาดในทอน"),
            //     array("hotel" => "Casa Sakoo Resort คาซา สาคู รีสอร์ท", "zones" => "หาดในทอน"),
            //     array("hotel" => "Naithonburi Beach Resort ในทอน บุรี บีช รีสอร์ท ", "zones" => "หาดในทอน"),
            //     array("hotel" => "PULLMAN PHUKET ARCADIA NAITHON BEACH พูลแมน ภูเก็ต อาเคเดีย ในทอน บีช รีสอร์ท", "zones" => "หาดในทอน"),
            //     array("hotel" => "The lifeco Phuket   เดอะ ลิฟีโก  ภูเก็ต", "zones" => "หาดในทอน"),
            //     array("hotel" => "Trisara ไตรซาร่า", "zones" => "หาดในทอน"),
            //     array("hotel" => "Villa Paradiso  วิลล่า พาราดิโซ", "zones" => "หาดในทอน"),
            //     array("hotel" => "DEWA PHUKET RESORT & VILLAS  โรงแรมเดวาภูเก็ต รีสอร์ท แอนด์ วิลล่า", "zones" => "หาดในยาง"),
            //     array("hotel" => "NAI YANG BEACH RESORT & SPA ในยางบีช รีสอร์ท แอนด์ สปา", "zones" => "หาดในยาง"),
            //     array("hotel" => "PHUKET MARRIOTT RESORT AND SPA NAI YANG BEACH โรงแรมภูเก็ต แมริออท รีสอร์ต แอนด์ สปา หาดในยาง", "zones" => "หาดในยาง"),
            //     array("hotel" => "THE SLATE เดอะซเลท ภูเก็ต", "zones" => "หาดในยาง"),
            //     array("hotel" => "ATOM PHUKET HOTEL อะตอม ภูเก็ต โฮเทล", "zones" => "หาดในยาง"),
            //     array("hotel" => "Lesprit de Naiyang เลสปรี เดอ ในยาง", "zones" => "หาดในยาง"),
            //     array("hotel" => "Marina Express Aviator Phuket Airport มารีนา เอ็กซ์เพรส เอวิเอเตอร์ ภูเก็ต แอร์พอร์ต ", "zones" => "หาดในยาง"),
            //     array("hotel" => "Maya Phuket มายา ภูเก็ต แอร์พอร์ต โฮเต็ล ", "zones" => "หาดในยาง"),
            //     array("hotel" => "NAIYANG PARK RESORT ในยาง พาร์ค รีสอร์ท ", "zones" => "หาดในยาง"),
            //     array("hotel" => "PENSIRI HOUSE เพ็ญศิริ เฮาส์ ", "zones" => "หาดในยาง"),
            //     array("hotel" => "Phuket Airport Place ภูเก็ต แอร์พอร์ท เพลส ", "zones" => "หาดในยาง"),
            //     array("hotel" => "The Slate Phuket เดอะ ซเลท ภูเก็ต", "zones" => "หาดในยาง"),
            //     array("hotel" => "Hotel all seasons Naiharn Phuket โรงแรม ออล ซีซั่น ในหาน ภูเก็ต", "zones" => "หาดในหาน"),
            //     array("hotel" => "NAI HARN PHUKET ในหาน ภูเก็ต", "zones" => "หาดในหาน"),
            //     array("hotel" => "SUNSURI PHUKET HOTEL สันติ์สุริย์ ภูเก็ต", "zones" => "หาดในหาน"),
            //     array("hotel" => "Naiharn Beach Resort ในหาน บีช รีสอร์ท ", "zones" => "หาดในหาน"),
            //     array("hotel" => "THE NAI HARN เดอะในหาน ", "zones" => "หาดในหาน"),
            //     array("hotel" => "Wyndham Grand Nai Harn Beach Phuket วินดอม แกรน ในหาน ภูเก็ต ", "zones" => "หาดในหาน"),
            //     array("hotel" => "Angsana Laguna Phuket อังสนา ลากูน่า", "zones" => "หาดบางเทา"),
            //     array("hotel" => "BANYAN TREE PHUKET บันยัน ทรีภูเก็ต ", "zones" => "หาดบางเทา"),
            //     array("hotel" => "BEST WESTERN PREMIER BANGTAO BEACH RESORT & SPA เบสท์เวสเทิร์น พรีเมียร์ บางเทาบีช รีสอร์ท แอนด์ สปา", "zones" => "หาดบางเทา"),
            //     array("hotel" => "DREAM PHUKET HOTEL & SPA ดรีม ภูเก็ต โฮเต็ล แอนด์ สปา", "zones" => "หาดบางเทา"),
            //     array("hotel" => "DUSIT THANI LAGUNA RESORT ดุสิตธานี ลากูน่า รีสอร์ท", "zones" => "หาดบางเทา"),
            //     array("hotel" => "LAGUNA HOLIDAY CLUB PHUKET RESORT ลากูน่า ฮอลิเดย์ คลับ ภูเก็ต รีสอร์ท", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Outrigger laguna phuket beach resort เอาท์ทิกเกอร์ ลากูน่า ภูเก็ต บีช รีสอร์ท", "zones" => "หาดบางเทา"),
            //     array("hotel" => "SUNWING RESORT & SPA ซันวิง รีสอร์ท & สปา", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Allamanda Laguna Phuket อัลลามันดา ลากูนา ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Angsana Laguna Phuket อังสนา ลากูน่า ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Angsana Villas Resort Phuket อังสนา วิลล่า รีสอร์ท ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Areeca อารีคา", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Cassia Hotel แคสเซีย ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Casuarina Shores คาซัวรีนา ชอร์", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Grand Villa Luxury Time Phuket แกรนด์ วิลล่า ลักชัวรี่ ไทม์ ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "HOTEL COCO Phuket Beach โรงแรมโคโค่ ภูเก็ต บีช", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Mövenpick Resort Bangtao Beach Phuket เมอเวนพิค รีสอร์ต บางเทาบีช ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "PAI TAN VILLAS ปายธาร วิลล่า ", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Pumeria Resort Phuket ภูมีเรีย รีสอร์ท ภูเก็ต ", "zones" => "หาดบางเทา"),
            //     array("hotel" => "SAii Laguna Phuket ทราย ลากูน่า ภูเก็ต", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Sunwing Bangtao Beach ซันวิง บางเทาบีช ", "zones" => "หาดบางเทา"),
            //     array("hotel" => "Holiday Inn Resort Phuket ฮอลิเดย์ อิน รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Hotel Clover Patong Phuket โรงแรมโคลเวอร์ ป่าตอง ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Wyndham Sea Pearl Resort Phuket วินด์แฮม ซีเพิร์ล รีสอร์ท ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ALPINA PHUKET NALINA RESORT โรงแรม ออพินา ภูเก็ต นาลินา รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "AMARI PHUKET โรงแรมอมารี ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ANDAKIRA HOTEL โรงแรมอันดาคิรา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ANDAMAN BEACH SUITES HOTEL โรงแรม อันดามัน บีช สวีท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ANDAMAN EMBRACE PATONG อันดามัน เอมเบรส ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ANDAMANTRA RESORT & VILLA PHUKET อันดามันตรา รีสอร์ท แอนด์ วิลล่า ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "BURASARI บุราส่าหรี", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DAYS INN BY WYNDHAM PATONG BEACH เดย์ส อินน์ บาย วินด์แฮม ป่าตอง บีช ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DEEVANA PATONG RESORT & SPA ดีวาน่า ป่าตอง รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DEEVANA PLAZA PHUKET PATONG ดีวานา พลาซ่า ภูเก็ต ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DIAMOND CLIFF RESORT & SPA ไดมอนด์คลิฟ รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DUANGJITT RESORT  ดวงจิต รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "FOUR POINTS BY SHERATON PHUKET PATONG BEACH RESORT โฟร์พอยท์ส บาย เชอราตัน ภูเก็ต ป่าตองบีช รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "GRAND MERCURE PHUKET PATONG แกรนด์ เมอร์เคียว ภูเก็ต ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "HOLIDAY INN EXPRESS PHUKET PATONG BEACH CENTRAL ฮอลิเดย์ อินน์ เอ็กซ์เพรส ภูเก็ต ป่าตองบีช เซ็นทรัล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "HOTEL INDIGO PHUKET PATONG โรงแรมโฮเทล อินดิโก ภูเก็ต ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "THE KEE RESORT & SPA เดอะ กี รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "LA FLORA RESORT PATONG ลาฟลอร่ารีสอร์ท ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "THE LANTERN RESORTS PATONG เดอะ แลนเทิร์น รีสอร์ท ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "LIV HOTEL PHUKET PATHONG BEACHFRONT ลิฟ โฮเทล ภูเก็ต ป่าตอง บีชฟรอนต์", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "MAI HOUSE PATONG HILL มาย เฮาส์ ป่าตอง ฮิลล์", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "MILLENNIUM RESORT PATONG PHUKET มิลเลเนียม รีสอร์ท ป่าตอง ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "NOVOTEL PHUKET VINTAGE PARK RESORT โนโวเทล ภูเก็ต วินเทจ พาร์ค รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG BAY GARDEN RESORT ป่าตอง เบย์ การ์เด้น รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG MERLIN HOTEL โรงแรมป่าตอง เมอร์ลิน", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG PALACE HOTEL โรงแรม ป่าตอง พาเลซ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG PARAGON RESORT & SPA ป่าตอง พารากอน รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG RESORT ป่าตอง รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PHUKET GRACELAND RESORT & SPA ภูเก็ต เกรซแลนด์ รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "RAMADA PHUKET DEEVANA รามาด้า ภูเก็ต ดีวาน่า", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "RED PLANET HOTELS (PATONG) โรงแรม เรด แพลนเนต ภูเก็ต ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "R-MAR RESORT AND SPA อาม่า รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ROYAL PARADISE HOTEL & SPA โรงแรม เดอะรอยัล พาราไดซ์ แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "SAWADDI PATONG RESORT & SPA สวัสดี ป่าตอง รีสอร์ต แอนด์ สปา ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "SEA SUN SAND RESORT & SPA ซี แซนด์ ซัน รีสอร์ท & สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "SLEEP WITH ME HOTEL design hotel @ patong สลีป วิธ มี โฮเทล ดีไซน์ โฮเทล แอท ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "THARA PATONG BEACH RESORT  ธาราป่าตองบีชรีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "TROPICA BUNGALOW HOTEL ทรอปิคา บังกะโล โฮเทล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "WYNDHAM SEA PEARL RESORT PHUKET วินด์แฮม ซีเพิร์ล รีสอร์ท ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Amari Phuket โรงแรมอมารี ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Amata Patong อมตะ ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Amici miei Hotelโรงแรมอมิชี มิเอย์ ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ASHLEE HUB HOTEL PATONG โรงแรมแอชลี ฮับ ป่าตอง ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Baan Laimai Beach Resort บ้าน ลายไม้ บีช รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Best Western Patong Beach โรงแรมเบสท์เวสเทิร์น ป่าตอง บีช", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Breezotel บรีซโซเทล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Burasari Phuket บุราสารี ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "BYD  Lofts Boutique Hotel บีวายดี ลอฟต์ บูทิก โฮเต็ล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "BYD Apartment บีวายดี อพาทเมนท์", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "C & N Hotel ซี แอนด์ เอ็น โฮเต็ล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "C&N Resort and Spa ซี แอนด์ เอ็น รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Coconut Village Resort โคโคนัทวิลเลจรีสอร์ท ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Dfeel Hostel ดีฟีล เฮาส์", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Dinso Resort ดินสอ รีสอร์ต แอนด์ วิลล่า ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Dokdin's Family ดอกดิน แฟมิลี่", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "DoubleTree by Hilton Phuket banthai Resort ดับเบิ้ลทรีบายฮิลตันภูเก็ตบ้านไทยรีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Fishermen's Harbour Urban Resort ฟิชเชอร์แมน ฮาร์เบอร์ เออร์เบิร์น รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Harry’s restaurant bar and hotel แฮรี่ส์ เรสเตอรองท์บาร์ แอนด์ โฮเต็ล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Hip Hostel ฮิป โฮสเทล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Hotel Clover Patong Phuket โรงแรมโคลเวอร์ ป่าตอง ภูเก็ต ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "ibis Phuket Patong Hotel ไอบิส ภูเก็ต ป่าตอง โฮเต็ล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Impiana Resort Patong อิมเพียน่า รีสอร์ท ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Jiraporn Hill Resort จิราภรณ์ ฮิลล์ รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Kudo Hotel โรงแรมคูโด ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Lokal Hotel Phuket โลคัล โฮเต็ล ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Mövenpick Myth Hotel Patong Phuket โรงแรมเมอเวนพิค มิธ ป่าตอง ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Nap Patong แนป ป่าตอง ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "New Square Patong Hotel นิว สแควร์ ป่าตอง โฮเต็ล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Nipa Resort Patong Beach นิภา รีสอร์ท ป่าตอง บีช", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Oceanfront Beach Resort & Spa โอเชียนฟรอนต์ บีช รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Palm View Resort ปาล์มวิวรีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Palmyra Patong Resort ปาล์มไมร่า ป่าตอง รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Paripas Patong Resort ปริภัส ป่าตอง รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Patong Bay Hill ป่าตอง เบย์ ฮิลล์ ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Patong Heritage Hotel ป่าตอง เฮอริเทจ โฮเทล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "PATONG MANSION HOTEL ป่าตอง แมนชั่น โฮเทล", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Phuket Graceland Resort & Spa ภูเก็ต เกรซแลนด์ รีสอร์ท แอนด์ สปา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Prince Edouard Apartment & Resort ปริ้นซ์ เอดูอาร์ อพาร์ตเมนต์ แอนด์ รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Rak Elegant Hotel Patong รัก เอลเลแกนต์ โฮเต็ล ป่าตอง", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Ramaburin resort รามาบุรินทร์ รีสอร์ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Royal Phawadee Village รอยัล ภาวดี วิลเลจ ป่าตอง บีช โฮเทล ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Safari Beach hotel โรงแรมซาฟารี บีช ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Seaview Patong Hotel โรงแรมซีวีว ป่าตอง ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Skyview Resort Patong Beach Hotel สกายวิว รีสอร์ท ภูเก็ต ป่าตอง บีช ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "Thanthip Beach Resort ฐานทิพย์ บีช รีสอร์ท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Ashlee Heights Patong Hotel & Suites ดิ แอชลี ไฮท์ ป่าตอง โฮเทล แอนด์ สวีท", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Bliss Phuket เดอะ บลิส ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Bloc Hotel โรงแรมเดอะบล็อค ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Lantern Resorts Patong เดอะแลนเทิร์น รีสอร์ท ป่าตอง ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Marina Phuket Hotel โรงแรมเดอะ มารีนา ภูเก็ต ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Nature Phuket เดอะ เนเจอร์ ภูเก็ต", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "THE ROYAL PARADISE HOTEL & SPA เดอะรอยัล พาราไดซ์ โฮเต็ล แอนด์ สปา ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "The Senses Resort & Pool Villas, PHUKET  เดอะ เซ็นเซ็ท ", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "7Q Bangla Hotel  เซเว่นคิว  บางลา", "zones" => "หาดป่าตอง"),
            //     array("hotel" => "AMATARA WELLNESS RESORT อมาธารา เวลเลย์เซอร์ รีสอร์ท", "zones" => "หาดพันวา"),
            //     array("hotel" => "BANDARA PHUKET BEACH RESORT บัญดารา ภูเก็ต บีช รีสอร์ต", "zones" => "หาดพันวา"),
            //     array("hotel" => "BANDARA VILLAS PHUKET บัญดารา วิลล่า ภูเก็ต ", "zones" => "หาดพันวา"),
            //     array("hotel" => "CAPE PANWA HOTEL โรงแรมเคปพันวา", "zones" => "หาดพันวา"),
            //     array("hotel" => "CROWNE PLAZA PHUKET PANWA BEACH คราวน์ พลาซา ภูเก็ต พันวา บีช", "zones" => "หาดพันวา"),
            //     array("hotel" => "THE MANGROVE PANWA PHUKET RESORT เดอะ แมนกรูฟ พันวา ภูเก็ต  รีสอร์ท", "zones" => "หาดพันวา"),
            //     array("hotel" => "PANWA BOUTIQUE BEACHFRONT พันวา บูทิก บีชฟรอนต์", "zones" => "หาดพันวา"),
            //     array("hotel" => "PULLMAN PHUKET PANWA BEACH RESORT พูลแมน ภูเก็ต พันวา บีช รีสอร์ท ", "zones" => "หาดพันวา"),
            //     array("hotel" => "SRI PANWA PHUKET โรงแรมศรีพันวา ภูเก็ต", "zones" => "หาดพันวา"),
            //     array("hotel" => "Amatara Wellness Resort อมาธารา เวลเลย์เซอร์ รีสอร์ท", "zones" => "หาดพันวา"),
            //     array("hotel" => "CAPE PANWA HOTEL โรงแรมเคปพันวา", "zones" => "หาดพันวา"),
            //     array("hotel" => "Cloud 19 Panwa คลาวด์ 19 พันวา", "zones" => "หาดพันวา"),
            //     array("hotel" => "Goodnight Phuket Villa Hotel กู๊ดไนท์ ภูเก็ต วิลลา", "zones" => "หาดพันวา"),
            //     array("hotel" => "KantaryBay Hotel Phuket โรงแรมแคนทารี เบย์ ภูเก็ต", "zones" => "หาดพันวา"),
            //     array("hotel" => "My Beach Resort Phuket มาย บีช รีสอร์ท ภูเก็ต", "zones" => "หาดพันวา"),
            //     array("hotel" => "PULLMAN PHUKET PANWA BEACH RESORT พูลแมน ภูเก็ต พันวา บีช รีสอร์ท ", "zones" => "หาดพันวา"),
            //     array("hotel" => "Sri panwa, Phuket ศรีพันวา ภูเก็ต ", "zones" => "หาดพันวา"),
            //     array("hotel" => "THE MANGROVE PANWA PHUKET RESORT เดอะ แมนกรูฟ พันวา ภูเก็ต  รีสอร์ท", "zones" => "หาดพันวา"),
            //     array("hotel" => "X10 Seaview Suites เอ็กเทน ซีวิว", "zones" => "หาดพันวา"),
            //     array("hotel" => "JW Marriott Phuket Resort & Spa เจดับบลิว แมริออท ภูเก็ต รีสอร์ท แอนด์ สปา", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "ANANTARA RESORT & SPA PHUKET อนันตรา  รีสอร์ท แอนด์ สปา ภูเก็ต ", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "HOLIDAY INN RESORT PHUKET MAI KHAO BEACH ฮอลิเดย์ อินน์ รีสอร์ท ภูเก็ต ไม้ขาวบีช", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "MAIKHAO DREAM VILLA RESORT & SPA ไม้ขาว ดรีม วิลลา รีสอร์ท แอนด์ สปา ", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "SALA PHUKET MAIKHAO BEACH RESORT ศาลาภูเก็ต ไม้ขาวบีช รีสอร์ท", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "SPLASH BEACH RESORT สแปลช บีช รีสอร์ต ไม้ขาว ภูเก็ต", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Anantara Vacation Club Mai Khao Phuket อนันตรา เวเคชั่น คลับ ไม้ขาว ภูเก็ต", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Avani+ Mai Khao Phuket Suites & Villas อวานี พลัส ไม้ขาว ภูเก็ต สวีท แอนด์ วิลล่า", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Coriacea Boutique Resort โคเรียซี บูติค รีสอร์ท", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "JW Marriott Phuket Resort & Spa เจดับบลิว แมริออท ภูเก็ต รีสอร์ท แอนด์ สปา", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Maikhao Home Garden Bungalow ไม้ขาว โฮม การ์เด้น บังกะโล", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Maikhao Palm Beach Resort ไม้ขาว ปาล์ม บีช รีสอร์ท ", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Marriott's Phuket Beach Club แมริออท ภูเก็ต บีช คลับ", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "Renaissance Phuket Resort & Spa เรเนซองส์ ภูเก็ต รีสอร์ต แอนด์ สปา", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "SALA Phuket Mai Khao Beach ศาลา ภูเก็ต ไม้ขาว บีช", "zones" => "หาดไม้ขาว"),
            //     array("hotel" => "BLUE BEACH GRAND RESORT AND SPA บลู บีช แกรนด์ รีสอร์ท แอนด์ สปา", "zones" => "หาดราไวย์"),
            //     array("hotel" => "MANGOSTEEN RESORT & SPA แมงโก้สทีน รีสอร์ท แอนด์ สปา ", "zones" => "หาดราไวย์"),
            //     array("hotel" => "THE VIJITT RESORT PHUKET เดอะวิจิตรรีสอร์ทภูเก็ต", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Babylon Pool Villas บาบิลอน พูล วิลล่า", "zones" => "หาดราไวย์"),
            //     array("hotel" => "BLUE BEACH GRAND RESORT AND SPA บลู บีช แกรนด์ รีสอร์ท แอนด์ สปา", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Casabay Luxury Pool Villas คาซาเบย์ ลักชัวรี พูลวิลล่า", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Friendship Beach Resort & Atmanjai Wellness Spa โรงแรมเฟรนด์ชิปบีช รีสอร์ท แอนด์ อัตมันไจ เวลเนส สปา", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Greg's Club Residence Rawai Hotel เกร็กซ์ คลับ เรสิเดนท์ ราไวย์ ", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Lady Naya Villas เลดี้ นายะ วิลล่า", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Le Resort and Villas เลอ รีสอร์ท แอนด์ วิลล่า", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Navatara Phuket Resort นวธารา ภูเก็ต รีสอร์ท", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Phu NaNa Boutique Hotel ภู นานา บูทีค โฮเต็ล ", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Rawai Palm Beach Resort ราไว ปาล์ม บีช รีสอร์ท ", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Serenity Resort & Residences Phuket เซลิน่า เซเรนิตี้ ราไวย์ ภูเก็ต", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Stay Wellbeing & Lifestyle Resort สเตย์ เวลบีอิ้ง แอนด์ ไลฟ์สไตล์ รีสอร์ท", "zones" => "หาดราไวย์"),
            //     array("hotel" => "THAMES TARA POOL VILLA RAWAI เทมส์ ธารา พูลวิลล่า ราไวย์", "zones" => "หาดราไวย์"),
            //     array("hotel" => "Tharawalai resort ธาราวาลัย รีสอร์ท ", "zones" => "หาดราไวย์"),
            //     array("hotel" => "The Mangosteen Resort and Spa เดอะ แมงโก้สทีน รีสอร์ท แอนด์ สปา", "zones" => "หาดราไวย์"),
            //     array("hotel" => "the view rawadaphuket   เดอะ วิว ราวาดา ภูเก็ต", "zones" => "หาดราไวย์"),
            //     array("hotel" => "ANANTARA PHUKET LAYAN RESORT  อนันตรา ลายัน ภูเก็ต รีสอร์ท", "zones" => "หาดลายัน"),
            //     array("hotel" => "The Pavilions Phuket เดอะ พาวิลเลี่ยน ภูเก็ต", "zones" => "หาดลายัน"),
            //     array("hotel" => "AYARA HILLTOPS ไอยรา ฮิลล์ทอปส์", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "SURIN PHUKET สุรินทร์ ภูเก็ต", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "TWINPALMS PHUKET HOTEL โรงแรมทวินปาล์มส์ภูเก็ต", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "AMANPURI Resort อมันปุรี  รีสอร์ท", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "Ayara Hilltops Boutique Resort and Spa ไอยรา ฮิลล์ท็อป บูติก รีสอร์ท แอนด์ สปา ภูเก็ต", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "The Chava Resort เดอะ ชวา รีสอร์ท", "zones" => "หาดสุรินทร์"),
            //     array("hotel" => "The Surin Phuket  เดอะ สุรินทร์", "zones" => "หาดสุรินทร์"),
            // );

            // $first_zone = array();
            // echo ' Count data : ' . count($data) . '</br>';
            // for ($i = 0; $i < count($data); $i++) {
            //     if ((strpos($data[$i]['zones'], ' ') === false) && (in_array($data[$i]['zones'], $first_zone) === false)) {
            //         $first_zone[] = $data[$i]['zones'];
            //         echo " <h4> Zone : " . $data[$i]['zones'] . '</h4>';
            //     }
            //     echo 'No : ' . $i . ' Hotel : ' . $data[$i]['hotel'] . ' Zone : ' . $data[$i]['zones'] . '</br>';

            //     // if (strpos($data[$i]['zones'], ' ') !== false) {
            //     //     echo "The text contains a space in " . $data[$i]['zones'] . '</br>';
            //     // } else {
            //     //     echo "The text does not contain a space in " . $data[$i]['zones'] . '</br>';
            //     // }

            //     // if ((strpos($data[$i]['zones'], ' ') === false) && (in_array($data[$i]['zones'], $first_zone) === false)) {
            //     //     $first_zone[] = $data[$i]['zones'];
            //     //     echo "The text does not contain a space in " . $data[$i]['zones'] . '</br>';
            //     // } 
            // }
            ?>
        </div>
    </div>
</div>