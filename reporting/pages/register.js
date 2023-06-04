const loginForm = document.getElementById("register-form")

loginForm.onsubmit = async (e) => {
    e.preventDefault();

    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value
    var error = document.getElementById("error-text")
    
    requestBody = {
        username,
        email,
        password
    }
    
    const res = await fetch("http://localhost:3000/user/register",{
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
                window.location.href = "./login.html";
            }
        })
    }).catch(error =>{
        console.log(error);
    });

}