function openImageModal() {
    var modal = document.getElementById("imageModal");
    var img = document.querySelector(".box_installation img");
    var modalImg = document.getElementById("modalImage");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = img.alt;
}

function openLoginModal() {
    var modal = document.getElementById("Connexion");
    modal.style.display = "block";
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}
