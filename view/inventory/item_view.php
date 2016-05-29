<?php
    if ($item->getStatus() == 'h') {
        header('Location: ' . $app_path . 'inventory');
    }
?>

<?php include 'view/head.php'; ?>
        <script src="https://code.jquery.com/jquery-latest.min.js"></script>
        <script src="../javascript/bxslider/jquery.bxslider.min.js"></script>       
        <link rel="stylesheet" href="../main.css">
        <link rel="stylesheet" href="../javascript/bxslider/jquery.bxslider.css">
<?php include '/view/header.php'; ?>

<?php include '/view/navigation.php'; ?>

<style>
    .thumb_container {
        display: inline-block;
    }
</style>

<script>
$(document).ready(function(){
  $('.bxslider').bxSlider({
      auto: true,
      autoControls: true,
      infiniteLoop: true
  });
});  
</script>

        <section>
            <h1><?php echo $item->getName(); ?></h1>
            
            <?php if ($item->getStatus() == 's') : ?>
                <p><strong>This item has been sold. Check out our current inventory <a href=".">here</a>.</strong></p>
            <?php endif ?>
            
            <p><?php echo htmlentities($item->getDescription()); ?></p>
            
            <?php
                $reserve = $item->getReservePrice();
                 
                if ($reserve > 0) {
                    echo '<p>Reserve: $' . $reserve . '</p>'; 
                }
            ?>
            
            <div>
                <ul class="bxslider">
                    <?php
                        $thumbs = array_reverse($item->getThumbs());
                        $images = array_reverse($item->getImages());                            
                        #$i = count($thumbs) - 1;
                        
                        #for ($i; $i >= 0; $i--) :
                        foreach ($images as $image) :
                    ?>
                        <li><img src="../images/inventory/<?php echo $itemNo; ?>/original/<?php echo $image; ?>" title="<?php echo htmlentities($item->getName()); ?>"></li>
                    <?php endforeach ?>
                </ul>
            </div> <!-- end my-slider -->
            
        </section>

<?php include '/view/footer.php'; ?>