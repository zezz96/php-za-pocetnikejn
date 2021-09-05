$(document).ready(function(){
    $("#dugmeZaPrijavu").click(function(){
        let korime=$("#korime").val();
        let lozinka=$("#lozinka").val();
        if(korime=="" || lozinka=="")
        {
            $("#odgovor").html("Svi podaci su obavezni");
            return false;
        }
        $.post("ajax/ajax_index.php?funkcija=prijava", {korime: korime, lozinka:lozinka}, function(response){
            if(response=="1") document.location.assign("index.php");
            else $("#odgovor").html(response);
        })
    })
})

function prijaviIspit(idPredmeta)
{
    $.post("ajax/ajax_index.php?funkcija=prijavaIspita", {id: idPredmeta}, function(response){
        if(response=="1") document.location.assign("index.php");
        else alert(response);
    })
}