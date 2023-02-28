document.getElementById('ajaxAdd').addEventListener('click', function (e) {
    e.preventDefault();
    var form = this.parentElement;
    var data = new FormData(form);
    fetch (urlAddGroup, { method: 'POST', body: data})
        .then(response => response.json())
            .then((data) => {
                var div = document.createElement('div');
                var h2 =document.createElement('h2');
                var pUsername = document.createElement('p');
                var pRole = document.createElement('p');
                var button = document.createElement('a');

                urlDetailGroup = urlDetailGroup.replace('id', data.id);

                div.setAttribute('class', 'd-flex m-3 groupe');
                button.setAttribute('class', 'p-2 rounded mx-5');
                button.setAttribute('href', urlDetailGroup);
                
                button.innerHTML = 'Détails';
                h2.innerHTML = data.nameGroup;
                pUsername.innerHTML = data.username;
                pRole.innerHTML = data.role;


                var groupe = document.querySelectorAll('.groupe');

                var lastGroupe = groupe[groupe.length-1];

                lastGroupe.insertAdjacentElement('afterend', div);
                div.appendChild(h2);
                div.appendChild(pUsername);
                div.appendChild(pRole);
                div.appendChild(button);

            })
        .catch(function (error) {
            console.log("Erreur dans l'opération fetch :" + error.message);
          })
})