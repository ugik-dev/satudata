<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <div class="card">
                <div class="card-header">
                    <form class="col-lg-12" id="toolbar_form" onsubmit="return false;">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label" for="tahun">Tahun</label>
                                <select class="form-control mr-2" name="tahun" id="tahun">
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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

            <div class="col-xl-6 xl-50 appointment box-col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="header-top">
                            <h5 class="m-0">Monitoring Website Tahunan</h5>
                            <div class="card-header-right-icon">

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
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#menu_6').addClass('active');
        var chartBulanan;
        var cartTahunan;

        var toolbar = {
            'form': $('#toolbar_form'),
            'id_ref': $('#toolbar_form').find('#id_ref'),
            'tahun': $('#toolbar_form').find('#tahun'),
            'layanan': $('#toolbar_form').find('#layanan'),
            'newBtn': $('#new_btn'),
        }
        toolbar.tahun.on('change', function() {
            getMonitorWebsite(true)
            // getAllUser();
        })
        getMonitorWebsite(false)

        // toolbar.tahun.trigger('change');

        function getMonitorWebsite(update) {
            Swal.fire({
                title: 'Loading!',
                allowOutsideClick: false,
            });
            Swal.showLoading()
            return $.ajax({
                url: `<?php echo base_url('MonitoringWebsite/getStatistic') ?>`,
                'type': 'get',
                data: toolbar.form.serialize(),
                success: function(data) {
                    Swal.close();
                    var json = JSON.parse(data);
                    if (json['error']) {
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