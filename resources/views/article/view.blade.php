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
    <title></title>
</head>
<body>
    <div>
        <label for="articlesTable">Article list</label>
    </div>
    <br>

    <div>
        <table>
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
                <tr id="{{ $result->id }}">
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
                    <td><input type="button" id="input{{ $result->id }}" value="+" onclick="shoppingCart({{ $result->id }})"></td>
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
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Remove from cart</th>
            </tr>
           <tr id="cartTable">

           </tr>
        </table>
        <br>
    </div>

<script>
    "use strict"
   /* const table = document.createElement("table")
    const thName = document.createElement("th")
    const thPrice = document.createElement("th")
    const thRemove = document.createElement("th")
    thRemove.setAttribute("width", "30%")

    const tr = document.createElement("tr")

    const thNameText = document.createTextNode("Name")
    const thPriceText = document.createTextNode("Price")

    thName.appendChild(thNameText)
    thPrice.appendChild(thPriceText)

    table.appendChild(thName)
    table.appendChild(thPrice)
    table.appendChild(thRemove)
    table.appendChild("tr")*/

    function shoppingCart(id) {
       /* if (document.getElementById(id).getAttribute("value") === "+")
            document.getElementById(id).setAttribute("value", "-")
        else
            document.getElementById(id).setAttribute("value", "+")*/
        // document.getElementById(id).remove()

        let tdName = document.createElement("td")
        let tdPrice = document.createElement("td")
        let tdRemove = document.createElement("td")

        let removeInput = document.createElement("input")
        removeInput.setAttribute("type", "button")

        // get whole information about article
        let inputID = document.getElementById("input" + id)
        let article = document.getElementById(id)
        //get specific info of that article, e.g. name, price, id, ...
        console.log(article.getElementsByTagName("td").item(6))
        // console.log(inp.getAttribute("value"))

        if (inputID.getAttribute("value") === "+") {
            let tdNameText = article.getElementsByTagName("td").item(1)
            let tdPriceText = article.getElementsByTagName("td").item(2)

            tdName.appendChild(tdNameText)
            tdPrice.appendChild(tdPriceText)


        }

        // if (document.getElementById(id).getAttribute())
    }

    // document.body.appendChild(table)
</script>

</body>
</html>
