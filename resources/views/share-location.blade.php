<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Share Location</title>
    <meta name="csrf-token" content="{{ Session::token() }}">

    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
</head>

<body class="share-location">
    <main class="main">

        <div class="header">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="logo-wrapper">
                        <div class="logo-img">
                            <img class="d-inline" width="30px" height="35px" src="{{ url('/images/logo.png') }}" />
                        </div>
                        <div class="site-title">
                            <p>Share location</p>
                        </div>
                    </div>
                    <div class="ads-area">
                        <a class="d-pc" href="#">
                            <img class="d-inline" width="830px" height="85px" src="{{ url('/images/ads.png') }}" />
                        </a>
                        <div class="d-mb avatar-mb">
                            <a href="#">
                                <div class="img-mb" style="background-image: url('{{ url('/images/ads.png') }}')"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mr-maker">
            <div class="vector">
                <img src="/images/vector.png" />
                <span>30km/h</span>
            </div>
            <div class="avatar-marker">
                <div>
                    <img src="https://lh3.googleusercontent.com/a/ACg8ocLLnhUp3Ns-5em4ymK-tqYC8Ag3MZI6glTApRY0Hx3L0WE=s96-c"/>
                </div>
            </div>
            <div class="vector">
                <img src="/images/battery-green.png" />
                <span>80%</span>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid map" id="map">
            </div>
        </div>

        <div class="container">
            <div class="footer">
                <div class="infor d-flex">
                    <div class="avt">
                        <img id="avatar" width="40px" height="40px" src="{{ url('/images/avt.png') }}" />
                    </div>
                    <div class="expires-time">
                        <div class="time">
                            <img class="d-inline clock" width="16px" height="16px"
                                src="{{ url('/images/clock.png') }}" />
                            <span id="time-remaining"></span>
                        </div>
                        <p class="intro">Join share location to continue to see <b id="name"></b>’s
                            real-time location</p>
                    </div>
                </div>
                <a href="#" class="btn btn-primary btn-download">
                    <img class="d-inline" width="24px" height="24px" src="{{ url('/images/download.png') }}" />
                    <span>Get the app on Google play</span>
                </a>
                <button class="btn btn-outline-dark" id="btn-get">Get</button>
            </div>
        </div>

    </main>

    <script type="text/javascript">
        const userId = @json(request()->get('key'));
    </script>

    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/jquery-3.7.1.min.js') }}"></script>

    <script src="{{ url('/js/leaflet.js') }}"></script>
    <script src="{{ url('/js/map.js') }}"></script>
</body>

</html>
