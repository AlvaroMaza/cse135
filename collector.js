window.addEventListener('DOMContentLoaded',init);
function init(){
    let payload = {};

    payload["url"] = window.location.href;

    payload["timestamp"] = new Date().toISOString();

    payload["userAgent"] = navigator.userAgent;
    payload["screenDimensions"] = {
        width: window.screen.width,
        height: window.screen.height
    };

    navigator.sendBeacon("https://cse135spain.site/api/static", JSON.stringify(payload));
}