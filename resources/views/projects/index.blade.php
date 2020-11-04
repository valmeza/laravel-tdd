<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Birdboard</title>
</head>
<body>
    <h1>Birdboard</h1>

    @forelse ($projects as $item)
        <li>
            <a href="{{$item->path()}}">{{$item->title}}</a>
        </li> 

     @empty
    
         <li>No Projects Yet</li>

    @endforelse

</body>
</html>