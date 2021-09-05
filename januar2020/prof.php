<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profesorski servis</title>
    <script src='jquery-3.4.1.js'></script>
    <script src='prof.js'></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
require_once("funkcije.php");
require_once("klase/classBaza.php");
require_once("klase/classLog.php");
$db=new Baza();
if(!$db->connect())
{
    echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
    exit();
}
if(login() and $_SESSION['status']=='Profesor')
    prikaziPodatke();
else
{
    echo "Morate biti prijavljeni kao Profesor da biste videli ovu stranicu<br><a href='index.php'>Prijavite se</a>";
    exit();
}
?>
<h1>Profesorski servis</h1>
<div>
<div class='opcija'>
    <h3>Dodavanje/izmena/brisanje predmeta</h3>
    <select name="predmet" id="predmet"></select> <button type='button' id="brisanje">Obrišite predmet</button><br><br>
    <input type="text" name="id" id="id" readonly/><br><br>
    <input type="text" name="naziv" id="naziv" placeholder="Unesite naziv"/><br><br>
    <select name="nacinPolaganja" id="nacinPolaganja">
        <option value="0">--izaberite način polaganja--</option>
        <?php
        $upit="SELECT * FROM nacinpolaganja";
        $rez=$db->query($upit);
        while($red=$db->fetch_object($rez))
            echo "<option value='$red->id'>$red->naziv</option>";
        ?>
        
    </select><br><br>
    <input type="date" name="datum" id="datum"/><br><br>
    <button id="btnPredmet" type="button">Snimite podatke</button>
    <div id="divPredmeti"></div>
</div>
<div class='opcija'>
    <h3>Logovi</h3>
    <select name="log" id="log">
        <option value="0">--izaberite log--</option>
        <option value="logovanje.txt">Logovanja</option>
        <option value="prijavaispita.txt">Prijava ispita</option>
    </select><br><br>
    <div id='divlogovi'></div>
</div>
<div class='opcija'>
    <h3>Broj prijavljenih studenata</h3>
    <select name="predmetiBroj" id="predmetiBroj"></select><br><br>
    <div id='divbroj'></div>
</div>
</div>
</body>
</html>
