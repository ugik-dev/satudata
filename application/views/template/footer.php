  </div>
  <footer class="footer">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12 footer-copyright text-center">
                  <p class="mb-0">Copyright 2022 © Dinas Kesehatan - Kabupaten Bangka</p>
              </div>
          </div>
      </div>
  </footer>
  </div>

  <script>
      $(document).ready(function() {
          $(".notif_click").on("click", function() {
              curData = $(this).data("id");
              console.log("redicrec" + curData);
              location.href = "<?= base_url() ?>notification/" + curData
          });
      });
  </script>

  <!-- <script src="<?= base_url() ?>assets/js/jquery-3.5.1.min.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/plugins/input-mask/jquery.mask.min.js"></script> -->

  <script src="<?= base_url() ?>assets/js/bootstrap/bootstrap.bundle.min.js"></script>
  <!-- feather icon js-->
  <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather.min.js"></script>
  <script src="<?= base_url() ?>assets/js/icons/feather-icon/feather-icon.js"></script>
  <!-- <script>
      feather.replace()
    </script> -->
  <!-- scrollbar js-->
  <script src="<?= base_url() ?>assets/js/scrollbar/simplebar.js"></script>
  <script src="<?= base_url() ?>assets/js/scrollbar/custom.js"></script>
  <!-- Sidebar jquery-->
  <script src="<?= base_url() ?>assets/js/config.js"></script>
  <!-- Plugins JS start-->
  <script src="<?= base_url() ?>assets/js/select2/select2.full.min.js"></script>
  <script src="<?= base_url() ?>assets/js/select2/select2-custom.js"></script>
  <script src="<?= base_url() ?>assets/js/sidebar-menu.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/chartist/chartist.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/knob/knob.min.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/knob/knob-chart.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/apex-chart/apex-chart.js"></script>
  <script src="<?= base_url() ?>assets/js/chart/apex-chart/stock-prices.js"></script>
  <script src="<?= base_url() ?>assets/js/notify/bootstrap-notify.min.js"></script>
  <script src="<?= base_url() ?>assets/js/notify/index.js"></script>
  <script src="<?= base_url() ?>assets/js/datepicker/date-picker/datepicker.js"></script>
  <script src="<?= base_url() ?>assets/js/datepicker/date-picker/datepicker.en.js"></script>
  <script src="<?= base_url() ?>assets/js/datepicker/date-picker/datepicker.custom.js"></script>
  <!-- <script src="<?= base_url() ?>assets/js/sweet-alert/sweetalert.min.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/js/chart-widget.js"></script> -->


  <!-- <script src="<?= base_url() ?>assets/js/typeahead/handlebars.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/js/typeahead/typeahead.bundle.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/js/typeahead/typeahead.custom.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/js/typeahead-search/handlebars.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/js/typeahead-search/typeahead-custom.js"></script> -->
  <script src="<?= base_url() ?>assets/js/tooltip-init.js"></script>
  <script src="<?= base_url() ?>assets/js/photoswipe/photoswipe.min.js"></script>
  <script src="<?= base_url() ?>assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
  <script src="<?= base_url() ?>assets/js/photoswipe/photoswipe.js"></script>
  <!-- Plugins JS Ends-->
  <!-- Theme js-->
  <script src="<?= base_url() ?>assets/js/script.js"></script>
  <script src="<?= base_url() ?>assets/js/theme-customizer/customizer.js?v=0.1"></script>
  <!-- login js-->
  <!-- Plugin used-->
  </body>

  </html>