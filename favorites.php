<!--
    favorites page for bookstore site
-->

<?php 
include('top.php');
$username = $_COOKIE['username'];

if(isset($_SESSION['removedFav'])) {                                                                # message for removing item from favorites
    unset( $_SESSION['removedFav']);
    ?>
    <p class="message">Item removed</p>
    <?php
}   
if(isset($_SESSION['addedCart'])) {                                                                 # messgae for adding item to cart
    unset($_SESSION['addedCart']);
    ?>
    <p class="message">Item added to cart</p>
    <?php
}
?>
<div id="fav_main" class="main_content">
    <h1>Favorites</h1>
    <div class="user_books"> 

    </div>
</div>
<?php include('bottom.php') ?>