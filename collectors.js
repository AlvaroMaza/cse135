window.addEventListener('DOMContentLoaded',init);
function init(){
    let payload = {};

    payload["url"] = window.location.href;
    payload["referrer"] = document.referrer;

    payload["timestamp"] = new Date().toISOString();

    payload["userAgent"] = navigator.userAgent;
    payload["screenDimensions"] = {
        width: window.screen.width,
        height: window.screen.height
    };

    navigator.sendBeacon("http://cse135spain.site/json/posts", JSON.stringify(payload));
}