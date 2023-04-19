
let postBtn = document.getElementById("postBtn");
let getBtn = document.getElementById("getBtn");
let putBtn = document.getElementById("putBtn");
let deleteBtn = document.getElementById("deleteBtn");

let form = document.getElementById("methodtestForm");
let output = document.getElementById("response");


postBtn.addEventListener('click', () => {

    const formData = new FormData(form);
    formData.append("Date", new Date());

    if(formData.get("requestSelect") == "Fetch API"){

        formData.delete("requestSelect");

        const resp = Object.fromEntries(formData);
        const payload = JSON.stringify(resp);

        fetch('https://httpbin.org/post', {
            method: "POST",
            body: payload,
            
        })

            .then(resp => resp.json())
            .then(resp => {
                console.log(resp);
                output.innerHTML = `<pre>${JSON.stringify(resp,null,2)}</pre>`;
                })
            .catch(error => console.error(error))
    }

    else{

        formData.delete("requestSelect");

        const resp = Object.fromEntries(formData);
        const payload = JSON.stringify(resp);

        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const resp = xhr.responseText; 
                output.innerHTML = `<pre>${resp}</pre>`;;
            } else {
                console.log('Error: ' + xhr.status);
            }
            }
        };

        xhr.open('POST', 'https://httpbin.org/post');
        xhr.send(payload);

    }

})

getBtn.addEventListener('click', () => {

    const url = new URL('https://httpbin.org/get');
    const formData = new FormData(form);
    formData.append("Date", new Date());

    if(formData.get("requestSelect") == "Fetch API"){

        formData.delete("requestSelect");
        const params = new URLSearchParams(formData);
        url.search = params;

        fetch(url, {
            method: "GET",
        })

            .then(resp => resp.json())
            .then(resp => {
                console.log(resp);
                output.innerHTML = `<pre>${JSON.stringify(resp,null,2)}</pre>`;
            })
            .catch(error => console.error(error))

        }

    else{

        formData.delete("requestSelect");
        const params = new URLSearchParams(formData);
        url.search = params;

        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const resp = xhr.responseText; 
                output.innerHTML = `<pre>${resp}</pre>`;;
            } else {
                console.log('Error: ' + xhr.status);
            }
            }
        };

        xhr.open('GET', url);
        xhr.send();

    }

})

putBtn.addEventListener('click', () => {

    const url = new URL('https://httpbin.org/put');
    const formData = new FormData(form);
    formData.append("Date", new Date());
    const formID = formData.get("id");
    formData.delete("id");

    if(formData.get("requestSelect") == "Fetch API"){

        formData.delete("requestSelect");

        const resp = Object.fromEntries(formData);
        const payload = JSON.stringify(resp);

        const params = new URLSearchParams(`id=${formID}`);
        url.search = params;

        fetch(url, {
            method: "PUT",
            body: payload, 
        })

            .then(resp => resp.json())
            .then(resp => {
                console.log(resp);
                output.innerHTML = `<pre>${JSON.stringify(resp,null,2)}</pre>`
                })
            .catch(error => console.error(error))
    }

    else{

        formData.delete("requestSelect");

        const resp = Object.fromEntries(formData);
        const payload = JSON.stringify(resp);

        const params = new URLSearchParams(`id=${formID}`);
        url.search = params;

        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const resp = xhr.responseText; 
                output.innerHTML = `<pre>${resp}</pre>`;;
            } else {
                console.log('Error: ' + xhr.status);
            }
            }
        };

        xhr.open('PUT', url);
        xhr.send(payload);

    }

})


deleteBtn.addEventListener('click', () => {

    const url = new URL('https://httpbin.org/delete');
    const formData = new FormData(form);
    formData.append("Date", new Date());
    const formID = formData.get("id");
    formData.delete("id");

    if(formData.get("requestSelect") == "Fetch API"){

        formData.delete("requestSelect");

        const params = new URLSearchParams(`id=${formID}`);
        url.search = params;

        // I do not add any payload since the delete only needs the ID of the form at the endpoint
        fetch(url, {
            method: "DELETE",
        })

            .then(resp => resp.json())
            .then(resp => {
                console.log(resp);
                output.innerHTML = `<pre>${JSON.stringify(resp,null,2)}</pre>`;
                })
            .catch(error => console.error(error))
    }

    else{

        formData.delete("requestSelect");

        const params = new URLSearchParams(`id=${formID}`);
        url.search = params;

        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const resp = xhr.responseText; 
                output.innerHTML = `<pre>${resp}</pre>`;;
            } else {
                console.log('Error: ' + xhr.status);
            }
            }
        };

        xhr.open('DELETE', url);
        xhr.send();

    }

})