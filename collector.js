window.addEventListener('DOMContentLoaded', init);

function init() {
  let payload = {};

  payload.url = window.location.href;
  payload.timestamp = new Date().toISOString();
  payload.userAgent = navigator.userAgent;
  payload.screenDimensions = {
    width: window.screen.width,
    height: window.screen.height,
  };

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