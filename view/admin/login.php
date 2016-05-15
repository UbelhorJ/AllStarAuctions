<?php
    require_once('../util/secure_connection.php');
?>
<?php include '../view/head.php'; ?>
        <link rel="stylesheet" href="../main.css">
<?php include '../view/header.php'; ?>

        <section>
            <div id="admin_login_form">
                <form action="." method="POST" id="admin_login">
                    <?php
                        echo $login_message . '<br>';
                    ?>
                    <label for="user_name">User Name:</label>
                    <input type="text" name="user_name" id="user_name" length="64" autofocus>
                    <br>
                    <label for="user_password">Password:</label>
                    <input type="password" name="user_password" id="user_password" length="64">
                    <br>
                    <label>&nbsp;</label>
                    <input type="submit" value="login">
                </form>
            </div>
        </section>

<?php include '../view/footer.php'; ?>