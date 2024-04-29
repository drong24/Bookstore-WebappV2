<!--
    cart page for bookstore site
-->

<?php 
include('top.php');
$username = (isset($_COOKIE['username'])) ? $_COOKIE['username'] : null;
$cartItems = (isset($_COOKIE['cart'])) ? unserialize($_COOKIE['cart']) : null;
?>
<div class='parse-cart'>
<?php
if ($cartItems != null) {
    foreach ($cartItems as $item) {
        echo $item . "-";
    }
}
?>
 </div>
 <?php
if (isset($_SESSION['removedCart'])) {                                          # message for removed item
    unset($_SESSION['removedCart']);    
    ?>
    <p class="message">Item removed</p>
    <?php
}
if (isset($_SESSION['error'])) {                                                # message if user tries to check out without items in cart
    unset($_SESSION['error']);
    ?>
    <p class="error_message">Please add at least one item to cart before checking out</p>
    <?php
}
?>
<div class="main_content" id="align_left">
    <h1 id="cart_header">Shopping Cart</h1>
    <hr>
    <div id="cart">
    <div class="user_books" id="float_left"> 
    </div>
    </div>
        <div id="float_right">
            <p><strong>Subtotal: </strong>free</p>
            <form action="purchase_products.php" method="post">
                <button class="cart_button">Proceed to Checkout</button>
            </form>
        </div>
    </div>
</div>
<?php include('bottom.php');?>