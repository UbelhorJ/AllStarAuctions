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
            width: 58px;
            text-align: right;
            font-size: 85%;
        }
        
        #newAnnouncementForm {
                border: 1px solid black;
        }
        
        .admin_announcement_dateTime, .admin_announcement_title, .admin_announcement_delete {
            font-weight: bold;
            display: inline-block;
        }
        
        .admin_announcement_body {
            padding-left: 20px;
            font-family: "Courier New", Courier, monospace;
        }
</style>

        <section>
            <h2>Announcements Administration</h2>
            
            <div id="newAnnouncementForm" style="padding: 5px; margin-bottom: 10px;">
                <form action="." name="newAnnouncement" method="POST">
                        <span style="font-weight: bold;">Add New Announcement</span></br>
                        <label for="announcementTitle">Title: </label>
                        <input type="text" name="announcementTitle" length="64" style="width: 463px"><br>
                        <label for="announcementBody">Details: </label>
                        <textarea name="announcementBody" rows="3" cols="64"></textarea>
                        <input type="hidden" name="action" value="add_announcement">
                        <input type="submit" value=" Save " style="margin-bottom: 3px;">
                </form>
            </div>
            
            <?php foreach ($announcements as $announcement) : ?>
                <div class="admin_announcements">
                    <div class="admin_announcement_dateTime">
                        <?php echo '[' . $announcement->getDateTime() . '] '; ?>
                    </div>
                    <div class="admin_announcement_title">
                        <?php echo $announcement->getTitle(); ?>
                    </div>
                    <div class="admin_announcement_delete">
                        <form action="." method="POST" id="deleteAnnouncementForm">
                            <input type="hidden" name="action" value="delete_announcement">
                            <input type="hidden" name="announcementToDelete" value="<?php echo $announcement->getID(); ?>">
                            <input type="submit" value=" Delete ">
                        </form>
                    </div>
                    <div class="admin_announcement_body">
                        <?php echo $announcement->getBody(); ?>
                    </div>
                </div>
                <br>
            <?php endforeach ?>
        </section>

<?php include '../../view/footer.php'; ?>