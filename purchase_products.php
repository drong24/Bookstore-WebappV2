<!--
    purchase product page for bookstore site
-->

<?php 
    include("top.php"); 
    $cartItems = (isset($_COOKIE['cart'])) ? unserialize($_COOKIE['cart']) : null;
?>
    <div class='parse-cart'>
    <?php
    foreach ($cartItems as $item) {
        //echo '<script type="text/javascript">fetchCart("'.$item.'")</script>';
        echo $item . "-";
    }
    ?>
     </div>
     <?php
    if (!isset($_COOKIE['cart']) || sizeof(unserialize($_COOKIE['cart'])) < 1) {            # redirects to cart.php if cart cookie is empty or null
        $_SESSION['error'] = TRUE;
        header('Location: cart.php');
        exit();
    }
    $cart = unserialize($_COOKIE['cart']);
    $price = 0;
?>
<div class = "main_content">
    <h3>Your Order</h3>
    <div class="cata_bottom one_row user_books" id="purchase_main"> 

    </div>
    <div id="purchase_details">
        <form action="purchase_product_submit.php" method="post" class="delivery_details">
            <h3>Delivery Details</h3>
            <fieldset>
                <div class="delivery_two_col">
                    <label>First Name</br><input></label></label>
                    <label>Last Name</br><input></label></label>
                </div>
                <label>Address 1</br><input></label></label>
                <label>Address 2</br><input></label></label>
                <label>State</br><input></label></label>
                <div class="delivery_two_col">
                    <label>City</br><input></label></label>
                    <label>Zip Code</br><input></label></label>
                </div>
                <label>Phone Number</br><input></label></label>
            </fieldset>
            <h3>Payment Options</h3>
            <fieldset>
                <p>No payment needed. It's Free!</p>
            </fieldset>
            <?php                                                                                  # calculations and variables for tax, shipping, and total price
            $tax = number_format($price * 0.15, 2);
            $shipping = number_format(sizeof($cart) * 4.18, 2);
            $totalPrice = number_format($price + $shipping + $tax, 2);
            ?>
            <button onclick=purchseBooks() type="submit" class="cart_button">Confirm Purchase</button>
        </form>
    </div>
</div>

<?php include("bottom.php"); ?>