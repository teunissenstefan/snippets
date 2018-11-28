<?php
if(!isset($_GET['delete'])){
?>
    Weet u zeker dat de volgende snippet wilt verwijderen?<br/>
    <a href='?controller=snippets&action=index'><button class='btn btn-danger'>Annuleren</button></a>
    <a href="?controller=snippets&action=delete&id=<?php echo $_GET['id']; ?>&delete=true"><button class='btn btn-primary'>Ja</button></a><br/><br/>
    <pre><code class='<?php echo $snippet->language->alias; ?>'><?php echo (htmlentities($snippet->snippet)); ?></code></pre>
<?php
}else{
    
}
?>