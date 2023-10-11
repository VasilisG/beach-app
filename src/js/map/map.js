const initMap = () => {
    let map = L.map('beach-map', {zoomControl: false}).setView([39.383810, 23.727539], 8);

    L.tileLayer(TILE_LAYER_PROVIDER, {
        maxZoom: 19,
        attribution: TILE_LAYER_ATTRIBUTION
    }).addTo(map);

    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);

    return map;
}