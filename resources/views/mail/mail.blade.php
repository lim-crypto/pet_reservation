<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
</head>
<body>
<h1>{{$subject}}</h1>
<p>{{$details['title']}}</p>
<p>{{date('l F d, Y - g A', strtotime($details['date']))}}</p>
<p>{{$details['body']}}</p>
@if(isset($details['link']))
<a href="{{$details['link']}}">{{$details['link']}}</a>
@endif
</body>
</html>