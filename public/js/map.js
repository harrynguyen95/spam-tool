$(document).ready(function () {
    var nameEle = $('#name');
    var avatarEle = $('#avatar');
    var timeRemainingEle = $('#time-remaining');

    var initLatLng = [0, 0];
    var inscrease = 0;
    var zoom = 13;
    var marker = null;
   
    var map = L.map('map').setView(initLatLng, zoom);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    $('body').on('click', '#btn-get', function(e) {
        e.preventDefault();
        getLocation();
    })

    const getLocationInterval = setInterval(function () {
        getLocation();
    }, 10000); // 10 seconds

    getLocation();
    function getLocation() {
        const apiUrl = 'http://share-localtion-laravel.test/api/location'
        const data = {userId: 'user_id_xxx'}
        $.ajax({
            url: apiUrl,
            method: 'POST',
            data: data,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(res) {
                inscrease = inscrease + 0.001;

                nameEle.text(res.data.name)
                avatarEle.attr('src', res.data.avatar)
                const htmlIcon = '<div class="avatar-marker"><div><img src="' + res.data.avatar + '"/></div></div>';

                const position = res.data.position;
                const LatLng = [position.lat + inscrease, position.lng + inscrease];
                map.setView(LatLng, zoom);

                if (marker) {
                    marker.setLatLng(LatLng);
                } else {
                    marker = L.marker(LatLng, { icon: L.divIcon({ html: htmlIcon }) }).addTo(map);
                }

                const expiredAt = parseFloat(res.data.expired_at) * 1000; // unix time to js time
                const now = Date.now();
                if (now >= expiredAt) {
                    console.log('The shared location is expired now.')
                    clearInterval(getLocationInterval);
                } else {
                    const timeleft = expiredAt - now;

                    // convert milliseconds to seconds / minutes / hours etc.
                    const msPerSecond = 1000;
                    const msPerMinute = msPerSecond * 60;
                    const msPerHour = msPerMinute * 60;

                    // calculate remaining time
                    const hours = String(Math.floor((timeleft % (1000 * 60 * 60 * 24)) / msPerHour)).padStart(2, '0');
                    const minutes = String(Math.floor((timeleft % (1000 * 60 * 60)) / msPerMinute)).padStart(2, '0');
                    const seconds = String(Math.floor((timeleft % (1000 * 60)) / msPerSecond)).padStart(2, '0');

                    timeRemainingEle.text('Expired in ' + hours + ':' + minutes + ':' + seconds);
                }
            },
            error: function(err) {
                console.log('err: ', err)
            }
        });
    }

});
