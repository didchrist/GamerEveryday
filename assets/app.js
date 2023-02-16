/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//date time picker
import "date-time-picker-component/dist/css/date-time-picker-component.min.css";
import { DateTimeRangePicker } from "date-time-picker-component/dist/js/date-time-picker-component.min";

//config date time picker
var date = new Date();

let it = {
  jan: "Janvier",
  feb: "Février",
  mar: "Mars",
  apr: "Avril",
  may: "Mai",
  jun: "Juin",
  jul: "Juillet",
  aug: "Août",
  sep: "Septembre",
  oct: "Octobre",
  nov: "Novembre",
  dec: "Décembre",
  jan_: "Janvier",
  feb_: "Février",
  mar_: "Mars",
  apr_: "Avril",
  may_: "Mai",
  jun_: "Juin",
  jul_: "Juillet",
  aug_: "Août",
  sep_: "Septembre",
  oct_: "Octobre",
  nov_: "Novembre",
  dec_: "Décembre",
  mon: "Lun",
  tue: "Mar",
  wed: "Mer",
  thu: "Jeu",
  fri: "Ven",
  sat: "Sam",
  sun: "Dim",
  mon_: "Lundi",
  tue_: "Mardi",
  wed_: "Mercredi",
  thu_: "Jeudi",
  fri_: "Vendredi",
  sat_: "Samedi",
  sun_: "Dimanche",
  done: "Valider",
};
new DateTimeRangePicker("start_date_time", "end_date_time", {
  l10n: it,
  first_date: new Date(),
  start_date: new Date(),
  end_date: date.setDate(date.getDate() + 1),
  last_date: new Date(2030, 0, 29, 14, 0),
  first_day_no: 1,
  round_to: 10,
  date_output: "full_ISO",
  styles: {
    active_background: "#e34c26",
    active_color: "#fff",
    inactive_background: "#0366d9",
    inactive_color: "#fff",
  },
});

new DateTimeRangePicker("start_date_time_2", "end_date_time_2", {
  l10n: it,
  first_date: new Date(),
  start_date: new Date(),
  end_date: date.setDate(date.getDate() + 1),
  last_date: new Date(2030, 0, 29, 14, 0),
  first_day_no: 1,
  round_to: 10,
  date_output: "full_ISO",
  styles: {
    active_background: "#e34c26",
    active_color: "#fff",
    inactive_background: "#0366d9",
    inactive_color: "#fff",
  },
});
