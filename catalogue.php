<!--
    catalogue page for bookstore site
-->

<?php include("top.php"); 


    if (isset($_POST['title'])) {                                      # calls the filter function in filter.php for each filter form value that has been inputed
        $books = filter($books, "title", $_POST['title']);
    }
    if (isset($_POST['author'])) {
        $books = filter($books, "author", $_POST['author']);
    }
    if (isset($_POST['genre'])) {
        $books = filter($books, "genre", $_POST['genre']);
    }
    if (isset($_POST['min'])) {
        $books = filter($books, "min", $_POST['min']);
    }
    if (isset($_POST['max'])) {
        $books = filter($books, "max", $_POST['max']);
    }
?>
<div id = "catalogue_main_content">
    <div id="catalogue">
        <div class="cata_top">
            <h1>Catalogue</h1>
        </div>
        <div class="cata_bottom"> 
        </div>
    </div>
</div>

<?php include("bottom.php"); ?>