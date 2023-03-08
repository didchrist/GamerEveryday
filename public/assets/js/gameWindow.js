var listGame = document.querySelectorAll('.click-icone');

listGame.forEach((element) => {
    element.addEventListener('click', function(e) {
        e.preventDefault();

    })
    element.addEventListener('dblclick', function(e) {
        e.preventDefault();
        var window = this.children[2];
        window.style.display = 'flex';
    })
})