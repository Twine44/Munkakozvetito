<?php

$conn = mysqli_connect("localhost", "root", "", "munkakozvetito");
if($conn->errno){
    echo "Nem sikerült csatlakozni az adatbázishoz.";
}
if(!$conn->set_charset('utf8')){
    echo "Hiba a karakterkódolás során.";
}