const closePopup = () => {
    let activePopup = document.querySelector('.popup-container-active');
    if(activePopup != null){
        activePopup.classList.remove('popup-container-active');
    }
}

const closeAllPopups = () => {
    let popups = document.getElementsByClassName('popup-container');
    for(popup of popups){
        popup.classList.remove('popup-container-active');
    }
}

const resetPopupForm = (popupClass) => {
    let popup = document.querySelector('.' + popupClass);
    let form = popup.querySelector('.ui-form');
    let addCommentForm = popup.querySelector('.add-comment-form');
    let addPhotoForm = popup.querySelector('.add-photo-form');
    let outputMessageContainer = popup.querySelector('.output-message-container');

    if(outputMessageContainer != null){
        outputMessageContainer.classList.remove('output-message-container-active');
        let outputMessage = popup.querySelector('.output-message');
        outputMessage.classList.remove('success-message');
        outputMessage.classList.remove('error-message');
    }

    if(form != null){
        if(form.classList.contains('add-beach-form')){
            popup.querySelector('.photo-preview-container').innerHTML = '';
        }
        form.reset();
    }

    if(addCommentForm != null){
        addCommentForm.reset();
    }

    if(addPhotoForm != null){
        document.querySelector('.preview-photos').innerHTML = '';
        addPhotoForm.reset();
    }

    popup.classList.add('popup-container-active');
}

const isPopupOpen = (popupClass) => {
    let popup = document.querySelector('.' + popupClass);
    if(popup != null){
        return popup.classList.contains('popup-container-active');
    }
    else return false;
}

const openPopup = (popupClass) => {
    let currentPopup = document.querySelector('.' + popupClass);
    if(currentPopup != null && !currentPopup.classList.contains('popup-container-active')){
        closeAllPopups();
        resetPopupForm(popupClass);
    }
}

const addPopupCloseEventListeners = () => {
    const popupCloseButtons = document.getElementsByClassName('close-popup');
    for(popupCloseButton of popupCloseButtons){
        popupCloseButton.addEventListener('click', function(){
            closePopup();
        });
    }
}