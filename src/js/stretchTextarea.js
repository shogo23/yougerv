const stretchTextarea = (elm) => {
    const element = document.querySelector(elm);
    const orig_height = element.clientHeight;
    const events = ["keyup", "input", "propertychange"];

    var scrollHeight = element.scrollHeight + 1;
    element.style.cssText = "height: " + scrollHeight + "px";
    
    for (var i = 0; i < events.length; i++) {
        element.addEventListener(events[i], function() {
            setTimeout(function() {
                element.style.cssText = "height:" + orig_height + "px";
                element.style.cssText = "height:" + element.scrollHeight + "px;";
            }, 0);
        });
    }
}

export default stretchTextarea;