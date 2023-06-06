const authRequiredMiddleware = (req, res, next) => {
    const auth_token = sessionStorage.getItem('auth-token');
    if (!auth_token) {
      return res.redirect("/login.html"); // Redirect to the login page if the authentication token is missing
    }
    next(); // Proceed to the next middleware or route handler if the authentication token is present
  };
  
  module.exports = authRequiredMiddleware;