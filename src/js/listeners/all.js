const initializeAllListeners = (map) => {
    addSideMenuListeners();
    addTabsEventListeners();
    addPopupCloseEventListeners();

    addUserAuthEventListeners();
    addUserNavigationContentListeners();
    addMapEventListeners(map);

    addPlaceEventListeners(map);
    addPhotoEventListeners();
    addCommentsEventListeners();
}

