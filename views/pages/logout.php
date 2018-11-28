<?php
session_unset();
header("Location:?controller=snippets&action=index");
echo "U bent uitgelogd";
?>