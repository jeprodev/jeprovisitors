<?php
/**
 * @version     1.0.3
 * @package     Components
 * @subpackage  admin.com_jvcounter
 * @link http://jeprodev.fr.nf
 * @copyright (C) 2009 - 2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of,
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

// Require the base controller
require_once( dirname(__FILE__). DIRECTORY_SEPARATOR.'controller.php' );

// Require specific controller if requested
if( $controller = JRequest::getWord('view')) {
    $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php';
    if( file_exists($path)) {
        require_once $path;
    }
    else {
        $controller = '';
    }
}

// Create the controller
$classname = 'JvcounterController'.$controller;
$controller = new $classname();
$task = JRequest::getVar( 'task' );

// Perform the Request task
$controller->execute( $task );

// Redirect if set by the controller
$controller->redirect();