<?php

//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

$selected = json_decode($_POST['mats']);

if ($connStatus == true) {
    $result_materials = $database->getData("SELECT * FROM `product_attributes_terms` WHERE `pattribterm_attribid`=".$_POST['id']." ORDER BY `pattribterm_name` ASC");

    if ($result_materials != false) {

        while ($materials_row = mysqli_fetch_array($result_materials)) {

?>
            <div class="form-group">

                <label class="form-check-label">

                    <input type="checkbox" class="form-check-input" name="materials[]" value="<?= $materials_row['pattribterm_id'] ?>" id="" <?php if(is_array($selected) && in_array($materials_row['pattribterm_id'], $selected)){ echo 'checked'; } ?>> <?= $materials_row['pattribterm_name'] ?>
                </label>
            </div>
<?php
        }
    }
}

?>