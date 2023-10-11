const initApp = () => {
    
    let map = initMap();

    getPlaces()
    .then(data => {
        if(data.status == 'success'){
            createMarkers(map, data.message);
            showBeachFromParam(map);
            initializeAllListeners(map);
        }
    })
    .catch(error => {
        console.error(error);
    }); 
}

window.onload = () => {
    initApp();
}