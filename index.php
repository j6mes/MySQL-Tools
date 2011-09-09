<?php

ini_set("display_errors",1);
ini_set("log_errors",1);


ob_start();

//load all the shizzz we need
require_once("application/support/core.php");
require_once("application/support/model.php");
require_once("application/support/view.php");
require_once("application/support/exceptions.php");
require_once("application/support/session.php");
require_once("application/support/application.php");

//and then create a new core
$app = new core();


?>

