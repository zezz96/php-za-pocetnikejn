$(document).ready(function(){
    popuniSelect();
    $("#log").change(function(){
        let fajl=$(this).val();
        if(fajl=="0")
        {
            $("#divlogovi").html("");
            return false;
        }
        $.post("ajax/ajax_prof.php?funkcija=log",{fajl:fajl}, function(response){
            $("#divlogovi").html(response);
        })
    })

    $("#predmetiBroj").change(function(){
        let id=$(this).val();
        if(id=="0")
        {
            $("#divbroj").html("");
            return false;
        }
        $.post("ajax/ajax_prof.php?funkcija=predmetiBroj",{id:id}, function(response){
            $("#divbroj").html(response);
        })
    })

    $("#brisanje").click(function(){
        let id=$("#predmet").val();
        if(!confirm("Da li ste sigurni da želite da izbrišete predmet?")) return false;
        if(id=="0")
        {
            $("#divPredmeti").html("Niste izabrali predmet za brisanje");
            return false;
        }
        $.post("ajax/ajax_prof.php?funkcija=brisanje", {id:id}, function(response){
            $("#divPredmeti").html(response);
        })
    })

    $("#btnPredmet").click(function(){
        let id=$("#id").val();
        let naziv=$("#naziv").val();
        let datum=$("#datum").val();
        let nacinpolaganja=$("#nacinPolaganja").val();
        $.post("ajax/ajax_prof.php?funkcija=predmet", {id:id, naziv:naziv, datum: datum, nacinpolaganja: nacinpolaganja}, function(response){
            $("#divPredmeti").html(response);
            popuniSelect();
            ocistiPredmet();
        })
    })

    $("#predmet").change(function(){
        let id=$(this).val();
        if(id=="0")
        {
            ocistiPredmet();
            return false;
        }
        $.post("ajax/ajax_prof.php?funkcija=prikaziPredmet", {id:id}, function(response){
            let predmet=JSON.parse(response);
            $("#id").val(predmet[0].id);
            $("#naziv").val(predmet[0].naziv);
            $("#datum").val(predmet[0].datum);
            $("#nacinPolaganja").val(predmet[0].nacinpolaganja);
        })
    })
})

function popuniSelect()
{
    let broj=$("#predmetiBroj");
    let predmet=$("#predmet");
    $.post("ajax/ajax_prof.php?funkcija=popuniSelect", function(response){
        let predmeti=JSON.parse(response);
        broj.empty();
        predmet.empty();
        broj.append("<option value='0'>--izaberite predmet--</option>");
        predmet.append("<option value='0'>--izaberite predmet--</option>");
        for(let i=0;i<predmeti.length;i++)
        {
            broj.append("<option value='"+ predmeti[i].id +"'>"+ predmeti[i].naziv +"</option>");
            predmet.append("<option value='"+ predmeti[i].id +"'>"+ predmeti[i].naziv +"</option>");
        }
    })
}

function ocistiPredmet(){
    $("input").val("");
    $("#predmet").val("0");
    $("#nacinPolaganja").val("0");
}