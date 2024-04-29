<!--
    sign in page for bookstore site
-->

<?php 
    include("top.php") ;

    if (isset($_COOKIE["error"])) {                                                    // error message for incorrect username/password combo
        setcookie ("error", "", time() - 3600);
?>
<p class="error_message">Incorrect username or password.</p>
<?php
    }
?>
<div class="main_content user_ver">
    <h1>Sign In</h1>

            <label>Username: </label>
            <input class="username" name="username" type="text" maxlength="20" required>
            <label>Password: </label>
            <input class="password" name="password" type="password" maxlength="20" required>
            <input type="submit" onclick=signin()>

</div>
<?php include("bottom.php") ?>