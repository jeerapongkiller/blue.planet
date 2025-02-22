<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Supplier.php';

$supObj = new Supplier();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : 0;
    $tat_license = $_POST['tat_license'] != "" ? $_POST['tat_license'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $email = $_POST['email'] != "" ? $_POST['email'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $address = $_POST['address'] != "" ? $_POST['address'] : '';
    $contact_person = $_POST['contact_person'] != "" ? $_POST['contact_person'] : '';
    $note = $_POST['note'] != "" ? $_POST['note'] : '';

    // get details of the uploaded file
    $countfiles = count($_FILES['logo']['name']);
    $fileArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $fileArray['fileTmpPath'][$i] = $_FILES['logo']['tmp_name'][$i];
        $fileArray['fileName'][$i] = $_FILES['logo']['name'][$i];
        $fileArray['fileSize'][$i] = $_FILES['logo']['size'][$i];
        $fileArray['fileBefore'][$i] = '';
        $fileArray['fileDelete'][$i] = 0;
    }

    $response = $supObj->insert_data($is_approved, $tat_license, $name, $email, $telephone, $address, $contact_person, $note, $fileArray);

    echo $response;
} else {
    echo $response = false;
}
