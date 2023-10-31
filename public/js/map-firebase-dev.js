$(document).ready(function () {
  const host = window.location.origin;
  const apiUrl = 'https://share-location.merryblue.llc/sharinglocation/api/v0/public/live-tracking/' + sharingId
  const firebaseConfig = {
    apiKey: "AIzaSyDO6esatJ8i14whnx7jzdevf37N9X4bRes",
    authDomain: "location-sharing-abdc2.firebaseapp.com",
    projectId: "location-sharing-abdc2",
    storageBucket: "location-sharing-abdc2.appspot.com",
    messagingSenderId: "706387942723",
    appId: "1:706387942723:web:acaa81aabe6a57ab5ea3f6",
    measurementId: "G-HY33PGT11H"
  };
  const publicKey = 'BKP-3EWy-hmqgx35du99Er41ert3GwRaL_ZF2T_IoJnVJ6MoCeiGp6um2C-Qnnt9MI2S5Q5PXlqfT_cwkV0GCvc'
  const serverKey = 'AAAApHgAnUM:APA91bGtlcRkEPXTwhUpxEHbU6qyafHTcZoH_elqjsIIii9KNICsDvhX7nLFLb_rQaXhXLUCkUon5oKe8ELxGizFSoo5-ZlhelBEmJyLHX0-DsPLDRTuzxfUvPS9nD4A0F4Eg_xa_qtZ'

  const msPerSecond = 1000;
  const msPerMinute = msPerSecond * 60;
  const msPerHour = msPerMinute * 60;

  var nameEle = $("#name");
  var avatarEle = $("#avatar");
  var timeRemainingEle = $("#time-remaining");

  var initLatLng = [0, 0];
  var zoom = 14;
  var marker = null;
  var layer = null;
  var countdownInterval = null;
  var getLocationInterval = null;

  var map = L.map("map").setView(initLatLng, zoom);
  layer = L.tileLayer('https://tile.osm.ch/switzerland/{z}/{x}/{y}.png', {
    minZoom: 0,
    maxZoom: 19,
  });

  layer.addTo(map);
  map.on("zoomend", function () {
    zoom = map.getZoom();
  });

  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  } else {
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        messaging.getToken({ vapidKey: publicKey }).then((token) => {
          if (token) {
            // console.log('fcmToken: ', token)
            subscribeTokenToTopic(token, sharingId)
          } else {
            setApiCalling()
            console.log('No registration token available. Request permission to generate one.');
          }
        }).catch((err) => {
          setApiCalling()
          console.log('An error occurred while retrieving token. ', err);
        });
      }
    }).catch((err) => {
      setApiCalling()
      console.log('An error occurred Notification requestPermission. ', err);
    });
  }

  // deleteToken()

  // messaging.onMessage((payload) => {
  //   console.log('Message received: ', payload);

  //   const data = formatData(payload.data)
  //   updateUI(data);
  // });

  navigator.serviceWorker.addEventListener('message', function (event) {
    console.log('ServiceWorker listener: ', event);

    const data = formatData(event.data.data ?? (event.data ?? {}))
    updateUI(data);
  });

  $("body").on("click", "#btn-get", function (e) {
    e.preventDefault();
    getLocation();
  });

  getLocation();
  function getLocation() {
    $.ajax({
      url: apiUrl,
      method: "GET",
      dataType: "JSON",
      contentType: false,
      cache: false,
      processData: false,
      success: function (res) {
        // console.log("getLocation() api", res);
        updateUI(res.data)
      },
      error: function (err) {
        const error = err.responseJSON
        if (error.code == 400 || error.error == 'INVALID_INPUT' || error.error == 'DATA_NOT_FOUND') {
          console.log('Error 400', error)
          clearInterval(getLocationInterval);
          clearInterval(countdownInterval);
          timeRemainingEle.text("Expired!");
          // window.location.href =  host + '/404'
        }
        if (error.error == 'LIVE_TRACKING_TIMEOUT') {
          console.log("The shared location is expired now.");
          clearInterval(getLocationInterval);
          clearInterval(countdownInterval);
          timeRemainingEle.text("Expired!");
          // window.location.href =  host + '/404'
        }
      },
    });
  }

  function updateUI(data) {
    console.log('updateUI: ', data)

    nameEle.text(data.userName);
    avatarEle.attr("src", data.avatarImageId);
    
    const htmlIcon = getMarkerDiv(data);

    const position = data.latestPosition;
    const LatLng = [
      position.latitude,
      position.longitude,
    ];
    map.setView(LatLng, zoom);

    if (marker) {
      marker.setLatLng(LatLng).setIcon(L.divIcon({ html: htmlIcon }));
    } else {
      marker = L.marker(LatLng, {
        icon: L.divIcon({ html: htmlIcon }),
      }).addTo(map);
    }

    const now = Date.now();
    const expiredAt = parseFloat(parseFloat(data.startTime) + parseFloat(data.duration)) * 1000; // unix time to js time
    if (now >= expiredAt) {
      console.log("The shared location is expired now.");
      clearInterval(getLocationInterval);
      clearInterval(countdownInterval);
      timeRemainingEle.text("Expired!");
    } else {
      const timeleft = expiredAt - now; // miliseconds
      setExpiredIn(timeleft)
    }
  }

  function getMarkerDiv(data) {
    const now = Date.now();

    let htmlIcon = `<div class="mr-maker">`;


    const velocity = parseFloat(data.velocity ?? 0)

    const updatedTime = parseFloat(data.updatedTime) * 1000; // unix time to js time
    const updatedSince = now - updatedTime; // miliseconds

    const hours = Math.floor((updatedSince % (1000 * 60 * 60 * 24)) / msPerHour)
    const minutes =  Math.floor((updatedSince % (1000 * 60 * 60)) / msPerMinute)
    console.log('updatedSince: ', hours, minutes)

    if (velocity > 0) {
      htmlIcon += `<div class="vector">
        <img src="/images/vector.png" />
        <span>`+ velocity + `km/h</span>
      </div>`;
    } else {
      if (hours == 0) {
        if (minutes <= 2) { // now
          htmlIcon += `<div class="vector">
            <img src="/images/clock.png" />
            <span>Now</span>
          </div>`;
        } else if (2 < minutes <= 10) { // 10'

        } else if (10 < minutes <= 20) { // 20'

        } else if (20 < minutes <= 30) { // 30'

        } else if (30 < minutes <= 40) { // 40'

        } else if (40 < minutes <= 50) { // 50'

        } else {

        }
      } else {

      }
    }
    
    htmlIcon += `<div class="avatar-marker">
                    <div>
                        <img src="`+ data.avatarImageId + `"/>
                    </div>
                </div>`;
    if (data.batteryLevel && data.batteryLevel > 0) {
      if (data.batteryLevel >= 20) {
        htmlIcon += `<div class="battery">
                        <img src="/images/battery-green.png" />
                        <span>`+ data.batteryLevel + `%</span>
                    </div>`;
      } else {
        htmlIcon += `<div class="battery">
                        <img src="/images/battery-red.png" />
                        <span>`+ data.batteryLevel + `%</span>
                    </div>`;
      }
    }
    htmlIcon += `</div>`;
    return htmlIcon
  }

  function setExpiredIn(timeleft) {
    const hours = String(
      Math.floor(
        (timeleft % (1000 * 60 * 60 * 24)) / msPerHour
      )
    ).padStart(2, "0");
    const minutes = String(
      Math.floor((timeleft % (1000 * 60 * 60)) / msPerMinute)
    ).padStart(2, "0");
    const seconds = String(
      Math.floor((timeleft % (1000 * 60)) / msPerSecond)
    ).padStart(2, "0");

    clearInterval(countdownInterval);
    countdownExpiredIn(hours, minutes, seconds, timeRemainingEle)
  }

  function countdownExpiredIn(hr, mm, ss, element) {
    countdownInterval = setInterval(function () {
      if (hr == 0 && mm == 0 && ss == 0) clearInterval(countdownInterval);
      ss--;
      if (ss == 0) {
        ss = 59;
        mm--;
        if (mm == 0) {
          mm = 59;
          hr--;
        }
      }

      if (hr.toString().length < 2) hr = "0" + hr;
      if (mm.toString().length < 2) mm = "0" + mm;
      if (ss.toString().length < 2) ss = "0" + ss;
      element.html("Expired in " + hr + ":" + mm + ":" + ss);
    }, 1000)
  }

  function deleteToken() {
    // [START messaging_delete_token]
    messaging.deleteToken().then(() => {
      console.log('Token deleted.');
      // ...
    }).catch((err) => {
      console.log('Unable to delete token. ', err);
    });
    // [END messaging_delete_token]
  }

  function subscribeTokenToTopic(token, topic) {
    fetch(`https://iid.googleapis.com/iid/v1/${token}/rel/topics/${topic}`, {
      method: 'POST',
      headers: new Headers({
        Authorization: `key=${serverKey}`
      })
    })
      .then((response) => {
        if (response.status == 200) {
          // console.log(`"${topic}" is subscribed.`);
        } else {
          console.log(response.status, response);
        }
      })
      .catch((error) => {
        console.error(error.result);
      });
    return true;
  }

  function setApiCalling() {
    getLocationInterval = setInterval(function () {
      getLocation();
    }, 10000); // 10 seconds
  }

  function formatData(data) {
    return {
      ...data,
      ...{
        "latestPosition": {
          "latitude": data.latitude,
          "longitude": data.longitude,
          "updatedTime": data.updatedTime,
        },
      }
    }
  }

});
