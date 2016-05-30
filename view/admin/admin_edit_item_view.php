<?php 
    require_once('../../util/secure_connection.php');
    require_once('../../util/verify_admin.php');  // verity admin user logged in 

    include ('../../view/head.php');
?>
        <script src="https://code.jquery.com/jquery-latest.min.js"></script>
<?php
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
    
    #edit_form * {
        margin: 3px;
    }
    
    #edit_form {
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
    
    .thumb_container {
        display: inline-block;
        vertical-align: top;
        height: 175px;
        margin: 5px;
    }
    
    .thumb {
        display: inline-block;
        text-align: center;
    }
    
    fieldset {
        display: inline-block;
        border: 1px solid #AAAAAA;
        padding: 5px;
    }
    
    fieldset p, legend {
        color: #AAAAAA;
    }
</style>

<script>
$(document).ready(function(){
    $("#unlock_delete").change(function(){
        if ($(this).is(":checked")) {
            $("#unlock_delete").next().text("Locked");
            $("#unlock_fieldset").css("border", "1px solid #AAAAAA");
            $("#unlock_fieldset legend, #unlock_fieldset p").css("color", "#AAAAAA");
            $("#delete_item").attr("disabled", "disabled");
        } else {
            $("#unlock_delete").next().text("Unlocked");
            $("#unlock_fieldset").css("border", "1px solid #FF0000");
            $("#unlock_fieldset legend, #unlock_fieldset p").css("color", "#FF0000");
            $("#delete_item").removeAttr("disabled");
        }
    });
    
    $("#delete_item").click(function(){
        var response = confirm("Are you sure you want to delete \"<?php echo $item->getName(); ?>\"?\nThis cannot be un-done.");
        
        if (response == true) {
            $("#delete_item_form").submit();
        }
    });
});    
</script>

        <section>
            <h2>Edit <?php echo $item->getName(); ?></h2>
            
            <!-- item info -->
            <div id="edit_form">
                <form action="edit_item.php" name="edit_item" method="POST" enctype="multipart/form-data">
                    <div>
                        <label for="name">Item Name: </label>
                        <input type="text" id="name" name="name" value="<?php echo htmlentities($item->getName()); ?>">
                        <label for="price">Reserve: $</label>
                        <input type="text" id="reserve" name="reserve" value="<?php echo $item->getReservePrice(); ?>">
                        <label for="status">Status: </label>
                        <select id="status" name="status">
                            <option value="d" <?php if ($item->getStatus() === 'd') echo 'selected'; ?>>Display</option>
                            <option value="h" <?php if ($item->getStatus() === 'h') echo 'selected'; ?>>Hidden</option>
                            <option value="s" <?php if ($item->getStatus() === 's') echo 'selected'; ?>>Sold</option>
                        </select>
                    </div>
                    <div style="height: 50px;">
                        <label for="description">Description: </label>
                        <textarea id="description" name="description" rows="3"><?php echo htmlentities($item->getDescription()); ?></textarea>
                    </div>
                    <div>
                        <label for="uploaded_images">Add Images: </label>
                        <input type="file" name="uploaded_images[]" multiple><br>
                    </div>
                    <div>
                        <?php
                            $thumbs = array_reverse($item->getThumbs());
                            $images = array_reverse($item->getImages());                            
                            $i = count($thumbs) - 1;
                        ?>
                        <?php for ($i; $i >= 0; $i--) : ?>
                            <div class="thumb_container">
                                <div class="radio_button">
                                    <input type="radio" name="primary_thumb" value="<?php echo $thumbs[$i]; ?>" <?php if ($item->getPrimaryThumb() == $thumbs[$i]) echo 'checked' ?>>Primary<br>
                                    <input type="checkbox" name="delete[]" value="<?php echo $images[$i]; ?>">Delete
                                </div> <!-- end radio_button -->
                                <div class="thumb">
                                    <a href="../../images/inventory/<?php echo $itemNo; ?>/original/<?php echo $images[$i]; ?>" target="_blank"><img src="../../images/inventory/<?php echo $itemNo; ?>/thumbs/<?php echo $thumbs[$i]; ?>"></a>
                                </div> <!-- end thumb -->
                            </div> <!-- end thumb_container -->
                        <?php endfor ?>
                    </div>
                    <input type="hidden" name="itemNo" value="<?php echo $item->getItemNo(); ?>">
                    <input type="hidden" name="action" value="save_changes">
                    <input type="submit" value=" Save " style="margin-bottom: 3px;">
            </div>
                </form>
                <form id="delete_item_form" method="POST">
                    <fieldset id="unlock_fieldset">
                        <legend><input type="checkbox" id="unlock_delete" checked> <span>Locked&nbsp;</span></legend>
                        <p>Deleting an item will cause any links to it to no longer work. If the item has been sold, change the status to "sold."<br>
                        Only delete items if they were mistakenly added, and you no longer wish it to be visible.</p>
                        <input type="button" id="delete_item" value=" Delete Item " disabled><br>
                        <input type="hidden" name="itemNo" value="<?php echo $itemNo; ?>">
                        <input type="hidden" name="action" value="delete_item">
                    </fieldset>
                </form>
            </div>
        </section>

<?php include '../../view/footer.php'; ?>