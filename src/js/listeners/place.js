const addPlaceEventListeners = (map) => {
    const userContentContainer = document.getElementById('user-content-container');
    const userPlaces = userContentContainer.querySelector('.user-places');
    const addBeachForm = document.getElementById('add-beach-form');
    const deletePlaceAction = document.getElementById('delete-place-action');

    addBeachForm.addEventListener('submit', (event) => {
        event.preventDefault();
        let formData = new FormData(addBeachForm);
        addPlace(formData)
        .then((data) => {
            if(data.status == 'success'){
                let markerData = JSON.parse(data.result);
                createMarker(map, markerData);
                closePopup();
                addBeachForm.reset();
            }
            showPopupMessage(data.status, data.message);
        });
    });

    addBeachForm.addEventListener('reset', () => {
        let addBeachPopup = document.querySelector('.add-beach-container');
        let previewPhotoContainer = addBeachPopup.querySelector('.photo-preview-container');
        previewPhotoContainer.innerHTML = '';
    });

    if(deletePlaceAction != null){
        deletePlaceAction.addEventListener('click', (event) => {
            event.preventDefault();
            confirmAction('Are you sure you want to delete this place?', () => {
                let placeId = deletePlaceAction.getAttribute('place-id');
                let formData = new FormData()
                formData.append('place_id', placeId);
                deletePlace(formData)
                .then(data => {
                    if(data.status == 'success'){
                        removeMarker(map, placeId);
                        closePopup();
                    }
                    showPopupMessage(data.status, data.message);
                });
            });
        });
    }

    userPlaces.addEventListener('click', (event) => {
        if(event.target.classList.contains('view-place-action')){
            getPlaceDetails(event.target.getAttribute('place-id'))
            .then(data => {
                if(data.status == 'success'){
                    createPlaceDetails(map, data.message);
                    openPopup('view-beach-container');
                }
                else showPopupMessage(data.status, data.message);
            });
        }
        if(event.target.classList.contains('delete-place-action')){
            confirmAction('Are you sure you want to delete this place?', () => {
                let placeId = event.target.getAttribute('place-id');
                let formData = new FormData()
                formData.append('place_id', placeId);
                deletePlace(formData)
                .then(data => {
                    if(data.status == 'success'){
                        removeUserElement('place', placeId);
                    }
                    showPopupMessage(data.status, data.message);
                });
            });
        }
        if(event.target.classList.contains('share-place-action')){
            navigator.clipboard.writeText(window.location.origin + '/beachapp?p=' + event.target.getAttribute('place-id'));
            showPopupMessage('success', 'Place URL copied to clipboard.');
        }
    });
}