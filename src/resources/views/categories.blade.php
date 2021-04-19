<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    </head>
    <body>
        <ul>
            @foreach ($categories as $category)
            <li> {{ $category->title }} </li>

            @if (count($category->childs))
                @include('includes.childs', ['childs' => $category->childs])
            @endif

            @endforeach
        </ul>

    </body>
</html>
