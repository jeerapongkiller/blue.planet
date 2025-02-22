<?php
require_once '../../../config/env.php';
require_once '../../../controllers/User.php';

$userObj = new User();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $role = $_POST['role'] != "" ? $_POST['role'] : '';
    $firstname = $_POST['firstname'] != "" ? $_POST['firstname'] : '';
    $lastname = $_POST['lastname'] != "" ? $_POST['lastname'] : '';
    $username = $_POST['username'] != "" ? $_POST['username'] : '';

    $users = $userObj->search($_SESSION["supplier"]["role_id"], $is_approved, $role, $firstname, $lastname, $username);
?>
    <table class="user-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">Status</th>
                <th>User</th>
                <th>Full name</th>
                <th>Role</th>
            </tr>
        </thead>
        <?php if ($users) { ?>
            <tbody>
                <?php
                foreach ($users as $user) {
                    $is_approved = $user['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $user['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=user/edit&id=' . $user['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td>
                            <a <?php echo $href; ?>>
                                <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                            </a>
                        </td>
                        <td><a <?php echo $href; ?>><?php echo $user['username']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $user['firstname'] . " " . $user['lastname']; ?></a></td>
                        <td><a <?php echo $href; ?>><?php echo $user['roleName']; ?></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $users = false;
}
