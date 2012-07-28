#MySQL Tools - A free query browser for PHP
##Prerequisits 
* PDO MySQL Driver
* PHP 5.2.4 + 
* A MySQL Server
* Mod-rewrite
* .htaccess support

##Install
* Copy files into root web directory (such as a subdomain (sorry I havent done anything else yet))
* Edit MySQL Servers in /application/configuration/servers.php
* CHMOD 0777 the /storage directory
* 

##Copyright and Licensing
    Copyright (C) 2011  James Thorne ~ www.mysqltools.org

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


##Roadmap:
###v0.0.0 - By end of November
* A Create / edit form
* A Relative directory support
* B Describe table page
* B Inline editor
	*	A delete
	*	C preset (types: int/enum/varchar->LIMIT:?!)
	*	B modal popout
* C Context menu fix


###v0.1.0 - By end of December
* Export Dataset
* Search
* Transaction Locking

###v0.2.0 - By end of January
* Backup restore
* Modules

###v1.0.0 - February?
* ????
