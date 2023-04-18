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
                        <td><input type="button" value="+" onclick="shoppingCart({{ $result->id }})"></td>
                    </tr>
                @endforeach
            </table>
    <br>
</div>

<script>
    "use strict"
    function shoppingCart(id) {
        console.log(id)
        document.getElementsByName("")
       /* if (document.getElementById(id).getAttribute("value") === "+")
            document.getElementById(id).setAttribute("value", "-")
        else
            document.getElementById(id).setAttribute("value", "+")*/
        document.getElementById(id).remove()

    }
</script>

</body>
</html>
