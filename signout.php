<!--
    php for sign out form
-->

<?php
    session_start();
    $_SESSION = array();
    session_destroy();

    setcookie('username', '', -1);

    header('Location: index.php');
    exit();
?>