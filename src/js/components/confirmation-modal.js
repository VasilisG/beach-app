const confirmAction = (modalMessage, callback) => {
    document.getElementById('modal-message').innerHTML = modalMessage;
    document.getElementById('modal-confirm-button').addEventListener('click', () => {
        callback();
        closeModal();
    });
    document.getElementById('modal-cancel-button').addEventListener('click', () => {
        closeModal();
    });
    document.getElementById('modal-close').addEventListener('click', (event) => {
        event.stopPropagation();
        closeModal();
    })
    openModal();
}

const openModal = () => {
    document.getElementById('modal').classList.add('popup-container-active');
    document.getElementById('modal-overlay').classList.add('modal-overlay-active');
}

const closeModal = () => {
    document.getElementById('modal').classList.remove('popup-container-active');
    document.getElementById('modal-overlay').classList.remove('modal-overlay-active');
}