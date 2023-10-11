const deletePhoto = (data) => {
    return fetch(
        PHOTO_DELETE_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const addPhoto = (data) => {
    return fetch(
        PHOTO_ADD_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const getPhotos = (params) => {
    return fetch(
        PHOTO_GET_URL + new URLSearchParams(params)
    )
    .then(response => response.json());
}