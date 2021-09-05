<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Početna</title>
    <script src='jquery-3.4.1.js'></script>
    <script src='index.js'></script>
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
if(isset($_GET['odjava']))
{
    Log::upisiLog("logovi/logovanje.txt", "Odjava korisnika '{$_SESSION['ime']}'");
    odjaviKorisnika();
}
if(login())
    prikaziPodatke();
else
{
    ?>
    <div class='podaciPrijava'>
        <input type="text" name='korime' id='korime' placeholder="Unesite korisničko ime"/> 
        <input type="text" name='lozinka' id='lozinka' placeholder="Unesite lozinku"/> 
        <button type='button' id='dugmeZaPrijavu'>Prijavite se</button><br>
        <div id="odgovor"></div>
    </div>
    <?php
}
?>
<h1>Prijava ispita</h1>
<?php
$upit="SELECT * FROM vwpredmeti order by datum asc";
$rez=$db->query($upit);
if($db->num_rows($rez)>0)
{
    while($red=$db->fetch_object($rez))
    {
        $klasa='aktivan';
        $dugme="";
        if(strtotime($red->datum." 00:00:00")<time())$klasa='prosao';
        if($klasa=="aktivan" AND login() AND $_SESSION['status']=='Student') $dugme="<button type='button' onclick='prijaviIspit($red->id)'>Prijavite ispit</button>";
        echo "<div class='$klasa'>";
        echo "<h4>$red->naziv ($red->ime $red->prezime)</h4>";
        echo "$red->datum ($red->nazivNP)";
        echo "<br>".$dugme;
        echo "</div>";
    }
}
else
    echo "Nema ni jedan zakazan ispit u bazi!";
if(login() AND $_SESSION['status']=="Student")
{
    echo "<h3>Prijavljeni ispiti</h3>";
    $upit="SELECT * FROM prijava WHERE idStudenta=".$_SESSION['id'];
    $rez=$db->query($upit);
    if($db->num_rows($rez)==0)
        echo "Nemate ni jedan prijavljen ispit";
    else
    {
        echo "<h4>Broj prijavljenih ispita: ".$db->num_rows($rez)."</h4>";
        echo "<br>";
        while($red=$db->fetch_object($rez))
        {
            $upit="SELECT * FROM predmeti WHERE id=$red->idPredmeta";
            $pomrez=$db->query($upit);
            $pomred=$db->fetch_object($pomrez);
            echo "$pomred->datum - $pomred->naziv<br>";
        }
    }
}
?>
</body>
</html>
