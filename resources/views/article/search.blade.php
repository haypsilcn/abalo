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
    <title>Article Search</title>
</head>
<body>
{{--TODO: make it look better--}}
<div><a href="/article/create">Create new article</a> </div>
<br>
    <div>
        <label for="resultsearch">Search the article</label>
        <form>
            <div>
                <input type="search" id="resultsearch" name="search" size=30
                       @if(!empty($keyword))
                           value="{{ $keyword }}"
                       @else
                           placeholder="What are you looking for?"
                       @endif
                />
                <button>Search</button>
            </div>
        </form>
    </div>

    <br>
    <div>
        @if(!empty($keyword))
            @if(count($results) != 0)
                <table>
                    <caption>Result for "{{ $keyword }}"</caption>
                    <tr>
                        <th>ArticleID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Created at</th>
                    </tr>
                    @foreach($results as $result)
                        <tr>
                            <td> {{ $result->id }} </td>
                            <th>
                                {{--check if article.id exists in images array--}}
                                @if( array_key_exists( $result->id , $images) )
                                    <img src="{{url($images[$result->id])}}" width="100" height="100" alt="">
                                @else
                                    No image found
                                @endif
                            </th>
                            <td> {{ $result->name }} </td>
                            <td> {{ $result->price }}€</td>
                            <td> {{ $result->description }} </td>
                            <td> {{ $result->user->name }} </td>
                            <td> {{ $result->created_at }} </td>
                        </tr>
                    @endforeach
                </table>
            @else
                No "{{ $keyword }}" was found. Try another keyword.
            @endif
        @endif
    </div>

</body>
</html>

{{--@extends('layout')

@section('content')
    <div>
        <label for="resultsearch">Search the article</label>
        <form>
            <div>
                <input type="search" id="resultsearch" name="search" size=30
                       @if(!empty($keyword))
                           value="{{ $keyword }}"
                       @else
                           placeholder="What are you looking for?"
                    @endif
                />
                <button>Search</button>
            </div>
        </form>
    </div>

    <br>
    <div>
        @if(!empty($keyword))
            @if(count($results) != 0)
                <table>
                    <caption>Result for "{{ $keyword }}"</caption>
                    <tr>
                        <th>ArticleID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>User</th>
                        <th>Created at</th>
                    </tr>
                    @foreach($results as $result)
                        <tr>
                            <td> {{ $result->id }} </td>
                            <th>
                                --}}{{--check if article.id exists in images array--}}{{--
                                @if( array_key_exists( $result->id , $images) )
                                    <img src="{{url($images[$result->id])}}" width="100" height="100">
                                @else
                                    No image found
                                @endif
                            </th>
                            <td> {{ $result->name }} </td>
                            <td> {{ $result->price }}€</td>
                            <td> {{ $result->description }} </td>
                            <td> {{ $result->user->name }} </td>
                            <td> {{ $result->created_at }} </td>
                        </tr>
                    @endforeach
                </table>
            @else
                No "{{ $keyword }}" was found. Try another keyword.
            @endif
        @endif
    </div>
@endsection--}}
