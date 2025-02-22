<?php
require_once '../../../config/env.php';
require_once '../../../controllers/BankAccount.php';

$bankaccObj = new BankAccount();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $is_approved = $_POST['is_approved'] != "" ? $_POST['is_approved'] : '';
    $name = $_POST['name'] != "" ? $_POST['name'] : '';
    $no = $_POST['no'] != "" ? $_POST['no'] : '';
    $bank = $_POST['bank'] != "" ? $_POST['bank'] : '';

    $bankaccs = $bankaccObj->search($is_approved, $name, $no, $bank);
?>
    <table class="bank-account-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">Status</th>
                <th>Account Name</th>
                <th>Account No</th>
                <th>Bank</th>
            </tr>
        </thead>
        <?php if ($bankaccs) { ?>
            <tbody>
                <?php
                foreach ($bankaccs as $bankacc) {
                    $is_approved = $bankacc['is_approved'] == 1 ? 'Active' : 'Inactive';
                    $is_approved_class = $bankacc['is_approved'] == 1 ? 'badge-light-success' : 'badge-light-secondary';
                    $href = 'href="./?pages=bank-account/edit&id=' . $bankacc['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td>
                            <a <?php echo $href; ?>>
                                <span class="badge badge-pill <?php echo $is_approved_class; ?> text-capitalized"><?php echo $is_approved; ?></span>
                            </a>
                        </td>
                        <td>
                            <a <?php echo $href; ?>>
                                <?php echo $bankacc['account_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a <?php echo $href; ?>>
                                <?php echo $bankacc['account_no']; ?>
                            </a>
                        </td>
                        <td>
                            <a <?php echo $href; ?>>
                                <?php echo $bankacc['bnkName']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
<?php
} else {
    echo $bank = false;
}
