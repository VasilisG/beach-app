<div id="user-content-container" class="user-content-container popup-container <?= isset($_SESSION['user_id']) ? 'logged-user-container' : '' ?>">
    <div class="close-popup-container">
        <span class="popup-title">User Content</span>
        <span class="close-popup">
            <i class="fa-sharp fa-solid fa-xmark"></i>
        </span>
    </div>
    <div id="view-beach-tab-container" class="tab-container">
        <ul class="user-tabs tabs">
            <li class="tab user-content-tab info-tab active-tab" data-view="info-view"><i class="fa-solid fa-umbrella-beach"></i><span>Places</span></li>
            <li class="tab user-content-tab photo-tab" data-view="photo-view"><i class="fa-sharp fa-solid fa-images"></i><span>Photos</span><span class="photo-total"></span></li>
            <li class="tab user-content-tab comment-tab" data-view="comment-view"><i class="fa-solid fa-comment"></i><span>Comments</span><span class="comment-total"></span></li>
        </ul>
    </div>
    <hr class="section-hr">
    <div class="section-view-container">
        <div class="user-section-view section-view place-view active-section-view">
            <div id="user-places" class="user-places"></div>
        </div>
        <div class="user-section-view section-view photo-view">
            <div id="user-photos" class="user-photos"></div>
        </div>
        <div class="user-section-view section-view comment-view">
            <div id="user-comments" class="user-comments place-comments"></div>
        </div>
    </div>
</div>