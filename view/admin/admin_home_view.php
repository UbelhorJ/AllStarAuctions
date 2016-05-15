<?php include '../view/head.php'; ?>
        <link rel="stylesheet" href="../main.css">
<?php include '../view/header.php'; ?>

<?php include '../view/admin/admin_navigation.php'; ?>

        <section>
            <div id="admin_actions">
                <a href="<?php $app_path; ?>announcements">Manage Annoucements</a><br>
                <a href="<?php $app_path; ?>inventory">Manage Featured Inventory</a><br>
                <a href="<?php $app_path; ?>calendar">Manage Events and Calendar</a><br>
                <a href="<?php $app_path; ?>?action=logout">Log Out</a>
            </div>
        </section>
        
        <?php
            echo 'app_path: ' . $app_path . '<br>';
            echo 'Is Valid Admin: ' . $_SESSION['is_valid_admin'] . '<br>';
            echo 'Document Root: ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
        ?>

<?php include '../view/footer.php'; ?>