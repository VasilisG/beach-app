const addPlace = (data) => {
    return fetch(
        PLACE_ADD_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const deletePlace = (data) => {
    return fetch(
        PLACE_DELETE_URL,
        {
            method: 'POST',
            body: data
        }
    )
    .then(response => response.json());
}

const getPlaces = () => {
    return fetch(
        PLACES_GET_URL,
        {
            method: 'GET'
        }
    )
    .then(response => response.json());
}

const getPlaceDetails = (placeId) => {
    return fetch(
        PLACE_DETAILS_URL + placeId,
        {
            method: 'GET'
        }
    )
    .then(response => response.json());
}