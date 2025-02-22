<?php
require_once '../../../config/env.php';
require_once '../../../controllers/User.php';

$userObj = new User();

if (isset($_POST['action']) && $_POST['action'] == "create") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : 0;
    $firstname = $_POST['firstname'] != "" ? $_POST['firstname'] : '';
    $lastname = $_POST['lastname'] != "" ? $_POST['lastname'] : '';
    $username = $_POST['username'] != "" ? $_POST['username'] : '';
    $password = $_POST['password'] != "" ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $role = $_POST['role'] != "" ? $_POST['role'] : 3; // role: reservation
    $department = !empty($_POST['department']) ? $_POST['department'] : 0;
    $email = $_POST['email'] != "" ? $_POST['email'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $permissions = !empty($_POST['permissions']) ? $_POST['permissions'] : '';
    $address = '';
    $contact_person = '';
    $note = '';
    $type = 1; // admin
    $companies = 0;

    // get details of the uploaded file
    $countfiles = count($_FILES['photo']['name']);
    $fileArray = array();

    for ($i = 0; $i < $countfiles; $i++) {
        $fileArray['fileTmpPath'][$i] = $_FILES['photo']['tmp_name'][$i];
        $fileArray['fileName'][$i] = $_FILES['photo']['name'][$i];
        $fileArray['fileSize'][$i] = $_FILES['photo']['size'][$i];
        $fileArray['fileBefore'][$i] = '';
        $fileArray['fileDelete'][$i] = 0;
    }

    $user_id = $userObj->insert_data($is_approved, $firstname, $lastname, $email, $telephone, $role, $department, $companies, $type, $address, $contact_person, $note, $fileArray);
    if ($user_id > 0) {
        # --- insert login data --- #
        $response = $userObj->insert_login($user_id, $username, $password);
        # --- insert permission user array --- #
        if ($response != false && !empty($permissions)) {
            for ($i = 0; $i < count($permissions); $i++) {
                $response = $userObj->insert_permiss($user_id, $permissions[$i]);
            }
        }
    }

    echo $response != false && $user_id != 0 ? $user_id : false;
} else {
    echo $response = false;
}
