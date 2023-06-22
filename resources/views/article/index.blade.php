<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .button {
            text-align: center;
            vertical-align: middle;

        }
    </style>
    <meta charset="UTF-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title>Article list</title>
</head>
<body>

<div id="app">
    <Site-Header></Site-Header>
        <div>
            @if(!\Illuminate\Support\Facades\Session::has("auth"))
                <a href="/login">Login</a>
            @else
                <a href="/logout">Logout</a>
            @endif

        </div>
        <br>

    <div>
        @if(\Illuminate\Support\Facades\Session::has("auth"))
            <h3>Your items</h3>
            <table id="userItems">
                <th>ArticleID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Created at</th>
                <th>Action</th>

                @foreach($userItems as $userItem)
                    <tr id="article{{ $userItem->id }}">
                        <td> {{ $userItem->id }} </td>
                        <td> {{ $userItem->name }} </td>
                        <td> {{ $userItem->price }}€</td>
                        <td> {{ $userItem->description }} </td>
                        <td> {{ $userItem->created_at }} </td>
                        <td class="button">
                            <input type="button" value="Discount"
                                   onclick='eventAction({{ $userItem->id }}, "discount")'>
                        </td>
                    </tr>
                @endforeach
            </table>

        @endif

        <h3>Selling items</h3>
        <table id="articlesTable">
            <tr>
                <th>ArticleID</th>
                {{--                    <th>Image</th>--}}
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Seller</th>
                <th>Created at</th>
                @if(\Illuminate\Support\Facades\Session::has("auth"))
                    <th>Shopping Cart</th>
                    <th>Action</th>
                @endif
            </tr>
            @foreach($results as $result)
                <tr id="article{{ $result->id }}">
                    <td> {{ $result->id }} </td>
                    {{--<th>
                        --}}{{--check if article.id exists in images array--}}{{--
                        @if( array_key_exists( $result->id , $images) )
                            <img src="{{url($images[$result->id])}}" width="100" height="100" alt="">
                        @else
                            No image found
                        @endif
                    </th>--}}
                    <td> {{ $result->name }} </td>
                    <td> {{ $result->price }}€</td>
                    <td> {{ $result->description }} </td>
                    <td> {{ $result->user->name }} </td>
                    <td> {{ $result->created_at }} </td>
                    @if(\Illuminate\Support\Facades\Session::has("auth"))
                        <td class="button"><input type="button" value="+"

                                                  onclick='shoppingCart({{ $result->id }},
                           "{{ $result->name }}",
                           {{ $result->price }},
                           "{{ $result->description }}",
                           "{{ $result->user->name }}",
                           "{{ $result->created_at }}",
                           "+")'>
                        </td>
                        <td class="button">
                            <input type="button" value="Buy"
                                   onclick='eventAction({{ $result->id }}, "buy")'>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <br>
    </div>

    @if(\Illuminate\Support\Facades\Session::has("auth"))
        <div>
            <h3>Shopping Cart</h3>
            <table id = "cartTable">
                <tr>
                    <th>ArticleID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Seller</th>
                    <th>Remove from cart</th>
                    <th>Action</th>
                </tr>
                @foreach($itemsInCart as $item)
                    <tr id="cart{{ $item->id }}">
                        <td> {{ $item->id }}</td>
                        <td> {{ $item->name }}</td>
                        <td> {{ $item->price }}</td>
                        <td> {{ $item->user->name}}</td>
                        <td class="button"><input type="button" value="-"
                                   onclick='shoppingCart({{ $item->id }},
                           "{{ $item->name }}",
                           {{ $item->price }},
                           "{{ $item->description }}",
                           "{{ $item->user->name }}",
                           "{{ $item->created_at }}",
                           "-")'>
                        </td>
                        <td class="button">
                            <input type="button" value="Buy"
                                   onclick='eventAction({{ $item->id }}, "buy")'>
                        </td>
                    </tr>

                @endforeach
            </table>
            <br>
        </div>
    @endif

</div>

@vite('resources/js/app.js')
<script>
    "use strict"

    // get current logged-in user whenever open or refresh page
    const userData = {"user": "{{ \Illuminate\Support\Facades\Session::get("user") }}", "mail": "{{ \Illuminate\Support\Facades\Session::get("mail") }}" };
    console.log(JSON.stringify(userData))

    const connection = new WebSocket("ws://localhost:8000/");

    connection.onmessage = function (e) {
        const msg = JSON.parse(e.data)
        if (msg["type"] === "buy") {
            if (userData["user"] === msg["item"]["username"])
                alert("Great! Your item "+ msg["item"]["name"] + " has been successfully sold!")
        } else
            alert("The article" + msg["item"]["name"] + " is now offered at a lower price! Get it fast")

    }
    connection.onopen = function () {
        console.log("Connection established");
    };
    connection.onerror = function () {
        console.log("Connection corrupted");
    }

    function shoppingCart(itemID, name, price, description, seller, date, value) {
        const cartTable = document.getElementById("cartTable")
        const articlesTable = document.getElementById("articlesTable")

        let xhr = new XMLHttpRequest();

        if (value === "+") {

            xhr.open("POST", "/api/shoppingCart/" + itemID)
            xhr.setRequestHeader('Content-Type', 'application/json')

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4)
                    console.log(xhr.responseText + " to shopping cart")
            }
            xhr.send(JSON.stringify(userData))

            // find and remove the to-be-deleted article from article table
            document.getElementById("article" + itemID).remove()

            // create new row and data cell for name, price and remove button in cart table
            let newRow = document.createElement("tr")
            newRow.setAttribute("id", "cart" + itemID)

            // create data cell for new row in cart table
            let tdID = document.createElement("td")
            let tdName = document.createElement("td")
            let tdPrice = document.createElement("td")
            let tdSeller = document.createElement("td")
            let tdRemove = document.createElement("td")
            tdRemove.setAttribute("class", "button")
            let tdBuy = document.createElement("td")
            tdBuy.setAttribute("class", "button")

            // create remove button in cart table
            let removeButton = document.createElement("input")
            removeButton.setAttribute("type", "button")
            removeButton.setAttribute("value", "-")
            removeButton.setAttribute("onclick", "shoppingCart("
                + itemID + ',"' + name.toString() + '",' + price + ',"' + description.toString() + '","' + seller.toString() + '","' + date.toString() + '", "-")')

            // create remove button in cart table
            let buyButton = document.createElement("input")
            buyButton.setAttribute("type", "button")
            buyButton.setAttribute("value", "Buy")
            buyButton.setAttribute("onclick", "eventAction(" + itemID + ", 'buy')")

            // insert name, price and button into data cell in cart table
            tdID.appendChild(document.createTextNode(itemID))
            tdName.appendChild(document.createTextNode(name))
            tdPrice.appendChild(document.createTextNode(price))
            tdSeller.appendChild(document.createTextNode(seller))
            tdRemove.appendChild(removeButton)
            tdBuy.appendChild(buyButton)

            // complete creating new row for cart table
            newRow.appendChild(tdID)
            newRow.appendChild(tdName)
            newRow.appendChild(tdPrice)
            newRow.appendChild(tdSeller)
            newRow.appendChild(tdRemove)
            newRow.appendChild(tdBuy)

            cartTable.appendChild(newRow) // insert new row to cart table

        } else {

            xhr.open("DELETE", "/api/shoppingCart/" + itemID)
            xhr.setRequestHeader('Content-Type', 'application/json')

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4)
                    console.log(xhr.responseText)
            }
            xhr.send(JSON.stringify(userData))

            // find and remove to be deleted row  in cart table
            document.getElementById("cart" + itemID).remove()

            // create row to put back article table
            let rowBack2article = document.createElement("tr")
            rowBack2article.setAttribute("id", "article" + itemID)

            // create back data cells to put back to article table
            let id_ = document.createElement("td")
            let name_ = document.createElement("td")
            let price_ = document.createElement("td")
            let description_ = document.createElement("td")
            let username_ = document.createElement("td")
            let date_ = document.createElement("td")
            let add_ = document.createElement("td")
            add_.setAttribute("class", "button")
            let buy_ = document.createElement("td")
            buy_.setAttribute("class", "button")


            // create add button in article table
            let addButton = document.createElement("input")
            addButton.setAttribute("type", "button")
            addButton.setAttribute("value", "+")
            addButton.setAttribute("onclick", "shoppingCart("
                + itemID + ',"' + name.toString() + '",' + price + ',"' + description.toString() + '","' + seller.toString() + '","' + date.toString() + '", "+")')

            // create buy button in article table
            let buyButton = document.createElement("input")
            buyButton.setAttribute("type", "button")
            buyButton.setAttribute("value", "Buy")
            buyButton.setAttribute("onclick", "eventAction(" + itemID + ", 'buy')")

            // insert article info to data cell
            id_.appendChild(document.createTextNode(itemID))
            name_.appendChild(document.createTextNode(name))
            price_.appendChild(document.createTextNode(price + "€"))
            description_.appendChild(document.createTextNode(description))
            username_.appendChild(document.createTextNode(seller))
            date_.appendChild(document.createTextNode(date))
            add_.appendChild(addButton)
            buy_.appendChild(buyButton)

            // insert data cell to row
            rowBack2article.appendChild(id_)
            rowBack2article.appendChild(name_)
            rowBack2article.appendChild(price_)
            rowBack2article.appendChild(description_)
            rowBack2article.appendChild(username_)
            rowBack2article.appendChild(date_)
            rowBack2article.appendChild(add_)
            rowBack2article.appendChild(buy_)

            articlesTable.appendChild(rowBack2article) // put row back to article table

        }
    }

    function eventAction(itemID, action) {
        let data

        if (action === "buy") {
            axios.post("/api/article/" + itemID + "/sold", {
                "id": itemID
            }).then(response => {
                data = {
                    "type": "buy",
                    "item": response.data
                }
                console.log(data)
                connection.send(JSON.stringify(data))
            }).catch(e => {
                console.log(e)
            })
        } else {
            axios.post("/api/article/" + itemID + "/discount", {
                "id": itemID
            }).then(response => {
                data = {
                    "type": "discount",
                    "item": response.data
                }
                console.log(data)
                connection.send(JSON.stringify(data))
            }).catch(e => {
                console.log(e)
            })
        }
    }

</script>

</body>
</html>
