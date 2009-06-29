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

Plugin::setInfos(array(
    'id'          => 'themr',
    'title'       => 'Themr',
    'description' => 'Add themes to your website.',
    'version'     => '0.1.2',
    'license'     => 'GPL',
    'author'      => 'Andrew Smith',
    'website'     => 'http://thehub.silentworks.co.uk/plugins/frog-cms/themr.html',
	'update_url'  => 'http://thehub.silentworks.co.uk/plugin-version.xml',
    'require_frog_version' => '0.9.5')
);

Plugin::addController('themr', 'Themr', 'administrator');