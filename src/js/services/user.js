const authUser = (form, url) => {
    fetch(
        url,
        {
            method: 'POST',
            body: getPostData(form)
        }
    )
    .then(response => response.json())
    .then(data => {
        if(data.status == 'success'){
            setUserSessionData(data.message);
            window.location.reload();
        }
        else {
            showPopupMessage(data.status, data.message);
        }
        form.reset();
    })
    .catch(error => {
        console.error(error);
    });
}

const getUserContent = (userId) => {
    return fetch(
        USER_CONTENT_URL + userId,
        {
            method: 'GET'
        }
    )
    .then(response => response.json());
}

const logoutUser = () => {
    return fetch(
        USER_LOGOUT_URL,
        {
            method: 'POST'
        }
    )
    .then(response => response.text())
    .then(data => {
        clearUserSessionData();
        window.location.reload();
    })
    .catch(error => {
        console.error(error);
    });
}