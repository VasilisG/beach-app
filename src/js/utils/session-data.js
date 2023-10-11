const isUserLoggedIn = () => {
    return localStorage.getItem('user_id') != null && localStorage.getItem('user_id') != undefined;
}

const userCreatedContent = (userId) => {
    return isUserLoggedIn() && localStorage.getItem('user_id') == userId;
}

const setUserSessionData = (data) => {
    localStorage.setItem('user_id', data.user_id);
    localStorage.setItem('username', data.username);
    localStorage.setItem('token', data.token);
    localStorage.setItem('last_login', data.last_login);
}

const clearUserSessionData = () => {
    localStorage.removeItem('user_id');
    localStorage.removeItem('username');
    localStorage.removeItem('token');
    localStorage.removeItem('last_login');
}