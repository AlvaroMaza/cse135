const form = document.querySelector('form');
const postBtn = document.querySelector('#postBtn');
const getBtn = document.querySelector('#getBtn');
const putBtn = document.querySelector('#putBtn');
const deleteBtn = document.querySelector('#deleteBtn');
const methodSelect = document.getElementById('methodSelect');
let requestMethod = 'fetch'; // Default to fetch API method

// Event listener for method selection
methodSelect.addEventListener('change', () => {
    requestMethod = methodSelect.value;
});

// Event listener for POST button
postBtn.addEventListener('click', () => {
  const data = new FormData(form);
  const payload = {};

  for (let [key, value] of data.entries()) {
    payload[key] = value;
  }

  if (requestMethod === 'fetch') {
        fetch('https://httpbin.org/post', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => displayResponse(data))
        .catch(error => console.error(error));

    } else {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    displayResponse(data);
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.open('POST', 'https://httpbin.org/post');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(payload));
    }
});

// Event listener for GET button
getBtn.addEventListener('click', () => {
  const url = new URL('https://httpbin.org/get');
  const data = new FormData(form);
  const params = new URLSearchParams(data);
  url.search = params;
  if (requestMethod === 'fetch') {
        fetch(url)
        .then(response => response.json())
        .then(data => displayResponse(data))
        .catch(error => console.error(error));
    } else {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    displayResponse(data);
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.open('GET', url);
        xhr.send();
    }
});

// Event listener for PUT button
putBtn.addEventListener('click', () => {
    const data = new FormData(form);
    const payload = {};

    for (let [key, value] of data.entries()) {
        if (key !== 'id') {
        payload[key] = value;
        }
    }

    const id = data.get('id');
    if (requestMethod === 'fetch') {
        fetch(`https://httpbin.org/put?id=${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => displayResponse(data))
        .catch(error => console.error(error));
    } else {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    displayResponse(data);
                } else {
                    console.error('Error:', xhr.status);
                }
            }
        };
        xhr.open('PUT', `https://httpbin.org/put?id=${id}`);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(payload));
    }
});

// Event listener for DELETE button
deleteBtn.addEventListener('click', () => {
    const data = new FormData(form);
    const id = data.get('id');
    if (requestMethod === 'fetch') {
        fetch(`https://httpbin.org/delete?id=${id}`, {
        method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => displayResponse(data))
        .catch(error => console.error(error));
    } else {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                displayResponse(data);
            } else {
                console.error('Error:', xhr.status);
            }
          }
        };
        xhr.open('DELETE', `https://httpbin.org/delete?id=${id}`);
        xhr.send();
    }
});


// Display the response in the output element
function displayResponse(data) {
    const outputElement = document.getElementById('response');
    outputElement.innerHTML = '';
  
    const title = document.createElement('h2');
    title.innerText = `Done with: ${requestMethod}`;
  
    outputElement.appendChild(title);
  
    const pre = document.createElement('pre');
    pre.innerText = JSON.stringify(data, null, 2);
  
    outputElement.appendChild(pre);
}

// Set the value of the date field to the current date and time
const dateField = document.getElementById('date');
dateField.value = new Date().toLocaleString();