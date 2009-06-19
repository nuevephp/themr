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
 * The Themr plugin provides an interface to add and remove themes.
 *
 * @package frog
 * @subpackage plugin.themr
 *
 * @author Andrew Smith <developer@thehub.silentworks.co.uk>
 * @version 0.1.0
 * @since Frog version 0.9.5
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Andrew Smith
 */
 
// Include Themr Model
include_once 'models/Themr.php';

/**
 * class ThemrController
 *
 * @package frog
 * @subpackage plugin.themr
 * @author Andrew Smith <developer@thehub.silentworks.co.uk>
 * @since Frog version 0.9.5
 */
class ThemrController extends PluginController
{
    public function __construct()
    {
        $this->setLayout('backend');
        $this->assignToLayout('sidebar', new View('../../plugins/themr/views/sidebar'));
    }

    public function index($page = 0)
    {	
		$allThemes = Themr::findAllThemes();
		
		$theme_info = Themr::findTheme('themr');
		/*if (isset($page)) {
			$CurPage = $page;
		} else {
			$CurPage = 0;
		}
		
		$rowspage = Plugin::getSetting('rowspage', 'themr');

		$start = $CurPage * $rowspage;

		$totalrecords = count($totalTags);

		$lastpage = ceil($totalrecords / $rowspage);
		if($totalrecords <= $rowspage) { $lastpage = 0; } else { $lastpage = abs($lastpage - 1); }

		/* Get data. */
		// $tags = Tagger::findAll(array('offset' =>  $start,'limit' => $rowspage));

        $this->display('themr/views/index', array(
            'themes' => $allThemes
        ));
    }

    public function install($id)
    {
    	$dir = FROG_ROOT.'/public/themes/'.$id.'/';
		$files = $this->scan_directory_recursively($dir, 'php');
		
		$data = array();
		$data['name'] = $id;
		
		// Layouts
		$layouts = array();
		$l = array();
		
		// Snippets
		$snippets = array();
		$s = array();
		
		foreach ($files as $file) {
			switch ($file['name']) {
				case 'layouts':
					foreach ($file['content'] as $layout) {
						
						$layouts[] = $layout['name'];
						
						$l['name'] = Themr::theme_name($layout['name']);
						$l['content_type'] = 'text/html';
						$l['content'] = file_get_contents($layout['path']);
						
						$layout = new Layout($l);
				        if( ! $layout->save()) {
				            Flash::set('error', __('Layout has not been added. Name must be unique!'));
				        }
					}
				break;
				case 'snippets':
					foreach ($file['content'] as $snippet) {
						$snippets[] = $snippet['name'];
						
						$s['name'] = $snippet['name'];
						$s['filter_id'] = '';
						$s['content'] = file_get_contents($snippet['path']);
						
						$snippet = new Snippet($s);
				        if ( ! $snippet->save()) {
				            Flash::set('error', __('Snippet has not been added. Name must be unique!'));
				        }
					}
				break;
			}
		}
		
		// Serialize Layout and Snippet names
		$data['layout'] = serialize($layouts);
		$data['snippet'] = serialize($snippets);
		
		// Get Current Theme Info
		$theme_info = Themr::findTheme($id);
		
		// Save into Themr database table
		$theme = new Themr($data);
		if (!$theme->save())
        {
            Flash::set('error', __('Theme has not been added. Name must be unique!'));
            redirect(get_url('plugin/themr'));
        } else {
            Flash::set('success', __('Theme <b>:name</b> has been added!', array(':name'=>$theme_info['name'])));
            redirect(get_url('plugin/themr'));
        }
    }
    
    /**
	 * Uninstall a theme along with snippets that came with it.
	 *
	 * @since 0.1.0
	 *
	 */
    public function uninstall($id)
    {
    	$layoutUsed = 0;
    	$theme = Record::findOneFrom('Themr', 'name=?', array($id));
    	
    	// Get Current Theme Info
		$theme_info = Themr::findTheme($id);
    	
    	foreach (unserialize($theme->layout) as $layouts) {
    		// find the user to delete
	        if ($layout = Record::findOneFrom('Layout', 'name=?', array(Themr::theme_name($layouts))))
	        {
	            if ($layout->isUsed()){
	                Flash::set('error', __('Theme <b>:theme</b> CANNOT be deleted because layout <b>:name</b> is being used!', array(':name'=>$layout->name, ':theme'=>$theme_info['name'])));
	                $layoutUsed = 1;
	            } else if ($layout->delete()) {
	                Flash::set('success', __('Layout <b>:name</b> has been deleted!', array(':name'=>$layout->name)));
	            }
	            else
	                Flash::set('error', __('Layout <b>:name</b> has not been deleted!', array(':name'=>$layout->name)));
	        }
	        else Flash::set('error', __('Layout not found!'));
    	}
    	
    	if($layoutUsed !== 1){
	    	foreach (unserialize($theme->snippet) as $snippets) {
		    	// find the snippet to delete
		        if ($snippet = Record::findOneFrom('Snippet', 'name=?', array($snippets)))
		        {
		            if ($snippet->delete())
		            {
		                Flash::set('success', __('Snippet <b>:name</b> has been deleted!', array(':name'=>$snippet->name)));
		            }
		            else
		                Flash::set('error', __('Snippet <b>:name</b> has not been deleted!', array(':name'=>$snippet->name)));
		        }
		        else Flash::set('error', __('Snippet not found!'));
			}
    	
			if($theme->delete()){
				Flash::set('success', __('Theme <b>:name</b> has been uninstalled!', array(':name'=>$theme_info['name'])));
				redirect(get_url('plugin/themr'));
			} else {
				Flash::set('error', __('Theme <b>:name</b> has not been uninstalled!', array(':name'=>$theme_info['name'])));
				redirect(get_url('plugin/themr'));
			}
		} else {
			redirect(get_url('plugin/themr'));
		}
    }
	
	function scan_directory_recursively($directory, $filter=FALSE)
	{
		if(substr($directory,-1) == '/') {
			$directory = substr($directory,0,-1);
		}
		
		if(!file_exists($directory) || !is_dir($directory)) {
			return FALSE;
		} elseif(is_readable($directory)) {
			// we open the directory
			$directory_list = opendir($directory);
			
			// and scan through the items inside
			while (FALSE !== ($file = readdir($directory_list))) {
				if($file != '.' && $file != '..') {
					// we build the new path to scan
					$path = $directory.'/'.$file;
					
					if(is_readable($path)) {
						// we split the new path by directories
						$subdirectories = explode('/',$path);
						
						// if the new path is a directory
						if(is_dir($path)) {
							// add the directory details to the file list
							$directory_tree[] = array(
								'path'    => $path,
								'name'    => end($subdirectories),
								'kind'    => 'directory',
	
								// we scan the new path by calling this function
								'content' => $this->scan_directory_recursively($path, $filter));
						// if the new path is a file
						} elseif(is_file($path)) {
							// get the file extension by taking everything after the last dot
							$extension = end(explode('.',end($subdirectories)));
	
							// if there is no filter set or the filter is set and matches
							if($filter === FALSE || $filter == $extension) {
								// add the file details to the file list
								$directory_tree[] = array(
									'path'      => $path,
									// 'name'      => end($subdirectories),
									'name'      => current(explode('.',end($subdirectories))),
									'extension' => $extension,
									'size'      => filesize($path),
									'kind'      => 'file');
							}
						}
					}
				}
			}
			// close the directory
			closedir($directory_list); 
	
			// return file list
			return $directory_tree;
		} else {
			return FALSE;	
		}
	}

	/**
	 * Settings for Themr to change specific features
	 *
	 * @since 0.1.0
	 *
	 */
	/*function settings() {
        $tmp = Plugin::getAllSettings('themr');
        $settings = array(
                          'rowspage' => $tmp['rowspage']
                         );
        $this->display('themr/views/settings', $settings);
    }*/

    /**
	 * Documentation for Themr
	 *
	 * @since 0.1.0
	 */
	public function documentation()
    {
        $this->display('themr/views/documentation');
    }
} // end ThemrController class
