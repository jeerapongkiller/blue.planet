<?php
require_once '../../../config/env.php';
require_once '../../../controllers/Bank.php';

$bankObj = new Bank();

if (isset($_POST['action']) && $_POST['action'] == "search") {
    // get value from ajax
    $name = $_POST['name'] != "" ? $_POST['name'] : '';

    $banks = $bankObj->search($name);
?>
    <table class="bank-list-table table table-responsive">
        <thead class="thead-light">
            <tr>
                <th class="cell-fit">Name</th>
            </tr>
        </thead>
        <?php if ($banks) { ?>
            <tbody>
                <?php
                foreach ($banks as $bank) {
                    $href = 'href="./?pages=bank/edit&id=' . $bank['id'] . '" style="color:#6E6B7B"';
                ?>
                    <tr>
                        <td>
                            <a <?php echo $href; ?>>
                                <?php echo $bank['name']; ?>
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
