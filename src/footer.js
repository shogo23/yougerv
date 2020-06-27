//|| document.querySelector(".watch_container .details .desc");

var elm = document.querySelector("ul");

if (elm !== null) {
    elm.addEventListener("click", function(e) {
        if (e.srcElement.localName == "a") {
            e.preventDefault();
            location = "/out?redirect=" + e.target.href;
        }
    });
}