<div class="container">
    <nav class="navbar navbar-expand-lg listtoolbar">
            <div id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item headercol" style="min-width:80px;">
                    <a class="toolbarlink" href="?controller=gebruikers&action=add"><img src="images/add.svg" style="max-height:20px;"/> Nieuw</a>&nbsp;
                    </li>
                    <li class="nav-item headercol" style="min-width:100px;">
                    <a class="toolbarlink" href="<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"><img src="images/reload.svg" style="max-height:20px;"/> Verversen</a>&nbsp;
                    </li>
                </ul>
            </div>
    </nav>
  <div class="row listheader">
    <div class="col-1 listcol">
      Delete
    </div>
    <div class="col-3 listcol">
      Naam
    </div>
    <div class="col-3 listcol">
      Gebruikersnaam
    </div>
    <div class="col-3 listcol">
      E-mail
    </div>
    <div class="col-2 listcol">
      Rol
    </div>
  </div>
  <?php foreach($users as $user) { ?>

    <a href='?controller=gebruikers&action=edit&id=<?php echo $user->id; ?>' class="listlink">
      <div class="row listrow">
        <div class="col-1 listcol" onclick="window.location='?controller=gebruikers&action=delete&id=<?php echo $user->id; ?>';return false;">
          Delete
        </div>
        <div class="col-3 listcol">
          <?php echo ucwords($user->achternaam.", ".$user->voornaam); ?>
        </div>
        <div class="col-3 listcol">
          <?php echo $user->gebruikersnaam; ?>
        </div>
        <div class="col-3 listcol">
          <?php echo $user->email; ?>
        </div>
        <div class="col-2 listcol">
          <?php echo $user->rol->role; ?>
        </div>
      </div>
    </a>

  <?php } ?>
</div>