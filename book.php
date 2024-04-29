<!--
    book info page for bookstore site
-->

<?php include("top.php"); 

$isbn = $_GET["isbn"];

if (isset($_SESSION["repeatError"])) {                                                  # error message if user tries to add book to favorites when it's already in favorites
    unset($_SESSION['repeatError']);
    ?>
    <div class="error_message">Item already in favorites</div> 
    <?php
}
if (isset($_COOKIE['error'])) {                                                        # error message if user tries to add book to favorites when not logged in 
    setcookie ("error", "", time() - 3600);
    ?>
    <div class="error_message">Please sign in first</div> 
    <?php
}
if (isset($_COOKIE['addedFav'])) {                                                     # message when book is added to favorites
    setcookie ("addedFav", "", time() - 3600);
    ?>
<div class="message">Added to favorites</div>
<?php
}
if (isset( $_SESSION['addedCart'])) {                                                   # message when book is added to cart
    unset( $_SESSION['addedCart']);
    ?>
    <div class="message">Added to cart</div>
    <?php
}

?>
<div id="book_main_content">
    <div id="parse-book"><?= $isbn ?></div>
    <a href="catalogue.php"><- Back to Catalogue</a>
    <div id="top_content">

    </div>
    <div id="bottom_content">
        <h2>Overview</h2>
    </div>
</div>
<?php include("bottom.php"); ?>