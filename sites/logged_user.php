<?php
session_start();
require_once("../config/db.php");
require_once('../config/functions.php');

if (!isLogged()) {
    header('Location: login.php');
}
echo file_get_contents('../html/head.html');

userDisplay();

?>
<div class="container">
    <div class="table-container">
        <?php readJobs(); ?>
    </div>
    <div class="table-container">
        <?php readCourses(); ?>
    </div>
</div>




</body>

</html>