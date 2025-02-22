<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Agent.php';

$agObj = new Agent();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $tat_license = $_POST['tat_license'] != "" ? $_POST['tat_license'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $agents = $agObj->search($is_approved, $tat_license, $name);
?>
    <table class="agent-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th>Status</th>
                <th>TAT License</th>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th class="cell-fit"></th>

            </tr>
        </thead>
        <?php if ($agents) { ?>
            <tbody>
                <?php
                foreach ($agents as $agent) {
                    $is_approved = $agent['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $agent['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                ?>
                    <tr>
                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"><span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span></a></td>
                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"><?php echo $agent['tat_license']; ?></a></td>
                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"><?php echo $agent['name']; ?></a></td>
                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"><?php echo $agent['email']; ?></a></td>
                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"><?php echo $agent['telephone']; ?></a></td>
                                         

                                            <td><a href="./?pages=agent/edit&id=<?php echo $agent['id']; ?>" style="color:#6E6B7B"></a></td>

                                        </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $agents = false;
}
