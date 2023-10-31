<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Share Location</title>
    <meta name="csrf-token" content="{{ Session::token() }}">

    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"> -->
    <link rel="stylesheet" href="{{ url('/css/fonts.css') }}">

    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ url('/css/styles.css') . '?v=' . time() }}">
</head>

<body class="share-location">
    <main class="main">

        @include('header')
        
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
                <a href="https://play.google.com/store/apps/details?id=share.location.decide" class="btn btn-primary btn-download">
                    <img class="d-inline" width="24px" height="24px" src="{{ url('/images/download.png') }}" />
                    <span>Get the app on Google play</span>
                </a>
                <button class="btn btn-outline-dark" id="btn-get">Get</button>
            </div>
        </div>

    </main>

    <script type="text/javascript">
        const sharingId = @json(request()->get('key'));
    </script>

    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>

    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ url('/js/leaflet.js') }}"></script>

    <script src="{{ url('/js/map-firebase-dev.js') . '?v=' . time() }}"></script>
</body>

</html>
