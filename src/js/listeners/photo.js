const addPhotoEventListeners = () => {
    const photoField = document.getElementById('photo-field');
    const photoPreviewContainer = document.querySelector('.photo-preview-container');

    const detailsPhotoField = document.getElementById('place-photo-field');
    const detailsPhotoPreviewContainer = document.querySelector('.preview-photos');

    const addPhotoForm = document.getElementById('add-photo-form');
    const placePhotos = document.getElementById('place-photos');
    
    const userContentContainer = document.getElementById('user-content-container');
    const userPhotos = userContentContainer.querySelector('.user-photos');

    if(addPhotoForm != null){
        const previewPhotos = addPhotoForm.querySelector('.preview-photos');
        addPhotoForm.addEventListener('submit', (event) => {
            event.preventDefault();
            document.querySelector('.upload-photo-button').disable = true;
            let placeId = document.getElementById('view-beach-container').getAttribute('place_id');
            let photoFormData = getFormData(addPhotoForm);
            photoFormData.append('place_id', placeId);
            addPhoto(photoFormData)
            .then(data => {
                if(data.status == 'success'){
                    getPhotos({'place_id' : placeId})
                    .then(data => {
                        if(data.status == 'success'){
                            createPhotos(JSON.parse(data.message));
                        }
                        showPopupMessage(data.status, 'Photos uploaded.');
                    });
                }
                else showPopupMessage(data.status, data.message);

                addPhotoForm.reset();
                previewPhotos.innerHTML = '';
                document.querySelector('.upload-photo-button').disable = false;
            });
        });
    }

    placePhotos.addEventListener('click', (event) => {
        event.preventDefault();
        if(event.target.classList.contains('delete-photo-action')){
            confirmAction('Are you sure you want to delete this photo?', () => {
                let placeId = document.getElementById('view-beach-container').getAttribute('place_id');
                let photoId = event.target.getAttribute('photo-id');
                let photoFormData = new FormData();
                photoFormData.append('photo_id', photoId);
                deletePhoto(photoFormData)
                .then(data => {
                    if(data.status == 'success'){
                        getPhotos({'place_id' : placeId})
                        .then(data => {
                            if(data.status == 'success'){
                                createPhotos(JSON.parse(data.message));
                            }
                            showPopupMessage(data.status, 'Photo deleted.');
                        });
                    }
                    else {
                        showPopupMessage(data.status, data.message);
                    }
                });
            });
        }
    });

    photoField.addEventListener('change', (event) => {
        if(event.target.files){
            for(let child of photoPreviewContainer.children){
                photoPreviewContainer.removeChild(child);
            }
            for(let photoFile of event.target.files) {
                let previewImage = document.createElement('img');
                previewImage.classList.add('preview-photo');
                previewImage.src = URL.createObjectURL(photoFile);
                previewImage.onload = () => {
                    URL.revokeObjectURL(previewImage.src);
                }
                photoPreviewContainer.appendChild(previewImage);
            }
        }
    });

    if(detailsPhotoField != null){
        detailsPhotoField.addEventListener('change', (event) => {
            if(event.target.files){
                for(let child of detailsPhotoPreviewContainer.children){
                    detailsPhotoPreviewContainer.removeChild(child);
                }
                for(let photoFile of event.target.files) {
                    let previewImage = document.createElement('img');
                    previewImage.classList.add('preview-photo');
                    previewImage.src = URL.createObjectURL(photoFile);
                    previewImage.onload = () => {
                        URL.revokeObjectURL(previewImage.src);
                    }
                    detailsPhotoPreviewContainer.appendChild(previewImage);
                }
            }
        });
    }

    userPhotos.addEventListener('click', (event) => {
        if(event.target.classList.contains('delete-photo-action')){
            confirmAction('Are you sure you want to delete this photo?', () => {
                let placeId = event.target.getAttribute('place-id');
                let photoId = event.target.getAttribute('photo-id');
                let photoFormData = new FormData();
                photoFormData.append('photo_id', photoId);
                deletePhoto(photoFormData)
                .then(data => {
                    if(data.status == 'success'){
                        removeUserElement('photo', photoId);
                        let placeGroup = userPhotos.querySelector('.place-group[place-id="' +  placeId + '"]');
                        if(placeGroup != null){
                            let placeGroupPhotos = placeGroup.querySelector('.place-group-photos');
                            if(placeGroupPhotos.children.length == 0){
                                placeGroup.remove();
                            }
                        }
                    }
                    showPopupMessage(data.status, data.message);
                });
            });
        }
    });
}