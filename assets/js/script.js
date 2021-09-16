const defaultLocation = [32.3475088, 53.7819863];
const defaultZoom = 6;
var map = L.map('map').setView(defaultLocation, defaultZoom);

$("#satellite").click(function () {
    googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 18,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);
});


L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'My github account: <a href="https://github.com/masoudharooni" target="_blank">Click Here</a>',
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1
}).addTo(map);



$("#defaultMap").click(function () {
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'My github account: <a href="https://github.com/masoudharooni" target="_blank">Click Here</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(map);
});

var userLocation;

$("#filterBtn").click(function () {
    $('#filterLocModal').fadeIn();
    function locate() {
        map.locate({ setView: false });
    }
    map.on('locationerror', function (e) {
        alert("لطفا فیلتر شکن خودرا روشن کنید");
    });
    var current_position, current_accuracy;
    map.on('locationfound', function (e) {
        if (current_position) {
            map.removeLayer(current_position);
            map.removeLayer(current_accuracy);
        }
        userLat = e.latlng.lat;
        userLng = e.latlng.lng;
    });
    setInterval(locate, 1);
    if (typeof userLat !== 'undefined' && typeof userLng !== 'undefined') {
        $('form#filterForm').attr({ datalat: userLat, datalng: userLng });
    } else {
        $('#filterLocModal').fadeOut(1);
    }
    // alert(userLat + "---" + userLng);
    // console.log();
});




$("#filterModalClose").click(function () {
    $("#filterLocModal").fadeOut(1000);
});

var icon = L.icon({
    iconUrl: 'assets/img/marker-icon.png',
    iconSize: [30, 50],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
    shadowSize: [68, 95],
    shadowAnchor: [22, 94]
});

// L.marker(defaultLocation, { icon: icon }).addTo(map).bindPopup("<b>میدان نقش جهان</b>");

// bounds line for window
var northLine = map.getBounds().getNorth();
var southLine = map.getBounds().getSouth();
var westLine = map.getBounds().getWest();
var eastLine = map.getBounds().getEast();
var center = map.getBounds().getCenter();





$("#userLoc").click(function () {
    function locate() {
        map.locate({ setView: true, maxZoom: 18 });
    }
    map.on('locationerror', function (e) {
        alert("لطفا فیلتر شکن خودرا روشن کنید");
    });
    var current_position, current_accuracy;
    map.on('locationfound', function (e) {
        if (current_position) {
            map.removeLayer(current_position);
            map.removeLayer(current_accuracy);
        }
        var radius = e.accuracy;
        current_position = L.marker(e.latlng).addTo(map).bindPopup('مکان تقریبی شما با اختلاف : ' + radius + " متر.").openPopup();
        current_accuracy = L.circle(e.latlng, radius).addTo(map);
    });
    setTimeout(locate, 10);
});



map.on('dblclick', function (event) {
    var lat = event.latlng.lat;
    var lng = event.latlng.lng;
    $(document).ready(function () {
        $("#registerLoc").fadeIn(1000);
        $("#lat-display").attr({ value: lat });
        // $("#lat-display").attr('disabled');
        $("#lng-display").attr({ value: lng });
        // $("#lng-display").attr('disabled');
        $(".modalClose").click(function () {
            $("#registerLoc").fadeOut(1000);
        });
    });
    L.marker([lat, lng]).addTo(map);
});


$(document).ready(function () {
    $('form#filterForm').submit(function (e) {
        e.preventDefault();
        var form = $(this);
        // alert(userLocation);
        $.ajax({
            method: "post",
            url: form.attr('action'),
            data: {
                action: 'filterLocation',
                userLat: form.attr('datalat'),
                userLng: form.attr('datalng'),
                value: form.serialize()
            },
            success: function (response) {
                $('div.resultFilterLoc').html(response);
                console.log(response);
            }
        });
    });
});