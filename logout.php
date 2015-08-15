<?php
require_once("includes/session.inc");
destroy_session();
header("Location: index.php")
?>