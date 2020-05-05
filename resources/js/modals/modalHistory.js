let modalHistory = document.getElementById("myModalHistory");
// Get the button that opens the modal
let btnHistory = document.getElementsByClassName("modalBtnHistory");
for (var i=0; i < btnHistory.length; i++) {
    // Here we have the same onclick
    btnHistory.item(i).onclick = modalShow;
}
function modalShow(){
    document.getElementById("delete-history-form").reset();
    document.getElementById('container-modal__delete-history').style.display = "inline";
    modalHistory.style.display = "flex";
}
var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
    // modalHistory.css({"display": "flex"});
}

