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
    <h2>Felhasználó kiválasztása</h2>
<div class="table-container">
    <?php readUsers(); ?>
</div>
</div>
</body>

</html>