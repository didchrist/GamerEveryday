var listGame = document.querySelectorAll(".click-icone");
var background = document.getElementById("background");

listGame.forEach((element) => {
  element.addEventListener("click", function (e) {
    e.preventDefault();
  });
  element.addEventListener("dblclick", function (e) {
    e.preventDefault();
    var window = element.nextElementSibling;
    window.style.display = "flex";
    background.style.display = "block";
  });
});
document.addEventListener("click", function (e) {
  if (e.target.id == "background") {
    background.style.display = "none";
    listGame.forEach((element) => {
      var window = element.nextElementSibling;
      window.style.display = "none";
    });
  }
});
var listClose = document.querySelectorAll(".close");
var listTiret = document.querySelectorAll(".tiret");

listClose.forEach((element) => {
  element.addEventListener("click", function (e) {
    e.preventDefault();
    var window = this.parentElement.parentElement.parentElement.parentElement;
    window.style.display = "none";
    background.style.display = "none";
  });
});

listTiret.forEach((element) => {
  element.addEventListener("click", function (e) {
    e.preventDefault();
    var window = this.parentElement.parentElement.parentElement.parentElement;
    window.style.display = "none";
    background.style.display = "none";
  });
});
