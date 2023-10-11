const addUserNavigationContentListeners = () => {
    const navActionButtons = document.querySelectorAll('.user-content-action');
    const userContentContainer = document.getElementById('user-content-container');
    const userTabs = userContentContainer.querySelectorAll('.user-content-tab');
    const userSections = userContentContainer.querySelectorAll('.section-view');

    navActionButtons.forEach((navActionButton, index) => {
        navActionButton.addEventListener('click', () => {
            if(isUserLoggedIn()){
                if(isPopupOpen('user-content-container')){
                    toggleSection(userTabs, userSections, index);
                }
                else {
                    getUserContent(localStorage.getItem('user_id'))
                    .then(data => {
                        if(data.status == 'success'){
                            createUserContent(data.message);
                            toggleSection(userTabs, userSections, index);
                            openPopup('user-content-container');
                        }
                        else {
                            showPopupMessage(data.status, data.message);
                        }
                    });
                    
                }
            }
            else openPopup('login-container');
        });
    });
}