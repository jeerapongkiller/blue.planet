<?php
require_once '../../../config/env.php';
require_once '../../../controllers/User.php';

$userObj = new User();

if (isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['user_id']) && $_POST['user_id'] > 0) {
    // get value from ajax
    $user_id = $_POST['user_id'] > 0 ? $_POST['user_id'] : 0;
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : 0;
    $firstname = $_POST['firstname'] != "" ? $_POST['firstname'] : '';
    $lastname = $_POST['lastname'] != "" ? $_POST['lastname'] : '';
    $password = $_POST['password'] != "" ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
    $role = $_POST['role'] != "" ? $_POST['role'] : 3; // role: reservation
    $department = !empty($_POST['department']) ? $_POST['department'] : 0;
    $email = $_POST['email'] != "" ? $_POST['email'] : '';
    $telephone = $_POST['telephone'] != "" ? $_POST['telephone'] : '';
    $permissions = !empty($_POST['permissions']) ? $_POST['permissions'] : '';
    $default_perms = !empty($_POST['default_perms']) ? $_POST['default_perms'] : array();
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
        $fileArray['fileBefore'][$i] = !empty($_POST['before_photo'][$i]) ? $_POST['before_photo'][$i] : '';
        $fileArray['fileDelete'][$i] = !empty($_POST['delete_photo'][$i]) && $_POST['delete_photo'][$i] == 1 ? $_POST['delete_photo'][$i] : 0;
    }

    if ($user_id > 0) {
        $response = $userObj->update_data($is_approved, $firstname, $lastname, $email, $telephone, $role, $department, $companies, $type, $address, $contact_person, $note, $fileArray, $user_id);
        # --- update login --- #
        $response = $response != false && !empty($password) ? $userObj->update_login($password, $user_id) : $response;
        # --- insert permission user array --- #
        if ($response != false && !empty($permissions)) {
            for ($i = 0; $i < count($permissions); $i++) {
                if (in_array($permissions[$i], $default_perms) != 1) {
                    $response = $userObj->insert_permiss($user_id, $permissions[$i]);
                }
            }
        }
        # --- delete permission user array --- #
        if ($response != false && !empty($default_perms)) {
            for ($i = 0; $i < count($default_perms); $i++) {
                if (in_array($default_perms[$i], $permissions) != 1) {
                    $response = $userObj->delete_permiss($user_id, $default_perms[$i]);
                }
            }
        }
    }

    echo $response;
} else {
    echo $response = false;
}
