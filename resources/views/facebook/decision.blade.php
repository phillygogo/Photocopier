<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Photocopier</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
    <div class="photo-header" role="banner">
        <div class="row photo-content">
            <div class="logo col-md-2">
            <a href="/"><img id="photo-logo" src="{{ asset('images/logo.png') }}" /></a>
            </div>
            <div class="col-md-2 offset-md-8 text-right photo-banner"><a href="/">About us</a></div>
        </div>
    </div>
    </div>
        <div class="photo-nav position-ref border-top border-bottom">
        <div class="row photo-content">
            <div class="links">
                <a href="/facebook/getAlbums">Facebook</a>
                <a href="/" style="color:#636b6f36;">Instagram</a>
                <a href="/" style="color:#636b6f36;">Dropbox</a>
                <a href="/" style="color:#636b6f36;">Google Drive</a>
                <a href="/" style=color:#636b6f36;">One Drive</a>
            </div>
        </div>
    </div>
    <div class="photo-body">
        <div class="container">
            <div class="photo-title">
                Photocopy into which location?
            </div>
            <div class="links">
                @foreach ($decisions as $key => $value)
                    <a id="{{$key}}" href="/facebook/savePhotos/{{$key}}">{{$value}}</a>
                @endforeach
                <a href="" style="color:#636b6f36;">One Drive</a>
                <a href="" style="color:#636b6f36;">Dropbox</a>
            </div>
        </div>
    </div>
    </body>
</html>
