const addCommentsEventListeners = () => {
    const addCommentForm = document.getElementById('add-comment-form');
    const placeComments = document.getElementById('place-comments');
    const userContentContainer = document.getElementById('user-content-container');
    const userComments = userContentContainer.querySelector('.user-comments');

    if(addCommentForm != null){
        addCommentForm.addEventListener('submit', (event) => {
            event.preventDefault();
            addCommentForm.querySelector('.add-comment-button').disable = true;
            let placeId = document.getElementById('view-beach-container').getAttribute('place_id');
            let commentFormData = getFormData(addCommentForm);
            commentFormData.append('place_id', placeId);
            addComment(commentFormData)
            .then(data => {
                if(data.status == 'success') {
                    getCommentsBy('place_id', placeId)
                    .then((newData) => {
                        if(newData.status == 'success'){
                            createComments(newData.comments);
                        }
                        showPopupMessage(newData.status, newData.message);
                    });
                }
                else showPopupMessage(data.status, data.message);
                addCommentForm.reset();
                addCommentForm.querySelector('.add-comment-button').disable = false;
                
            });
        });
    }

    placeComments.addEventListener('click', (event) => {
        event.preventDefault();
        if(event.target.classList.contains('delete-comment-action')){
            confirmAction('Are you sure you want to delete this comment?', () => {
                let placeId = document.getElementById('view-beach-container').getAttribute('place_id');
                let commentId = event.target.getAttribute('comment-id');
                let commentFormData = new FormData();
                commentFormData.append('comment_id', commentId);
                deleteComment(commentFormData)
                .then(data => {
                    if(data.status == 'success'){
                        getCommentsBy('place_id', placeId)
                        .then((newData) => {
                            if(newData.status == 'success'){
                                createComments(newData.comments);
                            }
                            showPopupMessage(newData.status, newData.message);
                        });
                    }
                    showPopupMessage(data.status, data.message);
                }); 
            });
        }
    });

    userComments.addEventListener('click', (event) => {
        if(event.target.classList.contains('delete-comment-action')){
            confirmAction('Are you sure you want to delete this comment?', () => {
                let placeId = event.target.getAttribute('place-id');
                let commentId = event.target.getAttribute('comment-id');
                let commentFormData = new FormData();
                commentFormData.append('comment_id', commentId);
                deleteComment(commentFormData)
                .then(data => {
                    if(data.status == 'success'){
                        removeUserElement('comment', commentId);
                        let placeGroup = userComments.querySelector('.place-group[place-id="' +  placeId + '"]');
                        if(placeGroup != null){
                            let placeGroupComments = placeGroup.querySelector('.place-group-comments');
                            if(placeGroupComments.children.length == 0){
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