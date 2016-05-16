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
        
        textarea {
            width: 575px;
        }
</style>

        <section>
            <h2>Inventory Administration</h2>
            
            <fieldset id="newItemsForm" style="padding: 5px; margin-bottom: 10px;">
                <legend>Add New Item</legend>
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
            
            <!-- just for testing below here -->
            <?php foreach($inventoryList as $item) : ?>
                <?php
                    $primaryThumb = $item->getPrimaryThumb();
                    $itemNo = $item->getItemNo();
                    echo "<img src=\"" . '..\\..\\images\\inventory\\' . $itemNo . '\\' . $primaryThumb . "\">";
                ?>
            <?php endforeach ?>
            <br>
            <?php foreach($inventoryList as $item) {
                $images = $item->getImages();
                foreach($images as $key => $value) {
                    echo $key . ', ' . $value . '<br>';
                }
            }
            ?>
        </section>

<?php include '../../view/footer.php'; ?>