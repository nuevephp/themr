<?php
/**
 * Themr Plugin for Frog CMS <http://thehub.silentworks.co.uk/plugins/frog-cms/themr.html>
 * Copyright (C) 2008 Andrew Smith <developer@thehub.silentworks.co.uk>

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.

 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

if ($driver == 'mysql')
{

	// Create category table
	$PDO->exec("CREATE TABLE IF NOT EXISTS ".TABLE_PREFIX."themr (
				id int(11) unsigned NOT NULL auto_increment,
				name varchar(100) default NULL,
				snippet text default NULL,
				layout text default NULL,
				created_on datetime default NULL,
				created_by_id int(11) default NULL,
				PRIMARY KEY  (id),
				UNIQUE KEY name (name)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
}
