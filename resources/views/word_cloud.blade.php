<!DOCTYPE html>
<html>
<head>
    <title>Word Cloud</title>
    <link rel="stylesheet" type="text/css" href="{{asset('styles.css')}}">
</head>
<body>
<div class="container">
    <h1>Word Cloud</h1>
    <div class="word-cloud">
        @foreach($words as $word)
            <span style="font-size: {{ $word['doc_count'] }}px">{{ $word['key'] }}</span>
        @endforeach
    </div>
</div>
</body>
</html>
