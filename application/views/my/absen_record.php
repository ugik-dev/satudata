<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Saran Kerja Pegawai
                </h5>
            </div>
            <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-12">
                        <p>Waktu Sekarang : <span id="jam"></span> : <span id="menit"></span> : <span id="detik"></span>
                        </p>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-primary" id="scan_btn"><i class="fa fa-map-marker"></i> Scan</button>
                        <input id="form_long" name="long">
                        <input id="form_lat" name="lat">
                        <input id="waktu_absen" name="waktu_absen">
                        <div id="info"></div>
                        <div id="log" style="width: 600px; height: 10px;"></div>
                        <div id="map" style="width: 100%; height: 400px;"></div>

                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <a class="btn btn-primary">

                            <label for="captureimage"><i class="fa fa-camera"></i>Ambil Gambar</label>
                        </a>
                        <input type="file" accept="image/*" capture="camera" id="captureimage" class="btn btn-info" caption style="display:none">
                        <!-- <div id="imagewrapper"> -->
                        <image id="showimage" preload="none" autoplay="autoplay" src="" width="100%" height="auto"></image>
                        <!-- </div> -->
                    </div>
                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
                    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js" integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s=" crossorigin=""></script>

                    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
                    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js" integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s=" crossorigin=""></script>
                    <div class="col-lg-6"> -->
                    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly" defer></script> -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan</strong></button>
            </div>
    </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#sidebar_wrapper_func').addClass('close_icon');
        $('#sidebar_skp').addClass('active_c');
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#showimage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#captureimage").change(function() {
        readURL(this);
    });
</script>


<script>
    swalLoading();
    // swal.close();
    var info = document.getElementById("info");
    var absen_time = false;
    var form_long = $('#form_long')
    var form_lat = $('#form_lat')
    var scan_btn = $('#scan_btn')
    var waktu_absen = $('#waktu_absen')
    var st_marker = false;
    var circle = [];
    var dataLocation = JSON.parse('<?= json_encode($dataContent['location']) ?>');

    // var waktu = new Date();
    window.setTimeout("waktu()", 1000);

    function waktu() {
        var waktu = new Date();
        setTimeout("waktu()", 1000);

        jam = waktu.getHours();
        menit = waktu.getMinutes();
        document.getElementById("jam").innerHTML = jam;
        document.getElementById("menit").innerHTML = menit;
        document.getElementById("detik").innerHTML = waktu.getSeconds();
        waktu_absen.val(jam + ':' + menit)
        // console.log(waktu.getMinutes());
        if (jam >= 6 && jam <= 11) {
            console.log('waktu pagi')

        }
        if (jam >= 15 && jam <= 18) {
            console.log('waktu sore')

        }
    }



    // }


    // console.log(dataLocation);
    var map = L.map('map').setView([-1.893218, 106.103813], 8);
    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 27,
    }).addTo(map);
    scan_btn.on('click', function() {
        getLocation();
    });

    renderLocation()

    function renderLocation() {
        i = 1;
        Object.values(dataLocation).forEach((l) => {
            // console.log(l)
            circle[i] = L.circle([l['lat_location'], l['long_location']], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50
            }).addTo(map);
            i++;

        })
    }

    function resetLocation(lat, long) {
        i = 1;
        Object.values(dataLocation).forEach((l) => {
            circle[i].setStyle({
                color: 'green',
                fillColor: '#bcf7c1'
            });
            distance = calcCrow(lat, long, l['lat_location'], l['long_location'])
            if (distance < 50) {
                circle[i].setStyle({
                    color: 'green',
                    fillColor: '#bcf7c1'
                });
            } else {
                circle[i].setStyle({
                    color: 'red',
                    fillColor: '#f03',
                });
            }
            i++;
        })
    }

    function calcCrow(lat1, lon1, lat2, lon2) {
        var R = 6371000; // km
        var dLat = toRad(lat2 - lat1);
        var dLon = toRad(lon2 - lon1);
        var lat1 = toRad(lat1);
        var lat2 = toRad(lat2);

        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.sin(dLon / 2) * Math.sin(dLon / 2) * Math.cos(lat1) * Math.cos(lat2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var d = R * c;
        console.log('jarak = ' + d);
        return d;
    }

    function toRad(Value) {
        return Value * Math.PI / 180;
    }


    function getLocation() {

        if (navigator.geolocation) {
            // info.innerHTML = "Geolocation is suport.";
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            info.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                info.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                info.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                info.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                info.innerHTML = "An unknown error occurred."
                break;
        }
    }

    function showPosition(position) {
        resetLocation(position.coords.latitude, position.coords.longitude)
        if (st_marker) {
            map.removeLayer(marker)
        }

        form_lat.val(position.coords.latitude);
        form_long.val(position.coords.longitude);
        // x.innerHTML = "Latitude: " + position.coords.latitude +
        //     "<br>Longitude: " + position.coords.longitude +
        //     "<br>ss: " + position.coords.latitude + ', ' + position.coords.longitude;
        st_marker = true;

        // var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
        // var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 27,
        // }).addTo(map);



        map.flyTo([position.coords.latitude, position.coords.longitude], 17)
        marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        // dinkes loc
        // -1.893218, 106.103813

        // var polygon = L.polygon([
        //     [51.509, -0.08],
        //     [51.503, -0.06],
        //     [51.51, -0.047]
        // ]).addTo(map);
    }
</script>