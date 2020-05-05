// Get the modal
let modal = document.getElementById("myModalCat");
// var modal = document.getElementsByClassName("myModal");
// Get the button that opens the modal
let btn = document.getElementsByClassName("modalBtnCat");
for (var i=0; i < btn.length; i++) {
    // Here we have the same onclick
    btn.item(i).onclick = modalShow;
}
function modalShow(){
    document.getElementById("delete-cat-form").reset();
    document.getElementById('container-modal__delete-cat').style.display = "inline";
    modalHistory.style.display = "flex";
}
var span = document.getElementsByClassName("close");
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}
