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

Installation Steps
==========================
1) Place this plugin in the Frog plugins directory.
2) Activate the plugin through the administration screen.
3) The plugin should automatically be ready to use.

If the plugin is not working, then the sql probably wasn't installed. Execute the statement below in your database.

CREATE TABLE IF NOT EXISTS themr (
id int(11) unsigned NOT NULL auto_increment,
name varchar(100) default NULL,
snippet text default NULL,
layout text default NULL,
created_on datetime default NULL,
created_by_id int(11) default NULL,
PRIMARY KEY  (id),
UNIQUE KEY name (name)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


Theme XML
========================
<?xml version="1.0" encoding="UTF-8"?>
<themr>
  <name>Theme Name</name>
  <author>Theme Author</author>
  <author_website>http://www.themeauthorwebsite.com/</author_website>
  <website>http://www.themewebsite.com/</website>
  <description>Theme description</description>
  <version>0.1.1</version>
</themr>

Theme Structure
=======================
Theme developer who want to use Themr must follow the folder structure of Themr theme layout.

themedir
==layouts
===themedir_layoutname.php
==snippets
===themedir-snippetname.php
==css

The reason for using the theme directory name at the begining of the layouts and snippets is to keep things 
organised and also make it easier for Themr to associate them. This will also help with future development of Themr.
Remember when referencing a snippet you will need to call it using the same name as the snippet filename without the extension. 

example
======================
<?php $this->includeSnippet('themedir-snippetname'); ?>