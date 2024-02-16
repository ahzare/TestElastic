<!DOCTYPE html>
<html>
<head>
    <title>Data</title>
</head>
<body>
<div class="container">
    <h1>Data</h1>
    <ol>
        @foreach($list as $item)
            <li>{{ $item['text'] }}</li>
            <hr/>
        @endforeach
    </ol>
</div>
</body>
</html>
