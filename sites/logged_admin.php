<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');
?>
    <?php
    adminDisplay();
    ?>
    <div class="admin-options" id="margin-top">
    <a href="users.php"><div>Jelentkezés képzésre</div></a>
    <a href="manager.php"><div>Kezelőfelület</div></a>
    <a href="statistics.php"><div>Statisztikák</div></a>
    </div>
    </body>

    </html>