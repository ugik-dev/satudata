<style>
  .img-profile {
    width: 50px !important;
    height: 50px !important;
  }

  .span-message {
    border-top-left-radius: 0px !important;
    border-bottom-left-radius: 20px !important;
    margin-bottom: 2px !important;
  }
</style>

<div class="container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h3>Dashboard</h3>
      </div>

      <div class="col-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg></a></li>
          <li class="breadcrumb-item">Sistem Informasi Administrasi dan Umum</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row second-chart-list third-news-update">
    <div class="col-xl-4 col-lg-12 xl-50 morning-sec box-col-12">
      <div class="card profile-greeting">
        <div class="card-body pb-0">
          <div class="media">
            <div class="media-body">
              <div class="greeting-user">
                <h4 class="f-w-600 font-primary" id="greeting">
                  Good Morning
                </h4>
                <!-- <p>Here whats happing in your account today</p> -->
                <div class="whatsnew-btn">
                  <a class="btn btn-primary">Whats New !</a>
                </div>
              </div>
            </div>
            <div class="badge-groups">
              <div class="badge f-10">
                <i class="me-1" data-feather="clock"></i><span id="txt"><?= date('H:i') ?></span>
              </div>
            </div>
          </div>
          <div class="cartoon">
            <img class="img-fluid" src="<?= base_url() ?>assets/images/dashboard/cartoon.png" alt="" />
          </div>
        </div>
      </div>
    </div>

    <!-- livechat -->
    <div class="col-xl-4 xl-50 chat-sec box-col-6">
      <div class="card chat-default">
        <div class="card-header card-no-border">
          <div class="media media-dashboard">
            <div class="media-body">
              <h5 class="mb-0">Live Chat</h5>
            </div>
            <div class="icon-box">
              <i data-feather="more-horizontal"></i>
            </div>
          </div>
        </div>
        <div class="card-body chat-box">
          <button class="btn-download btn btn-gradient f-w-400" id="load_more" style="width: 100% !important"><i class="fa fa-cloud-download"></i> Muat lebih banyak ..</button>
          <div class="chat" id="layout_live_chat">
          </div>
          <div class="input-group">
            <input class="form-control" id="text_live_chat" name="text_live_chat" type="text" placeholder="Tulis pesan disini..." name="text" />
            <div class="send-msg" id="send_live_chat"><i class="fa fa-send"></i></div>
          </div>
        </div>
      </div>
    </div>
    <!-- Aktifitas SPT -->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Kegiatan Hari Ini</h5>
          </div>
        </div>
        <div class="card-body">
          <table id="TableAktifitas" class="table ">
            <thead>
              <tr>
                <th>Tujuan</th>
                <th>Pelaksana</th>
                <th>Maksud</th>
                <th>Instansi</th>
                <th>Lihat</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>

      </div>
    </div>
    <!-- Info SPT -->
    <div class="col-xl-12 col-lg-12 xl-100 appointment box-col-12">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Monitoring SPT Puskesmas</h5>
            <div class="card-header-right-icon">
              <select name="tahun" id="tahun_spt">
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2021">2020</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="apache-cotainer-large" id="echart-bar2"></div>
        </div>
      </div>
    </div>

    <div class="col-xl-12 col-lg-12 xl-100 appointment box-col-12">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Monitoring SPT / SPPD</h5>
            <div class="card-header-right-icon">
              <select name="tahun" id="tahun_spt">
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2021">2020</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-Body">
          <div class="radar-chart">
            <div id="info_spt"></div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-xl-12 xl-100 appointment box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Monitoring Website Tahunan</h5>
            <div class="card-header-right-icon">
              <select name="tahun" id="tahun_monitor_website">
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
                <option value="2021">2020</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-Body">
          <div class="radar-chart">
            <div id="web_tahunan"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-xl-4 xl-50 appointment box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Graph Kehadiran</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Harian
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Tahun</a>
                  <a class="dropdown-item" href="#">Bulanan</a>
                  <a class="dropdown-item" href="#">Harian</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-Body">
          <div class="radar-chart">
            <div id="kehadiranchart"></div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- Monitor Web -->
    <div class="col-md-12 box-col-12">
      <div class="card o-hidden">
        <div class="card-header">
          <h5>Monitoring Website Puskesmas Bulanan</h5>
        </div>
        <div class="bar-chart-widget">
          <div class="bottom-content card-body">
            <div class="row">
              <div class="col-12">
                <div id="web_bulanan"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
      <div class="card earning-card">
        <div class="card-body p-0">
          <div class="row m-0">
            <div class="col-xl-3 earning-content p-0">
              <div class="row m-0 chart-left">
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>Dashboard</h5>
                  <p class="font-roboto">Overview of last month</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>$4055.56</h5>
                  <p class="font-roboto">This Month Earning</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>$1004.11</h5>
                  <p class="font-roboto">This Month Profit</p>
                </div>
                <div class="col-xl-12 p-0 left_side_earning">
                  <h5>90%</h5>
                  <p class="font-roboto">This Month Sale</p>
                </div>
                <div class="col-xl-12 p-0 left-btn">
                  <a class="btn btn-gradient">Summary</a>
                </div>
              </div>
            </div>
            <div class="col-xl-9 p-0">
              <div class="chart-right">
                <div class="row m-0 p-tb">
                  <div class="col-xl-8 col-md-8 col-sm-8 col-12 p-0">
                    <div class="inner-top-left">
                      <ul class="d-flex list-unstyled">
                        <li>Daily</li>
                        <li class="active">Weekly</li>
                        <li>Monthly</li>
                        <li>Yearly</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-xl-4 col-md-4 col-sm-4 col-12 p-0 justify-content-end">
                    <div class="inner-top-right">
                      <ul class="d-flex list-unstyled justify-content-end">
                        <li>Online</li>
                        <li>Store</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xl-12">
                    <div class="card-body p-0">
                      <div class="current-sale-container">
                        <div id="chart-currently"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row border-top m-0">
                <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
                  <div class="media p-0">
                    <div class="media-left">
                      <i class="icofont icofont-crown"></i>
                    </div>
                    <div class="media-body">
                      <h6>Referral Earning</h6>
                      <p>$5,000.20</p>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-6">
                  <div class="media p-0">
                    <div class="media-left bg-secondary">
                      <i class="icofont icofont-heart-alt"></i>
                    </div>
                    <div class="media-body">
                      <h6>Cash Balance</h6>
                      <p>$2,657.21</p>
                    </div>
                  </div>
                </div>
                <div class="col-xl-4 col-md-12 pe-0">
                  <div class="media p-0">
                    <div class="media-left">
                      <i class="icofont icofont-cur-dollar"></i>
                    </div>
                    <div class="media-body">
                      <h6>Sales forcasting</h6>
                      <p>$9,478.50</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <div class="col-xl-9 xl-100 chart_data_left box-col-12">
      <div class="card">
        <div class="card-body p-0">
          <div class="row m-0 chart-main">
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart flot-chart-container"></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>1001</h4>
                    <span>Jumlah Pegawai </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart1 flot-chart-container"></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>0</h4>
                    <span>Izin Hari ini</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart2 flot-chart-container"></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>0</h4>
                    <span>Pegawai yang DL</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
              <div class="media border-none align-items-center">
                <div class="hospital-small-chart">
                  <div class="small-bar">
                    <div class="small-chart3 flot-chart-container"></div>
                  </div>
                </div>
                <div class="media-body">
                  <div class="right-chart-content">
                    <h4>101</h4>
                    <span>Purchase ret</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 xl-50 chart_data_right box-col-12">
      <div class="card">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="media-body right-chart-content">
              <h4>96%<span class="new-box">Good</span></h4>
              <span>Persentase Kehadian</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 xl-50 chart_data_right second d-none">
      <div class="card">
        <div class="card-body">
          <div class="media align-items-center">
            <div class="media-body right-chart-content">
              <h4>23<span class="new-box">New</span></h4>
              <span>Jumlah Surat Tugas bulan ini</span>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-4 xl-50 news box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Berita Puskesmas</h5>
            <div class="card-header-right-icon">
              <!-- <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Today
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="card-body p-0" id="layout_berita_pkm">
        </div>
        <!-- <div class="card-footer">
          <div class="bottom-btn"><a href="#">Lihat Semua</a></div>
        </div> -->
      </div>
    </div>

    <div class="col-xl-4 xl-50 news box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">Pengumuman</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Today
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body p-0" id="layout_pengumuman">

        </div>
        <div class="card-footer">
          <div class="bottom-btn"><a href="#">Lihat Semua</a></div>
        </div>
      </div>
    </div>

    <!-- <div class="col-xl-4 xl-50 appointment-sec box-col-6">
      <div class="row">
        <div class="col-xl-12 appointment">
          <div class="card">
            <div class="card-header card-no-border">
              <div class="header-top">
                <h5 class="m-0">appointment</h5>
                <div class="card-header-right-icon">
                  <div class="dropdown">
                    <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Today
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body pt-0">
              <div class="appointment-table table-responsive">
                <table class="table table-bordernone">
                  <tbody>
                    <tr>
                      <td>
                        <img class="img-fluid img-40 rounded-circle mb-3" src="<?= base_url() ?>assets/images/appointment/app-ent.jpg" alt="Image description" />
                        <div class="status-circle bg-primary"></div>
                      </td>
                      <td class="img-content-box">
                        <span class="d-block">Venter Loren</span><span class="font-roboto">Now</span>
                      </td>
                      <td>
                        <p class="m-0 font-primary">28 Sept</p>
                      </td>
                      <td class="text-end">
                        <div class="button btn btn-primary">Done</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img class="img-fluid img-40 rounded-circle" src="<?= base_url() ?>assets/images/appointment/app-ent.jpg" alt="Image description" />
                        <div class="status-circle bg-primary"></div>
                      </td>
                      <td class="img-content-box">
                        <span class="d-block">John Loren</span><span class="font-roboto">11:00</span>
                      </td>
                      <td>
                        <p class="m-0 font-primary">22 Sept</p>
                      </td>
                      <td class="text-end">
                        <div class="button btn btn-warning">
                          Pending
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <div class="col-xl-12 alert-sec">
          <div class="card bg-img">
            <div class="card-header">
              <div class="header-top">
                <h5 class="m-0">Alert</h5>
                <div class="dot-right-icon">
                  <i data-feather="more-horizontal"></i>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="body-bottom">
                <h6>10% off For drama lights Couslations...</h6>
                <span class="font-roboto">Lorem Ipsum is simply dummy...It is a long
                  established fact that a reader will be distracted by
                </span>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div> -->
    <!-- <div class="col-xl-4 xl-50 notification box-col-6">
      <div class="card">
        <div class="card-header card-no-border">
          <div class="header-top">
            <h5 class="m-0">notification</h5>
            <div class="card-header-right-icon">
              <div class="dropdown">
                <button class="btn dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Today
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Today</a><a class="dropdown-item" href="#">Tomorrow</a><a class="dropdown-item" href="#">Yesterday </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-0">
          <div class="media">
            <div class="media-body">
              <p>20-04-2020 <span>10:10</span></p>
              <h6>
                Updated Product<span class="dot-notification"></span>
              </h6>
              <span>Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <p>
                20-04-2020<span class="ps-1">Today</span><span class="badge badge-secondary">New</span>
              </p>
              <h6>
                Tello just like your product<span class="dot-notification"></span>
              </h6>
              <span>Quisque a consequat ante sit amet magna... </span>
            </div>
          </div>
          <div class="media">
            <div class="media-body">
              <div class="d-flex mb-3">
                <div class="inner-img">
                  <img class="img-fluid" src="<?= base_url() ?>assets/images/notification/1.jpg" alt="Product-1" />
                </div>
                <div class="inner-img">
                  <img class="img-fluid" src="<?= base_url() ?>assets/images/notification/2.jpg" alt="Product-2" />
                </div>
              </div>
              <span class="mt-3">Quisque a consequat ante sit amet magna...</span>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <!-- chat -->

    <!-- Kalender Lama -->
    <!-- <div class="col-xl-4 col-lg-12 xl-50 calendar-sec box-col-6">
      <div class="card gradient-primary o-hidden">
        <div class="card-body">
          <div class="setting-dot">
            <div class="setting-bg-primary date-picker-setting pull-right">
              <div class="icon-box">
                <i data-feather="more-horizontal"></i>
              </div>
            </div>
          </div>
          <div class="default-datepicker">
            <div class="datepicker-here" data-language="en"></div>
          </div>
          <span class="default-dots-stay overview-dots full-width-dots"><span class="dots-group"><span class="dots dots1"></span><span class="dots dots2 dot-small"></span><span class="dots dots3 dot-small"></span><span class="dots dots4 dot-medium"></span><span class="dots dots5 dot-small"></span><span class="dots dots6 dot-small"></span><span class="dots dots7 dot-small-semi"></span><span class="dots dots8 dot-small-semi"></span><span class="dots dots9 dot-small"> </span></span></span>
        </div>
      </div>
    </div> -->
  </div>
</div>
<script src="<?= base_url() ?>assets/js/dashboard/default.js"></script>

<!-- Container-fluid Ends-->
<!-- </div> -->
<!-- footer start-->
<script>
  $(document).ready(function() {

    var tahun_monitor_website = $('#tahun_monitor_website');
    var layout_berita_pkm = $('#layout_berita_pkm');
    var layout_pengumuman = $('#layout_pengumuman');
    var layout_live_chat = $('#layout_live_chat');
    var send_live_chat = $('#send_live_chat');
    var text_live_chat = $('#text_live_chat');
    var load_more = $('#load_more');

    var info_spt = $('#info_spt');
    var TableAktifitas = $('#TableAktifitas').DataTable({
      // dom: 'Bfrtip',
      'columnDefs': [],
      // responsive: true,
      deferRender: true,
      "order": [
        [3, "asc"]
      ],

    });

    var primary = localStorage.getItem("primary") || "#7366ff";
    var secondary = localStorage.getItem("secondary") || "#f73164";

    function getKehadiran() {
      Swal.fire({
        title: 'Loading!',
        allowOutsideClick: false,
      });
      Swal.showLoading()
      return $.ajax({
        url: `<?php echo site_url('general/getAllKehadian/') ?>`,
        'type': 'get',
        // data: toolbar.form.serialize(),
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            return;
          }
          // dataSKP = json['data'];
          // renderSKP(dataSKP);
        },
        error: function(e) {}
      });
    }
    // renderKehadiran()

    function renderKehadiran() {
      var options1 = {
        chart: {
          height: 380,
          type: "radar",
          toolbar: {
            show: false,
          },
        },
        series: [{
          name: "Market value",
          data: [20, 100, 40, 30, 50, 80, 33],
        }, ],
        stroke: {
          width: 3,
          curve: "smooth",
        },
        labels: [
          "Sunday",
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday",
        ],
        plotOptions: {
          radar: {
            size: 140,
            polygons: {
              fill: {
                colors: ["#fcf8ff", "#f7eeff"],
              },
            },
          },
        },
        colors: [CubaAdminConfig.primary],
        markers: {
          size: 6,
          colors: ["#fff"],
          strokeColor: CubaAdminConfig.primary,
          strokeWidth: 3,
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val;
            },
          },
        },
        yaxis: {
          tickAmount: 7,
          labels: {
            formatter: function(val, i) {
              if (i % 2 === 0) {
                return val;
              } else {
                return "";
              }
            },
          },
        },
      };
      var chart1 = new ApexCharts(document.querySelector("#kehadiranchart"), options1);
      chart1.render();
    }

    var lastChat = 0;
    var lastChatUser = 0;
    var lastLoadMore = 0;
    var chartBulanan;
    var cartTahunan;
    var loadingLiveChat = false;
    var dataSPT = <?= json_encode($dataContent['infoSPTPKm']['data']) ?>;
    var dataAktifitas = <?= json_encode($dataContent['aktifitasharian']) ?>;
    renderSPT2(dataSPT)
    renderAktifitas(dataAktifitas)
    // getLiveChat(false)

    function getRealTimeLiveChat() {
      let timerId = setTimeout(function tick() {
        if (!loadingLiveChat) getLiveChat(true)
        timerId = setTimeout(tick, 5000); // (*)
      }, 5000);
    }
    setTimeout(
      getLiveChat(false), 10000);

    getPengumuman(false)
    getMonitorWebsite(false)
    getBeritaPkm(false)
    // getAktifitasHarian(false)
    getInfoSPT(false)
    getInfoSPTPkm(false)

    // toolbar.tahun.trigger('change');
    tahun_monitor_website.on('change', function() {
      getMonitorWebsite(true);
    })

    text_live_chat.on("keydown", function search(e) {
      // console.log(e.keyCode);
      if (e.keyCode == 13) {
        sending_livechat()
      }
    });


    send_live_chat.on('click', function(ev) {
      sending_livechat()

    })

    function sending_livechat() {
      cur_text = text_live_chat.val();
      text_live_chat.val('');
      return $.ajax({
        url: `<?php echo base_url('Dashboard/send_live_chat') ?>`,
        'type': 'get',
        data: {
          text: cur_text
        },
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");
            return;
          }
        },
        error: function(e) {}
      })
    }

    load_more.on('click', function(ev) {
      load_more.html('<i class="fa fa-spinner fa-spin"></i> Sedang memuat chat..')
      load_more.prop('disabled', true)
      return $.ajax({
        url: `<?php echo base_url('Dashboard/getLiveChat') ?>`,
        'type': 'get',
        data: {
          loadmore_id: lastLoadMore,
          limit: 5
        },
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");
            return;
          }
          dataChat = json['data'];
          renderLoadMoreLiveChat(dataChat)
          load_more.html('<i class="fa fa-cloud-download"></i> Muat lebih banyak..')
          load_more.prop('disabled', false)
        },
        error: function(e) {}
      });
    })

    function getLiveChat(update) {
      if (!loadingLiveChat) {
        loadingLiveChat = true;
        return $.ajax({
          url: `<?php echo base_url('Dashboard/getLiveChat') ?>`,
          'type': 'get',
          data: {
            last_id: lastChat,
            limit: 5
          },
          success: function(data) {
            var json = JSON.parse(data);
            if (json['error']) {
              loadingLiveChat = false;
              return;
            }
            dataChat = json['data'];
            renderLiveChat(dataChat, update)
            // if (!update) getRealTimeLiveChat()
            // loadingLiveChat = false;

          },
          error: function(e) {}
        });
      }

    }


    function renderLiveChat(data, update) {
      cur_id = '<?= $this->session->userdata('id') ?>';
      i = 0;
      Object.values(data).forEach((b) => {
        if (!update && i == 0) {
          lastLoadMore = b['id_chat'];
        }
        i++;
        time = b['time_chat'].substr(11, 5);
        if (b['id_user'] == cur_id) {
          html = `
        <div class="media right-side-chat">
              <p class="f-w-400">${time}</p>
              <div style="width: 70% !important" class="media-body text-end">
                <div class="message-main pull-right">
                  <span class="mb-0 text-start">${b['text']}</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            `;
        } else {
          if (lastChatUser == b['id_user']) {
            html = `<div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile" style="width: 50px !important" title="${b['nama']}">
                </div>
                <div style="width: 70% !important" class="main-chat">
                  <div class="sub-message message-main mt-0">
                    <span class="span-message">
                  ${b['text']}</span>
                  </div>
                </div>
              </div>
              <p class="f-w-400">${time}</p>
            </div>`;

          } else {
            photo_user = (b['photo_user'] == '' || b['photo_user'] == null ? 'default.jpg' : b['photo_user']);
            html = `<div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile" style="width: 50px !important" title="${b['nama']}">
                  <img class="img-fluid img-profile" style="width: 50px !important" src="<?= base_url() ?>uploads/foto_profil/${photo_user}" alt="Profile" />
                </div>
                <div style="width: 70% !important" class="main-chat">
                  <small> <b>${b['nama']}</b></small>
                  <div class="sub-message message-main mt-0">
                    <span class="span-message">
                  ${b['text']}</span>
                  </div>
                </div>
              </div>
              <p class="f-w-400">${time}</p>
            </div>`;

          }
        }
        lastChatUser = b['id_user']
        lastChat = b['id_chat'];
        console.log(lastChat);
        layout_live_chat.append(html)
      })
    }

    function renderLoadMoreLiveChat(data) {
      cur_id = '<?= $this->session->userdata('id') ?>';
      html = '';
      i = 0;
      tmp_id = 0;
      Object.values(data).forEach((b) => {
        if (i == 0)
          lastLoadMore = b['id_chat'];
        i++;
        time = b['time_chat'].substr(11, 5);
        if (b['id_user'] == cur_id) {
          html += `
             <div class="media right-side-chat">
              <p class="f-w-400">${time}</p>
              <div style="width: 70% !important" class="media-body text-end">
                <div class="message-main pull-right">
                  <span class="mb-0 text-start">${b['text']}</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            `;
        } else {
          if (tmp_id != b['id_user']) {

            photo_user = (b['photo_user'] == '' || b['photo_user'] == null ? 'default.jpg' : b['photo_user']);
            html += `<div class="media left-side-chat">
               <div class="media-body d-flex">
                <div class="img-profile" style="width: 50px !important" title="${b['nama']}">
                  <img class="img-fluid img-profile" style="width: 50px !important" src="<?= base_url() ?>uploads/foto_profil/${photo_user}" alt="Profile" />
                </div>
                <div style="width: 70% !important" class="main-chat">
                  <small> <b>${b['nama']}</b></small>
                  <div class="sub-message message-main mt-0">
                    <span class="span-message">
                  ${b['text']}</span>
                  </div>
                </div>
                </div>
                <p class="f-w-400">${time}</p>
                </div>`;
          } else
            html += `<div class="media left-side-chat">
               <div class="media-body d-flex">
                <div class="img-profile" style="width: 50px !important" title="${b['nama']}">
                </div>
                <div style="width: 70% !important" class="main-chat">
                  <div class="sub-message message-main mt-0">
                    <span class="span-message">
                  ${b['text']}</span>
                  </div>
                </div>
              </div>
              <p class="f-w-400">${time}</p>
            </div>`;
        }
        tmp_id = b['id_user'];
      })
      layout_live_chat.prepend(html)
    }

    function getPengumuman(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('informasi/getAllPengumuman') ?>`,
        'type': 'get',
        data: {},
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataPengumuman = json['data'];
          renderPengumuman(dataPengumuman)
        },
        error: function(e) {}
      });
    }

    function getInfoSPT(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('dashboard/getInfoSPT') ?>`,
        'type': 'get',
        data: {},
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataSPT = json['data'];
          renderSPT(dataSPT)
        },
        error: function(e) {}
      });
    }

    function getInfoSPTPkm(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('dashboard/getInfoSPTPkm') ?>`,
        'type': 'get',
        data: {},
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataSPT = json['data'];
          renderSPT2(dataSPT)
        },
        error: function(e) {}
      });
    }

    function getAktifitasHarian(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('dashboard/getAktifitasHarian') ?>`,
        'type': 'get',
        data: {},
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataSPT = json['data'];
          renderAktifitas(dataSPT)
        },
        error: function(e) {}
      });
    }

    function tgl_indo(tgl) {
      tgl2 = tgl.split(' ');
      ex_tgl = tgl2[0].split('-');
      var bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
      return ex_tgl[2] + ' ' + bulan[parseInt(ex_tgl[1])] + ' ' + ex_tgl[0]
    }

    function renderAktifitas(data) {
      if (data == null || typeof data != "object") {
        console.log("Sppd::UNKNOWN DATA");
        return;
      }
      var i = 0;
      var renderData = [];
      Object.values(data).forEach((d) => {
        lihatButton = `
                         <a class="btn btn-light" target="_blank" style="width: 110px" href='<?= base_url() ?>spt/detail/${d['id_spt']}'><i class='fa fa-eye'></i></a>
                 `;
        renderData.push([
          d['tujuan'],
          d['pelaksana'],
          d['maksud'],
          d['instansi'],
          lihatButton
        ]);
      });
      TableAktifitas.clear().rows.add(renderData).draw('full-hold');
    };

    function renderSPT(data) {
      var options1 = {
        chart: {
          height: 380,
          type: "radar",
          toolbar: {
            show: false,
          },
        },
        series: [{
          name: "Jumlah Postingan",
          data: data['jml'],
        }, ],
        stroke: {
          width: 3,
          curve: "smooth",
        },
        labels: data['nama'],
        plotOptions: {
          radar: {
            size: 140,
            polygons: {
              fill: {
                colors: ["#fcf8ff", "#f7eeff"],
              },
            },
          },
        },
        colors: [CubaAdminConfig.primary],
        markers: {
          size: 6,
          colors: ["#fff"],
          strokeColor: CubaAdminConfig.primary,
          strokeWidth: 3,
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val;
            },
          },
        },
        yaxis: {
          tickAmount: 7,
          labels: {
            formatter: function(val, i) {
              if (i % 2 === 0) {
                return val;
              } else {
                return "";
              }
            },
          },
        },
      };

      cartInfoSPT = new ApexCharts(document.querySelector("#info_spt"), options1);

      cartInfoSPT.render();

    }

    function renderSPT2(data) {
      var myChart = echarts.init(document.getElementById('echart-bar2'));
      myChart.setOption({
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "shadow",
          },
        },
        legend: {
          data: [
            "Total SPT",
            "Sudah Laporan",
            "Belum Laporan",
          ],
        },
        toolbox: {
          show: true,
          orient: "vertical",
          left: "right",
          top: "center",
          feature: {
            mark: {
              show: true
            },
            dataView: {
              show: true,
              readOnly: false
            },
            magicType: {
              show: true,
              type: ["bar", "stack"]
            },
            restore: {
              show: true
            },
            saveAsImage: {
              show: true
            },
          },
        },
        calculable: true,
        xAxis: [{
          type: "category",
          data: data['nama'],
        }, ],
        yAxis: [{
          type: "value",
        }, ],
        series: [{
            name: "Total SPT",
            type: "bar",
            // color: 'blue',
            // label: 'ss',
            data: data['total'],
          },
          {
            name: "Belum Laporan",
            type: "bar",
            color: 'red',
            stack: "advertising",
            data: data['belum'],
          },
          {
            name: "Sudah Laporan",
            type: "bar",
            // color: 'green',
            stack: "advertising",
            data: data['sudah'],
          },

        ],
      });

    }

    function getBeritaPkm(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('MonitoringWebsite/getAll') ?>`,
        'type': 'get',
        data: {
          limit: 3,
          tahun: tahun_monitor_website.val()
        },
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataBeritaPkm = json['data'];
          renderBeritaPKM(dataBeritaPkm)
          // if (update) {
          //   renderWebUpdate(dataWeb);
          // } else {
          //   renderWeb(dataWeb);
          //   renderWebTahunan(dataWeb);
          // }
        },
        error: function(e) {}
      });
    }

    function renderPengumuman(data) {
      Object.values(data).forEach((b) => {

        if (b['sampul']) {
          sampul = b['sampul'];
        } else {
          sampul = "default.jpg";
        }
        html = `
        <a href="<?= base_url('pengumuman/') ?>${b['id_pengumuman']}"> <div class="news-update media" >
            <img class="img-fluid me-3 b-r-10" width=100px src="<?= base_url('uploads/pengumuman_sampul/') ?>${sampul}" alt="" />
            <div class="media-body">
              <h6>${b['judul']}</h6>
              <span>${b['nama_satuan']} </span><span class="time-detail d-block"><i data-feather="clock"></i>${b['tanggal']}</span>
            </div>
          </div>
          </a>`;
        layout_pengumuman.append(html)
      })
    };

    function renderBeritaPKM(data) {
      Object.values(data).forEach((b) => {
        html = `
        <a href="http://${b['pkm']}.puskesmas.bangka.go.id/${b['tulisan_jenis'].toLowerCase()}/${b['tulisan_slug']}"> <div class="news-update media" >
            <img class="img-fluid me-3 b-r-10" width=100px src="http://${b['pkm']}.puskesmas.bangka.go.id/upload/images/${b['tulisan_gambar']}" alt="" />
            <div class="media-body">
              <h6>${b['tulisan_judul']}</h6>
              <span>${b['pkm']} </span><span class="time-detail d-block"><i data-feather="clock"></i>${b['tulisan_tanggal']}</span>
            </div>
          </div>
          </a>`;
        layout_berita_pkm.append(html)
      })
    };

    function getMonitorWebsite(update) {
      if (update) {
        Swal.fire({
          title: 'Loading!',
          allowOutsideClick: false,
        });
        Swal.showLoading()
      }
      return $.ajax({
        url: `<?php echo base_url('MonitoringWebsite/getStatistic') ?>`,
        'type': 'get',
        data: {
          tahun: tahun_monitor_website.val()
        },
        success: function(data) {
          Swal.close();
          var json = JSON.parse(data);
          if (json['error']) {
            Swal.fire("Error", json['message'], "error");

            return;
          }
          dataWeb = json['data'];
          if (update) {
            renderWebUpdate(dataWeb);
            renderWebTahunanUpdate(dataWeb);
          } else {
            renderWeb(dataWeb);
            renderWebTahunan(dataWeb);
          }
        },
        error: function(e) {}
      });
    }

    function renderWebTahunan(data) {
      var options1 = {
        chart: {
          height: 380,
          type: "radar",
          toolbar: {
            show: false,
          },
        },
        series: [{
          name: "Jumlah Postingan",
          data: data['data_tahunan']['data_pkm'],
        }, ],
        stroke: {
          width: 3,
          curve: "smooth",
        },
        labels: data['data_tahunan']['nama_pkm'],
        plotOptions: {
          radar: {
            size: 140,
            polygons: {
              fill: {
                colors: ["#fcf8ff", "#f7eeff"],
              },
            },
          },
        },
        colors: [CubaAdminConfig.primary],
        markers: {
          size: 6,
          colors: ["#fff"],
          strokeColor: CubaAdminConfig.primary,
          strokeWidth: 3,
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val;
            },
          },
        },
        yaxis: {
          tickAmount: 7,
          labels: {
            formatter: function(val, i) {
              if (i % 2 === 0) {
                return val;
              } else {
                return "";
              }
            },
          },
        },
      };

      cartTahunan = new ApexCharts(document.querySelector("#web_tahunan"), options1);

      cartTahunan.render();

    }

    function renderWebTahunanUpdate(data) {

      cartTahunan.updateOptions({
        series: [{
          data: data['data_tahunan']['data_pkm'],
        }, ],
        labels: data['data_tahunan']['nama_pkm'],
      });

    }

    function renderWeb(data) {
      new_bulan = [];
      ref_bulan = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
      Object.values(data['bulan']).forEach((b) => {
        new_bulan.push(ref_bulan[b - 1]);
      })
      newData = [];
      Object.values(data['data']).forEach((d) => {
        var newData2 = [];
        Object.values(d['data']).forEach((ds) => {
          newData2.push(ds);

        });

        newData.push({
          'name': d['name'],
          'data': newData2
        });
      })
      console.log(newData);
      console.log(data['data']);
      var optionscolumnchart = {
        series: newData,
        chart: {
          type: "bar",
          height: 380,
          toolbar: {
            show: false,
          },
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: "30%",
            endingShape: "rounded",
          },
        },
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 1,
          colors: ["transparent"],
          curve: "smooth",
          lineCap: "butt",
        },
        xaxis: {
          categories: new_bulan,
          floating: false,
          axisTicks: {
            show: false,
          },
          axisBorder: {
            color: "#C4C4C4",
          },
        },
        yaxis: {
          title: {
            text: "Dollars in thounand",
            style: {
              fontSize: "14px",
              fontFamily: "Roboto, sans-serif",
              fontWeight: 500,
            },
          },
        },
        colors: [CubaAdminConfig.secondary, "#51bb25", CubaAdminConfig.primary],
        fill: {
          type: "gradient",
          gradient: {
            shade: "light",
            type: "vertical",
            shadeIntensity: 0.1,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 0.9,
            stops: [0, 100],
          },
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val + " Postingan";
            },
          },
        },
      };

      chartBulanan = new ApexCharts(
        document.querySelector("#web_bulanan"),
        optionscolumnchart
      );
      chartBulanan.render();
    }

    function renderWebUpdate(data) {
      new_bulan = [];
      ref_bulan = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
      console.log(data['data']);
      Object.values(data['bulan']).forEach((b) => {
        new_bulan.push(ref_bulan[b - 1]);
      })
      var newData = [];
      Object.values(data['data']).forEach((d) => {
        var newData2 = [];
        Object.values(d['data']).forEach((ds) => {
          newData2.push(ds);

        });

        newData.push({
          'name': d['name'],
          'data': newData2
        });
      })
      console.log(newData);

      chartBulanan.updateOptions({
        series: newData,
        xaxis: {
          categories: new_bulan,
        },
      });
    }
  });
</script>

<!-- 
<script src="<?= base_url() ?>assets/js/chart/echart/pie-chart/facePrint.js"></script>
<script src="<?= base_url() ?>assets/js/chart/echart/pie-chart/testHelper.js"></script>
<script src="<?= base_url() ?>assets/js/chart/echart/pie-chart/custom-transition-texture.js"></script>
-->
<!--
  <script src="<?= base_url() ?>assets/js/chart/echart/data/symbols.js"></script> 
   <script src="<?= base_url() ?>assets/js/chart/echart/custom.js"></script>
   -->