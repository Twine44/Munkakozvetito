<?php

//AJAX queries
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    switch ($action) {
        case 'readCompanySites':
            readCompanySites($_POST['cId'], $_POST['sId']);
            break;
    }
}

//check if the User is logged in
function isLogged()
{
    if (!isset($_SESSION['id'])) {
        return false;
    }
    return true;
}

//check if the User is an Admin
function isAdmin()
{
    if (isset($_SESSION['szerepk'])) {
        return ($_SESSION['szerepk'] == 1);
    }
    return false;
}

//read the Users from the Database - with selection (for Admins)
function readUsers()
{
    require("db.php");

    //query the Users from the database
    $sql = "SELECT felhasznalo_id, elotag ,nev, felhasznalok.email_cim, regisztracio_datuma FROM felhasznalok WHERE felhasznalok.szerepkor=2";
    $result = $conn->query($sql);


    echo "<table><tr><th>felhasználó id</th><th>előtag</th><th>név</th><th>email</th><th>regisztráció dátuma</th><th></th></tr>";
    while ($row = $result->fetch_array()) {
        echo "<tr>";
        echo '<td>' . $row[0] . '</td>';
        echo '<td>' . $row[1] . '</td>';
        echo '<td>' . $row[2] . '</td>';
        echo '<td>' . $row[3] . '</td>';
        echo '<td>' . $row[4] . '</td>';
        echo '<td class="select-td"><a href="../sites/apply_courses.php?id=' . $row[0] . '">Kiválasztás</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}

//read all the job offers
function readJobs()
{
    require("db.php");

    $sql = "SELECT allas_id, munkakori_pozicio, cegnev, telepules_nev, kozterulet_neve, hazszam, iranyitoszam, elvart_eletkor, allasajanlatok.kapcsolattarto_email, aktualis FROM allasajanlatok, cegek, telephely WHERE allasajanlatok.ceg_id=cegek.ceg_id AND allasajanlatok.telephely_id=telephely.telephely_id;";
    $result = $conn->query($sql);
    echo "<h2>Állásajánlatok</h2>";
    echo "<table>
    <tr>
        <th>pozíció</th>
        <th>cég</th>
        <th>cím</th>
        <th>elvárt életkor</th>
        <th>kapcsolattartó email</th>
        <th>aktuális-e</th>
        <th>képességek</th>
    </tr>";
    while ($row = $result->fetch_assoc()) {

        //read all the skills that the current job requires
        $sqlSkills = "SELECT kepesseg.nev FROM kepessegek, kepesseg WHERE kepessegek.kepesseg_id = kepesseg.kepesseg_id AND kepessegek.allas_id=" . $row["allas_id"] . ";";
        $resultSkills = $conn->query($sqlSkills);

        $isAvailable = $row["aktualis"] == 1 ? "Igen" : "Nem";
        echo "<tr>
        <td>" . $row["munkakori_pozicio"] . "</td>
        <td>" . $row["cegnev"] . "</td>
        <td>" . $row["iranyitoszam"] . ", " . $row["telepules_nev"] . ", " . $row["kozterulet_neve"] . " " . $row["hazszam"] . "</td>
        <td>" . $row["elvart_eletkor"] . "</td>
        <td>" . $row["kapcsolattarto_email"] . "</td>
        <td>" . $isAvailable . "</td>
        <td>";

        $i = 0;
        while ($row = $resultSkills->fetch_array()) {
            $i++;
            echo $row[0];
            echo $i != $resultSkills->num_rows ? ", " : "";
        }

        echo "</td></tr>";
    }
    echo "</table>";
}

//read all the courses
function readCourses()
{
    require("db.php");

    $sql = "SELECT * FROM kepzes";
    $result = $conn->query($sql);
    echo "<h2>Képzések</h2>";
    echo "<table>
    <tr>
        <th>név</th>
        <th>szint</th>
        <th>megnevezés</th>
        <th>ár</th>
        <th>kezdés dátuma</th>
        <th>befejezés dátuma</th>
        <th>max létszám</th>
    </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["nev"] . "</td>
        <td>" . $row["szint"] . "</td>
        <td>" . $row["megnevezes"] . "</td>
        <td>" . $row["ar"] . "</td>
        <td>" . $row["kezdes_datuma"] . "</td>
        <td>" . $row["befejezes_datuma"] . "</td>
        <td>" . $row["max_letszam"] . "</td>
    </tr>";
    }
    echo "</table>";
}

//read all the courses - with apply feature (for Admins)
function applyCourses($uId)
{
    require("db.php");

    //query all the courses with the number of people who applied them
    $sql = "SELECT kepzes.kepzes_id, kepzes.nev, kepzes.szint, kepzes.megnevezes, kepzes.ar, kepzes.kezdes_datuma, kepzes.befejezes_datuma, kepzes.max_letszam,
    COUNT(resztvevok.felhasznalo_id) AS letszam
    FROM kepzes
    LEFT JOIN resztvevok ON kepzes.kepzes_id = resztvevok.kepzes_id
    GROUP BY kepzes.kepzes_id, kepzes.nev, kepzes.szint, kepzes.megnevezes, kepzes.ar, kepzes.kezdes_datuma, kepzes.befejezes_datuma, kepzes.max_letszam;";
    $result = $conn->query($sql);

    //declare form for the submit buttons
    echo '<form id="applyForm" method="POST"></form>';
    echo "<h3>Képzések</h3>";
    echo "<table>
    <tr>
        <th>név</th>
        <th>szint</th>
        <th>megnevezés</th>
        <th>ár</th>
        <th>kezdés dátuma</th>
        <th>befejezés dátuma</th>
        <th>max létszám</th>
        <th>jelentkezők</th>
        <th></th>
    </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row["nev"] . "</td>
        <td>" . $row["szint"] . "</td>
        <td>" . $row["megnevezes"] . "</td>
        <td>" . $row["ar"] . "</td>
        <td>" . $row["kezdes_datuma"] . "</td>
        <td>" . $row["befejezes_datuma"] . "</td>
        <td>" . $row["max_letszam"] . "</td>
        <td>" . $row["letszam"] . "</td>";

        //query that the User was already applied to the course or not
        $sqlApplied = 'SELECT resztvevok.felhasznalo_id FROM resztvevok WHERE resztvevok.kepzes_id=' . $row["kepzes_id"] . ' AND resztvevok.felhasznalo_id=' . $uId . ';';
        $resultApplied = $conn->query($sqlApplied);
        if ($resultApplied->num_rows == 0) {

            //passing course id, and the purpose of the button through POST
            echo '<td class="select-td"><button type="submit" form="applyForm" name="applyBtn" class="applyBtn" value="' . $row["kepzes_id"] . ':Jelentkezés">Jelentkezés</button></td>';
        } else {
            echo '<td class="select-td"><button type="submit" form="applyForm" name="applyBtn" class="applyBtn" value="' . $row["kepzes_id"] . ':Lejelentkezés">Lejelentkezés</button></td>';
        }
        echo "</tr>";
    }
    echo "</table>";
}

//read all the job offers - with modify feature (for Admins)
function modifyJobs()
{
    require("db.php");

    //query all the courses with the number of people who applied them
    $sql = "SELECT allas_id, munkakori_pozicio, elvart_eletkor, allasajanlatok.kapcsolattarto_email as kapcsolattarto_email, aktualis, felhasznalo_id, iranyitoszam,telepules_nev,kozterulet_neve,hazszam, cegnev FROM allasajanlatok, telephely, cegek WHERE allasajanlatok.telephely_id = telephely.telephely_id AND allasajanlatok.ceg_id=cegek.ceg_id";
    $result = $conn->query($sql);

    //declare form for the modify buttons
    echo '<form id="modifyForm" method="POST"></form>';
    echo "<table id='custom-jobtable'>
    <tr>
        <th>pozíció</th>
        <th>cég</th>
        <th>cím</th>
        <th>elvárt életkor</th>
        <th>kapcsolattartó email</th>
        <th>aktuális-e</th>
        <th>képességek</th>
        <th></th>
    </tr>";
    while ($row = $result->fetch_assoc()) {

        //read all the skills that the current job requires
        $sqlSkills = "SELECT kepesseg.nev FROM kepessegek, kepesseg WHERE kepessegek.kepesseg_id = kepesseg.kepesseg_id AND kepessegek.allas_id=" . $row["allas_id"] . ";";
        $resultSkills = $conn->query($sqlSkills);
        $isAvailable = $row["aktualis"] == 1 ? "Igen" : "Nem";
        echo "<tr>
        <td>" . $row["munkakori_pozicio"] . "</td>
        <td>" . $row["cegnev"] . "</td>
        <td>" . $row["iranyitoszam"] . ", " . $row["telepules_nev"] . ", " . $row["kozterulet_neve"] . " " . $row["hazszam"] . "</td>
        <td>" . $row["elvart_eletkor"] . "</td>
        <td>" . $row["kapcsolattarto_email"] . "</td>
        <td>" . $isAvailable . "</td>
        <td>";
        $i = 0;
        while ($row2 = $resultSkills->fetch_array()) {
            $i++;
            echo $row2[0];
            echo $i != $resultSkills->num_rows ? ", " : "";
        }
        echo "</td>";

        //passing job id through the URL
        echo '<td class="select-td"><a href="job.php?id=' . $row["allas_id"] . '">Módosítás</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}

//read all Companies name into options (for Admins)
function readCompanyNames($cId)
{
    error_reporting(E_ALL);

    require("db.php");
    echo "Reached point A";

    $sql = "SELECT cegnev, ceg_id FROM cegek";
    $result = $conn->query($sql);
    while ($row = $result->fetch_array()) {

        //if there is a Company ID select it for modification
        if ($cId != 0 && $cId == $row[1]) {
            echo "<option selected value='$row[1]'>$row[0]</option>";
        } else {
            echo "<option value='$row[1]'>$row[0]</option>";
        }
    }
}

//read all the Company sites for the selected Company (for Admins)
function readCompanySites($cId, $sId)
{
    require("db.php");
    $sql = "SELECT iranyitoszam, telepules_nev, kozterulet_neve, hazszam, telephely_id FROM telephely WHERE ceg_id=$cId";
    $result = $conn->query($sql);

    $options = "";
    while ($row = $result->fetch_array()) {
        if ($sId != 0 && $sId == $row[4]) {
            $options .= "<option selected value='$row[4]'>$row[0], $row[1], $row[2] $row[3]</option>";
        } else {
            $options .= "<option value='$row[4]'>$row[0], $row[1], $row[2] $row[3]</option>";
        }
    }
    echo $options;
}

//read all the skills that the job requires (for Admins)
function readSkills($jId)
{
    require("db.php");

    if ($jId != 0) {
        $sqlRequiredSkills = "SELECT kepesseg.kepesseg_id FROM kepessegek, kepesseg WHERE kepessegek.kepesseg_id=kepesseg.kepesseg_id AND kepessegek.allas_id=$jId;";
        $result = $conn->query($sqlRequiredSkills);
        $jobSkills = array();
        while ($row = $result->fetch_array()) {
            $jobSkills[] = $row[0];
        }
    }

    $sql = "SELECT kepesseg.nev, kepesseg.kepesseg_id FROM kepesseg;";
    $result = $conn->query($sql);
    $checkboxes = "";
    while ($row = $result->fetch_array()) {
        $checked = "";
        if ($jId != 0) {
            for ($i = 0; $i < count($jobSkills); $i++) {
                if ($jobSkills[$i] == $row[1]) {
                    $checked = "checked";
                    break;
                }
            }
        }
        $checkboxes .= '<input type="checkbox" class="custom-radiocheckbox" name="skill[]" value="' . $row[1] . '" id="skill' . $row[1] . '" ' . $checked . '><label for="skill' . $row[1] . '">' . $row[0] . '</label><br>';
    }
    echo $checkboxes;
}

//check that the User is logged in and that he is an Admin and show Admin information with logout
function adminDisplay()
{

    if (isLogged()) {
        echo '<div id="user-container">';
        if (isAdmin()) {
            echo "<table id='user-table'><tr><td>";
            echo "Bejelentkezve: " . $_SESSION["nev"] . " - <i>admin</i></td>";
            echo '<td id="logout-td"><a href="../config/logout.php" id="logout">Kijelentkezés <img src="../images/logout.png" id="logout-img"></a></td>';
            echo "</tr></table>";
        } else {
            header('Location: logged_user.php');
            exit;
        }
    } else {
        header('Location: index.php');
        exit;
    }
    echo "</div>";
}

//check that the User is logged in and show User information with logout
function userDisplay()
{
    if (isLogged()) {
        echo ' <div id="user-container">';
        echo "<table id='user-table'><tr><td>";
        echo "Bejelentkezve: " . $_SESSION["nev"] . "</td>";
        echo '<td id="logout-td"><a href="../config/logout.php" id="logout">Kijelentkezés <img src="../images/logout.png" id="logout-img"></a></td>';
        echo "</tr></table>";
    } else {
        header('Location: index.php');
        exit;
    }
    echo '</div>';
}



//complex queries (for statistics)
function oneYearUsersWithoutCourse()
{
    require("db.php");


    $sql1Year = "SELECT felhasznalok.felhasznalo_id, felhasznalok.nev, felhasznalok.email_cim 
    FROM felhasznalok, resztvevok 
    WHERE resztvevok.felhasznalo_id NOT IN (SELECT felhasznalok.felhasznalo_id FROM resztvevok) AND felhasznalok.regisztracio_datuma <= CURDATE() - INTERVAL 1 YEAR;";
    $result1Year = $conn->query($sql1Year);
    if ($result1Year->num_rows == 0) {
        echo "Nincs ilyen felhasználó.";
    } else {
        echo "<ul>";
        while ($row = $result1Year->fetch_array()) {
            echo "<li>$row[1].', '.$row[2]</li>";
        }
        echo "</ul>";
    }
}

function threeJobOffer()
{
}

function mostPopularJobs()
{
    require("db.php");

    $sql = "SELECT telephely.telepules_nev, allasajanlatok.munkakori_pozicio, COUNT(allasajanlatok.allas_id) AS popularity
    FROM telephely
    JOIN allasajanlatok ON telephely.telephely_id = allasajanlatok.telephely_id
    GROUP BY telephely.telepules_nev, allasajanlatok.munkakori_pozicio
    ORDER BY popularity DESC, telephely.telepules_nev ASC;";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Nincsenek állások.";
    } else {
        echo "<table>";
        while ($row = $result->fetch_array()) {
            echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
        }
        echo "<table>";
    }
}

function lessThanHalfApply(){
    require("db.php");
    $sql = "SELECT kepzes.kepzes_id, kepzes.nev, szint, megnevezes, ar, max_letszam, COUNT(resztvevok.felhasznalo_id) AS letszam
    FROM kepzes
    LEFT JOIN resztvevok ON kepzes.kepzes_id = resztvevok.kepzes_id
    GROUP BY kepzes.kepzes_id, kepzes.nev, kepzes.szint, kepzes.megnevezes, kepzes.ar, kepzes.max_letszam
    HAVING letszam<max_letszam/2;";
    $result=$conn->query($sql);
    if($result->num_rows==0){
        echo "Nincs ilyen képzés.";
    }
    else{
        echo "<ul>";
        while ($row=$result->fetch_array()) {
            echo "<li>id: $row[0], név: $row[1], max létszám: $row[5], jelentkezők: $row[6]</li>";
        }
        echo "</ul>";
    }
   
}
