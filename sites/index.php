<?php
session_start();
require_once("../config/db.php");
require_once('../config/functions.php');

//POST query and check if the fields are empty
if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
    $success = false; //login status for feedback when the user click the button
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))){
        $email = $conn->real_escape_string(trim($_POST['email']));
        $passwd = $conn->real_escape_string(trim($_POST['password']));
    
        //query the User with that email
        $sqlEmail = "SELECT felhasznalo_id, nev, jelszo, szerepkor FROM felhasznalok WHERE email_cim = ?";
        $stmte = $conn->prepare($sqlEmail); 
        $stmte->bind_param("s", $email);
        $stmte->execute();
        $resultEmail = $stmte->get_result();
        
        //check if there is a user with the email
        if($resultEmail->num_rows==1){
            $dbUser = $resultEmail->fetch_array();
    
            //verify password with the one from the database
            if (password_verify($passwd, $dbUser[2])) {
                $_SESSION['id'] = $dbUser[0];
                $_SESSION['nev'] = $dbUser[1];
                $_SESSION['szerepk'] = $dbUser[3];
    
                //check if it is a User or an Admin
                if($dbUser[3]==2){
                    $success = true;
                    header('Location: logged_user.php');
                    exit();
                }
                else{
                    $success = true;
                    header('Location: logged_admin.php');
                    exit();
                }   
            }
        }
    }
}

echo file_get_contents('../html/head.html');
?>
<div id="logreg-container">
<h2>Bejelentkezés</h2>
<form method="POST" class="custom-form">
    <label for="email">Email</label><br><input type="email" id="email" name="email" required><br>
    <label for="password">Jelszó</label><br><input type="password" id="password" name="password" required><br>
    <div id="reglog-btn-container">
    <button type="submit">Bejelentkezés</button><br>
    <p>Ha még nincs fiókod, <a href="register.php"><b>regisztrálj</b></a> egyet!</p>
    <?php

        //feedback from the login
        if(isset($success) && $success){
            echo "<span class='err-msg'><span class='mark'>✔</span>Sikeres bejelentkezés.</span>";
        }
        else if(isset($success) && !$success){
            echo "<span class='err-msg'><span class='mark'>X</span> Sikertelen bejelentkezés.</span>";
        }
    ?>
    </div>
    
    
</form>
</div>  
</body>
</html>