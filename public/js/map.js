$(document).ready(function () {
    const host = window.location.origin;
    const apiUrl = 'https://share-location.merryblue.llc/sharinglocation/api/v0/public/live-tracking/' + userId

    var nameEle = $("#name");
    var avatarEle = $("#avatar");
    var timeRemainingEle = $("#time-remaining");

    var initLatLng = [0, 0];
    var zoom = 13;
    var marker = null;
    var layer = null;

    var map = L.map("map").setView(initLatLng, zoom);

    layer = L.tileLayer('https://tile.osm.ch/switzerland/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: 19,
    });

    layer.addTo(map);
    map.on("zoomend", function () {
        zoom = map.getZoom();
    });

    $("body").on("click", "#btn-get", function (e) {
        e.preventDefault();
        getLocation();
    });

    const getLocationInterval = setInterval(function () {
        getLocation();
    }, 60000); // 60 seconds

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
                // console.log("getLocation() success", res);

                nameEle.text(res.data.userName);
                avatarEle.attr("src", res.data.avatarImageId);
                let htmlIcon = `<div class="mr-maker">`;
                if (res.data.velocity && res.data.velocity > 0) {
                    htmlIcon += `<div class="vector">
                        <img src="/images/vector.png" />
                        <span>`+ res.data.velocity +`km/h</span>
                    </div>`;
                }
                htmlIcon += `<div class="avatar-marker">
                    <div>
                        <img src="`+ res.data.avatarImageId +`"/>
                    </div>
                </div>`;
                if (res.data.batteryLevel && res.data.batteryLevel > 0) {
                    if (res.data.batteryLevel >= 20) {
                        htmlIcon += `<div class="battery">
                            <img src="/images/battery-green.png" />
                            <span>`+ res.data.batteryLevel +`%</span>
                        </div>`;
                    } else {
                        htmlIcon += `<div class="battery">
                            <img src="/images/battery-red.png" />
                            <span>`+ res.data.batteryLevel +`%</span>
                        </div>`;
                    }
                }
                htmlIcon += `</div>`;

                const position = res.data.latestPosition;
                const LatLng = [
                    position.latitude,
                    position.longitude,
                ];
                map.setView(LatLng, zoom);

                if (marker) {
                    marker.setLatLng(LatLng);
                } else {
                    marker = L.marker(LatLng, {
                        icon: L.divIcon({ html: htmlIcon }),
                    }).addTo(map);
                }

                const now = Date.now();
                const expiredAt = parseFloat(res.data.startTime + res.data.duration) * 1000; // unix time to js time
                if (now >= expiredAt) {
                    console.log("The shared location is expired now.");
                    clearInterval(getLocationInterval);
                    timeRemainingEle.text("Expired!");
                } else {
                    const timeleft = expiredAt - now;

                    // convert milliseconds to seconds / minutes / hours etc.
                    const msPerSecond = 1000;
                    const msPerMinute = msPerSecond * 60;
                    const msPerHour = msPerMinute * 60;

                    // calculate remaining time
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

                    timeRemainingEle.text(
                        "Expired in " + hours + ":" + minutes + ":" + seconds
                    );
                }
            },
            error: function (err) {
                const error = err.responseJSON
                if (error.code == 400 || error.error == 'INVALID_INPUT' || error.error == 'DATA_NOT_FOUND' ) {
                    console.log('error 400', error)
                    // window.location.href =  host + '/404'
                }

                if (error.error == 'LIVE_TRACKING_TIMEOUT' ) {
                    console.log("The shared location is expired now.");
                    clearInterval(getLocationInterval);
                    timeRemainingEle.text("Expired!");
                    // window.location.href =  host + '/404'
                }
            },
        });
    }
});
