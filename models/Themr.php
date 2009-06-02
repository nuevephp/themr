<?php 

/**
 * Tagger Plugin for Frog CMS <http://thehub.silentworks.co.uk/plugins/frog-cms/tagger>
 * Alternate Mirror site <http://www.tbeckett.net/articles/plugins/tagger.xhtml>
 * Copyright (C) 2008 Andrew Smith <a.smith@silentworks.co.uk>
 * Copyright (C) 2008 Tyler Beckett <tyler@tbeckett.net>

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
 * class PagePart
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @since  0.8.7
 */

class Themr extends Record
{   
    public $name;
    public $count;
    static $themes_infos = array();
    
    public static function find($args = null)
    {
        
        // Collect attributes...
        $where    = isset($args['where']) ? trim($args['where']) : '';
        $order_by = isset($args['order']) ? trim($args['order']) : '';
        $offset   = isset($args['offset']) ? (int) $args['offset'] : 0;
        $limit    = isset($args['limit']) ? (int) $args['limit'] : 0;

        // Prepare query parts
        $where_string = empty($where) ? '' : "WHERE $where";
        $order_by_string = empty($order_by) ? '' : "ORDER BY $order_by";
        $limit_string = $limit > 0 ? "LIMIT $offset, $limit" : '';

        $tablename = self::tableNameFromClassName('Tag');

        // Prepare SQL
        $sql = "SELECT * FROM $tablename".
               " $where_string $order_by_string $limit_string";

        $stmt = self::$__CONN__->prepare($sql);
        $stmt->execute();

        // Run!
        if ($limit == 1)
        {
            return $stmt->fetchObject('Tag');
        }
        else
        {
            $objects = array();
            while ($object = $stmt->fetchObject('Tag'))
            {
                $objects[] = $object;
            }
            return $objects;
        }
    
    } // find
    
    public static function findAll($args = null)
    {
        return self::find($args);
    }
    
    public static function findById($id)
    {
        return self::find(array(
            'where' => self::tableNameFromClassName('Tag').'.id='.(int)$id,
            'limit' => 1
        ));
    }
    
    /**
	 * Find all themes installed in the themes folder
	 *
	 * @return array
	 */
	static function findAllThemes()
	{
		$dir = FROG_ROOT.'/public/themes/';

		if ($handle = opendir($dir))
		{
			while (false !== ($theme_id = readdir($handle)))
			{
				// if ( ! isset(self::$plugins[$theme_id]) && is_dir($dir.$theme_id) && strpos($theme_id, '.') !== 0)
				if ( is_dir($dir.$theme_id) && strpos($theme_id, '.') !== 0)
				{
					$xml_file = $dir . $theme_id . '/theme.xml';
					if (file_exists($xml_file)) {
						$xml = simplexml_load_file($xml_file);
						self::$themes_infos[$theme_id]['id'] 			= (string) $theme_id;
						self::$themes_infos[$theme_id]['name'] 			= (string) $xml->name;
						self::$themes_infos[$theme_id]['author'] 		= (string) $xml->author;
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
	
	static function isInstalled($id) {
		
	}
}