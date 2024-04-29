/*
    script for bookstore project
    @author Daisy Rong
*/

window.onload = function() {
    $("catalogue_main_content")?.addEventListener("DOMContentLoaded", fetchCatalogue());
    $("book_main_content")?.addEventListener("DOMContentLoaded", fetchName());
    $("cart")?.addEventListener("DOMContentLoaded", fetchCart());
    $("purchase_main")?.addEventListener("DOMContentLoaded", fetchCart());
    $("user_info")?.addEventListener("DOMContentLoaded", showAccountInfo());
    $("fav_main")?.addEventListener("DOMContentLoaded", fetchFavorites());
}

function fetchFavorites() {
    var uname = getCookie("username").split(";");
    new Ajax.Request (
        "server.php",
        {
            method: "GET",
            parameters: {type: "getFavorites", username: uname[0]},
            onSuccess: showFavorites,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    );
}

function showFavorites(ajax) {
    var dataList = JSON.parse(ajax.responseText);
    dataList.forEach(data => {
        document.querySelector(".user_books").innerHTML += 
        "<a href='book.php?isbn='"
        + data.isbn 
        + "' class='list_book'><img src='"
        + data.image
        + "' alt='book image'/><div><p class='title'>"
        + data.title
        + "</br></p><p class='author'>by: '"
        + data.author
        + "'</p><p><strong>$"
        + data.price
        + "</strong></p></div></a>";
    });
}
function showAccountInfo() {
    var cookies = getCookie("username").split(";");
     var uname = cookies[0];
    $("user_info").innerHTML += 
    "<img src='./images/default.jpeg' alt='profile image'>"
    + "<div><h3>User Info</h3><div><p><strong>Username:</strong> <span>"
    + uname
    + "</span></p></div></div>";

    new Ajax.Request (
        "server.php", 
        {
            method: "GET",
            parameters: {type: "purchased", username: uname},
            onSuccess: displayPurchases,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    )
}

function displayPurchases(ajax) {
    var data = JSON.parse(ajax.responseText);
    if (data[0] != null) {
        data.forEach(i => {
            document.querySelector(".history_list").innerHTML += 
            "<a href='book.php?isbn='" 
            + i.isbn
            + "' class='history_book'><img src='"
            + i.image
            + "' alt='book image'/><p class='title'>"
            + i.title
            + "</br></p> <p class='author'>by: "
            + i.author + "</p></a>";
        });
    }
    else {
        document.querySelector(".history_list").innerHTML += "<h4>No Previous Purchases Found</h4>";
    }

}


function signin() {
    var uname = document.querySelector(".username").value;
    var pass = document.querySelector(".password").value;
    new Ajax.Request (
        "server.php", 
        {
            method: "GET",
            parameters: {type: "signin", username: uname, password: pass},
            onSuccess: setCookieUname,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    );
}

function purchseBooks() {
    if (getCookie("username") == null) {
        return;
    }
    var name = getCookie("username");
    name = name.slice(0, 4);
    var cartItems = document.querySelector(".parse-cart").innerHTML.split("-");
    cartItems.splice(cartItems.length - 1);
    var cartItems = JSON.stringify(cartItems);
    new Ajax.Request (
        "server.php",
        {
            method: "GET",
            parameters: {type: "purchase", username: name, isbn: cartItems},
            onSuccess: test,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    );
}

function test(ajax) {
    console.log(ajax.responseText);
}

function fetchCart() {
    if (document.querySelector(".parse-cart").innerHTML.trim() == "") {
        return;
    }
    var cartItems = document.querySelector(".parse-cart").innerHTML.split("-");
    cartItems.splice(cartItems.length - 1);
    var cartItems = JSON.stringify(cartItems);
    new Ajax.Request (
        "server.php", 
        {
            method: "GET",
            parameters: {type: "cart", isbn: cartItems},
            onSuccess: displayCart,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    );
}

function displayCart(ajax) {
    var data = JSON.parse(ajax.responseText);
    data.forEach(d => {
        document.querySelector(".user_books").innerHTML += 
        "<a href='book.php?isbn='"
        + d.isbn
        + "' class='list_book'><img src='"
        + d.image
        + "' alt='book image'/><div><p class='title'>" 
        + d.title
        + "</br></p><p class='author'>by: "
        + d.author
        + "</p><p><strong>$"
        + d.price
        + "</strong></p></div><form action='book-buttons.php' method='post' class='fav_page_buttons'>"
        + "<button name='removeCart' value='"
        + d.title
        + "' class='fav_button'>Remove</button></form></a>";
    });
}

function fetchCatalogue() {
    new Ajax.Request (
    "server.php", 
    {
        method: "GET",
        parameters: {type: "list"},
        onSuccess: displayCatalogue,
        onFailure: ajaxFailed,
        onException: ajaxFailed
    }
    );
}

function fetchName() {
    new Ajax.Request (
        'book.php',
        {
            method: "GET",
            onSuccess: fetchBook,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    )
}

function fetchBook() {
    var t =  $("parse-book").innerHTML;
    new Ajax.Request (
        "server.php",
        {
            method: "GET",
            parameters: {type: "book", isbn: t},
            onSuccess: displayBook,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    )
    new Ajax.Request (
        "server.php",
        {
            method: "GET",
            parameters: {type: "desc", isbn: t},
            onSuccess: displayBookDesc,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    )
}

function displayCatalogue(ajax) {
    var data = JSON.parse(ajax.responseText);
    data.forEach(book => {
        document.querySelector(".cata_bottom").innerHTML += 
        "<a href='./book.php?isbn="
        + book.isbn
        + "' class='cata_book'><img src="
        + book.image 
        + " alt='book image'/><p class= title>"
        + book.title 
        + "</p></br><p class='author'> by: "
        + book.author
        + "</p></a>"; 
    });

}

function displayBook(ajax) {

    var data = JSON.parse(ajax.responseText);
    $("top_content").innerHTML +=
    "<img src='" + data[0].image + "' /> <div><h1>"
    + data[0].title
    + "</h1><p>By: "
    + data[0].author
    +"</p><p>ISBN: "
    + data[0].isbn
    + "</p><form action='book-buttons.php' method='post'><button name = 'addCart' value='"
    + data[0].isbn 
    + "' class='cart_button'>Add to Cart</button></form> </br>"
    + "<button name = 'fav' value='"
    + data[0].isbn
    + "' onclick='addToFavorites()' class='fav_button'>Add to Favorites</button></div>";
}

function displayBookDesc(ajax) {
    var data = JSON.parse(ajax.responseText);
    data.forEach(para => {
        $("bottom_content").innerHTML += "<p>" + para + "</p>";
    });
}

function addToFavorites() {
    var t = $("parse-book").innerHTML;
    if (getCookie("username") == null) {
        setCookie("error", "true");
        location.reload();
    }
    else {
        var u = getCookie("username").split(";");
        new Ajax.Request (
            "server.php",
            {
                method: "GET",
                parameters: {type: "fav", username: u[0], isbn: t},
                onSuccess: confirmFav,
                onFailure: ajaxFailed,
                onException: ajaxFailed
            }
        )
    }
}

function confirmFav(ajax) {
    var uname = getCookie("username");
    document.cookie = "addedFav=" + uname;
    location.reload();
}

function setCookieUname(ajax) {
    
    var data = JSON.parse(ajax.responseText);
    if (data[0] != null) {
        var cookieItem = "username=" + data[0];
        document.cookie = cookieItem;
        window.location.href="index.php";
    }
    else {
        document.cookie = "error=true"; 
        location.reload();
    }
}
function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

function setCookie(name, value) {
    var cookieItem = name + "=" + value;
    document.cookie = cookieItem;
}

function signinUser() {
    var uname = $("username_input").value;
    var pass =  $("password_input").value;
    new Ajax.Request (
        "server.php", 
        {
            method: "GET",
            parameters: {type: "signin", username: uname, password: pass},
            onSuccess: ajaxFailed,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        }
    )
}

// for error and exception handling
function ajaxFailed(ajax, exception) {
    $("container").innerHTML = "";
    var message = "Error making ajax request: \n";
    if (exception) {
        message += "Exception: " + exception.message;
    } else {
        message += "Server Status: " + ajax.status + " Status Text: " + ajax.statusText + " Server Response Text: " + ajax.responseText;
    }
    $("container").innerHTML += message;
}