//------MODAL FOR DELETE && NEW REGISTER ACCOUNT
// Get the modal
console.log('File hello');
let modal = document.getElementById("myModalShow");
// Get the button that opens the modal
let btn = document.getElementsByClassName("modalBtn");

for (var i=0; i < btn.length; i++) {
    // Here we have the same onclick
    btn.item(i).onclick = modalShow;
}
function modalShow(){
    modal.style.display = "inline";
}
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
    modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
