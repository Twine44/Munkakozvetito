<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");

echo file_get_contents('../html/head.html');
$userExist = false;
if (isset($_GET['id'])) {
    $selected_uid = $_GET['id'];

    //check if a User is exist with the selected id
    $sqlUser = "SELECT nev FROM felhasznalok WHERE felhasznalo_id = $selected_uid;";
    $result = $conn->query($sqlUser);
    $userExist = $result->num_rows == 1;
}

//POST
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id']))) {
    if (isset($_POST["applyBtn"])) {
        list($course_id, $purpose) = explode(":", $_POST["applyBtn"]);
        if ($purpose == "Jelentkezés") {
            $sqlApplied = "SELECT kepzes.max_letszam, COUNT(resztvevok.felhasznalo_id) AS letszam 
            FROM kepzes 
            LEFT JOIN resztvevok ON kepzes.kepzes_id = resztvevok.kepzes_id
            WHERE kepzes.kepzes_id = $course_id
            GROUP BY kepzes.kepzes_id;";

            //check if the course is full
            $resultApplied = $conn->query($sqlApplied);
            $row = $resultApplied->fetch_array();
            if($row[0]>$row[1]){
                $sqlApply = "INSERT INTO resztvevok(kepzes_id, felhasznalo_id) VALUES ($course_id,$selected_uid);";
                $conn->query($sqlApply);
                header("Refresh:0");
            }
        } else if ($purpose == "Lejelentkezés") {
            $sqlRefuse = "DELETE FROM resztvevok WHERE resztvevok.kepzes_id=$course_id AND resztvevok.felhasznalo_id=$selected_uid;";
            $conn->query($sqlRefuse);
            header("Refresh:0");
        }
    }
}
?>
<?php

adminDisplay();

//go back to the previous page
echo "<div id='previous-page'>";
echo '<a href="users.php">Vissza</a>';
echo "</div>";
?>
<div class="container">
<h2>Jelentkezés Kurzusokra</h2>

<?php
if (isset($_GET['id']) && $userExist) {
    $sqlName = "SELECT nev FROM felhasznalok WHERE felhasznalo_id = $selected_uid;";
    $resultName = $conn->query($sqlName);
    $row = $resultName->fetch_array();
    echo "<h4>Kiválasztott felhasználó - id: $selected_uid, név: $row[0]</h4>";
    echo '<div class="table-container">';
    applyCourses($selected_uid);
    echo '</table>';
} else {
    echo "Ilyen ID-val nem létezik Felhasználó az adatbázisban.";
}
?>
</div>
</body>

</html>
