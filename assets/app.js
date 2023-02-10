/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import "date-time-picker-component/dist/css/date-time-picker-component.min.css";
import { DateTimeRangePicker } from "date-time-picker-component/dist/js/date-time-picker-component.min";

var date = new Date();

new DateTimeRangePicker("start_date_time", "end_date_time", {
  start_date: new Date(),
  end_date: date.setDate(date.getDate() + 1),
  last_date: new Date(2030, 0, 29, 14, 0),
  first_day_no: 1,
  round_to: 10,
  date_output: "timestamp",
  styles: {
    active_background: "#e34c26",
    active_color: "#fff",
    inactive_background: "#0366d9",
    inactive_color: "#fff",
  },
});

new DateTimeRangePicker("start_date_time_2", "end_date_time_2", {
  start_date: new Date(),
  end_date: date.setDate(date.getDate() + 1),
  last_date: new Date(2030, 0, 29, 14, 0),
  first_day_no: 1,
  round_to: 10,
  date_output: "timestamp",
  styles: {
    active_background: "#e34c26",
    active_color: "#fff",
    inactive_background: "#0366d9",
    inactive_color: "#fff",
  },
});
