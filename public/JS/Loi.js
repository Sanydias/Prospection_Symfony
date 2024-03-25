
function setStorage(){
    input = document.getElementById("IdLoi").checked;
    if(input){
        localStorage.setItem("loi", true);
        window.location.href = "/home";
    }
}

function getStorage(){
    var loi = localStorage.getItem("loi");
    if (loi) {
        window.location.href = "/home";
    }
}

window.onload = getStorage();