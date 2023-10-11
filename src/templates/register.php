<div class="register-container popup-container">
    <div class="close-popup-container">
        <span class="popup-title">Register</span>
        <span class="close-popup">
            <i class="fa-sharp fa-solid fa-xmark"></i>
        </span>
    </div>
    <form action="" id="register-form" class="register-form ui-form" method="POST">
        <div class="field-container user-field-container">
            <input type="text" value="" class="input-field user-field" id="username-field" name="username" placeholder="Username" required>
            <i class="fa fa-user" aria-hidden="true"></i>
        </div>
        <div class="field-container user-field-container">
            <input type="password" value="" class="input-field user-field" id="password-field" name="password" placeholder="Password" required>
            <i class="fa-solid fa-key"></i>
        </div>
        <div class="field-container user-field-container">
            <input type="password" value="" class="input-field user-field" id="confirm-password-field" name="confirm_password" placeholder="Confirm Password" required>
            <i class="fa-solid fa-key"></i>
        </div>
        <div class="field-container submit-container">
            <button type="submit" class="submit-button">Register</button>
        </div>
    </form>
    <div class="output-message-container">
        <span class="output-message success-message"></span>
    </div>
</div>