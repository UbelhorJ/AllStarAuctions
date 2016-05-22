<?php 
    require_once('../../util/secure_connection.php');
    require_once('../../util/verify_admin.php');  // verity admin user logged in 

    include ('../../view/head.php');
    include ('../../view/header.php');
    include ('../../view/admin/admin_navigation.php'); 
?>

<style>
    label {
        display: inline-block;
        width: 75px;
        text-align: right;
        font-size: 80%;
    }
    
    fieldset * {
        margin: 3px;
    }
    
    fieldset {
        border: 2px solid #3F51B5;
        padding: 3px; 
        margin-bottom: 10px;
        font-size: 80%;
    }
    
    textarea {
        width: 575px;
    }
    
    table {
        width: 100%; 
        border: 2px solid #3F51B5;
        border-collapse: collapse;
    }
    
    tr {
        border: 1px solid #3F51B5;
    }
    
    tr, td {
        border: 1px solid #3F51B5;
        vertical-align: top;
        padding: 3px;
    }
    
    .check {
        width: 20px;
        text-align: center;
    }
    
    .item_no {
        width: 50px;
        text-align: center;
    }
    
    .image {
        width: 65px;
        text-align: center;
    }
    
    .name {
        padding-left: 5px;
    }
    
    .reserve {
        width: 60px; 
        text-align: right;
    }
    
    .status {
        width: 70px;
        text-align: center;
    }
    
    .save_message {
        color: #FF3E3E;
    }
    
</style>

        <section>
            <h2>Inventory Administration</h2>
            
            <!-- New Item Form -->
            <fieldset id="newItemsForm">
                <legend>&nbsp;Add New Item&nbsp;</legend>
                <form action="." name="newItem" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="name">Item Name: </label>
                        <input type="text" id="name" name="name">
                        <label for="price">Reserve: $</label>
                        <input type="text" id="reserve" name="reserve">
                        <label for="status">Status: </label>
                        <select id="status" name="status">
                            <option value="d">Display</option>
                            <option value="h">Hidden</option>
                        </select>
                    </div>
                    <div style="height: 50px;">
                        <label for="description">Description: </label>
                        <textarea id="description" name="description" rows="3"></textarea>
                    </div>
                    <div>
                        <label for="uploaded_images">Images: </label>
                        <input type="file" name="uploaded_images[]" multiple><br>
                        <label>&nbsp;</label>
                        <input type="hidden" name="action" value="new_item">
                        <input type="submit" value=" Save " style="margin-bottom: 3px;">
                    </div>
                </form>
            </fieldset>
            
            <!-- Filter -->
            <fieldset>
                <legend>&nbsp;Filter Items&nbsp;</legend>
                    <form action="." method="POST" id="items_filter">
                        <span>
                            <label for="status">Status:</label> 
                            <input type="checkbox" name="display" <?php if ($status['d'] === true) echo 'checked' ?>>Display 
                            <input type="checkbox" name="hidden" <?php if ($status['h'] === true) echo 'checked' ?>>Hidden 
                            <input type="checkbox" name="sold" <?php if ($status['s'] === true) echo 'checked' ?>>Sold
                        </span>
                        <br>
                        <span>
                            <label for="sort_by">Sort By:</label> 
                            <input type="radio" name="order_by" value="itemNo" <?php if ($order_by == 'itemNo') echo 'checked' ?>>Item # 
                            <input type="radio" name="order_by" value="name" <?php if ($order_by == 'name') echo 'checked' ?>> Name 
                            <input type="radio" name="order_by" value="reservePrice" <?php if ($order_by == 'reservePrice') echo 'checked' ?>>Reserve 
                            <input type="radio" name="order_by" value="status" <?php if ($order_by == 'status') echo 'checked' ?>>Status
                            <select name="direction">
                                <option value="ASC" <?php if ($direction == 'ASC') echo 'selected' ?>>A to Z | Highest to Lowest</option>
                                <option value="DESC" <?php if ($direction == 'DESC') echo 'selected' ?>>Z to A | Lowest to Highest</option>
                            </select>
                        </span>
                        <input type="hidden" value="action" value="show_inventory_home">
                        <input type="submit" value=" Filter ">
                    </form>
            </fieldset>
            
            <!-- Item List Table -->
            <table id="item_list">
                <thead>
                    <tr>
                        <!-- <td class="check"><input type="checkbox" id="select_all"></td> -->
                        <td class="item_no">Item #</td>
                        <td class="image">Image</td>
                        <td class="name">Name</td>
                        <td class="reserve">Reserve</td>
                        <td class="status">Status</td>
                    </tr>
                </thead>
                <tbody>            
                    <?php foreach($inventoryList as $item) : ?>
                        <?php
                            $itemNo = $item->getItemNo();
                            $itemNoPad = str_pad($itemNo, 4, 0, STR_PAD_LEFT);
                            $status = $item->getStatus();
                            $reserve = '$' . $item->getReservePrice();
                            if ($reserve == '$0.00') {
                                $reserve = '';
                            }
                        ?>
                    
                        <tr>
                            <!-- <td class="check"><input type="checkbox" name="<?php echo $itemNo; ?>" id="<?php echo $itemNo; ?>"> -->
                            <td class="item_no"><?php echo $itemNoPad ?></td>
                            <td class="image"><img src="../../images/inventory/<?php echo $itemNo; ?>/thumbs/<?php echo $item->getPrimaryThumb(); ?>" style="max-width: 65px; max-height: 65px;"></td>
                            <td class="name"><?php echo $item->getName(); ?></td>
                            <td class="reserve"><?php echo $reserve; ?></td>
                            <td class="status">
                                <form id="item_status">
                                    <select name="status" id="status">
                                        <option value="h" <?php if ($status == 'h') echo 'selected' ?>>Hidden</option>
                                        <option value="d" <?php if ($status == 'd') echo 'selected' ?>>Display</option>
                                        <option value="s" <?php if ($status == 's') echo 'selected' ?>>Sold</option>
                                    </select>
                                    <input type="hidden" name="action" value="change_item_status">
                                    <input type="hidden" name="item_no" value="<?php echo $itemNo; ?>">
                                </form>
                                <span class="save_message"></span>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <tbody>
            </table>
        </section>

<?php include '../../view/footer.php'; ?>