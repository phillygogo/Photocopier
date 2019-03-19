<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script type="text/javascript">
            if (window.location.hash == '#_=_' || window.location.hash == '#') {
                window.location.hash = '';
            }
        </script>

        <title>Photocopier</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="logo">
            <a href="/"><img id="photo-logo" src="{{ asset('images/banner_logo.png') }}" /></a>
            </div>
            <div class="content">
                <div class="title m-b-md">
                    Photocopy into which location?
                </div>
                <p>Pick a place for us to save your photos</p>
                <div class="links">
                    @foreach ($decisions as $key => $value)
                        @if ($decided == $key)
                            <i class="fas fa-check-circle"></i><a id="{{$key}}" href="/facebook/savePhotos/{{$key}}">{{$value}}</a>
                        @else
                            <a id="{{$key}}" href="/facebook/savePhotos/{{$key}}">{{$value}}</a>
                        @endif
                    @endforeach
                    <a href="" style="font-weight:100;">One Drive</a>
                    <a href="" style="font-weight:100;">Dropbox</a>

                </div>
            </div>
        </div>
    </body>
</html>
