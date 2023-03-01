var boutonRejoindre = document.getElementById('ajaxAddUserInGroup');
boutonRejoindre.addEventListener('click', function (e) {
    e.preventDefault();
    var data = document.querySelector('.js-group-id').dataset.group;
    var dataJson = JSON.stringify({ 'id': data});

    fetch(urlAjaxAddUserInGroup, { method:'POST',headers: { "Content-Type": "application/json" }, body: dataJson})
        .then((response) => response.text)
            .then()
        .catch(function (error) {
            console.log("Erreur dans l'opération fetch :" + error.message);
          })
});