<div class="add-beach-container popup-container">
    <div class="close-popup-container">
        <span class="popup-title">Add Beach</span>
        <span class="close-popup">
            <i class="fa-sharp fa-solid fa-xmark"></i>
        </span>
    </div>
    <form action="" id="add-beach-form" class="add-beach-form ui-form" method="POST" enctype="multipart/form-data">
        <div class="field-group">
            <div class="field-container item-field-container">
                <input type="text" class="name-field item-field" id="name-field" name="name" placeholder="Beach name..." required>
            </div>
            <div class="field-container item-field-container">
                <textarea type="textarea" class="description-field item-field" id="description-field" name="description" placeholder="Description and information about beach..." rows="8"></textarea>
            </div>
        </div>
        <div class="field-group">
            <div class="field-container item-field-container photo-field-container">
                <label for="photo-field" class="field-label">Add Photos</label>
                <input multiple="true" type="file" class="photo-field" id="photo-field" name="photos[]">
            </div>
            <div class="photo-preview-container"></div>
        </div>
        <div class="field-group">
            <div class="field-container item-field-container">
                <textarea class="comment-field item-field" id="comment-field" name="comment" placeholder="Enter a comment..." rows="4"></textarea>
            </div>
        </div>
        <div class="field-container submit-container">
            <input id="latitude-field" type="hidden" name="latitude" value="" required>
            <input id="longitude-field" type="hidden" name="longitude" value="" required>
            <!-- <button type="submit" class="submit-button" name="add-beach">Add Beach</button> -->
            <input type="submit" class="submit-button" name="add-beach" value="Add Beach">
        </div>
    </form>
    <div class="output-message-container">
        <span class="output-message success-message"></span>
    </div>
</div>