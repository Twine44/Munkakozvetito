<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');

adminDisplay();

//go back to the previous page
echo "<div id='previous-page'>";
echo '<a href="logged_admin.php">Vissza</a>';
echo "</div>";
?>
<div class="container">
    <h2 class="stat-title">Statisztikák</h2>
    <div id="oneYearUsers">
        <h4 class="stat-title">Azok a felhasználók, akik már 1 éve regisztráltak, de még nem jelentkeztek képzésre:</h4>
        <?php oneYearUsersWithoutCourse(); ?>
    </div>
    <div id="threeJobOff">

    </div>
    <div id="mostPopJobs">
        <h4 class="stat-title">A legnépszerűbb munkaköri pozíciók települések szerint, népszerűség szerint csökkenő, település szerint növekvő sorrendben:</h4>
        <?php mostPopularJobs(); ?>
    </div>

    <div id="lessThanHalf">
        <h4 class="stat-title">Képzések ahol a jelentkezések száma nem éri el a maximum létszám felét:</h4>
        <?php lessThanHalfApply(); ?>
    </div>
</div>