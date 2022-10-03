<div class="container-fluid">
    <div class="card">
        <form id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">
                    Form Saran Kerja Pegawai
                </h5>
                <!-- <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
            <div class="modal-body">
                <div class="row">

                    <!-- <div class="hr-line-dashed"></div> -->
                    <!-- <div class="col-lg-6"> -->
                    <!-- <div class="col-form-label">Periode Penilaian</div> -->
                    <!-- </div> -->
                    <div id="log" style="width: 600px; height: 10px;"></div>
                    <div id="map" style="width: 600px; height: 10px;"></div>

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
</script>


<script>
    var x = document.getElementById("demo");
    var xx = document.getElementById("log");
    // window.navigator.geolocation
    //     .getCurrentPosition();

    // const successCallback = (position) => {
    //     console.log(position);
    //     xx.innerHTML = "G.";
    // };

    // const errorCallback = (error) => {
    //     console.log(error);
    //     xx.innerHTML = error;
    // };


    getLocation()

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
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude +
            "<br>ss: " + position.coords.latitude + ', ' + position.coords.longitude;

        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);

        var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

        var circle = L.circle([51.508, -0.11], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map);


        var polygon = L.polygon([
            [51.509, -0.08],
            [51.503, -0.06],
            [51.51, -0.047]
        ]).addTo(map);

    }
</script>