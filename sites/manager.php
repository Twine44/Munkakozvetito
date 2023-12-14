<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');
?>

    <?php
    
    adminDisplay();

    //go back to the previous page
    echo "<div id='previous-page'>";
    echo '<a href="logged_admin.php">Vissza</a>';
    echo "</div>";
    ?>
    <div class="container" id="margin-top-wtitle">
    <h2>Kezelőfelület</h2>
    <div class="admin-options">
    <a href="manage_comp.php"><div>Cégek kezelése</div></a>
    <a href="manage_course.php"><div>Képzések kezelése</div></a>
    <a href="manage_jobs.php"><div>Állásajánlatok kezelése</div></a>
    </div>
    </div>
    </body>

    </html>