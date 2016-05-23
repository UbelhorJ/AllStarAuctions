<?php include 'view/head.php'; ?>
        <link rel="stylesheet" href="main.css">
<?php include 'view/header.php'; ?>

<?php include '/view/navigation.php'; ?>

<style>
    .item_wrapper{
        /*background-color: #C5CAE9;*/
        display: inline-block;
        width: 426px;
        margin-bottom: 5px;
        max-height: 426px;
    }
    
    .item_wrapper:hover {
        background-color: #C5CAE9;
    }
    
    .thumb_container {
        display: inline-block;
        vertical-align: middle;
        height: 125px;
        width: 125px;
        text-align: center;
        background-color: #212121;
    }
    
    .item_info {
        display: inline-block;
        width: 100%;
        vertical-align: top;
    }
    
    .item_info a:link, .item_info a:visited, .item_info a:hover {
        text-decoration: none;
    }
    
    .item_title {
        color: #FFFFFF;
        background-color: #3F51B5;
        padding: 3px 10px 3px 10px;
        font-size: 110%;
        height: 19px;
    }
    
    .item_title a:link, .item_title a:visited {
        color: #FFFFFF;
        text-decoration: none;
    }
    
    .item_title a:hover {
        color: #FFFFFF;
        text-decoration: underline;
    }
        
    .center_helper {
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    
    .thumb {
        vertical-align: middle;
        border: none;
    }
    
    .item_details {
        display: inline-block;
        width: 296px;
        margin-top: 5px;
        vertical-align: top;
    } 
 
</style>

        <section>
           <?php foreach($inventoryList as $item) : ?>
                <div class="item_wrapper" id="wrap<?php echo $item->getItemNo(); ?>">
                    <div class="item_info">
                        <div class="item_title">
                            <a href=".?action=view_item&itemNo=<?php echo $item->getItemNo(); ?>"><?php echo $item->getName(); ?></a>
                        </div> <!-- end item title -->
                        <a href=".?action=view_item&itemNo=<?php echo $item->getItemNo(); ?>">
                        <div class="thumb_container">
                                <span class="center_helper"></span><img src="../images/inventory/<?php echo $item->getItemNo(); ?>/thumbs/<?php echo $item->getPrimaryThumb() ?>" class="thumb">
                        </div> <!-- end thumb container -->
                        </a>
                        <div class="item_details">
                            <p>
                                <?php
                                    $reservePrice = $item->getReservePrice();
                                    if ($reservePrice == 0 || $reservePrice === NULL) {
                                        echo 'No Reserve';
                                    } else {
                                        echo 'Reserve: $' . $reservePrice;
                                    }
                                ?>                               
                            </p>
                            <p>
                                <?php
                                    $description = $item->getDescription();
                                    
                                    if (strlen($description) > 100) {
                                        $description = substr($description, 0, 100) . '...';
                                    } 
                                    
                                    echo htmlentities($description);
                                ?>
                            </p>
                        </div> <!-- end item details -->
                    </div> <!-- item info -->
                </div> <!-- end item wrapper -->
            <?php endforeach ?>
        </section>

<?php include '/view/footer.php'; ?>