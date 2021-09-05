<?php
session_start();
require_once("../klase/classBaza.php");
require_once("../klase/classLog.php");
$db=new Baza();
if(!$db->connect())
{
    echo "Baza trenutno nije dostupna!!!!";
    exit();
}
$funkcija=$_GET['funkcija'];
if($funkcija=="prijava")
{
    if(isset($_POST['korime']) and isset($_POST['lozinka']))
    {
        $korime=$_POST['korime'];
        $lozinka=$_POST['lozinka'];
        if($korime=="" or $lozinka=="")
        {
            echo "Svi podaci su obavezni";
            exit();
        }
        
        $upit="SELECT * FROM korisnici WHERE korime='{$korime}'";
        $rez=$db->query($upit);
        if($db->num_rows($rez)==0)
        {
            echo "Ne postoji korisnik sa korisničkim imenom <b>'{$korime}'</b>";
            Log::upisiLog("../logovi/logovanje.txt", "Pogrešni podaci: '{$korime}' i '{$lozinka}'");
            exit();
        }
        $red=$db->fetch_object($rez);
        if($red->lozinka!=$lozinka)
        {
            echo "Pogrešna lozinka za korisnika <b>'{$korime}'</b>";
            Log::upisiLog("../logovi/logovanje.txt", "Pogrešni podaci: '{$korime}' i '{$lozinka}'");
            exit();
        }
        $_SESSION['id']=$red->id;
        $_SESSION['ime']="$red->ime $red->prezime";
        $_SESSION['status']=$red->status;
        Log::upisiLog("../logovi/logovanje.txt", "Uspešno logovanje za korisnika {$korime}");
        echo "1";
    }
}
if($funkcija=="prijavaIspita")
{
    if(isset($_POST['id']))
    {
        $idPredmeta=$_POST['id'];
        $upit="SELECT * FROM prijava WHERE idStudenta={$_SESSION['id']} AND idPredmeta={$idPredmeta}";
        $rez=$db->query($upit);
        if($db->num_rows($rez)>0)
        {
            echo "Ovaj ispit je već prijavljen";
            exit();
        }
            
        $upit="INSERT INTO prijava (idStudenta, idPredmeta) VALUES ({$_SESSION['id']}, {$idPredmeta})";
        $db->query($upit);
        if($db->error())
        {
            Log::upisiLog("../logovi/prijavaispita.txt", "Neuspešna prijava ispita $idPredmeta za korisnika {$_SESSION['ime']} - ".$db->error());
            echo "Neuspešna prijava\n".$db->error();
        }
            
        else
        {
            Log::upisiLog("../logovi/prijavaispita.txt", "Uspešna prijava ispita $idPredmeta za korisnika {$_SESSION['ime']}");
            echo "1";
        }
           
    }
}

?>