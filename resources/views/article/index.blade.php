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
        <table id="articlesTable">
            <tr>
                <th>ArticleID</th>
                {{--                    <th>Image</th>--}}
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>User</th>
                <th>Created at</th>
                @if(\Illuminate\Support\Facades\Session::has("auth"))
                    <th>Shopping Cart</th>
                    <th>Quick Buy</th>
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
                                   onclick='quickBuy({{ $result->id }})'>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <br>
    </div>

    @if(\Illuminate\Support\Facades\Session::has("auth"))
        <div>
            <label for="shoppingCart">Shopping cart</label>
        </div>
        <br>
        <div>
            <table id = "cartTable">
                <tr>
                    <th>ArticleID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Remove from cart</th>
                </tr>
                @foreach($itemsInCart as $item)
                    <tr id="cart{{ $item->id }}">
                        <td> {{ $item->id }}</td>
                        <td> {{ $item->name }}</td>
                        <td> {{ $item->price }}</td>
                        <td class="button"><input type="button" value="-"
                                   onclick='shoppingCart({{ $item->id }},
                           "{{ $item->name }}",
                           {{ $item->price }},
                           "{{ $item->description }}",
                           "{{ $item->user->name }}",
                           "{{ $item->created_at }}",
                           "-")'>
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

    function shoppingCart(id, name, price, description, username, date, value) {
        const cartTable = document.getElementById("cartTable")
        const articlesTable = document.getElementById("articlesTable")

        let xhr = new XMLHttpRequest();

        if (value === "+") {

            xhr.open("POST", "/api/shoppingCart/" + id)
            xhr.setRequestHeader('Content-Type', 'application/json')

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4)
                    console.log(xhr.responseText)
            }
            xhr.send(JSON.stringify(userData))

            // find and remove the to-be-deleted article from article table
            document.getElementById("article" + id).remove()

            // create new row and data cell for name, price and remove button in cart table
            let newRow = document.createElement("tr")
            newRow.setAttribute("id", "cart" + id)

            // create data cell for new row in cart table
            let tdID = document.createElement("td")
            let tdName = document.createElement("td")
            let tdPrice = document.createElement("td")
            let tdRemove = document.createElement("td")
            tdRemove.setAttribute("class", "button")

            // create remove button in cart table
            let removeButton = document.createElement("input")
            removeButton.setAttribute("type", "button")
            removeButton.setAttribute("value", "-")
            removeButton.setAttribute("onclick", "shoppingCart("
                + id + ',"' + name.toString() + '",' + price + ',"' + description.toString() + '","' + username.toString() + '","' + date.toString() + '", "-")')

            // insert name, price and button into data cell in cart table
            tdID.appendChild(document.createTextNode(id))
            tdName.appendChild(document.createTextNode(name))
            tdPrice.appendChild(document.createTextNode(price))
            tdRemove.appendChild(removeButton)

            // complete creating new row for cart table
            newRow.appendChild(tdID)
            newRow.appendChild(tdName)
            newRow.appendChild(tdPrice)
            newRow.appendChild(tdRemove)

            cartTable.appendChild(newRow) // insert new row to cart table

        } else {

            xhr.open("DELETE", "/api/shoppingCart/" + id)
            xhr.setRequestHeader('Content-Type', 'application/json')

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4)
                    console.log(xhr.responseText)
            }
            xhr.send(JSON.stringify(userData))

            // find and remove to be deleted row  in cart table
            document.getElementById("cart" + id).remove()

            // create row to put back article table
            let rowBack2article = document.createElement("tr")
            rowBack2article.setAttribute("id", "article" + id)

            // create back data cells to put back to article table
            let id_ = document.createElement("td")
            let name_ = document.createElement("td")
            let price_ = document.createElement("td")
            let description_ = document.createElement("td")
            let username_ = document.createElement("td")
            let date_ = document.createElement("td")
            let add_ = document.createElement("td")
            add_.setAttribute("class", "button")


            // create add button in article table
            let addButton = document.createElement("input")
            addButton.setAttribute("type", "button")
            addButton.setAttribute("value", "+")
            addButton.setAttribute("onclick", "shoppingCart("
                + id + ',"' + name.toString() + '",' + price + ',"' + description.toString() + '","' + username.toString() + '","' + date.toString() + '", "+")')

            // insert article info to data cell
            id_.appendChild(document.createTextNode(id))
            name_.appendChild(document.createTextNode(name))
            price_.appendChild(document.createTextNode(price + "€"))
            description_.appendChild(document.createTextNode(description))
            username_.appendChild(document.createTextNode(username))
            date_.appendChild(document.createTextNode(date))
            add_.appendChild(addButton)

            // insert data cell to row
            rowBack2article.appendChild(id_)
            rowBack2article.appendChild(name_)
            rowBack2article.appendChild(price_)
            rowBack2article.appendChild(description_)
            rowBack2article.appendChild(username_)
            rowBack2article.appendChild(date_)
            rowBack2article.appendChild(add_)

            articlesTable.appendChild(rowBack2article) // put row back to article table

        }
    }

    const connection = new WebSocket("ws://localhost:8000/");

    connection.onmessage = function (e) {
        const msg = JSON.parse(e.data)
        if (userData["user"] === msg["username"])
            alert("Great! Your item "+ msg["name"] + " has been successfully sold!")
    }
    connection.onopen = function() {
        console.log("Connection established");
    };

    function quickBuy(id) {
        const xhr = new XMLHttpRequest()
        xhr.open("POST", "/api/article/" + id + "/sold", false)
        xhr.setRequestHeader('Content-Type', 'application/json')

        xhr.send({
            "articleID": id
        })
        const data = xhr.responseText
        console.log(data)
        connection.send(data)
    }




</script>

</body>
</html>
