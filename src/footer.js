var body = document.querySelector("body");

body.addEventListener("click", function(e) {
    if (e.srcElement.localName == "a") {
        e.preventDefault();
    }
});