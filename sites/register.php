<?php
session_start();
require_once("../config/db.php");
require_once('../config/functions.php');

//POST query and check if the fields are empty
if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $success = false; //registration status for feedback when the user click the button
    if (!empty(trim($_POST['name'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['password']) && !empty(trim($_POST['passwordConfirm'])))) {
        $name = $conn->real_escape_string(trim($_POST['name']));
        $email = $conn->real_escape_string(trim($_POST['email']));

        //check if the prefix is filled or not
        if (!empty(trim($_POST['prefix']))) {
            $prefix = $conn->real_escape_string(trim($_POST['prefix']));
        }

        $passwd = $conn->real_escape_string(trim($_POST['password']));
        $passwordConfirm = $conn->real_escape_string(trim($_POST['passwordConfirm']));

        //check if the user previously registered with the email
        $sqlEmail = "SELECT * FROM felhasznalok WHERE email_cim = ?";
        $stmte = $conn->prepare($sqlEmail);
        $stmte->bind_param("s", $email);
        $stmte->execute();
        $resultEmail = $stmte->get_result();
        $emailMatch = false;
        $passwdMatch = false;
        if ($resultEmail->num_rows >= 1)
            $emailMatch = true;

        //check if the passwords match
        if ($passwd == $passwordConfirm)
            $passwdMatch = true;

        //if all criteria are passed the user will be registrated into the database
        if ($emailMatch == false && DataCheck($name, $email, $passwd, $passwdMatch)) {
            $hashedPwd = encrypt($passwd); //password encryption

            //if the prefix was not filled NULL value will be set to that field in the database (it is not a must to fill it out)
            if (isset($prefix)) {
                $sql = "INSERT INTO `felhasznalok`(`jelszo`, `elotag`, `nev`, `email_cim`, `szerepkor`, `regisztracio_datuma`) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $today = date('Y-m-d');
                $szerepkor_altalanos = 2;
                $stmt->bind_param("ssssis", $hashedPwd, $prefix, $name, $email, $szerepkor_altalanos, $today);
            } else {
                $sql = "INSERT INTO `felhasznalok`(`jelszo`, `elotag`, `nev`, `email_cim`, `szerepkor`, `regisztracio_datuma`) VALUES (?,NULL,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $today = date('Y-m-d');
                $szerepkor_altalanos = 2;
                $stmt->bind_param("sssis", $hashedPwd, $name, $email, $szerepkor_altalanos, $today);
            }
            $stmt->execute();

            //check errors
            if ($conn->errno) {
                die($conn->error);
            } else {
                $success = true;
                $stmt->close();
            }
            $conn->close();
        }
    }
}

//check that all data is in the right format
function DataCheck($name, $email, $passwd, $passwdMatch)
{
    $regexPasswd = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/"; //starts with a string, at least 1 lower and 1 uppercase letter, at least 1 digit, contains only letters and digits, min 8, max 30 character 
    $regexName = '/^[a-zA-ZáéíóúüőűÁÉÍÓÚÜŐŰ ]{4,50}$/'; //starts with a string, contains only letters and spaces, min 4, max 50 character 

    //check the format with regular expressions
    if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($regexPasswd, $passwd) && preg_match($regexName, $name) && $passwdMatch == true) {
        return true;
    } else
        return false;
}

//implementation of password encryption by PASSWORD_DEFAULT
function encrypt($pwd)
{
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    return $hashedPwd;
}

echo file_get_contents('../html/head.html');
?>
<div id="logreg-container">
<h2>Regisztráció</h2>
<form method="POST" class="custom-form">
    <label for="name">Név</label><input type="text" id="name" name="name" required><br>
    <label for="prefix">Előtag</label><input type="text" id="prefix" name="prefix"><br>
    <label for="email">Email</label><input type="text" id="email" name="email" required><br>
    <label for="password">Jelszó <span class="mark" title="minimum 8, maximum 30 karakter, minimum 1 db nagy betűt és számot kell tartalmaznia">?</span></label><input type="password" id="password" name="password" required><br>
    <label for="passwordConfirm">Jelszó megerősítése</label><input type="password" id="passwordConfirm" name="passwordConfirm" required><br>
    <div id="reglog-btn-container">
        <button type="submit" id="submit-btn">Regisztráció</button><br>
        <p>Ha már van fiókod, <a href="index.php"><b>jelentkezz be</b></a>!</p>
        <?php

    //feedback from the registration
    if (isset($success) && $success == true) {
        echo "<span class='err-msg'>Sikeres regisztráció.</span>";
    } else if (isset($success) && $success == false) {
        echo "<span class='err-msg'>Sikertelen regisztráció.</span>";
    }
    ?>
    </div>

    
</form>
</div>
</body>

</html>