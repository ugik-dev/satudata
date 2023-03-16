<!-- Container-fluid starts-->
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/vendors/calendar.css" /> -->
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
          <!-- <li class="breadcrumb-item active">Calender Basic</li> -->
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- <div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card box-shadow-title">
        <div class="card-header">
          <h5>Basic</h5>
        </div>
        <div class="d-flex event-calendar">
          <div id="lnb">
            <div class="lnb-new-schedule text-center">
              <button class="btn btn-primary" id="btn-new-schedule" type="button" data-bs-toggle="modal">
                New schedule
              </button>
            </div>
            <div class="lnb-calendars" id="lnb-calendars">
              <div>
                <div class="lnb-calendars-item">
                  <label>
                    <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked="" /><span></span><strong>View all</strong>
                  </label>
                </div>
              </div>
              <div class="lnb-calendars-d1" id="calendarList"></div>
            </div>
          </div>
          <div id="right">
            <div id="menu">
              <div class="dropdown d-inline">
                <button hidden class="btn btn-default btn-sm dropdown-toggle" id="dropdownMenu-calendarType" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="calendar-icon ic_view_month" id="calendarTypeIcon" style="margin-right: 4px"></i><span id="calendarTypeName">Dropdown</span><i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                </button>

              </div>
              <span id="menu-navi">
                <button class="btn btn-default btn-sm move-today" type="button" data-action="move-today">
                  Today
                </button>
                <button class="btn btn-default btn-sm move-day" type="button" data-action="move-prev">
                  <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button class="btn btn-default btn-sm move-day" type="button" data-action="move-next">
                  <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i></button></span><span class="render-range" id="renderRange"></span>
            </div>
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- <script src="<?= base_url() ?>assets/js/calendar/tui-code-snippet.min.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/tui-time-picker.min.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/tui-date-picker.min.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/chance.min.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/tui-calendar.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/calendars.js"></script>
<script src="<?= base_url() ?>assets/js/calendar/schedules.js"></script> -->
<!-- <script src="<?= base_url() ?>assets/js/calendar/app.js"></script> -->

<!-- <script src="<?= base_url() ?>assets/js/tooltip-init.js"></script> -->
<!-- <script>
  "use strict";

  /* eslint-disable */
  /* eslint-env jquery */
  /* global moment, tui, chance */
  /* global findCalendar, CalendarList, ScheduleList, generateSchedule */

  (function(window, Calendar) {
    var cal, resizeThrottled;
    var useCreationPopup = true;
    var useDetailPopup = true;
    var datePicker, selectedCalendar;

    cal = new Calendar("#calendar", {
      // options.month.visibleWeeksCount = 0;
      // viewName = "month";
      defaultView: "month",
      useCreationPopup: useCreationPopup,
      useDetailPopup: useDetailPopup,
      calendars: CalendarList,
      template: {
        milestone: function(model) {
          return (
            '<span class="calendar-font-icon ic-milestone-b"></span> <span style="background-color: ' +
            model.bgColor +
            '">' +
            model.title +
            "</span>"
          );
        },
        allday: function(schedule) {
          // console.log('calendarlist' + CalendarList);
          console.log('line 150')
          return getTimeTemplate(schedule, true);
        },
        time: function(schedule) {
          console.log('line 154')
          return getTimeTemplate(schedule, false);
        },
      },
    });

    // event handlers
    cal.on({
      clickMore: function(e) {
        console.log("clickMore", e);
      },
      clickSchedule: function(e) {
        console.log("clickSchedule", e);
      },
      clickDayname: function(date) {
        console.log("clickDayname", date);
      },
      beforeCreateSchedule: function(e) {
        console.log("beforeCreateSchedule", e);
        saveNewSchedule(e);
      },
      beforeUpdateSchedule: function(e) {
        var schedule = e.schedule;
        var changes = e.changes;

        console.log("beforeUpdateSchedule", e);

        if (changes && !changes.isAllDay && schedule.category === "allday") {
          changes.category = "time";
        }

        cal.updateSchedule(schedule.id, schedule.calendarId, changes);
        refreshScheduleVisibility();
      },
      beforeDeleteSchedule: function(e) {
        // console.log("beforeDeleteSchedule", e);
        cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
      },
      afterRenderSchedule: function(e) {
        var schedule = e.schedule;
        // var element = cal.getElement(schedule.id, schedule.calendarId);
        // console.log('afterRenderSchedule', element);
      },
      clickTimezonesCollapseBtn: function(timezonesCollapsed) {
        // console.log("timezonesCollapsed", timezonesCollapsed);

        if (timezonesCollapsed) {
          cal.setTheme({
            "week.daygridLeft.width": "77px",
            "week.timegridLeft.width": "77px",
          });
        } else {
          cal.setTheme({
            "week.daygridLeft.width": "60px",
            "week.timegridLeft.width": "60px",
          });
        }

        return true;
      },
    });

    /**
     * Get time template for time and all-day
     * @param {Schedule} schedule - schedule
     * @param {boolean} isAllDay - isAllDay or hasMultiDates
     * @returns {string}
     */
    function getTimeTemplate(schedule, isAllDay) {
      // console.log('ini schedule dari getTimeTemplate')
      // return;
      var html = [];
      var start = moment(schedule.start.toUTCString());
      // console.log(start)
      if (!isAllDay) {
        html.push("<strong> ini waktu" + start.format("HH:mm") + "</strong> ");
      }
      if (schedule.isPrivate) {
        html.push('<span class="calendar-font-icon ic-lock-b"></span>');
        html.push(" Private");
      } else {
        if (schedule.isReadOnly) {
          html.push('<span class="calendar-font-icon ic-readonly-b"></span>');
        } else if (schedule.recurrenceRule) {
          html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
        } else if (schedule.attendees.length) {
          html.push('<span class="calendar-font-icon ic-user-b"></span>');
        } else if (schedule.location) {
          html.push('<span class="calendar-font-icon ic-location-b"></span>');
        }
        html.push("Ini Judul");
      }
      // console.log(html.join(""))

      return html.join("");
    }

    /**
     * A listener for click the menu
     * @param {Event} e - click event
     */
    function onClickMenu(e) {
      var target = $(e.target).closest('a[role="menuitem"]')[0];
      var action = getDataAction(target);
      var options = cal.getOptions();
      var viewName = "";

      // console.log(target);
      // console.log(action);
      switch (action) {
        case "toggle-daily":
          viewName = "day";
          break;
        case "toggle-weekly":
          viewName = "week";
          break;
        case "toggle-monthly":
          options.month.visibleWeeksCount = 0;
          viewName = "month";
          break;
        case "toggle-weeks2":
          options.month.visibleWeeksCount = 2;
          viewName = "month";
          break;
        case "toggle-weeks3":
          options.month.visibleWeeksCount = 3;
          viewName = "month";
          break;
        case "toggle-narrow-weekend":
          options.month.narrowWeekend = !options.month.narrowWeekend;
          options.week.narrowWeekend = !options.week.narrowWeekend;
          viewName = cal.getViewName();

          target.querySelector("input").checked = options.month.narrowWeekend;
          break;

        case "toggle-start-day-1":
          options.month.startDayOfWeek = options.month.startDayOfWeek ? 0 : 1;
          options.week.startDayOfWeek = options.week.startDayOfWeek ? 0 : 1;
          viewName = cal.getViewName();

          target.querySelector("input").checked = options.month.startDayOfWeek;
          break;
        case "toggle-workweek":
          options.month.workweek = !options.month.workweek;
          options.week.workweek = !options.week.workweek;
          viewName = cal.getViewName();

          target.querySelector("input").checked = !options.month.workweek;
          break;
        default:
          break;
      }

      cal.setOptions(options, true);
      cal.changeView(viewName, true);

      setDropdownCalendarType();
      setRenderRangeText();
      setSchedules();
    }

    function onClickNavi(e) {
      var action = getDataAction(e.target);

      switch (action) {
        case "move-prev":
          cal.prev();
          break;
        case "move-next":
          cal.next();
          break;
        case "move-today":
          cal.today();
          break;
        default:
          return;
      }

      setRenderRangeText();
      setSchedules();
    }

    function onNewSchedule() {
      var title = $("#new-schedule-title").val();
      var location = $("#new-schedule-location").val();
      var isAllDay = document.getElementById("new-schedule-allday").checked;
      var start = datePicker.getStartDate();
      var end = datePicker.getEndDate();
      var calendar = selectedCalendar ? selectedCalendar : CalendarList[0];

      if (!title) {
        return;
      }

      cal.createSchedules([{
        id: String(chance.guid()),
        calendarId: calendar.id,
        title: "title",
        isAllDay: isAllDay,
        start: start,
        end: end,
        category: isAllDay ? "allday" : "time",
        dueDateClass: "",
        color: calendar.color,
        bgColor: calendar.bgColor,
        dragBgColor: calendar.bgColor,
        borderColor: calendar.borderColor,
        raw: {
          location: location,
        },
        state: "Busy",
      }, ]);

      $("#modal-new-schedule").modal("hide");
    }

    function onChangeNewScheduleCalendar(e) {
      var target = $(e.target).closest('a[role="menuitem"]')[0];
      var calendarId = getDataAction(target);
      changeNewScheduleCalendar(calendarId);
    }

    function changeNewScheduleCalendar(calendarId) {
      var calendarNameElement = document.getElementById("calendarName");
      var calendar = findCalendar(calendarId);
      var html = [];

      html.push(
        '<span class="calendar-bar" style="background-color: ' +
        calendar.bgColor +
        "; border-color:" +
        calendar.borderColor +
        ';"></span>'
      );
      html.push('<span class="calendar-name">' + calendar.name + "</span>");

      calendarNameElement.innerHTML = html.join("");

      selectedCalendar = calendar;
    }

    function createNewSchedule(event) {
      var start = event.start ? new Date(event.start.getTime()) : new Date();
      var end = event.end ?
        new Date(event.end.getTime()) :
        moment().add(1, "hours").toDate();

      if (useCreationPopup) {
        cal.openCreationPopup({
          start: start,
          end: end,
        });
      }
    }


    function onChangeCalendars(e) {
      var calendarId = e.target.value;
      var checked = e.target.checked;
      var viewAll = document.querySelector(".lnb-calendars-item input");
      var calendarElements = Array.prototype.slice.call(
        document.querySelectorAll("#calendarList input")
      );
      var allCheckedCalendars = true;

      if (calendarId === "all") {
        allCheckedCalendars = checked;

        calendarElements.forEach(function(input) {
          var span = input.parentNode;
          input.checked = checked;
          span.style.backgroundColor = checked ?
            span.style.borderColor :
            "transparent";
        });

        CalendarList.forEach(function(calendar) {
          calendar.checked = checked;
        });
      } else {
        findCalendar(calendarId).checked = checked;

        allCheckedCalendars = calendarElements.every(function(input) {
          return input.checked;
        });

        if (allCheckedCalendars) {
          viewAll.checked = true;
        } else {
          viewAll.checked = false;
        }
      }
      refreshScheduleVisibility();
    }

    function refreshScheduleVisibility() {
      var calendarElements = Array.prototype.slice.call(
        document.querySelectorAll("#calendarList input")
      );

      CalendarList.forEach(function(calendar) {
        cal.toggleSchedules(calendar.id, !calendar.checked, false);
      });

      cal.render(true);

      calendarElements.forEach(function(input) {
        var span = input.nextElementSibling;
        span.style.backgroundColor = input.checked ?
          span.style.borderColor :
          "transparent";
      });
    }

    function setDropdownCalendarType() {
      var calendarTypeName = document.getElementById("calendarTypeName");
      var calendarTypeIcon = document.getElementById("calendarTypeIcon");
      var options = cal.getOptions();
      var type = cal.getViewName();
      var iconClassName;

      if (type === "day") {
        type = "Daily";
        iconClassName = "calendar-icon ic_view_day";
      } else if (type === "week") {
        type = "Weekly";
        iconClassName = "calendar-icon ic_view_week";
      } else if (options.month.visibleWeeksCount === 2) {
        type = "2 weeks";
        iconClassName = "calendar-icon ic_view_week";
      } else if (options.month.visibleWeeksCount === 3) {
        type = "3 weeks";
        iconClassName = "calendar-icon ic_view_week";
      } else {
        type = "Monthly";
        iconClassName = "calendar-icon ic_view_month";
      }

      calendarTypeName.innerHTML = type;
      calendarTypeIcon.className = iconClassName;
    }

    function currentCalendarDate(format) {
      var currentDate = moment([
        cal.getDate().getFullYear(),
        cal.getDate().getMonth(),
        cal.getDate().getDate(),
      ]);

      return currentDate.format(format);
    }

    function setRenderRangeText() {
      var renderRange = document.getElementById("renderRange");
      var options = cal.getOptions();
      var viewName = cal.getViewName();

      var html = [];
      if (viewName === "day") {
        html.push(currentCalendarDate("YYYY.MM.DD"));
      } else if (
        viewName === "month" &&
        (!options.month.visibleWeeksCount || options.month.visibleWeeksCount > 4)
      ) {
        html.push(currentCalendarDate("YYYY.MM"));
      } else {
        html.push(moment(cal.getDateRangeStart().getTime()).format("YYYY.MM.DD"));
        html.push(" ~ ");
        html.push(moment(cal.getDateRangeEnd().getTime()).format(" MM.DD"));
      }
      renderRange.innerHTML = html.join("");
    }

    function setSchedules() {
      cal.clear();
      generateSchedule(
        cal.getViewName(),
        cal.getDateRangeStart(),
        cal.getDateRangeEnd()
      );

      cal.createSchedules(ScheduleList);

      refreshScheduleVisibility();
    }

    function setEventListener() {
      $("#menu-navi").on("click", onClickNavi);
      $('.dropdown-menu a[role="menuitem"]').on("click", onClickMenu);
      $("#lnb-calendars").on("change", onChangeCalendars);

      $("#btn-save-schedule").on("click", onNewSchedule);
      $("#btn-new-schedule").on("click", createNewSchedule);

      $("#dropdownMenu-calendars-list").on("click", onChangeNewScheduleCalendar);

      window.addEventListener("resize", resizeThrottled);
    }

    function getDataAction(target) {
      return target.dataset ?
        target.dataset.action :
        target.getAttribute("data-action");
    }

    resizeThrottled = tui.util.throttle(function() {
      cal.render();
    }, 50);

    window.cal = cal;

    setDropdownCalendarType();
    setRenderRangeText();
    setSchedules();
    setEventListener();
  })(window, tui.Calendar);

  // set calendars
  (function() {
    var calendarList = document.getElementById("calendarList");
    var html = [];
    CalendarList.forEach(function(calendar) {
      html.push(
        '<div class="lnb-calendars-item"><label>' +
        '<input type="checkbox" class="tui-full-calendar-checkbox-round" value="' +
        calendar.id +
        '" checked>' +
        '<span style="border-color: ' +
        calendar.borderColor +
        "; background-color: " +
        calendar.borderColor +
        ';"></span>' +
        "<span>" +
        calendar.name +
        "</span>" +
        "</label></div>"
      );
    });
    calendarList.innerHTML = html.join("\n");
  })();
</script> -->
<!-- Plugins JS Ends-->
<!-- Theme js-->
<!-- <script src="<?= base_url() ?>assets/js/script.js"></script> -->

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
                <p>Here whats happing in your account today</p>
                <div class="whatsnew-btn">
                  <a class="btn btn-primary">Whats New !</a>
                </div>
              </div>
            </div>
            <div class="badge-groups">
              <div class="badge f-10">
                <i class="me-1" data-feather="clock"></i><span id="txt"></span>
              </div>
            </div>
          </div>
          <div class="cartoon">
            <img class="img-fluid" src="<?= base_url() ?>assets/images/dashboard/cartoon.png" alt="" />
          </div>
        </div>
      </div>
    </div>
    <!-- Info SPT -->
    <div class="col-xl-6 xl-50 appointment box-col-6">
      <div class="card">
        <div class="card-header">
          <div class="header-top">
            <h5 class="m-0">SPT / SPT / Lembur</h5>
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
    <!-- Monitor Web -->

    <div class="col-xl-6 xl-50 appointment box-col-6">
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
        <div class="card-body p-0">
          <div class="news-update media">
            <img class="img-fluid me-3 b-r-10" src="<?= base_url() ?>assets/images/dashboard/update/1.jpg" alt="" />
            <div class="media-body">
              <h6>Pengikinian Data Diri</h6>
              <span>Seluruh Pegawai di harapkan melalukan update data diri pada menu profile..</span><span class="time-detail d-block"><i data-feather="clock"></i>10 Minutes Ago</span>
            </div>
          </div>
          <div class="news-update media">
            <img class="img-fluid me-3 b-r-10" src="<?= base_url() ?>assets/images/dashboard/update/2.jpg" alt="" />
            <div class="media-body">
              <h6>Manual Book</h6>
              <span>
                Petunjuk penggunaan aplikasi... </span><span class="time-detail d-block"><i data-feather="clock"></i>1 Hour Ago</span>
            </div>
          </div>
          <div class="news-update media">
            <img class="img-fluid me-3 b-r-10" src="<?= base_url() ?>assets/images/dashboard/update/3.jpg" alt="" />
            <div class="media-body">
              <h6>Jadwal Apel Februari 2023.</h6>
              <span>apalah...</span><span class="time-detail d-block"><i data-feather="clock"></i>8 Hours Ago</span>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="bottom-btn"><a href="#">Lihat Semua</a></div>
        </div>
      </div>
    </div>
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
          <div class="chat">
            <div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile">
                  <img class="img-fluid" src="<?= base_url() ?>assets/images/user.jpg" alt="Profile" />
                </div>
                <div class="main-chat">
                  <div class="message-main">
                    <span class="mb-0">Hi deo, Please send me link.</span>
                  </div>
                  <div class="sub-message message-main">
                    <span class="mb-0">Right Now</span>
                  </div>
                </div>
              </div>
              <p class="f-w-400">7:28 PM</p>
            </div>
            <div class="media right-side-chat">
              <p class="f-w-400">7:28 PM</p>
              <div class="media-body text-end">
                <div class="message-main pull-right">
                  <span class="mb-0 text-start">How can do for you</span>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <div class="media left-side-chat">
              <div class="media-body d-flex">
                <div class="img-profile">
                  <img class="img-fluid" src="<?= base_url() ?>assets/images/user.jpg" alt="Profile" />
                </div>
                <div class="main-chat">
                  <div class="sub-message message-main mt-0">
                    <span>It's argently</span>
                  </div>
                </div>
              </div>
              <p class="f-w-400">7:28 PM</p>
            </div>
            <div class="media right-side-chat">
              <div class="media-body text-end">
                <div class="message-main pull-right">
                  <span class="loader-span mb-0 text-start" id="wave"><span class="dot"></span><span class="dot"></span><span class="dot"></span></span>
                </div>
              </div>
            </div>
            <div class="input-group">
              <input class="form-control" id="mail" type="text" placeholder="Type Your Message..." name="text" />
              <div class="send-msg"><i data-feather="send"></i></div>
            </div>
          </div>
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
<!-- Container-fluid Ends-->
<!-- </div> -->
<!-- footer start-->
<script>
  $(document).ready(function() {

    var tahun_monitor_website = $('#tahun_monitor_website');
    var layout_berita_pkm = $('#layout_berita_pkm');
    var info_spt = $('#info_spt');

    var primary = localStorage.getItem("primary") || "#7366ff";
    var secondary = localStorage.getItem("secondary") || "#f73164";
    var options = {
      series: [{
          name: "Online",
          data: [6, 20, 15, 40, 18, 20, 18, 23, 18, 35, 30, 55, 0],
        },
        {
          name: "Store",
          data: [2, 22, 35, 32, 40, 25, 50, 38, 42, 28, 20, 45, 0],
        },
      ],
      chart: {
        height: 254,
        type: "area",
        toolbar: {
          show: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        curve: "smooth",
      },
      xaxis: {
        type: "category",
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        categories: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
          "Jan",
        ],
        labels: {
          low: 0,
          offsetX: 0,
          show: false,
        },
        axisBorder: {
          low: 0,
          offsetX: 0,
          show: false,
        },
      },
      markers: {
        strokeWidth: 3,
        colors: "#ffffff",
        strokeColors: ["#7366ff", "#f73164"],
        hover: {
          size: 6,
        },
      },
      yaxis: {
        low: 0,
        offsetX: 0,
        offsetY: 0,
        show: false,
        labels: {
          low: 0,
          offsetX: 0,
          show: false,
        },
        axisBorder: {
          low: 0,
          offsetX: 0,
          show: false,
        },
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0,
          bottom: -15,
          top: -40,
        },
      },
      colors: [primary, secondary],
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.5,
          stops: [0, 80, 100],
        },
      },
      legend: {
        show: false,
      },
      tooltip: {
        x: {
          format: "MM",
        },
      },
    };


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




    var chart1 = new ApexCharts(document.querySelector("#kehadiranchart"), options1);

    chart1.render();


    var chartBulanan;
    var cartTahunan;

    getMonitorWebsite(false)
    getBeritaPkm(false)
    getInfoSPT(false)

    // toolbar.tahun.trigger('change');
    tahun_monitor_website.on('change', function() {
      getMonitorWebsite(true);
    })

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

    function renderSPT(data) {
      console.log(data['jml']);
      console.log(data['nama']);
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