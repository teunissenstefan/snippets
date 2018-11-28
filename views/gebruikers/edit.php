<?php
    if($post == true){
        if(!$gelukt){
            echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
            echo $errorMsg;
            echo '</div></div>';
        }else{
            if($opgeslagen){
                header("Location:?controller=gebruikers&action=index");
                echo '<div class="card card-inverse bg-success text-center"><div class="card-block">';
                echo "Opslaan succesvol";
                echo '</div></div>';
            }else{
                echo '<div class="card card-inverse bg-danger text-center"><div class="card-block">';
                echo "Kon gebruiker niet worden opgeslagen";
                echo '</div></div>';
            }
        }
    }
?>
<form action="?controller=gebruikers&action=edit&id=<?php echo $_GET['id']; ?>" method="POST">
<div class="row">
  <div class="form-group col-sm-6">
    <label for="inputVoornaam">Voornaam</label>
    <input type="text" name="voornaam" class="form-control" id="inputVoornaam" placeholder="Voornaam" value="<?php echo $post_voornaam;?>">
  </div>
  <div class="form-group col-sm-6">
    <label for="inputAchternaam">Achternaam</label>
    <input type="text" name="achternaam" class="form-control" id="inputAchternaam" placeholder="Achternaam" value="<?php echo $post_achternaam;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputPhone">Telefoonnummer</label>
    <input type="text" name="telefoonnummer" class="form-control" id="inputPhone" placeholder="Telefoonnummer" value="<?php echo $post_telefoonnummer;?>">
  </div>
  <div class="form-group col-12">
    <label for="inputWachtwoord">Wachtwoord (leeglaten als het niet aangepast moet worden)</label>
    <input type="password" name="wachtwoord" class="form-control" id="inputWachtwoord" placeholder="Wachtwoord" value="<?php echo $post_wachtwoord;?>">
    <small id="wachtwoordHelp" class="form-text text-muted">Moet cijfers en letters bevatten</small>
  </div>
  <div class="form-group col-sm-12">
      <label for="inputRol">Rol</label>
      <select class="form-control" id="inputRol" name="rol">
      <?php
          foreach($rollen as $hrol){
              if($hrol->id==$post_rol){
                  echo "<option value='".$hrol->id."' selected>".$hrol->role."</option>";
              }else{
                  echo "<option value='".$hrol->id."'>".$hrol->role."</option>";
              }
          }
      ?>
      </select>
  </div>
  <div class="form-group col-12">
    <button type="submit" name="submit" class="btn btn-primary col-md-2">Gebruiker opslaan</button>
  </div>
</div>
</form>