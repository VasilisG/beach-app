const menuClose = document.getElementById('menu-close');
const menuToggle = document.getElementById('menu-toggle');
const menuToggleIcon = menuToggle.querySelector('.fa-bars');
const menuContainer = document.getElementById('menu-container');
const body = document.querySelector('body');

const toggleSideMenu = () => {
    menuToggle.classList.toggle('menu-toggle-active');
    menuContainer.classList.toggle('menu-container-active');
    menuToggleIcon.classList.toggle('fa-xmark');
}

const closeSideMenu = () => {
    menuToggle.classList.remove('menu-toggle-active');
    menuContainer.classList.remove('menu-container-active');
    menuToggleIcon.classList.remove('fa-xmark');
}

const addSideMenuListeners = () => {
    menuToggle.addEventListener('click', (event) => {
        event.stopPropagation();
        toggleSideMenu();
    });

    menuClose.addEventListener('click', (event) => {
        event.stopPropagation();
        toggleSideMenu();
    });

    body.addEventListener('click', () => {
        closeSideMenu();
    });
}