<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beach App</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./src/css/styles.css">
    <link rel="stylesheet" href="./src/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"
            integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
            crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" 
            integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" 
            crossorigin="anonymous" 
            referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"
                integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg="
                crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.js" 
            integrity="sha512-0rYcJjaqTGk43zviBim8AEjb8cjUKxwxCqo28py38JFKKBd35yPfNWmwoBLTYORC9j/COqldDc9/d1B7dhRYmg==" 
            crossorigin="anonymous" 
            referrerpolicy="no-referrer"></script>
</head>
<body>
    <?php include_once('./src/templates/map.php'); ?>
    <?php include_once('./src/templates/menu.php'); ?>
    <?php include_once('./src/templates/register.php'); ?>
    <?php include_once('./src/templates/login.php'); ?>
    <?php include_once('./src/templates/add_beach.php'); ?>
    <?php include_once('./src/templates/view_beach.php'); ?>
    <?php include_once('./src/templates/user_content.php'); ?>
    <?php include_once('./src/templates/modal.php'); ?>
    <?php include_once('./src/templates/info_popup.php'); ?>
    <?php include_once('./src/templates/place_marker_info.php'); ?>
    <script src="./src/js/config/config.js"></script>
    <script src="./src/js/components/side-menu.js"></script>
    <script src="./src/js/components/main-popup.js"></script>
    <script src="./src/js/components/info-popup.js"></script>
    <script src="./src/js/components/place-marker-popup.js"></script>
    <script src="./src/js/components/confirmation-modal.js"></script>
    <script src="./src/js/components/section.js"></script>
    <script src="./src/js/map/map.js"></script>
    <script src="./src/js/utils/form-data.js"></script>
    <script src="./src/js/utils/post-data.js"></script>
    <script src="./src/js/utils/session-data.js"></script>
    <script src="./src/js/services/user.js"></script>
    <script src="./src/js/services/comment.js"></script>
    <script src="./src/js/services/photo.js"></script>
    <script src="./src/js/services/place.js"></script>
    <script src="./src/js/view/place-details.js"></script>
    <script src="./src/js/map/place-marker.js"></script>
    <script src="./src/js/view/user-details.js"></script>
    <script src="./src/js/utils/place-data.js"></script>
    <script src="./src/js/listeners/user-auth.js"></script>
    <script src="./src/js/listeners/user-content.js"></script>
    <script src="./src/js/listeners/map.js"></script>
    <script src="./src/js/listeners/place.js"></script>
    <script src="./src/js/listeners/photo.js"></script>
    <script src="./src/js/listeners/comment.js"></script>
    <script src="./src/js/listeners/all.js"></script>
    <script src="./src/js/script.js"></script>
</body>
</html>