let loadStartTime 
loadStartTime = performance.now();
let loadEndTime;
window.addEventListener('DOMContentLoaded',() => {

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

});

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

window.onerror = function (errorMsg, url, lineNumber, columnNumber, errorObj) {
  // Collect the thrown error and send it to the API endpoint
  sendErrorToAPI(errorMsg, url, lineNumber, columnNumber, errorObj);
};

// Function to send error data to the API endpoint
function sendErrorToAPI(errorMsg, url, lineNumber, columnNumber, errorObj) {

  const payload3 = {
    errorMsg: errorMsg,
    url: url,
    lineNumber: lineNumber,
    columnNumber: columnNumber,
    errorObj: errorObj
  };

  // Send the error data to the API endpoint using fetch
  fetch('https://cse135spain.site/api/errors', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload3)
  })
    .then(response => {
      if (response.ok) {
        console.log('Error data sent successfully');
      } else {
        console.error('Error sending error data:', response.statusText);
      }
    })
    .catch(error => {
      console.error('Error sending error data:', error);
    });
};

// Intentionally throwing an error for testing purposes
//function triggerError() {
//  throw new Error('Intentional error for testing');
//}

// Call the function to trigger the error
//triggerError();


function sendMouseActivityToAPI(mouseData) {
  fetch('https://cse135spain.site/api/mouseactivity', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(mouseData)
  })
    .then(response => {
      if (response.ok) {
        console.log('Mouse activity data sent successfully');
      } else {
        console.error('Error sending mouse activity data:', response.statusText);
      }
    })
    .catch(error => {
      console.error('Error sending mouse activity data:', error);
    });
}

// Mousemove event listener to capture cursor positions
window.addEventListener('mousemove', function(event) {
  const cursorPosition = {
    x: event.clientX,
    y: event.clientY
  };
  sendMouseActivityToAPI({ type: 'mousemove', data: cursorPosition });
});

// Click event listener to capture clicks and mouse button information
window.addEventListener('click', function(event) {
  const button = event.button === 0 ? 'left' : event.button === 1 ? 'middle' : 'right';
  const clickData = {
    x: event.clientX,
    y: event.clientY,
    button: button
  };
  sendMouseActivityToAPI({ type: 'click', data: clickData });
});

// Scroll event listener to capture scrolling coordinates
window.addEventListener('scroll', function(event) {
  const scrollData = {
    x: window.scrollX,
    y: window.scrollY
  };
  sendMouseActivityToAPI({ type: 'scroll', data: scrollData });
});

// Keyboard event listener to capture key presses
window.addEventListener('keydown', function(event) {
  const keyData = {
    keyValue: event.key,
    code: event.code,
    shiftKey: event.shiftKey,
    ctrlKey: event.ctrlKey,
    altKey: event.altKey,
    metaKey: event.metaKey
  };
  sendKeyboardActivityToAPI({ type: 'keypress', data: keyData });
});

// Function to send keyboard activity data to the API endpoint
function sendKeyboardActivityToAPI(activityData) {
  fetch('https://cse135spain.site/api/keyboardactivity', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(activityData)
  })
    .then(response => {
      if (response.ok) {
        console.log('Keyboard activity data sent successfully');
      } else {
        console.error('Error sending keyboard activity data:', response.statusText);
      }
    })
    .catch(error => {
      console.error('Error sending keyboard activity data:', error);
    });
}

// Variable to store the break start timestamp
let breakStartTimestamp;

// Function to handle idle timeout
function handleIdleTimeout() {
  // Calculate the duration of the break in milliseconds
  const breakEndTimestamp = Date.now();
  const breakDuration = breakEndTimestamp - breakStartTimestamp;

  // Prepare the payload to send to the API endpoint
  const payload = {
    breakStartTimestamp: breakStartTimestamp,
    breakEndTimestamp: breakEndTimestamp,
    breakDuration: breakDuration
  };

  // Send the break data to the API endpoint using fetch
  fetch('https://cse135spain.site/api/idleactivity', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  })
    .then(response => {
      if (response.ok) {
        console.log('Idle data sent successfully');
      } else {
        console.error('Error sending idle data:', response.statusText);
      }
    })
    .catch(error => {
      console.error('Error sending idle data:', error);
    });

  // Restart the idle timeout
  startIdleTimeout();
}

// Function to start the idle timeout
function startIdleTimeout() {
  // Set the break start timestamp
  breakStartTimestamp = Date.now();

  // Set the idle timeout for 2 seconds (2000 milliseconds)
  setTimeout(handleIdleTimeout, 2000);
}

// Event listener for mousemove event
window.addEventListener('mousemove', function() {
  // Reset the idle timeout on mouse movement
  try {
    clearTimeout(idleTimeout);
    startIdleTimeout();
  } catch (error) {
    console.log('Checking for idle breaks...')
  };
});

// Event listener for keydown event
window.addEventListener('keydown', function() {
  // Reset the idle timeout on key press
  try {
    clearTimeout(idleTimeout);
    startIdleTimeout();
  } catch (error) {
    console.log('Checking for idle breaks...')
  };
  
});

// Start the initial idle timeout
startIdleTimeout();

// Function to send page activity data to the API endpoint
function sendPageActivityToAPI(type, page) {
  const payload = {
    type: type,
    page: page
  };

  // Send the page activity data to the API endpoint using fetch
  fetch('https://cse135spain.site/api/pageactivity', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(payload)
  })
    .then(response => {
      if (response.ok) {
        console.log('Page activity data sent successfully');
      } else {
        console.error('Error sending page activity data:', response.statusText);
      }
    })
    .catch(error => {
      console.error('Error sending page activity data:', error);
    });
}

// Event handler for when the user enters the page
window.onload = function() {
  const page = window.location; // Get the current page path
  sendPageActivityToAPI('enter', page); // Send the enter activity to the API
};

// Event handler for when the user leaves the page
window.onunload = function() {
  const page = window.location; // Get the current page path
  sendPageActivityToAPI('leave', page); // Send the leave activity to the API
};


