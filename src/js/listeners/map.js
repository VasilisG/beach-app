const addMapEventListeners = (map) => {
    let addPinAction = document.getElementById('add-pin-action');
    let latitudeField = document.getElementById('latitude-field');
    let longitudeField = document.getElementById('longitude-field');
    let isPinningOn = false;

    addPinAction.addEventListener('click', () => {
        if(isPinningOn){
            closePopup();
            map.dragging.enable();
            isPinningOn = false;
        }
        else {
            showMarkerPopup();
            map.dragging.disable();
            isPinningOn = true;
        }
        addPinAction.classList.toggle('menu-toggle-active');
    });

    map.addEventListener('click', (event) => {
        if(isPinningOn){
            if(isUserLoggedIn()){
                openPopup('add-beach-container');
                latitudeField.value = event.latlng.lat;
                longitudeField.value = event.latlng.lng;
            }
            else openPopup('login-container');
        }
        isPinningOn = false;
        map.dragging.enable();
        addPinAction.classList.remove('menu-toggle-active');
    });
}