<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript">
            if (window.location.hash == '#_=_') {
                window.location.hash = '';
            }
        </script>
        <title>Photocopier</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'open sans', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                margin: auto;

            }
            row {

            }

            .container {
                margin-top: 120px;
            }

            /* .full-height {
                height: 100vh;
            } */

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .photo-content {
                margin: auto;
                max-width: 978px;
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

            .title {
                font-size: 84px;
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

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>

    <div class="photo-header" role="banner">
        <div class="row photo-content">
            <div class="logo col-md-2">
                <img id="photo-logo" src="{{ asset('images/banner_logo.png') }}" />
            </div>
            <div class="col-md-2 offset-md-8 text-right photo-banner"><a href="/">About us</a></div>
        </div>
    </div>
    </div>
        <div class="photo-nav position-ref full-height border-top border-bottom">
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
    <div class="container">
        <div class="text-center title">
            Welcome to Photocopier!
        </div>
        <p class="text-center"> Which one of the social media platforms would you like to photocopy from?
    </div>

    </body>
</html>
