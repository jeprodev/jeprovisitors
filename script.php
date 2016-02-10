<?php
/**
 * @package     Components
 * @subpackage  com_jvcounter
 * @link 		http://jeprodev.net
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

class com_jvcounterInstallerScript
{
    protected $_jvcounter_extension = "com_jvcounter";

    /**
     * method to install the component
     * return void
     * */
    function install($parent){

    }

    /**
     * method to uninstall the component
     * @param $parent
     * @return void
     */
    function uninstall($parent){

    }

    /**
     * method to update the component
     * @param $parent
     * @return void
     */
    function update($parent){

    }

    /**
     * method to run before an install/update/uninstall method
     * @param $type
     * @param $parent
     * @return void
     */
    function preflight($type, $parent){
        if(in_array($type, array('install', 'discover_install'))){
            $this->bugfixDBFunctionReturnedNoError();
        } else {
            $this->bugfixCantBuildAdminMenus();
        }
    }

    /**
     * method to run after an install/uninstall/update method
     */
    function postflight($type, $parent){

    }

    function bugfixDBFunctionReturnedNoError(){
        $db = JFactory::getDBO();
    }

    function bugfixCantBuildAdminMenus()
    {
        $db = JFactory::getDBO();
    }
}