var formAjax = document.querySelectorAll(".form-game");

function creationSwitch(element) {
  var newlabel = document.createElement("label");
  newlabel.setAttribute("class", "switch");
  var newChildrenInput = document.createElement("input");
  newChildrenInput.setAttribute("type", "checkbox");
  newChildrenInput.setAttribute("checked", true);
  newChildrenInput.setAttribute("class", "eventCheckbox");
  var newChildrenSpan = document.createElement("span");
  newChildrenSpan.setAttribute("class", "slider round");
  element.insertAdjacentElement("afterend", newlabel);
  newlabel.append(newChildrenInput);
  newlabel.append(newChildrenSpan);
  newChildrenInput.addEventListener("click", function () {
    var idgame = element.parentElement.children[0].value;
    if (this.checked == true) {
      data = { idGame: idgame, showGame: true };
    } else {
      data = { idGame: idgame, showGame: false };
    }
    dataJson = JSON.stringify(data);
    //Attention problème performance possible
    fetch(urlUpdate, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
      .then(() => {})
      .catch(function (error) {
        console.log("Erreur dans l'opération fetch :" + error.message);
      });
  });
}
formAjax.forEach(function (element) {
  element.addEventListener("submit", function (event) {
    event.preventDefault();
    form = new FormData(this);
    var hasGameUser = this.children[1].textContent;
    if (hasGameUser == "Posséder") {
      fetch(urlAdd, { method: "post", body: form })
        .then(() => {
          var input = this.children[1];
          creationSwitch(input);
          input.className = "fond-neon-possede";
          input.innerHTML = "Non-posséder";
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    } else {
      fetch(urlDelete, { method: "post", body: form })
        .then(() => {
          var input = this.children[1];
          var checkbox = this.children[2];
          checkbox.remove();
          input.className = "fond-neon-non-possede";
          input.innerHTML = "Posséder";
        })
        .catch(function (error) {
          console.log("Erreur dans l'opération fetch :" + error.message);
        });
    }
  });
});

var checkbox = document.querySelectorAll(".eventCheckbox");

checkbox.forEach(function (element) {
  element.addEventListener("click", function AjaxUpdate() {
    var idgame = this.parentElement.parentElement.children[0].value;
    if (this.checked == true) {
      data = { idGame: idgame, showGame: true };
    } else {
      data = { idGame: idgame, showGame: false };
    }
    dataJson = JSON.stringify(data);
    //Attention problème performance possible
    fetch(urlUpdate, { method: "post", headers: { "Content-Type": "application/json" }, body: dataJson })
      .then(() => {})
      .catch(function (error) {
        console.log("Erreur dans l'opération fetch :" + error.message);
      });
  });
});
