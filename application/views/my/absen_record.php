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
                    <div class="col-lg-6">
                        <button class="btn btn-primary" id="scan_btn"><i class="fa fa-map-marker"></i> Scan</button>
                        <input id="form_long" name="long">
                        <input id="form_lat" name="lat">
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
                    <div id="demo"></div>
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
    var x = document.getElementById("demo");
    var xx = document.getElementById("log");

    var form_long = $('#form_long')
    var form_lat = $('#form_lat')
    var scan_btn = $('#scan_btn')
    var st_marker = false;
    var i = 0;

    var map = L.map('map').setView([-1.893218, 106.103813], 8);
    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 27,
    }).addTo(map);
    scan_btn.on('click', function() {
        getLocation();
    })
    var circle = L.circle([-1.893218, 106.103813], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 50
    }).addTo(map);

    function getLocation() {

        if (navigator.geolocation) {
            x.innerHTML = "Geolocation is suport.";
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }

    function showPosition(position) {
        if (st_marker) {
            // i = i + 1
            // console.log(marker);
            map.removeLayer(marker)
            // map.removeLayer(marker[0])
        }

        form_lat.val(position.coords.latitude);
        form_long.val(position.coords.longitude);
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude +
            "<br>ss: " + position.coords.latitude + ', ' + position.coords.longitude;
        st_marker = true;

        // var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
        // var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 27,
        // }).addTo(map);



        marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        map.flyTo([position.coords.latitude, position.coords.longitude], 15)
        // dinkes loc
        // -1.893218, 106.103813

        // var polygon = L.polygon([
        //     [51.509, -0.08],
        //     [51.503, -0.06],
        //     [51.51, -0.047]
        // ]).addTo(map);
    }
</script>