const createPlaceDetails = (map, markerData) => {
    createBasicInfo(map, markerData.place);
    createPhotos(markerData.photos);
    createComments(markerData.comments);
    resetTabs();
}

const resetTabs = () => {
    document.querySelector('.photo-tab').classList.remove('active-tab');
    document.querySelector('.comment-tab').classList.remove('active-tab');
    document.querySelector('.info-tab').classList.add('active-tab');
    document.querySelector('.photo-view').classList.remove('active-section-view');
    document.querySelector('.comment-view').classList.remove('active-section-view');
    document.querySelector('.info-view').classList.add('active-section-view');
}

const createBasicInfo = (map, markerPlace) => {
    document.querySelector('.view-beach-container').setAttribute('place_id', markerPlace.place_id);
    document.querySelector('.section-title-name').textContent = markerPlace.name;

    let tabContainer = document.getElementById('view-beach-tab-container');

    let actionContainer = document.createElement('div');
    actionContainer.classList.add('actions-container');

    let shareActionElem = tabContainer.querySelector('.share-place-action');
    if(shareActionElem != null){
        shareActionElem.remove();
    }
    shareActionElem = document.createElement('a');
    shareActionElem.classList.add('share-place-action');
    shareActionElem.textContent = 'Share';
    shareActionElem.setAttribute('place-id', markerPlace.place_id);
    shareActionElem.addEventListener('click', (event) => {
        navigator.clipboard.writeText(window.location.origin + '/beachapp?p=' + event.target.getAttribute('place-id'));
        showPopupMessage('success', 'Place URL copied to clipboard.');
    });

    actionContainer.appendChild(shareActionElem);

    if(userCreatedContent(markerPlace.user_id)){

        let deleteActionElem = tabContainer.querySelector('.delete-place-action');
        if(deleteActionElem != null){
            deleteActionElem.remove();
        }
        deleteActionElem = document.createElement('a');
        deleteActionElem.classList.add('delete-place-action');
        deleteActionElem.textContent = 'Delete Place';
        deleteActionElem.setAttribute('place-id', markerPlace.place_id);
        deleteActionElem.addEventListener('click', (event) => {
            event.preventDefault();
            confirmAction('Are you sure you want to delete this place?', () => {
                let placeId = deleteActionElem.getAttribute('place-id');
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

        actionContainer.appendChild(deleteActionElem);
    }

    tabContainer.appendChild(actionContainer);

    if(markerPlace.description.length > 0){
        document.querySelector('.description-wrapper').innerHTML = markerPlace.description;
    }
    else document.querySelector('.description-wrapper').innerHTML = '- No description available. -';
}

const createPhotos = (markerPhotos) => {
    let photosTotal = document.querySelector('.photo-total');
    photosTotal.innerHTML = '(' + markerPhotos.length + ')';

    let viewBeachContainer = document.querySelector('.view-beach-container');
    let placePhotos = viewBeachContainer.querySelector('.place-photos');
    placePhotos.innerHTML = '';
    if(markerPhotos.length > 0){
        markerPhotos.forEach((photo) => {
            addPhotoElement(photo, placePhotos);
        });
    }
}

const addPhotoElement = (photo, placePhotos) => {
    let placePhoto = document.createElement('div');
    placePhoto.id = 'place-photo-' + photo.photo_id;
    placePhoto.classList.add('place-photo');
    placePhoto.setAttribute('user-id', photo.user_id);

    let datePosted = photo.date_created.split(' ')[0];
    
    let placePhotoLink = document.createElement('a');
    placePhotoLink.href = photo.filename;
    placePhotoLink.setAttribute('data-lightbox', 'beach-photos');
    placePhotoLink.setAttribute('data-title', 'posted by ' + photo.username + ' on ' + datePosted);

    let placePhotoImage = document.createElement('img');
    placePhotoImage.classList.add('place-photo-image');
    placePhotoImage.src = photo.filename;
    placePhotoImage.alt = 'Image';

    placePhotoLink.appendChild(placePhotoImage);

    let placePhotoInfo = document.createElement('div');
    placePhotoInfo.classList.add('place-photo-info');

    let placePhotoInfoName = document.createElement('span');
    placePhotoInfoName.classList.add('place-photo-info-name');
    placePhotoInfoName.textContent = photo.username;

    let placePhotoInfoPosted = document.createElement('span');
    placePhotoInfoPosted.classList.add('place-photo-info-posted');
    placePhotoInfoPosted.textContent = datePosted;

    placePhotoInfo.appendChild(placePhotoInfoName);
    placePhotoInfo.appendChild(placePhotoInfoPosted);

    placePhoto.appendChild(placePhotoLink);
    placePhoto.appendChild(placePhotoInfo);

    if(userCreatedContent(photo.user_id)){
        let placePhotoActions = document.createElement('div');
        placePhotoActions.classList.add('place-photo-actions');
        
        let placePhotoAction = document.createElement('a');
        placePhotoAction.classList.add('delete-photo-action');
        placePhotoAction.setAttribute('user-id', localStorage.getItem('user_id'));
        placePhotoAction.setAttribute('photo-id', photo.photo_id);
        placePhotoAction.innerHTML = '<span>Delete</span>';

        placePhotoActions.appendChild(placePhotoAction);
        placePhoto.appendChild(placePhotoActions);
    }

    placePhotos.appendChild(placePhoto);
}

const createComments = (markerComments) => {
    let commentsTotal = document.querySelector('.comment-total');
    commentsTotal.innerHTML = '(' + markerComments.length + ')';
    
    let placeComments = document.querySelector('.place-comments');
    placeComments.innerHTML = '';
    if(markerComments.length > 0){
        markerComments.forEach(comment => {
            addCommentElement(comment, placeComments);
        });
    }
}

const addCommentElement = (comment, placeComments) => {
    let placeComment = document.createElement('div');
    placeComment.id = 'place-comment-' + comment.comment_id;
    placeComment.classList.add('place-comment');
    if(userCreatedContent(comment.user_id)){
        placeComment.classList.add('own-comment');
    }

    let placeCommentInfo = document.createElement('div');
    placeCommentInfo.classList.add('place-comment-info');

    let commentCreator = document.createElement('span');
    commentCreator.classList.add('comment-creator');
    if(userCreatedContent(comment.user_id)){
        commentCreator.innerHTML = 'posted by <span class="comment-creator-name">You</span>';
    }
    else commentCreator.innerHTML = 'posted by <span class="comment-creator-name">' + comment.username + '</span>';

    let commentCreationDate = document.createElement('span');
    commentCreationDate.classList.add('comment-creation-date');
    commentCreationDate.innerHTML = '<span class="comment-creation-date-info">' + comment.date_created.split(' ')[0] + '</span>';

    let placeCommentContent = document.createElement('div');
    placeCommentContent.classList.add('place-comment-content');
    placeCommentContent.innerHTML = comment.content;

    placeCommentInfo.appendChild(commentCreator);
    placeCommentInfo.appendChild(commentCreationDate);

    placeComment.appendChild(placeCommentInfo);
    placeComment.appendChild(placeCommentContent);

    if(userCreatedContent(comment.user_id)){
        let commentDeleteContainer = document.createElement('div');
        commentDeleteContainer.classList.add('place-comment-actions');

        let commentDeleteAction = document.createElement('a');
        commentDeleteAction.classList.add('delete-comment-action');
        commentDeleteAction.setAttribute('comment-id', comment.comment_id);
        commentDeleteAction.title = 'Delete Comment';

        commentDeleteContainer.appendChild(commentDeleteAction);
        placeComment.appendChild(commentDeleteContainer);
    }

    placeComments.appendChild(placeComment);
}

const deleteCommentElement = (commentId) => {
    deleteElement('place-comment-', commentId);
}

const deletePhotoElement = (photoId) => {
    deleteElement('place-photo-', photoId);
}

const deleteElement = (elemPrefix, elemId) => {
    let element = document.getElementById(elemPrefix + elemId);
    if(element != null){
        element.remove();
    }
}