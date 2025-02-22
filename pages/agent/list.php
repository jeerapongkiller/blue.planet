<?php
require_once 'controllers/Agent.php';

$agObj = new Agent();
$agents = $agObj->showlist();
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- agents list start -->
            <section class="app-agent-list">
                <!-- agents filter start -->
                <div class="card">
                    <h5 class="card-header">Search Filter</h5>
                    <form id="agent-search-form" name="agent-search-form" method="post" enctype="multipart/form-data">
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
                                    <label class="form-label" for="tat_license">TAT License</label>
                                    <input type="text" class="form-control" id="tat_license" name="tat_license" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="name">Agent Name</label>
                                    <input type="text" class="form-control" id="name" name="name" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-primary" name="submit" value="Submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- agents filter end -->
                <!-- list section start -->

                <div class="card">
                    <div class="card-datatable pt-0" id="agent-search-table">
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
                    </div>
                </div>
                <!-- list section end -->
            </section>
            <!-- agents list ends -->
            <?php
            // foreach ($agents as $agent) {
            //     $programs = $agObj->showprograms(1);
            //     if ($programs) {
            //         foreach ($programs as $program) {
            //             $categorys = $agObj->showcategory($program["id"]);
            //             if ($categorys) {
            //                 foreach ($categorys as $category) {
            //                     $periods = $agObj->showperiod($category['id']);
            //                     if ($categorys) {
            //                         foreach ($periods as $period) {
            //                             switch ($period['id']) {
            //                                 case 1:
            //                                     $rate_adult = 1800;
            //                                     $rate_child = 1500;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 2:
            //                                     $rate_adult = 2200;
            //                                     $rate_child = 1800;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 3:
            //                                     $rate_adult = 2600;
            //                                     $rate_child = 2200;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 4:
            //                                     $rate_adult = 1800;
            //                                     $rate_child = 1500;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 5:
            //                                     $rate_adult = 2200;
            //                                     $rate_child = 1800;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 6:
            //                                     $rate_adult = 2600;
            //                                     $rate_child = 2200;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 7:
            //                                     $rate_adult = 3000;
            //                                     $rate_child = 2700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 8:
            //                                     $rate_adult = 3200;
            //                                     $rate_child = 2800;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 9:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 10:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 11:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 12:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 13:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 14:
            //                                     $rate_adult = 2300;
            //                                     $rate_child = 1700;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 15:
            //                                     $rate_adult = 1800;
            //                                     $rate_child = 1500;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 16:
            //                                     $rate_adult = 1800;
            //                                     $rate_child = 1500;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                                 case 17:
            //                                     $rate_adult = 1800;
            //                                     $rate_child = 1500;
            //                                     $rate_infant = 0;
            //                                     $rate_private = 0;
            //                                     break;
            //                             }
            //                             $rate_id = $agObj->insert_data_rate($rate_adult, $rate_child, $rate_infant, $rate_private, $period['id']);
            //                             $response = $rate_id != false && $rate_id > 0 ? $agObj->insert_data_company($period['id'], $rate_id, $agent['id']) : false;
            //                             echo 'agent id : ' . $agent['id'] . ' agent name : ' . $agent['name'] . ' period : ' . $period['id'] . ' rate id : ' . $rate_id . '</br>';
            //                         }
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }
            ?>
        </div>
    </div>
</div>