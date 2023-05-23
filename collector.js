window.addEventListener('DOMContentLoaded', init);

function init() {
  let payload = {};

  payload.url = window.location.href;
  payload.timestamp = new Date().toISOString();
  payload.userAgent = navigator.userAgent;
  payload.language = navigator.language;
  payload.cookieEnabled = navigator.cookieEnabled;
  payload.jsEnabled = true; // JavaScript is always enabled in the browser
  payload.imagesEnabled = true; // Images are always enabled in the browser
  payload.cssEnabled = true; // CSS is always enabled in the browser
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
}