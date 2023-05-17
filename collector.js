window.addEventListener('DOMContentLoaded',init);
function init(){
    let payload = {};

    payload["url"] = window.location.href;;

    navigator.sendBeacon("https://cse135spain.site/api/static", JSON.stringify(payload));
}