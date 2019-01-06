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

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
                margin-top: 10%;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" />
            </div>
            <div class="content">
                <div class="title m-b-md">
                    Select an ablum:
                </div>
                <p>Which album do you want us to save?</p>
                <div class="links">
                @foreach($PhotoAlbums as $album)
                    <a href="/facebook/decision/{{ $album['id'] }}/{{ $album['name'] }}">{{ $album['name'] }}</a> <br>
                @endforeach
                </div>
            </div>
        </div>
    </body>
</html>
