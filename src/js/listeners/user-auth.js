const addUserAuthEventListeners = () => {
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    const logoutButton = document.getElementById('logout-action');
    const loginAction = document.getElementById('login-action');
    const registerAction = document.getElementById('register-action');

    registerForm.addEventListener('submit', (event) => {
        event.preventDefault();
        authUser(registerForm, USER_REGISTER_URL);
    });

    registerAction.addEventListener('click', () => {
        openPopup('register-container');
    });

    loginForm.addEventListener('submit', (event) => {
        event.preventDefault();
        authUser(loginForm, USER_LOGIN_URL);
    });

    if(loginAction != null){
        loginAction.addEventListener('click', () => {
            openPopup('login-container');
        });
    }

    if(logoutButton != null){
        logoutButton.addEventListener('click', () => {
            logoutUser();
        });
    }
}