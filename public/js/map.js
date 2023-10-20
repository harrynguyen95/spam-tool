$(document).ready(function () {
    var nameEle = $("#name");
    var avatarEle = $("#avatar");
    var timeRemainingEle = $("#time-remaining");

    var initLatLng = [0, 0];
    var inscrease = 0;
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
        const host = window.location.href;
        const apiUrl = host + "api/location";
        const data = { userId: "user_id_xxx" };
        $.ajax({
            url: apiUrl,
            method: "POST",
            data: JSON.stringify(data),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                inscrease = inscrease + 0.001;

                nameEle.text(res.data.name);
                avatarEle.attr("src", res.data.avatar);
                const htmlIcon =
                    '<div class="avatar-marker"><div><img src="' +
                    res.data.avatar +
                    '"/></div></div>';

                const position = res.data.position;
                const LatLng = [
                    position.lat + inscrease,
                    position.lng + inscrease,
                ];
                console.log("getLocation() success", res);

                map.setView(LatLng, zoom);

                if (marker) {
                    marker.setLatLng(LatLng);
                } else {
                    marker = L.marker(LatLng, {
                        icon: L.divIcon({ html: htmlIcon }),
                    }).addTo(map);
                }

                const now = Date.now();
                const expiredAt = parseFloat(res.data.expired_at) * 1000; // unix time to js time
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
                console.log("err: ", err);
            },
        });
    }
});
