var selectGame = document.getElementById("availability_game");
selectGame.addEventListener("change", function () {
  var game = this.value;

  fetch(urlListGameAvailability, { method: "post", body: game })
    .then((response) => response.json())
    .then((data) => {
      function removeChild() {
        var listAvailability = document.getElementById("listAvailability");
        var child = listAvailability.firstElementChild;
        while (child) {
          listAvailability.removeChild(child);
          child = listAvailability.firstElementChild;
        }
      }
      if (Object.keys(data).length != 1) {
        removeChild();
        for (const availability of data) {
          element = document.createElement("div");
          element.setAttribute("class", "availability");
          var sousElementP = document.createElement("p");
          var sousElementButton = document.createElement("button");
          sousElementButton.setAttribute("class", "ajaxDeleteAvailability");
          var listAvailability = document.getElementById("listAvailability");
          sousElementP.innerHTML = availability.startDate + " => " + availability.endDate;
          sousElementButton.innerHTML = "x";
          listAvailability.appendChild(element);
          element.appendChild(sousElementP);
          element.appendChild(sousElementButton);
          sousElementButton.addEventListener("click", function (e) {
            e.preventDefault();
            var data = { startDate: availability.startDate, endDate: availability.endDate };
            var dataJson = JSON.stringify(data);
            fetch(urlDeleteAvailability, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
              .then((response) => response.text())
              .then((text) => {
                var reponse = document.getElementById("statusAjaxGlobal");
                reponse.innerHTML = text;
                element.remove();
              })
              .catch(function (error) {
                console.log("Erreur dans l'opération fetch :" + error.message);
              });
          });
        }
      } else if (Object.keys(data).length == 0) {
        removeChild();
      } else {
        removeChild();
        element = document.createElement("div");
        element.setAttribute("class", "availability");
        var sousElementP = document.createElement("p");
        var sousElementButton = document.createElement("button");
        sousElementButton.setAttribute("class", "ajaxDeleteAvailability");
        var listAvailability = document.getElementById("listAvailability");
        sousElementP.innerHTML = data[0].startDate + " => " + data[0].endDate;
        sousElementButton.innerHTML = "x";
        listAvailability.appendChild(element);
        element.appendChild(sousElementP);
        element.appendChild(sousElementButton);
        sousElementButton.addEventListener("click", function (e) {
          e.preventDefault();
          var data = { startDate: data[0].startDate, endDate: data[0].endDate };
          var dataJson = JSON.stringify(data);
          fetch(urlDeleteAvailability, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
            .then((response) => response.text())
            .then((text) => {
              var reponse = document.getElementById("statusAjaxGlobal");
              reponse.innerHTML = text;
              element.remove();
            })
            .catch(function (error) {
              console.log("Erreur dans l'opération fetch :" + error.message);
            });
        });
      }
    })
    .catch(function (error) {
      console.log("Erreur dans l'opération fetch :" + error.message);
    });
});

//ajax ajout de la disponibilité global
var confirmAjaxGlobal = document.getElementById("ajaxSendGlobal");
confirmAjaxGlobal.addEventListener("click", function () {
  var inputStartDateRangeGlobal = document.querySelector("#start_date_time input.date_output");
  var inputEndDateRangeGlobal = document.querySelector("#end_date_time input.date_output");

  var data = { startDate: inputStartDateRangeGlobal.value, endDate: inputEndDateRangeGlobal.value };
  var dataJson = JSON.stringify(data);
  fetch(urlAddGlobalAvailability, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
    .then((response) => response.text())
    .then((text) => {
      var balise = document.getElementById("statusAjaxGlobal");
      balise.innerHTML = text;
      if (text == "ajout effectué") {
        var listAvailability = document.getElementById("listAvailabilityGlobal");
        var element = document.createElement("div");
        element.setAttribute("class", "availability");
        var sousElementP = document.createElement("p");
        var sousElementButton = document.createElement("button");
        sousElementButton.setAttribute("class", "ajaxDeleteAvailabilityGlobal");
        var startDate = new Date(inputStartDateRangeGlobal.value);
        startDate = toLocalStringCusto(startDate);
        var endDate = new Date(inputEndDateRangeGlobal.value);
        endDate = toLocalStringCusto(endDate);
        sousElementP.innerHTML = startDate + " => " + endDate;
        sousElementButton.innerHTML = "x";
        listAvailability.appendChild(element);
        element.appendChild(sousElementP);
        element.appendChild(sousElementButton);
        sousElementButton.addEventListener("click", function () {
          var date = sousElementP.textContent;
          date = date.split(" => ");
          var startDate = date[0];
          var endDate = date[1];
          var data = { startDate: startDate, endDate: endDate };
          var dataJson = JSON.stringify(data);
          fetch(urlDeleteAvailabilityGlobal, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
            .then((response) => response.text())
            .then((text) => {
              var reponse = document.getElementById("statusAjaxGlobal");
              reponse.innerHTML = text;
              element.remove();
            })
            .catch(function (error) {
              console.log("Erreur dans l'opération fetch :" + error.message);
            });
        });
      }
    })
    .catch(function (error) {
      console.log("Erreur dans l'opération fetch :" + error.message);
    });
});
//function pour changer le format de la date en h:i d/m/y
function toLocalStringCusto(date) {
  var year = date.getFullYear();
  var month = date.getMonth() + 1;
  if (month < 10) {
    month = "0" + month;
  }
  var day = date.getUTCDate();
  if (day < 10) {
    day = "0" + day;
  }
  var hours = date.getHours();
  if (hours < 10) {
    hours = "0" + hours;
  }
  var minutes = date.getMinutes();
  if (minutes < 10) {
    minutes = "0" + minutes;
  }

  return hours + ":" + minutes + " " + day + "/" + month + "/" + year;
}

//ajax ajout de la disponibilité lié a un jeu
var confirmAjax = document.getElementById("ajaxSend");
confirmAjax.addEventListener("click", function (e) {
  e.preventDefault();
  var inputStartDateRange = document.querySelector("#start_date_time_2 input.date_output");
  var inputEndDateRange = document.querySelector("#end_date_time_2 input.date_output");
  var game = document.getElementById("availability_game").value;
  var data = { startDate: inputStartDateRange.value, endDate: inputEndDateRange.value, game: game };
  var dataJson = JSON.stringify(data);
  fetch(urlAddAvailability, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
    .then((response) => response.text())
    .then((text) => {
      var balise = document.getElementById("statusAjax");
      balise.innerHTML = text;
      if (text == "ajout effectué") {
        var listAvailability = document.getElementById("listAvailability");
        var element = document.createElement("div");
        element.setAttribute("class", "availability");
        var sousElementP = document.createElement("p");
        var sousElementButton = document.createElement("button");
        sousElementButton.setAttribute("class", "ajaxDeleteAvailability");
        var startDate = new Date(inputStartDateRange.value);
        startDate = toLocalStringCusto(startDate);
        var endDate = new Date(inputEndDateRange.value);
        endDate = toLocalStringCusto(endDate);
        sousElementP.innerHTML = startDate + " => " + endDate;
        sousElementButton.innerHTML = "x";
        listAvailability.appendChild(element);
        element.appendChild(sousElementP);
        element.appendChild(sousElementButton);
      }
    })
    .catch(function (error) {
      console.log("Erreur dans l'opération fetch :" + error.message);
    });
});

//ajax pour supprimer les disponibilitées
var ajaxDeleteGlobal = document.querySelectorAll(".ajaxDeleteAvailabilityGlobal");
ajaxDeleteGlobal.forEach((element) => {
  element.addEventListener("click", function () {
    var date = this.previousElementSibling.textContent;
    var removeElement = this.parentElement;
    date = date.split("\n\t\t\t\t\t=>\n\t\t\t\t\t");
    var startDate = date[0];
    var endDate = date[1];
    var data = { startDate: startDate, endDate: endDate };
    var dataJson = JSON.stringify(data);
    fetch(urlDeleteAvailabilityGlobal, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
      .then((response) => response.text())
      .then((text) => {
        var reponse = document.getElementById("statusAjaxGlobal");
        reponse.innerHTML = text;
        removeElement.remove();
      })
      .catch(function (error) {
        console.log("Erreur dans l'opération fetch :" + error.message);
      });
  });
});

var ajaxDelete = document.querySelectorAll(".ajaxDeleteAvailability");
