<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Share Location</title>
  <meta name="csrf-token" content="{{ Session::token() }}"> 

  <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

  <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/css/leaflet.css') }}">
  <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
</head>

<body class="antialiased">
  

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
              <a href="#">
                <img class="d-inline" width="830px" height="85px" src="{{ url('/images/ads.png') }}" />
              </a>
            </div>
          </div>
        </div>
      </div>

      <div class="content">
        <div class="container map" id="map">
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
                <img class="d-inline clock" width="16px" height="16px" src="{{ url('/images/clock.png') }}" />
                <span id="time-remaining">Expired in 00:00:00</span>
              </div>
              <p class="intro">Join share location to continue to see <span id="name"></span>’s real-time location</p>
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

  <script src="{{ url('/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('/js/jquery-3.7.1.min.js') }}"></script>

  <script src="{{ url('/js/leaflet.js') }}"></script>
  <script src="{{ url('/js/map.js') }}"></script>
</body>

</html>