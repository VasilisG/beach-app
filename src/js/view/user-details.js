const createUserContent = (data) => {
    createUserPlaces(data.places);
    createUserPhotos(data.photos, data.places);
    createUserComments(data.comments, data.places);
}

const createUserPlaces = (places) => {
    let userPlaces = document.getElementById('user-places');
    userPlaces.innerHTML = '';

    for(let placeId in places){
        let placeElement = document.createElement('div');
        placeElement.classList.add('user-place');
        placeElement.setAttribute('place-id', placeId);
        
        let placeName = document.createElement('span');
        placeName.classList.add('user-place-name');
        placeName.textContent = places[placeId];

        let placeActions = document.createElement('div');
        placeActions.classList.add('user-place-actions');

        let shareAction = document.createElement('a');
        shareAction.classList.add('share-place-action');
        shareAction.setAttribute('place-id', placeId);
        shareAction.textContent = 'Share';

        let viewAction = document.createElement('a');
        viewAction.classList.add('view-place-action');
        viewAction.setAttribute('place-id', placeId);
        viewAction.textContent = 'View';

        let deleteAction = document.createElement('a');
        deleteAction.classList.add('delete-place-action');
        deleteAction.setAttribute('place-id', placeId);
        deleteAction.textContent = 'Delete';

        placeActions.appendChild(shareAction);
        placeActions.appendChild(viewAction);
        placeActions.appendChild(deleteAction);

        placeElement.appendChild(placeName);
        placeElement.appendChild(placeActions);

        userPlaces.appendChild(placeElement);
    }
}

const createUserPhotos = (photos, places) => {
    let userPhotos = document.getElementById('user-photos');
    userPhotos.innerHTML = '';

    for(let placeId in photos){

        let placeGroup = document.createElement('div');
        placeGroup.classList.add('place-group');
        placeGroup.setAttribute('place-id', placeId);

        let placeGroupNameContainer = document.createElement('div');
        placeGroupNameContainer.classList.add('place-group-name-container');

        let placeGroupName = document.createElement('span');
        placeGroupName.classList.add('place-group-name');
        placeGroupName.textContent = places[placeId];

        placeGroupNameContainer.appendChild(placeGroupName);
        placeGroup.appendChild(placeGroupNameContainer);

        let placeGroupPhotos = document.createElement('div');
        placeGroupPhotos.classList.add('place-photos');
        placeGroupPhotos.classList.add('place-group-photos');

        photos[placeId].forEach(placePhoto => {

            let creationDate = placePhoto.date_created.split(' ')[0];

            let placePhotoElement = document.createElement('div');
            placePhotoElement.classList.add('place-photo');
            placePhotoElement.classList.add('user-photo');
            placePhotoElement.setAttribute('photo-id', placePhoto.photo_id);
            placePhotoElement.setAttribute('user-id', localStorage.getItem('user_id'));

            let placeLink = document.createElement('a');
            placeLink.href = placePhoto.filename;
            placeLink.setAttribute('data-lightbox', 'beach-photos-' + placeId);
            placeLink.setAttribute('data-title', 'posted on ' + creationDate);

            let placeImage = document.createElement('img');
            placeImage.src = placePhoto.filename;
            placeImage.alt = 'Image';
            placeImage.classList.add('place-photo-image');

            placeLink.appendChild(placeImage);

            let placePhotoInfo = document.createElement('div');
            placePhotoInfo.classList.add('place-photo-info');
            
            let placePhotoInfoPosted = document.createElement('span');
            placePhotoInfoPosted.classList.add('place-photo-info-posted');
            placePhotoInfoPosted.textContent = creationDate;

            placePhotoInfo.appendChild(placePhotoInfoPosted);

            let placePhotoActions = document.createElement('div');
            placePhotoActions.classList.add('place-photo-actions');

            let deletePhotoAction = document.createElement('a');
            deletePhotoAction.classList.add('delete-photo-action');
            deletePhotoAction.setAttribute('user-id', localStorage.getItem('user_id'));
            deletePhotoAction.setAttribute('photo-id', placePhoto.photo_id);
            deletePhotoAction.setAttribute('place-id', placePhoto.place_id);

            placePhotoActions.appendChild(deletePhotoAction);

            placePhotoElement.appendChild(placeLink);
            placePhotoElement.appendChild(placePhotoInfo);
            placePhotoElement.appendChild(placePhotoActions);

            placeGroupPhotos.appendChild(placePhotoElement);
        });

        placeGroup.appendChild(placeGroupPhotos);
        userPhotos.appendChild(placeGroup);
    }
}

const createUserComments = (comments, places) => {
    let userComments = document.getElementById('user-comments');
    userComments.innerHTML = '';

    for(let placeId in comments){

        let placeGroup = document.createElement('div');
        placeGroup.classList.add('place-group');
        placeGroup.setAttribute('place-id', placeId);

        let placeGroupNameContainer = document.createElement('div');
        placeGroupNameContainer.classList.add('place-group-name-container');

        let placeGroupName = document.createElement('span');
        placeGroupName.classList.add('place-group-name');
        placeGroupName.textContent = comments[placeId][0]['name'];

        placeGroupNameContainer.appendChild(placeGroupName);
        placeGroup.appendChild(placeGroupNameContainer);

        let placeGroupComments = document.createElement('div');
        placeGroupComments.classList.add('place-comments');
        placeGroupComments.classList.add('user-comments');
        placeGroupComments.classList.add('place-group-comments');

        comments[placeId].forEach(placeComment => {

            let creationDate = placeComment.date_created.split(' ')[0];

            let commentElement = document.createElement('div');
            commentElement.classList.add('place-comment');
            commentElement.classList.add('user-comment');
            commentElement.classList.add('own-comment');
            commentElement.setAttribute('comment-id', placeComment.comment_id);
            commentElement.setAttribute('place-id', placeComment.place_id);

            let commentInfo = document.createElement('div');
            commentInfo.classList.add('place-comment-info');

            let commentCreationDate = document.createElement('span');
            commentCreationDate.classList.add('comment-creation-date');

            let commentCreationDateInfo = document.createElement('span');
            commentCreationDateInfo.classList.add('comment-creation-date-info');
            commentCreationDateInfo.textContent = creationDate;

            commentCreationDate.appendChild(commentCreationDateInfo);
            commentInfo.appendChild(commentCreationDate);

            let contentElement = document.createElement('div');
            contentElement.classList.add('place-comment-content');
            contentElement.innerHTML = placeComment.content;

            let commentActions = document.createElement('div');
            commentActions.classList.add('place-comment-actions');

            let commentDeleteAction = document.createElement('a');
            commentDeleteAction.classList.add('delete-comment-action');
            commentDeleteAction.setAttribute('comment-id', placeComment.comment_id);
            commentDeleteAction.setAttribute('place-id', placeComment.place_id);
            commentDeleteAction.setAttribute('title', 'Delete Comment');

            commentActions.appendChild(commentDeleteAction);

            commentElement.appendChild(commentInfo);
            commentElement.appendChild(contentElement);
            commentElement.appendChild(commentActions);

            placeGroupComments.appendChild(commentElement);
        });

        placeGroup.appendChild(placeGroupComments);
        userComments.appendChild(placeGroup);
    }
}

const removeUserElement = (type, elementId) => {
    let placeElement = document.querySelector('.user-' + type + '[' + type + '-id="' + elementId + '"]');
    if(placeElement != null){
        placeElement.remove();
    }
}