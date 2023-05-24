const loadStartTime = Date.now();
let loadEndTime;
window.addEventListener('DOMContentLoaded', loadFunction());

function loadFunction() {
  let payload = {};

  payload.url = window.location.href;
  payload.timestamp = new Date().toISOString();
  payload.userAgent = navigator.userAgent;
  payload.language = navigator.language;
  payload.cookieEnabled = navigator.cookieEnabled;
  payload.jsEnabled = JavaScriptEnabled(); 
  payload.imagesEnabled = ImagesEnabled(); 
  payload.cssEnabled = CSSEnabled(); 
  payload.screenDimensions = {
    width: window.screen.width,
    height: window.screen.height,
  };
  payload.windowDimensions = {
    width: window.innerWidth,
    height: window.innerHeight,
  };
  payload.connectionType = navigator.connection
    ? navigator.connection.effectiveType
    : 'unknown'; // If network information is not available, set it as unknown

  const data = JSON.stringify(payload);

  fetch('https://cse135spain.site/api/static', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: data,
  })
    .then((response) => {
      if (response.ok) {
        console.log('Data sent successfully.');
      } else {
        console.log('Failed to send data.');
      }
    })
    .catch((error) => {
      console.log('Error:', error);
    });
  


    loadEndTime = performance.now();
    const totalLoadTime = loadEndTime - loadStartTime;

    const timingObject = performance.timing;
    
    // Create payload object with performance data
    let payload2 = {
      timing: timingObject,
      loadStartTime: loadStartTime,
      loadEndTime: loadEndTime,
      totalLoadTime: totalLoadTime
    };

  const performanceData = JSON.stringify(payload2);

  fetch('https://cse135spain.site/api/performance', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: performanceData,
  })
    .then((response) => {
      if (response.ok) {
        console.log('Data sent successfully.');
      } else {
        console.log('Failed to send data.');
      }
    })
    .catch((error) => {
      console.log('Error:', error);
    });
}




function JavaScriptEnabled() {
  // Check if JavaScript is enabled
  return typeof navigator === 'object' && 'onLine' in navigator;
}

function ImagesEnabled() {
  // Check if images are enabled
  const img = new Image();
  img.src = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
  return img.width > 0 && img.height > 0;
}

function CSSEnabled() {
  // Check if CSS is enabled
  const style = document.createElement('style');
  style.innerText = 'body { color: red; }';
  document.head.appendChild(style);
  const computedStyle = window.getComputedStyle(document.body);
  const color = computedStyle.color;
  document.head.removeChild(style);
  return color === 'rgb(255, 0, 0)';
}