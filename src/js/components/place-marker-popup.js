const showMarkerPopup = () => {
    let showMarker = localStorage.getItem('shown_marker_popup');
    if(showMarker == null){
        let markerPopup = document.getElementById('place-marker-popup');
        markerPopup.classList.add('place-marker-active');
        setTimeout(() => {
            markerPopup.classList.remove('place-marker-active');
            localStorage.setItem('shown_marker_popup', 1);
        }, 2000);
    }
}