<?php
if(!isset($_GET['delete'])){
    echo "Weet u zeker dat u ".DisplayName($gebruiker)." wilt verwijderen?<br/>";
    echo "<span style='color:red;font-size:18px;font-weight:bold;'>LET OP!! Zijn/haar snippets worden hierbij ook verwijderd!</span><br/>";
    echo "<a href='?controller=gebruikers&action=index'><button class='btn btn-danger'>Annuleren</button></a> ";
    echo "<a href='?controller=gebruikers&action=delete&id=".$_GET['id']."&delete=true'><button class='btn btn-primary'>Ja</button></a>";
}else{
    
}
?>