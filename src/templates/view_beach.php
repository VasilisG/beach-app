<div id="view-beach-container" class="view-beach-container popup-container <?= isset($_SESSION['user_id']) ? 'logged-user-container' : '' ?>">
    <div class="close-popup-container">
        <span class="popup-title">View Beach</span>
        <span class="close-popup">
            <i class="fa-sharp fa-solid fa-xmark"></i>
        </span>
    </div>
    <div id="view-beach-tab-container" class="tab-container">
        <ul class="tabs">
            <li class="tab info-tab active-tab" data-view="info-view"><i class="fa-solid fa-umbrella-beach"></i><span>Info</span></li>
            <li class="tab photo-tab" data-view="photo-view"><i class="fa-sharp fa-solid fa-images"></i><span>Photos</span><span class="photo-total"></span></li>
            <li class="tab comment-tab" data-view="comment-view"><i class="fa-solid fa-comment"></i><span>Comments</span><span class="comment-total"></span></li>
        </ul>
    </div>
    <hr class="section-hr">
    <div class="section-view-container">
        <div class="section-view info-view active-section-view">
            <div class="section-inner place-name-inner">
                <div class="section-wrapper name-wrapper">
                    <p class="section-title-name"></p>
                </div>
            </div>
            <div class="section-inner place-description-inner">
                <h3 class="section-title">Description</h3>
                <div class="section-wrapper description-wrapper"></div>
            </div>
        </div>
        <div class="section-view photo-view">
            <div id="place-photos" class="place-photos"></div>
            <?php if(isset($_SESSION['token'])): ?>
                <div class="add-action-container">
                    <form id="add-photo-form" class="add-photo-form" action="" method="POST">
                        <div class="preview-photos place-photos"></div>
                        <div class="field-container submit-container">
                            <input multiple="true" type="file" class="photo-field" id="place-photo-field" name="photos[]">
                            <label for="place-photo-field" class="select-photo-button submit-button">Select</label>
                            <button type="submit" class="upload-photo-button submit-button">Upload</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
        <div class="section-view comment-view">
            <div id="place-comments" class="place-comments"></div>
            <?php if(isset($_SESSION['token'])): ?>
                <div class="add-action-container">
                    <form id="add-comment-form" class="add-comment-form" action="" method="POST">
                        <div class="field-container item-field-container">
                            <textarea class="comment-field item-field" name="user-comment" id="user-comment-field" placeholder="Enter a comment..." rows="3" required></textarea>
                        </div>
                        <div class="field-container submit-container">
                            <button type="submit" class="add-comment-button submit-button" title="Add comment"><i class="fa-regular fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>