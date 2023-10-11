const showPopupMessage = (type, message) => {
    let infoPopup = document.getElementById('info-popup');
    infoPopup.querySelector('.info-popup-message').innerHTML = message;
    infoPopup.classList.remove('success-info');
    infoPopup.classList.remove('error-info');
    infoPopup.classList.add(type + '-info');
    infoPopup.classList.add('info-popup-active');
    setTimeout(() => {
        infoPopup.classList.remove('info-popup-active');
    }, 2500);
}