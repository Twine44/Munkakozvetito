<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');

//set default values - default values means New Job
$job_id = 0;
$cId = 0;
$sId = 0;

if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $success = false;

    //check that every field is filled
    if (
        !empty(trim($_POST['position'])) &&
        isset($_POST['company']) && $_POST['company'] != "Válassz egy céget!" && isset($_POST['companySite']) && $_POST['companySite'] != "Válassz egy telephelyet!" &&
        !empty(trim($_POST['age'])) && !empty(trim($_POST['email'])) && isset($_POST['available']) && isset($_POST['skill'])
    ) {
        if (isset($_GET['id'])) {
            $job_id = $_GET['id'];
        }
        $position = $conn->real_escape_string(trim($_POST['position']));
        $company = $_POST['company'];
        $companySite = $_POST['companySite'];
        $age = $_POST['age'];
        $email = $conn->real_escape_string(trim($_POST['email']));
        $available = $_POST['available'] == "Igen" ? 1 : 0;
        $skills = $_POST['skill'];
        $uId = $_SESSION['id'];

        //modify
        if ($job_id != 0) {
            $sqlExist = "SELECT allas_id FROM allasajanlatok WHERE munkakori_pozicio='$position' AND elvart_eletkor=$age AND kapcsolattarto_email='$email' AND telephely_id=$companySite AND ceg_id=$company AND allas_id!=$job_id;";
            $resultExist = $conn->query($sqlExist);
            if ($resultExist->num_rows == 0) {
                $success = true;
                $sqlJobMod = "UPDATE allasajanlatok SET munkakori_pozicio='$position',elvart_eletkor=$age,kapcsolattarto_email='$email',aktualis=$available,telephely_id=$companySite,ceg_id=$company, felhasznalo_id=$uId WHERE allasajanlatok.allas_id=$job_id;";
                $conn->query($sqlJobMod);

                //query skills for the job from the database and delete records which aren't in the new skill list and add new skills which are not already in the database
                $sqlSkills = "SELECT kepesseg_id FROM kepessegek WHERE allas_id=$job_id;";
                $resultSkills = $conn->query($sqlSkills);
                $containedSkills = array();
                while ($row = $resultSkills->fetch_array()) {
                    $contain = false;
                    for ($i = 0; $i < count($skills); $i++) {
                        if ($skills[$i] == $row[0]) {
                            $contain = true;
                            $containedSkills[] = $row[0];
                            break;
                        }
                    }
                    if (!$contain) {
                        $sqlDel = "DELETE FROM kepessegek WHERE kepesseg_id=$row[0] AND allas_id=$job_id;";
                        $conn->query($sqlDel);
                    }
                }

                for ($i = 0; $i < count($skills); $i++) {
                    $contain = false;
                    for ($j = 0; $j < count($containedSkills); $j++) {
                        if ($skills[$i] == $containedSkills[$j]) {
                            $contain = true;
                            break;
                        }
                    }
                    if (!$contain) {
                        $sqlSkill = "INSERT INTO kepessegek(allas_id, kepesseg_id) VALUES ($job_id,$skills[$i]);";
                        $conn->query($sqlSkill);
                    }
                }
            }
        }
        //new job offer
        else if ($job_id == 0) {
            $sqlExist = "SELECT allas_id FROM allasajanlatok WHERE munkakori_pozicio='$position' AND elvart_eletkor=$age AND kapcsolattarto_email='$email' AND telephely_id=$companySite AND ceg_id=$company;";
            $resultExist = $conn->query($sqlExist);
            if ($resultExist->num_rows == 0) {
                $success = true;
                $sqlJobOffer = "INSERT INTO allasajanlatok( munkakori_pozicio, elvart_eletkor, kapcsolattarto_email, aktualis, felhasznalo_id, telephely_id, ceg_id) VALUES ('$position',$age,'$email',$available, $uId , $companySite,$company);";
                $conn->query($sqlJobOffer);
                $sqlAddedJob = "SELECT allas_id FROM allasajanlatok WHERE ceg_id=$company AND telephely_id=$companySite AND kapcsolattarto_email='$email' AND elvart_eletkor=$age AND munkakori_pozicio='$position';";
                $resultAddedJob = $conn->query($sqlAddedJob);
                $addedId = $resultAddedJob->fetch_array()[0];
                for ($i = 0; $i < count($skills); $i++) {
                    $sqlSkill = "INSERT INTO kepessegek(allas_id, kepesseg_id) VALUES ($addedId,$skills[$i]);";
                    $conn->query($sqlSkill);
                }
            }
        }
    }
}

adminDisplay();

//go back to the previous page
echo "<div id='previous-page'>";
echo '<a href="manage_jobs.php">Vissza</a>';
echo "</div>";

echo "</div>";

//check if there is an ID - ID means Modification
if (isset($_GET["id"])) {
    $job_id = $_GET["id"];
    $sql = "SELECT munkakori_pozicio, elvart_eletkor, kapcsolattarto_email, aktualis, felhasznalo_id, telephely_id, ceg_id FROM allasajanlatok WHERE allas_id=$job_id;";
    $result = $conn->query($sql);

    //check if the Job is really exist in the database
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $position = $row["munkakori_pozicio"];
        $age = $row["elvart_eletkor"];
        $email = $row["kapcsolattarto_email"];
        $available = $row["aktualis"];
        $cId = $row["ceg_id"];
        $sId = $row["telephely_id"];
    } else {
        $job_id = 0;
        header('Location: job.php');
    }
}
?>
<div class="container">
    <h2><?php echo $job_id != 0 ? "Állásajánlat módosítása" : "Állásajánlat hozzáadása"; ?></h2>
    <form method="POST" class="custom-form">
        <label for="position">Pozíció</label><input id="position" name="position" type="text" value="<?php echo $job_id != 0 ? $position : ""; ?>"><br>
        <label for="company">Cég</label><br>
        <select id="company" name="company">
            <option value="default" selected disabled>Válassz egy céget!</option>
            <?php readCompanyNames($cId) ?>
        </select><br>
        <label for="companySite">Telephely</label><br>
        <select id="companySite" name="companySite">
            <option value="default" selected disabled>Válassz telephelyet!</option>
            <?php
            if ($job_id != 0) {
                readCompanySites($cId, $sId);
            } ?>
        </select><br>
        <label for="age">Elvárt életkor</label><input type="number" id="age" name="age" value="<?php echo $job_id != 0 ? $age : ""; ?>"><br>
        <label for="email">Kapcsolattartó email</label><input type="text" id="email" name="email" value="<?php echo $job_id != 0 ? $email : ""; ?>"><br>

        <label>Aktuális-e?</label><br>
        <input type="radio" name="available" value="Igen" id="yes" <?php echo (isset($available) && $available) ? "checked" : ""; ?> class="custom-radiocheckbox">
        <label for="yes">Igen</label><br>
        <input type="radio" name="available" value="Nem" id="no" <?php echo (isset($available) && !$available) ? "checked" : ""; ?> class="custom-radiocheckbox">
        <label for="no">Nem</label>
        <div id="skills">
        <label>Képességek</label><br>
            <?php readSkills($job_id) ?>
        </div>

        <?php
        echo $job_id != 0 ? '<button type="submit" id="submitBtn">Módosítás</button>' : '<button type="submit" id="submitBtn">Létrehozás</button>';

        if (isset($success)) {
            echo $success ? "<br><span class='err-msg'><span class='mark'>✔</span> Sikeres művelet.</span>" : "<br><span class='err-msg'><span class='mark'>X</span> Sikertelen művelet.</span>";
        }
        ?>
    </form>
</div>