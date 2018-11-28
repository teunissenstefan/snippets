<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($toegevoegd){
                header("Location:?controller=snippets&action=show&id=".$genId);
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Toevoegen succesvol!";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon niet toevoegen";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=snippets&action=add" method="POST">
<div class="row">
    <div class="form-group col-12">
        <button type="submit" name="submit" class="btn btn-primary col-md-2">Toevoegen</button>
    </div>
    <div class="form-group col-12">
        <label for="inputBeschrijving">Korte beschrijving</label>
        <input type="text" name="beschrijving" class="form-control" id="inputBeschrijving" placeholder="Beschrijving" value="<?php echo $post_beschrijving;?>">
    </div>
    <div class="form-group col-sm-12">
        <label for="inputSnippet">Snippet</label>
        <textarea class="form-control" id="inputSnippet" name="snippet" rows="16" placeholder="Snippet"><?php echo $post_snippet;?></textarea>
    </div>
    <div class="form-group col-sm-12">
        <label for="inputTaal">Taal</label>
        <select class="form-control" id="inputTaal" name="taal">
        <?php
            foreach($alle_talen as $htaal){
                if($htaal->id==$post_taal){
                    echo "<option value='".$htaal->id."' selected>".$htaal->language."</option>";
                }else{
                    echo "<option value='".$htaal->id."'>".$htaal->language."</option>";
                }
            }
        ?>
        </select>
    </div>
</div>
</form>