const showBeachFromParam = (map) => {
    let placeParams = new URLSearchParams(window.location.search);
    let placeId = placeParams.get('p');
    if(placeId != null){
        getPlaceDetails(placeId)
        .then(data => {
            if(data.status == 'success'){
                createPlaceDetails(map, data.message);
                openPopup('view-beach-container');
            }
        });
    }
}