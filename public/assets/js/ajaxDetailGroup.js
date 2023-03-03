var buttonJoin = document.getElementById("ajaxAddUserInGroup");

//ajax comportement bouton pour rejoindre/s'en aller d'un groupe
if (buttonJoin) {
  buttonJoin.addEventListener("click", function join(e) {
    e.preventDefault();
    var data = document.querySelector(".js-group-id").dataset.group;
    var dataJson = JSON.stringify({ id: data });
    if (buttonJoin.text == "Rejoindre") {
      fetch(urlAjaxAddUserInGroup, { method: "POST", headers: { "Content-Type": "application/json" }, body: dataJson })
        .then((response) => response.text())
        .then((text) => {
          var listUser = document.querySelectorAll(".user");

          var lastUser = listUser[listUser.length - 1];

          var div = document.createElement("div");
          var pUsername = document.createElement("p");
          pUsername.setAttribute("class", "mx-5");
          var pRole = document.createElement("p");

          div.setAttribute("class", "d-flex justify-content-center user");

          lastUser.insertAdjacentElement("afterend", div);
          div.appendChild(pUsername);
          div.appendChild(pRole);

          pUsername.innerHTML = text;
          pRole.innerHTML = "En attente";

          buttonJoin.innerHTML = "Annuler la demande";
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    } else {
      fetch(urlAjaxDeleteUserInGroup, { method: "POST", headers: { "Content-Type": "application/json" }, body: dataJson })
        .then((response) => response.text)
        .then((text) => {
          var listUser = document.querySelectorAll(".user");

          var lastUser = listUser[listUser.length - 1];

          lastUser.remove();

          buttonJoin.innerHTML = "Rejoindre";
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    }
  });
}

var listConfirmButton = document.querySelectorAll(".confirm");
if (listConfirmButton) {
  listConfirmButton.forEach(function (element) {
    element.addEventListener("click", function (e) {
      e.preventDefault();
      var data = document.querySelector(".js-group-id").dataset.group;
      var divUser = this.parentElement;
      var username = divUser.firstElementChild.innerHTML;
      var dataJson = JSON.stringify({ idGroup: data, username: username });

      fetch(urlAjaxConfirmAddUser, { method: "POST", headers: { "Content-Type": "application/json" }, body: dataJson })
        .then((response) => response.text)
        .then((text) => {
          divUser.children[1].innerHTML = "Membre";
          divUser.children[3].remove();
          divUser.children[2].remove();
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    });
  });
}

var listRejectButton = document.querySelectorAll(".reject");
if (listRejectButton) {
  listRejectButton.forEach(function (element) {
    element.addEventListener("click", function (e) {
      e.preventDefault();
      var data = document.querySelector(".js-group-id").dataset.group;
      var divUser = this.parentElement;
      var username = divUser.firstElementChild.innerHTML;
      var dataJson = JSON.stringify({ idGroup: data, username: username });

      fetch(urlAjaxDeleteUserInGroup, { method: "POST", headers: { "Content-Type": "application/json" }, body: dataJson })
        .then((response) => response.text)
        .then((text) => {
          divUser.remove();
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    });
  });
}
