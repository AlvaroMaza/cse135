<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!-- Add your CSS and JavaScript files here -->
    <!-- For example: -->
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <!-- <script src="script.js"></script> -->
    <script src="https://cdn.zinggrid.com/zinggrid.min.js" defer></script>
</head>
<body>
    <header>
        <h1>Welcome to My Dashboard</h1>
    </header>
    
    <main>
        <h2>Dashboard Overview</h2>
        <button id="logout-button">Logout</button>
        <a href="./crud.html">
            <button>Go to CRUD</button>
        </a>
        <!-- Add your dashboard content here -->
    </main>
    
    <footer>
        <h2>Contact Information</h2>
        <!-- Add your footer content here -->
    </footer>
    <script>

        window.onload = function() {
            auth_token = sessionStorage.getItem('auth_token');
            if(auth_token == null){
                console.log('Auth token not present')
                window.location.href = "./login.html";
            }
        };


        // Add a click event listener to the logout button
        document.getElementById("logout-button").addEventListener("click", function() {
          // Clear the authentication token from the session storage
          sessionStorage.removeItem("auth_token");
          
          // Redirect the user to the login page
          window.location.href = "./logout.html";
        });

        
      </script>
</body>
</html>