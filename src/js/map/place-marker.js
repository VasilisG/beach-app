const placeMarker = L.Marker.extend({
    options: {
        place_id: ''
    }
});

const createMarkers = (map, markers) => {
    markers.forEach(marker => {
        createMarker(map, marker);
    });
}

const createMarker = (map, markerData) => {
    let customMarker = new placeMarker([markerData.lat, markerData.lng], {
        place_id: markerData.place_id
    })
    .bindPopup(markerData.name)
    .on('mouseover', (event) => {
        event.target.openPopup();
    })
    .on('mouseout', (event) => {
        event.target.closePopup();
    })
    .on('click', (event) => {
        getPlaceDetails(event.target.options.place_id)
        .then(detailsData => {
            if(detailsData.status == 'success'){
                createPlaceDetails(map, detailsData.message);
                openPopup('view-beach-container');
            }
            else showPopupMessage(detailsData.status, detailsData.message);
        });
    });
    customMarker.addTo(map);
}

const removeMarker = (map, placeId) => {
    map.eachLayer((layer) => { 
        if(layer instanceof L.Marker && layer.options.place_id == placeId) {
            map.removeLayer(layer);
        }
    });
}