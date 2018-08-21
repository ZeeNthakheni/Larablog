<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name','LSAPP')}}</title>

   
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>
<body>
    @include('partials.nav')
    <Div class="container">
      @yield('content')  
    </Div>
    

    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>