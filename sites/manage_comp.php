<?php
session_start();
require_once("../config/db.php");
require_once("../config/functions.php");
echo file_get_contents('../html/head.html');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $success = false;
    if (isset($_POST["companyName"]) && !empty(trim($_POST["companyName"])) && isset($_POST["email"]) && !empty(trim($_POST["email"]))) {
        // process Company data
        $companyName = $_POST["companyName"];
        $email = $_POST["email"];

        //check if the Company name and email is already exist, and check the empty fields
        $sqlExist = 'SELECT ceg_id FROM cegek WHERE cegnev="' . $companyName . '" AND kapcsolattarto_email="' . $email . '";';
        $resultExist = $conn->query($sqlExist);
        if ($resultExist->num_rows != 1) {
            $sqlCompany = 'INSERT INTO cegek( cegnev, kapcsolattarto_email) VALUES ("' . $companyName . '","' . $email . '")';

            // Process Company sites
            $postcodes = $_POST["postcode"];
            $citynames = $_POST["cityname"];
            $addresses = $_POST["address"];
            $houseNumbers = $_POST["houseNumber"];

            //check if any of the Company site inputs are empty
            $emptyfields = false;
            for ($i = 0; $i < count($postcodes); $i++) {
                if (empty($postcodes[$i]) || empty($citynames[$i]) || empty($citynames[$i]) || empty($addresses[$i]) || empty($houseNumbers[$i])) {
                    $emptyfields = true;
                }
            }
            if (!$emptyfields) {
                $sqlCompSites = "INSERT INTO telephely(ceg_id, iranyitoszam, telepules_nev, kozterulet_neve, hazszam) VALUES ";
                $sqlSites = array();

                //create Company
                $conn->query($sqlCompany);

                //query Company id
                $resultCompId = $conn->query($sqlExist);
                $companyId = $resultCompId->fetch_array()[0];

                //iterate over sites and generate database insertion values
                for ($i = 0; $i < count($postcodes); $i++) {
                    $postcode = $postcodes[$i];
                    $cityname = $citynames[$i];
                    $address = $addresses[$i];
                    $houseNumber = $houseNumbers[$i];
                    $sqlSites[] = '(' . $companyId . ', ' . $postcode . ', "' . $cityname . '", "' . $address . '", ' . $houseNumber . ')';
                }

                //add Company sites to the database
                $sitesString = implode(", ", $sqlSites);
                $sqlCompSites .= $sitesString;
                $conn->query($sqlCompSites);
                $success = true;
            }
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
    <h2>Cég hozzáadása</h2>
    <form method="POST" class="custom-form">
        <label for="companyName">cég neve:</label><br><input type="text" id="companyName" name="companyName" required><br>
        <label for="email">e-mail:</label><br><input type="text" id="email" name="email" required><br>

        <fieldset id="comp-fieldset">
            <legend>Telephelyek megadása</legend>
            <div id="siteContainer">
                <div class="site">
                    <h4>Telephely</h4>
                    <label for="postcode">irányítószám:</label><br><input type="number" id="postcode" name="postcode[]" required><br>
                    <label for="cityname">településnév:</label><br><input type="text" id="cityname" name="cityname[]" required><br>
                    <label for="address">közterület neve:</label><br><input type="text" id="address" name="address[]" required><br>
                    <label for="houseNumber">házszám:</label><br><input type="number" id="houseNumber" name="houseNumber[]" required><br>
                </div>
            </div>
            <button type="button" class="addremoveItemBtn" onclick="addItem()">új telephely hozzáadása</button><br>
        </fieldset>
        <button type="submit" class="addremoveItemBtn">Cég hozzáadása</button><br>
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