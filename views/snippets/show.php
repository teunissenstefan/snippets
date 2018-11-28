<div class="container">
    <?php if($_SESSION['rol']=="1" || ($_SESSION['rol']=="2" && $snippet->aangemaaktdoor->id==$_SESSION['id'])){ ?>
    <nav class="navbar navbar-expand-lg listtoolbar">
        <div id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item headercol" style="min-width:100px;">
                    <a class="toolbarlink" href="?controller=snippets&action=edit&id=<?php echo $_GET['id'] ?>"><img src="images/edit.svg" style="max-height:20px;"/> Bewerken</a>&nbsp;
                </li>
                <li class="nav-item headercol" style="min-width:100px;">
                    <a class="toolbarlink" href="?controller=snippets&action=delete&id=<?php echo $_GET['id'] ?>"><img src="images/delete.svg" style="max-height:20px;"/> Delete</a>&nbsp;
                </li>
            </ul>
        </div>
    </nav>
    <?php } ?>
    <div class="row">
        <div class="col-sm-3 sidebar">
            <div class="sb-row">
                Beschrijving:<br/><?php echo htmlentities($snippet->beschrijving); ?>
            </div>
            <div class="sb-row">
                Taal:<br/><?php echo $snippet->language->language; ?>
            </div>
            <div class="sb-row">
                Laatst geupdate:<br/><?php echo $snippet->datum_update; ?>
            </div>
        </div>
        <div class="col-sm-9 maincontent">
            <div class="divider">
                <a class="toolbarlink" href="#" id="copycodebutton" data-clipboard-target="#copycode"><img src="images/copy.svg" style="max-height:20px;"/> Code kopieren</a>
            </div>
            <div class="sb-row melding">
                <pre><code id="copycode" class="<?php echo $snippet->language->alias; ?>"><?php echo (htmlentities($snippet->snippet)); ?></code></pre>
            </div>
        </div>
    </div>
</div>