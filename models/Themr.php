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
 
/**
 * class Themr
 *
 * @package frog
 * @subpackage plugin.themr
 * @author Andrew Smith <developer@thehub.silentworks.co.uk>
 * @since Frog version 0.9.5
 */
class Themr extends Record
{   
	const TABLE_NAME = 'themr';
	
    public $name;
    public $count;
    static $themes_infos = array();
    
    public $created_on;
    public $updated_on;
    public $created_by_id;
    public $updated_by_id;
    
    public function beforeInsert()
    {
        $this->created_by_id = AuthUser::getId();
        $this->created_on = date('Y-m-d H:i:s');
        return true;
    }
    
    public function beforeUpdate()
    {
        $this->updated_by_id = AuthUser::getId();
        $this->updated_on = date('Y-m-d H:i:s');
        return true;
    }
    
    /**
	 * Find all themes installed in the themes folder
	 *
	 * @return array
	 */
	public static function findAllThemes()
	{
		$dir = FROG_ROOT.'/public/themes/';

		if ($handle = opendir($dir))
		{
			while (false !== ($theme_id = readdir($handle)))
			{
				if ( is_dir($dir.$theme_id) && strpos($theme_id, '.') !== 0)
				{
					$xml_file = $dir . $theme_id . '/theme.xml';
					if (file_exists($xml_file)) {
						$xml = simplexml_load_file($xml_file);
						self::$themes_infos[$theme_id]['id'] 			= (string) $theme_id;
						self::$themes_infos[$theme_id]['name'] 			= (string) $xml->name;
						self::$themes_infos[$theme_id]['author'] 		= (string) $xml->author;
						self::$themes_infos[$theme_id]['author_website'] = (string) $xml->author_website;
						self::$themes_infos[$theme_id]['website'] 		= (string) $xml->website;
						self::$themes_infos[$theme_id]['description'] 	= (string) $xml->description;
						self::$themes_infos[$theme_id]['version'] 		= (string) $xml->version;
						self::$themes_infos[$theme_id]['path'] 			= (string) $dir . $theme_id;
					}
				}
			}
			closedir($handle);
		}

		ksort(self::$themes_infos);
		return self::$themes_infos;
	}
	
	/**
	 * Getting the information for theme by its id
	 *
	 * @since 0.1.1
	 *
	 */
	public function findTheme($id)
	{
		$dir  = FROG_ROOT.'/public/themes/'.$id.'/';

		if ($handle = opendir($dir))
		{
			if ( is_dir($dir) !== 0)
			{
				$xml_file = $dir . 'theme.xml';
				if (file_exists($xml_file)) {
					$xml = simplexml_load_file($xml_file);
					$themes_infos['id'] 		 	= (string) $id;
					$themes_infos['name'] 		 	= (string) $xml->name;
					$themes_infos['author_website'] = (string) $xml->author_website;
					$themes_infos['website']	 	= (string) $xml->website;
					$themes_infos['description'] 	= (string) $xml->description;
					$themes_infos['version'] 	 	= (string) $xml->version;
					$themes_infos['path'] 		 	= (string) $dir;
				}
			}
			closedir($handle);
		}

		ksort($themes_infos);
		return $themes_infos;
	}
	
	public static function isInstalled($theme_id) {
		$theme = Record::findOneFrom('Themr', 'name=?', array($theme_id));
		
		if(isset($theme->id)){
			return true;
		}
		
		return false;
	}
	
	public function theme_name($string){
		return ucwords(str_replace('_', ' ', $string));
	}
}