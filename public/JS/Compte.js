function suppressionCompte() {
    $( "div.BlocSupprimer" ).toggleClass( "Hide" );
}

// var mousePosition;
// var offset = [0,0];
// var div;
// var isDown = false;

// var div = document.getElementById('test');

// div.addEventListener('mousedown', function(e) {
//     div.style.position = "absolute";
//     div.style.cursor = "grabbing";
//     div.style.zIndex = "10";
//     isDown = true;
//     offset = [
//         0,
//         div.offsetTop - e.clientY
//     ];
// }, true);

// document.addEventListener('mouseup', function() {
//     div.style.position = "fixed";
//     div.style.cursor = "grab";
//     div.style.zIndex = "1";
//     isDown = false;
// }, true);

// document.addEventListener('mousemove', function(event) {
//     event.preventDefault();
//     if (isDown) {
//         mousePosition = {
    
//             x : 0,
//             y : event.clientY
    
//         };
//         div.style.left = (mousePosition.x + offset[0]) + 'px';
//         div.style.top  = (mousePosition.y + offset[1]) + 'px';
//     }
// }, true);

/* HELPER */

    let draggedTarget;
    let helper;
    
    document.addEventListener("dragstart", function(e) {
        draggedTarget = e.target;
        if (draggedTarget.classList.contains("ListeFavoris")) {
            helper = document.createElement("div");
            helper.innerText = draggedTarget.querySelector(".RankingFavoris").innerText;
            helper.style.position = "absolute";
            helper.style.top = "-9999px";
            helper.style.padding = "4px 8px";
            helper.style.backgroundColor = "#000";
            helper.style.color = "#ddd";
            document.querySelector("body").appendChild(helper);
            draggedTarget.classList.add("grabbing");
            
            e.dataTransfer.setDragImage(helper, -20, -10);
        }
    });

/**
 * code récupéré et modifier depuis :
 * https://codepen.io/Timesient/pen/GGKywZ
 */

    document.addEventListener("dragenter", function(e) {
        if (e.target.classList.contains("ListeFavoris")) {
            console.log(e.target);
            list = document.getElementById("GroupeFavoris");
            console.log(list);
            if (e.target !== draggedTarget && e.target.classList[0] === "ListeFavoris") {
                const ep = e.target.previousElementSibling;
                console.log("ep = " + ep);
                const en = e.target.nextElementSibling;
                console.log("en = " + en);
                const dp = draggedTarget.previousElementSibling;
                console.log("dp = " + dp);
                const dn = draggedTarget.nextElementSibling;
                console.log("dn = " + dn);

                if (!ep && !dn) {
                    list.removeChild(draggedTarget);
                    e.target.insertAdjacentElement("beforebegin", draggedTarget);
                } else if (!en && !dp) {
                    list.removeChild(draggedTarget);
                    e.target.insertAdjacentElement("afterend", draggedTarget);
                } else if (ep && ep != draggedTarget) {
                    list.removeChild(e.target);
                    list.removeChild(draggedTarget);
                    ep.insertAdjacentElement("afterend", draggedTarget);
                    draggedTarget.insertAdjacentElement("afterend", e.target);
                } else if (!ep) {
                    list.removeChild(e.target);
                    list.removeChild(draggedTarget);
                    dn.insertAdjacentElement("beforebegin", e.target);
                    e.target.insertAdjacentElement("beforebegin", draggedTarget);
                } else if (en && en != draggedTarget) {
                    list.removeChild(e.target);
                    list.removeChild(draggedTarget);
                    en.insertAdjacentElement("beforebegin", draggedTarget);
                    draggedTarget.insertAdjacentElement("beforebegin", e.target);
                } else if (!en) {
                    list.removeChild(e.target);
                    dp.insertAdjacentElement("afterend", e.target);
                }
            }
        }
    });

    document.addEventListener("dragover", function(e) {
        if (draggedTarget.classList.contains("ListeFavoris")) {
            e.preventDefault();
        }
    });

    document.addEventListener("drop", function(e) {
        if (draggedTarget.classList.contains("ListeFavoris")) {
            helper.parentNode.removeChild(helper);
            draggedTarget.classList.remove("grabbing");
            list = document.getElementById("GroupeFavoris").children;
            text = "";
            for (let i = 0; i < list.length; i++) {
                const element = list[i];
                firstSeparator = "_";
                if (i+1 == list.length) {
                    lastSeparator = "";
                } else {
                    lastSeparator = "-";
                }
                text = text + element.children[0].children[2].innerText + firstSeparator;
                text = text + element.children[0].children[1].innerText + lastSeparator;
                
            }
            window.location.href = '/favori/modifier/' + text;
        }
    });