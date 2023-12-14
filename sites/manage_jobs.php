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
    echo '<a href="manager.php">Vissza</a>';
    echo "</div>";
    ?>
    <?php
    echo '<div class="container">';
    echo "<h2>Állásajánlatok Módosítása/Hozzáadása</h2>";
    echo '<a href="job.php" id="newJob-btn">➕ Új állásajánlat</a>';
    echo '<div class="table-container">';
    modifyJobs();
    echo '</div>';
    echo '</div>';
    ?>
    </body>

</html>
