const loginForm = document.getElementById("login")

window.onload = function() {
    auth_token = sessionStorage.getItem('auth_token');
    if(auth_token != null){
        console.log('Auth token present')
        window.location.href = "./dashboard.html";
    }
};

loginForm.onsubmit = async (e) => {
    e.preventDefault();

    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var error = document.getElementById("error-text");
    requestBody = {
        email,
        password
    }
    const res = await fetch("http://localhost:3002/user/login",{
        method: 'POST',
        headers:{
            "Content-Type":'application/json'
        },
        body: JSON.stringify(requestBody)
    }).then(response => {
        response.json().then(data => {
            if(response.status != 200){
                error.innerHTML = data.msg;
            } else {
                sessionStorage.setItem('auth_token', data.token);
                window.location.href = "./dashboard.html";
            }
        })
    }).catch(error =>{
        console.log(error);
    });

}