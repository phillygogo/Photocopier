<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
    console.log(window.location.hash);
        if (window.location.hash == '#_=_') {
            window.location.hash = '';
        }
    </script>

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'open sans Light', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                margin: auto;

            }

            #photo-logo {
                height: 90px;
            }

            .position-ref {
                position: relative;
            }

            .photo-banner {
                margin-top: 40px;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 15px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .photo-banner > a {
                color: #636b6f;
            }

            .photo-title {
                color: #333;
                font-size: 40px;
                font-weight: 300;
                text-alight: center;
                line-height: 81px;
            }

            .photo-content {
                margin: auto;
                max-width: 978px;
            }

            .photo-body {
                margin-top: 70px;
            }

            .photo-nav {
                line-height: 35px;
            }

            .photo-footer {
                margin-top: 35px;
            }

            .container {
                margin: auto;
                max-width: 978px;
                text-align: center;
            }

            .container > p {
                max-width: 500px;
                margin: auto;
                text-align: center;
            }

            .container > img {
                margin-top: 35px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    <div class="photo-header" role="banner">
        <div class="row photo-content">
            <div class="logo col-md-2">
                <a href="/"><img id="photo-logo" src="{{ asset('images/banner_logo.png') }}" /></a>
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
                Select an ablum:
            </div>
            <p>
                Store this album where? choose on next screen
            </p>
            <div class="links">
            @foreach($PhotoAlbums as $album)
                <a href="/facebook/decision/{{ $album['id'] }}/{{ $album['name'] }}">{{ $album['name'] }}</a> <br>
            @endforeach
            </div>
        </div>
    </div>
    <!-- <div class="photo-footer border-top">

        <div class="flex-center position-ref full-height">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" />
            </div>
            <div class="content">
                <div class="title m-b-md">

                </div>
                <p>Which album do you want us to save?</p>

            </div>
        </div> -->
    </body>
</html>
