let modalGen = document.getElementById("myModalGen");
// Get the button that opens the modal
let btnGen = document.getElementsByClassName("modalBtnGen");
for (var i=0; i < btnGen.length; i++) {
    // Here we have the same onclick
    btnGen.item(i).onclick = modalShow;
}
function modalShow(){
    // document.getElementById("delete-genre-form").reset();
    document.getElementById("delete-genre-form").reset();
    document.getElementById('container-modal__delete-genre').style.display = "inline";
    modalGen.style.display = "flex";
}
// var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
document.getElementsByClassName("close")[0].addEventListener("click", function(){
    modalGen.style.display = "none";
});

// span.onclick = function() {
//     modalGen.style.display = "none";
// }

