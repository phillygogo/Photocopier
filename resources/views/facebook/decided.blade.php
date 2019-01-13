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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
