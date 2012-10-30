<?php
/**
 * Copyright (C) 2012  James Thorne ~ www.mysqltools.org
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */


ini_set("display_errors",1);
ini_set("log_errors",1);
ini_set('memory_limit','256M');
ini_set('error_reporting' ,E_PARSE);
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