<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <meta charset="UTF-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <title></title>
</head>
<body>
<div>
    <label for="articlesTable">Article list</label>
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
            <th>Shopping Cart</th>
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
                <td><input type="button" value="+"
                           onclick='shoppingCart({{ $result->id }},
                           "{{ $result->name }}",
                           {{ $result->price }},
                           "{{ $result->description }}",
                           "{{ $result->user->name }}",
                           "{{ $result->created_at }}",
                           "+")'>
                </td>
            </tr>
        @endforeach
    </table>
    <br>
</div>

<div>
    <label for="shoppingCart">Shopping cart</label>
</div>
<br>
<div>
    <table id = cartTable>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th style="width: 20%"></th>
        </tr>
    </table>
    <br>
</div>

<script>
    "use strict"

    // get current logged-in user whenever open or refresh page
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/isloggedin", false)

    xhr.send()

    const userData = xhr.responseText
    console.log(userData)

    // create shopping cart record for that current logged-in user
    xhr.open("POST", "/api/shoppingCart", false)
    xhr.setRequestHeader('Content-Type', 'application/json')

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4)
            console.log(xhr.responseText)
    }
    xhr.send(userData)

    const shoppingCartStatus = xhr.status

    const cartTable = document.getElementById("cartTable")
    const articlesTable = document.getElementById("articlesTable")

    function shoppingCart(id, name, price, description, username, date, value) {

        if (value === "+") {

            if (shoppingCartStatus !== 201)
                alert("Please log in to add article to shopping cart.")
            else {
                xhr.open("POST", "/api/shoppingCart/" + id)
                xhr.setRequestHeader('Content-Type', 'application/json')

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4)
                        console.log(xhr.responseText)
                }
                xhr.send(userData)

                // find and remove the to-be-deleted article from article table
                document.getElementById("article" + id).remove()

                // create new row and data cell for name, price and remove button in cart table
                let newRow = document.createElement("tr")
                newRow.setAttribute("id", "cart" + id)

                // create data cell for new row in cart table
                let tdName = document.createElement("td")
                let tdPrice = document.createElement("td")
                let tdRemove = document.createElement("td")

                // create remove button in cart table
                let removeButton = document.createElement("input")
                removeButton.setAttribute("type", "button")
                removeButton.setAttribute("value", "-")
                removeButton.setAttribute("onclick", "shoppingCart("
                    + id + ',"' + name.toString() + '",' + price + ',"' + description.toString() + '","' + username.toString() + '","' + date.toString() + '", "-")')

                // insert name, price and button into data cell in cart table
                tdName.appendChild(document.createTextNode(name))
                tdPrice.appendChild(document.createTextNode(price))
                tdRemove.appendChild(removeButton)

                // complete creating new row for cart table
                newRow.appendChild(tdName)
                newRow.appendChild(tdPrice)
                newRow.appendChild(tdRemove)

                cartTable.appendChild(newRow) // insert new row to cart table
            }



        } else {

            xhr.open("DELETE", "/api/shoppingCart/" + id)
            xhr.setRequestHeader('Content-Type', 'application/json')

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4)
                    console.log(xhr.responseText)
            }
            xhr.send(userData)

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

</script>

</body>
</html>
