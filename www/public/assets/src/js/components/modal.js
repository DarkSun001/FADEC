function initModal() {
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function () {
        modal.style.display = "block";
    }

    span.onclick = function () {
        modal.style.display = "none";
    }
}

// Appel de la fonction pour initialiser le modal
initModal();