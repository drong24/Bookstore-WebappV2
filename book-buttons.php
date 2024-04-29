<!--
    php code for all things cart or favorites form related
-->

<?php
session_start();

# retrieving and removing white space and invisible characters from POST values
$fav = trim($_POST['fav']);
$fav = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $fav);
$cart = trim($_POST['addCart']);
$cart = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $cart);
$favCart = trim($_POST['shiftCart']);
$favCart = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $favCart);
$toRem = trim($_POST['removeFav']);
$toRem = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $toRem);
$toRemCart = trim($_POST['removeCart']);
$toRemCart = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $toRemCart);

$expireTime = time() + (60 * 60 * 24);
$user = $_COOKIE['username'];

# for adding items to cart from book info
if (isset($_POST['addCart'])) {
    #setcookie('cart', '', -1);                         debugging purposes
    #checks if there's other items in cart
    if (isset($_COOKIE['cart'])) {
        $curCart = unserialize($_COOKIE['cart']);
        $curCart[] = $cart;
    }
    else {
        $curCart[] = $cart;
    }
    $curCart = serialize($curCart);
    setcookie('cart', $curCart, $expireTime);
    $_SESSION['addedCart'] = TRUE;
    header("Location: book.php?isbn=$cart");
    exit();
}

# for adding items to cart from favorites
if (isset($_POST['shiftCart'])) {
    #setcookie('cart', '', -1);                         debugging purposes
    #checks if there's other items in cart
    if (isset($_COOKIE['cart'])) {
        $curCart = unserialize($_COOKIE['cart']);
        $curCart[] = $favCart;
    }
    else {
        $curCart[] = $favCart;
    }
    $curCart = serialize($curCart);
    setcookie('cart', $curCart, $expireTime);
    $_SESSION['addedCart'] = TRUE;
    header("Location: favorites.php");
    exit();
}

# for removing items from cart 
if (isset($_POST['removeCart'])) {
    #setcookie('cart', '', -1);     
    $curCart = unserialize($_COOKIE['cart']);
    $index = array_search($toRemCart, $curCart);
    array_splice($curCart, $index, 1);
    $curCart = serialize($curCart);
    setcookie('cart', $curCart, $expireTime);
    $_SESSION['removedCart'] = TRUE;
    header("Location: cart.php");
    exit();
}

# verifies if user if logged in
if (!isset($_COOKIE['username'])) {
    $_SESSION["error"] = TRUE;
    header("Location: book.php?title=$fav");
    exit();
}

?>

--end of file--