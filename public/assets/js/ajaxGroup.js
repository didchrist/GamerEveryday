// document.getElementById('ajaxAdd').addEventListener('click', function (e) {
//     e.preventDefault();
//     var form = this.parentElement;
//     var data = new FormData(form);
//     fetch (urlAddGroup, { method: 'POST', body: data})
//         .then(response => response.json())
//             .then((data) => {
//                 var div = document.createElement('div');
//                 var h2 =document.createElement('h2');
//                 var pUsername = document.createElement('p');
//                 var pRole = document.createElement('p');
//                 var button = document.createElement('a');

//                 urlDetailGroup = urlDetailGroup.replace('id', data.id);

//                 div.setAttribute('class', 'd-flex m-3 groupe');
//                 button.setAttribute('class', 'p-2 rounded mx-5');
//                 button.setAttribute('href', urlDetailGroup);
                
//                 button.innerHTML = 'Détails';
//                 h2.innerHTML = data.nameGroup;
//                 pUsername.innerHTML = data.username;
//                 pRole.innerHTML = data.role;

//                 if (document.getElementById('nothing')) {
//                     document.getElementById('nothing').remove();
//                     var listUserGroup = document.getElementById('listUserGroup');

//                     listUserGroup.insertAdjacentElement('afterend', div);
//                     div.appendChild(h2);
//                     div.appendChild(pUsername);
//                     div.appendChild(pRole);
//                     div.appendChild(button);
                    
//                 } else {
//                     var groupe = document.querySelectorAll('.groupe');
    
//                     var lastGroupe = groupe[groupe.length-1];
    
//                     lastGroupe.insertAdjacentElement('afterend', div);
//                     div.appendChild(h2);
//                     div.appendChild(pUsername);
//                     div.appendChild(pRole);
//                     div.appendChild(button);
//                 }

//             })
//         .catch(function (error) {
//             console.log("Erreur dans l'opération fetch :" + error.message);
//           })
// })

document.getElementById('ajaxAdd').addEventListener('click', function (e) {
    e.preventDefault();
    var form = this.parentElement;
    var data = new FormData(form);
    fetch(urlAddGroup, { method: 'POST', body: data })
        .then(response => response.json())
        .then((data) => {
            var table = document.createElement('table');
            var thead = document.createElement('thead');
            var th1 = document.createElement('th');
            var th2 = document.createElement('th');
            var th3 = document.createElement('th');
            var th4 = document.createElement('th');
            var tr = document.createElement('tr');
            var tr1 = document.createElement('tr');
            var tdNameGroup = document.createElement('td');
            var tdUsername = document.createElement('td');
            var tdRole = document.createElement('td');
            var tdDetails = document.createElement('td');
            var linkDetails = document.createElement('a');

            urlDetailGroup = urlDetailGroup.replace('id', data.id);

            linkDetails.setAttribute('class', 'p-2 rounded mx-2');
            linkDetails.setAttribute('href', urlDetailGroup);
            table.setAttribute('class', 'groupes');

            linkDetails.innerHTML = 'Détails';
            th1.innerHTML = 'Nom';
            th2.innerHTML = 'Pseudo';
            th3.innerHTML = 'Rôle';
            th4.innerHTML = 'Option';
            tdNameGroup.innerHTML = data.nameGroup;
            tdUsername.innerHTML = data.username;
            tdRole.innerHTML = data.role;

            tdDetails.appendChild(linkDetails);
            // table.appendChild(thead);
            // thead.appendChild(tr1);
            // tr1.appendChild(th1);
            // tr1.appendChild(th2);
            // tr1.appendChild(th3);
            // tr1.appendChild(th4);
            tr.appendChild(tdNameGroup);
            tr.appendChild(tdUsername);
            tr.appendChild(tdRole);
            tr.appendChild(tdDetails);

            if (document.getElementById('nothing')) {
                document.getElementById('nothing').remove();
                var listUserGroup = document.getElementById('listUserGroup');

                    listUserGroup.insertAdjacentElement('afterend', table);
                    table.appendChild(thead);
                    thead.appendChild(tr1);
                    tr1.appendChild(th1);
                    tr1.appendChild(th2);
                    tr1.appendChild(th3);
                    tr1.appendChild(th4);
                    tr.appendChild(tdNameGroup);
                    tr.appendChild(tdUsername);
                    tr.appendChild(tdRole);
                    tr.appendChild(tdDetails);

                listUserGroup.insertAdjacentElement('afterend', tr);
            } else {
                var groupe = document.querySelectorAll('.groupe');

                var lastGroupe = groupe[groupe.length - 1];

                lastGroupe.insertAdjacentElement('afterend', tr);
            }
        })
        .catch(function (error) {
            console.log("Erreur dans l'opération fetch :" + error.message);
        })
})