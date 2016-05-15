<?php include 'view/head.php'; ?>
        <link rel="stylesheet" href="main.css">
<?php include 'view/header.php'; ?>

<?php include '/view/navigation.php'; ?>

<style>
    #announcements_header {
        background-color: #3F51B5;
        color: #FFFFFF;
        text-align: center;
        font-weight: bold;
        padding: 3px;
    }
    
    #announcements {
        border: 2px solid #3F51B5;
        float: right; 
        width: 200px;
    }
    
    .announcement_title {
        color: #FF3E3E;
        font-weight: 600;
    }
</style>

        <section>
            <div id="announcements">
                <div id="announcements_header">
                ANNOUNCEMENTS
                </div>
                <div style="padding: 5px; margin-top: 5px;">
                <?php foreach ($announcements as $announcement) : ?>
                    <div>
                        <span class="announcement_title"><?php echo $announcement->getTitle(); ?></span><br>
                        <?php echo $announcement->getBody(); ?><br>
                        <br>
                    </div>
                <?php endforeach ?>
                </div>
            </div>
            <h1>All Star Auctions in Sweet Home, OR</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </section>

<?php include '/view/footer.php'; ?>