<?php
/**
 * @version     1.0.3
 * @package     plugins
 * @subpackage  plg_jvcounter
 * @group       system
 * @link http://jeprodev.net
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

jimport('joomla.plugin.plugin');

class plgSystemJvcounter extends JPlugin {
    function onAfterInitialise(){
        $config = JFactory::getConfig();
        $lifeTime = (int)$config->get('lifetime');
        $offset = (float) $config->get('offset');

        $jvcSessionTime = $this->params->get('jvc_session_time', 15);
        $jvcSessionTime = min($jvcSessionTime, $lifeTime);

        /** determine date  */
        $now = time();
        $hourStart = $now - ($now % 3600);

        $filePath = JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_jvcounter'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'jvcounter.php';

        if(file_exists($filePath)){
            require_once $filePath;
        }else{
            return;
        }

        $lastTime = JvcounterModelJvcounter::lastTimeLog();

        if(!$lastTime){
            $visits = JvcounterModelJvcounter::getOnlineVisits($jvcSessionTime);
            JvcounterModelJvcounter::insertLog($now, $visits);
            $lasttime = $now;
        }else{
            $now = time();
            if($lastTime < $hourStart){
                $visits = JvcounterModelJvcounter::getVisitsFromSession($lastTime + 1, $hourStart);
                JvcounterModelJvcounter::insertLog($hourStart, $visits);
                $lastTime = $hourStart;
            } else if($now >= $lastTime + $jvcSessionTime){
                $visits = JvcounterModelJvcounter::getVisitsFromSession($lastTime + 1);
                JvcounterModelJvcounter::insertLog($now, $visits);
                $lastTime = $now;
            }
        }

        $now = time();
        if(($now % 86400) < 60){
            JvcounterModelJvcounter::removeNullLogs();
        }
    }
}