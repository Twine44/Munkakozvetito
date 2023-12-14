<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $success=false;
    //process Course data
    if (
        isset($_POST["courseName"]) && !empty(trim($_POST["courseName"])) && isset($_POST["level"]) &&
        !empty(trim($_POST["level"])) && isset($_POST["profession"]) && !empty(trim($_POST["profession"])) &&
        isset($_POST["price"]) && !empty(trim($_POST["price"])) && isset($_POST["startDate"]) && !empty(trim($_POST["startDate"])) &&
        isset($_POST["endDate"]) && !empty(trim($_POST["endDate"])) && isset($_POST["maxEntry"]) && !empty(trim($_POST["maxEntry"]))
    ) 
    {
        $courseName = $_POST["courseName"];
        $level = $_POST["level"];
        $profession = $_POST["profession"];
        $price = $_POST["price"];
        $startDate = $_POST["startDate"];
        $endDate = $_POST["endDate"];
        $maxEntry = $_POST["maxEntry"];

        $sqlExist="SELECT kepzes_id FROM kepzes WHERE nev='$courseName' AND szint='$level' AND megnevezes='$profession' AND ar=$price;";
        $resultExist=$conn->query($sqlExist);
        if($resultExist->num_rows!=1){
            $sqlCourse = "INSERT INTO kepzes(nev, szint, megnevezes, ar, kezdes_datuma, befejezes_datuma, max_letszam) VALUES ('$courseName','$level','$profession',$price,'$startDate','$endDate','$maxEntry');";
            $conn->query($sqlCourse);
            $success=true;
        } 
    }
}
adminDisplay();

//go back to the previous page
echo "<div id='previous-page'>";
echo '<a href="manager.php">Vissza</a>';
echo "</div>";
?>
<div class="container">
    <h2>Képzés hozzáadása</h2>
    <form method="POST" class="custom-form" id="course-form">
        <label for="courseName">képzés neve:</label><br><input type="text" id="courseName" name="courseName" required><br>
        <label for="level">szint:</label><br><input type="text" id="level" name="level" required><br>
        <label for="profession">megnevezés:</label><br><input type="text" id="profession" name="profession" required><br>
        <label for="price">ár:</label><br><input type="number" id="price" name="price" required><br>
        <label for="startDate">kezdés dátuma:</label><br><input type="date" id="startDate" name="startDate" required><br>
        <label for="endDate">befejezés dátuma:</label><br><input type="date" id="endDate" name="endDate" required><br>
        <label for="maxEntry">max létszám::</label><br><input type="number" id="maxEntry" name="maxEntry" required><br>
        <button type="submit" class="addremoveItemBtn">Képzés hozzáadása</button><br>
        <?php
        if (isset($success) && $success) {
            echo "<br><span class='err-msg'><span class='mark'>✔</span> Sikeres hozzáadás.</span>";
        } else if (isset($success) && !$success) {
            echo "<br><span class='err-msg'><span class='mark'>X</span> Sikerestelen hozzáadás.</span>";
        }
        ?>
    </form>
</div>


</body>

</html>