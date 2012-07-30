<?php

ini_set("display_errors",1);
ini_set("log_errors",1);
ini_set('memory_limit','256M');

ob_start();

//load all the shizzz we need			TODO:Autoload the support folder.
require_once("application/support/session.php");
require_once("application/support/controller.php");
require_once("application/support/model.php");
require_once("application/support/database.php");
require_once("application/support/core.php");


require_once("application/support/view.php");
require_once("application/support/exceptions.php");

require_once("application/support/application.php");


//and then create a new core
$app = new core();