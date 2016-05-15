<?php 
    require_once('../util/secure_connection.php');
    require_once('../util/verify_admin.php');  // verity admin user logged in 
?>

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

<?php include '../view/footer.php'; ?>