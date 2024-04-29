<?php
/*
    server for bookstore project
    @author Daisy Rong
*/

ini_set('display_errors', 1);
$username = "dzr0070";
$password = "!myData28";
$result = [];
try {
    $con = new PDO("mysql:host=sysmysql8.auburn.edu;dbname=dzr0070db", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $type = (isset($_GET["type"])) ?  $type = $_GET["type"] : null;
    if ($type == "list") {
        $data = $con->query("select * from books");
        
        while ($row = $data->fetch()) {
            $temp = [];
            $temp['title'] = $row['title'];
            $temp['author'] = $row['author'];
            $temp['image'] = $row['image-url'];
            $temp['isbn'] = $row['isbn'];
            $result[] = $temp;
        }
        
        echo json_encode($result);
    }
    if ($type == "book") {
        $t = "select * from books where isbn = '" . $_GET["isbn"] . "';";
        $data = $con->query($t);
        while ($row = $data->fetch()) {
            $temp = [];
            $temp['isbn'] = $row['isbn'];
            $temp['title'] = $row['title'];
            $temp['author'] = $row['author'];
            $temp['genre'] = $row['genre'];
            $temp['price'] = $row['price'];
            $temp['image'] = $row['image-url'];
            $result[] = $temp;
        }
        echo json_encode($result);
    }
    if ($type == "desc") {
        $result = [];
        $t = "select * from descriptions where isbn = '" . $_GET["isbn"] . "';";
        $data = $con->query($t);
        while ($row = $data->fetch()) {
            $result[] = $row["descr"];
        }
        echo json_encode($result);
    }
    if ($type == "fav") {
        $uname = $_GET["username"];
        $isbn = $_GET["isbn"];
        $query = "insert into favorites values ('" . $uname . "', '" . $isbn . "');";
        $con->query($query);
        echo $query;
    }
    if ($type == "cart") {
        
        $isbn = json_decode($_GET["isbn"]);
        $t = "select * from books";
        for ($i = 0; $i < count($isbn); $i++) {
            $t = ($i == 0) ? $t . " where isbn = " . $isbn[$i] : $t . " or isbn = " . $isbn[$i];
        }
        $t = $t . ";";
        
        $data = $con->query($t);
        while ($row = $data->fetch()) {
            $temp = [];
            $temp['isbn'] = $row['isbn'];
            $temp['title'] = $row['title'];
            $temp['author'] = $row['author'];
            $temp['genre'] = $row['genre'];
            $temp['price'] = $row['price'];
            $temp['image'] = $row['image-url'];
            $result[] = $temp;
        }
        echo json_encode($result);
        
    }
    if ($type == "purchase") {
        
        $user = $_GET["username"];
        $isbn = json_decode($_GET["isbn"]);
        $query = "insert into purchases values";
        for ($i = 0; $i < count($isbn); $i++) {
            $query = $query . " ('" . $user . "', '" . trim($isbn[$i]) . "')";
            $query = ($i != count($isbn) - 1) ? $query . ", " : $query;
        }
        $query = $query . ";";
        $con->query($query);
        echo $query;
    }
    if ($type == "signin") {
        
        $user = $_GET["username"];
        $pass = $_GET["password"];
        $query = "select * from users where username ='" . $user . "' and password = '" . $pass . "';";
        $data = $con->query($query);
        while ($row = $data->fetch()) {
            $result[] = $row['username'];
        }
        echo json_encode($result);
    }
    if ($type == "purchased") {
        $user = $_GET["username"];
        $query = "select * from purchases p join users u on p.user_id = u.username join books b on b.isbn = p.book_id where username = '" . $user . "';";
        $data = $con->query($query);
        while ($row = $data->fetch()) {
            $temp = [];
            $temp['isbn'] = $row['isbn'];
            $temp['title'] = $row['title'];
            $temp['author'] = $row['author'];
            $temp['genre'] = $row['genre'];
            $temp['price'] = $row['price'];
            $temp['image'] = $row['image-url'];
            $result[] = $temp;
        }
        echo json_encode($result);
    }
    if ($type == "getFavorites") {
        $uname = $_GET['username'];
        $query = "select * from favorites join books on book_id = isbn where user_id ='" . $uname . "';";
        $data = $con->query($query);
        while ($row = $data->fetch()) {
            $temp = [];
            $temp['isbn'] = $row['isbn'];
            $temp['title'] = $row['title'];
            $temp['author'] = $row['author'];
            $temp['genre'] = $row['genre'];
            $temp['price'] = $row['price'];
            $temp['image'] = $row['image-url'];
            $result[] = $temp;
        }
        echo json_encode($result);
    }
}
catch (PDOException $e) {
    echo "Connection failed: " . $e -> getMessage();
}
?>