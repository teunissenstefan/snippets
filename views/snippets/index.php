<div class="container">
  <nav class="navbar navbar-expand-lg listtoolbar">
    <div id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <?php if($_SESSION['rol']=="1" || $_SESSION['rol']=="2"){ ?>
          <li class="nav-item headercol" style="min-width:80px;">
            <a class="toolbarlink" href="?controller=snippets&action=add"><img src="images/add.svg" style="max-height:20px;"/> Nieuw</a>&nbsp;
          </li>
        <?php } ?>
          <li class="nav-item headercol" style="min-width:100px;">
            <a class="toolbarlink" href="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"><img src="images/reload.svg" style="max-height:20px;"/> Verversen</a>&nbsp;
          </li>
        <li>
            <select id="inputGroep" name="taal" onchange="ChangeSnippetsLang(this);">
              <option value="-empty-">Alle talen</option>
            <?php
                foreach($alle_talen as $htaal){
                    if($htaal->id==$gettaal){
                        echo "<option value='".$htaal->id."' selected>".$htaal->language."</option>";
                    }else{
                        echo "<option value='".$htaal->id."'>".$htaal->language."</option>";
                    }
                }
            ?>
            </select>
        </li>
        </ul>
    </div>
  </nav>
  <div class="row listheader">
    <?php if($_SESSION['rol']=="1" || $_SESSION['rol']=="2"){ ?>
    <div class="col-1 listcol">
      Delete
    </div>
    <?php } ?>
    <div class="col-1 listcol">
      Taal
    </div>
    <div class="col-3 listcol">
      Beschrijving
    </div>
    <div class="col listcol">
      Snippet preview
    </div>
  </div>
  <?php 
  if(count($snippets) > 0){
    foreach($snippets as $snippet) { ?>

      <a href='?controller=snippets&action=show&id=<?php echo $snippet->id; ?>' class="listlink">
        <div class="row listrow">
          <?php if($_SESSION['rol']=="1"){ ?>
          <div class="col-1 listcol" onclick="window.location='?controller=snippets&action=delete&id=<?php echo $snippet->id; ?>';return false;">
            Delete
          </div>
          <?php }else if($_SESSION['rol']=="2" && $snippet->aangemaaktdoor->id==$_SESSION['id']){ ?>
          <div class="col-1 listcol" onclick="window.location='?controller=snippets&action=delete&id=<?php echo $snippet->id; ?>';return false;">
            Delete
          </div>
          <?php }else if($_SESSION['rol']=="2"){ ?>
          <div class="col-1 listcol">
            &nbsp;
          </div>
          <?php } ?>
          <div class="col-1 listcol">
            <?php echo $snippet->language; ?>
          </div>
          <div class="col-3 listcol">
            <?php echo htmlentities($snippet->beschrijving); ?>
          </div>
          <div class="col listcol">
            <?php echo htmlentities($snippet->snippet); ?>
          </div>
        </div>
      </a>

    <?php } 
  }else{
    echo "Geen snippets gevonden";
  } ?>
  <div class="container">
    <?php   
    if(count($countWithoutPage) > $amountPerPage){
      echo '<nav aria-label="Page navigation example" class="d-sm-block">
        <ul class="pagination justify-content-center">';
      $_GET['page'] = $page-1;
      echo '<li class="page-item';
      if($page > 1){}else{
        echo ' disabled';
      }
      echo '"><a class="page-link" href="?'.http_build_query($_GET).'">Vorige</a></li>';
      for($i = 1;$i <= $pagination[0];$i++){

        $_GET['page'] = $i;
        echo '<li class="page-item';
        if($page==$i){
          echo ' active';
        }
        echo '"><a class="page-link" href="?'.http_build_query($_GET).'">'.$i.'</a></li>';

      }
      $_GET['page'] = $page+1;
      echo '<li class="page-item d-inline';
      if($page < $pagination[0]){}else{
        echo ' disabled';
      }
      echo '"><a class="page-link" href="?'.http_build_query($_GET).'">Volgende</a></li>';
      echo '</ul>
      </nav>';
    }
    ?>
  </div>
</div>