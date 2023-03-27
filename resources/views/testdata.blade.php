<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test data</title>
</head>
<body>
    @foreach($products as $product)
        <div>
            {{ $product->id }} : {{ $product->ab_testname }}
        </div>
    @endforeach

</body>
</html>
