<?php
/**
 * @version     1.0.3
 * @package     Components
 * @subpackage  admin.com_jvcounter.models
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

require_once __DIR__ . DIRECTORY_SEPARATOR. 'helper.php';
require_once('administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_jvcounter'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'jvcounter.php');

$jvcissunday 		= $params->get('jvcissunday', 1);
$jvcshowstatistics = $params->get('', 1);
$jvcshowtoday = $params->get('jvcshowtoday', 1);
$jvcshowyesterday = $params->get('jvcshowyesterday', 1);
$jvcshowthisweek = $params->get('jvcshowthisweek', 1);
$jvcshowlastweek = $params->get('jvcshowlastweek', 1);
$jvcshowthismonth = $params->get('jvcshowthismonth', 1);
$jvcshowlastmonth = $params->get('jvcshowlastmonth', 1);
$jvcshowall = $params->get('jvcshowall', 1);
$jvcshowdigit = $params->get('jvcshowdigit', 1);
$jvcshowdigit = $params->get('jvcshowdigit', 1);
$showhrline = $params->get('showhrline', 1);
$showonlinevisits = $params->get('showonlinevisits',1);
$jvcnumberofdigits 	= $params->get('jvcnumberofdigits', 6);
$jvcdigittype = $params->get('jvcdigittype', 'default');
$jvcshowonlinevisitors = $params->get('jvcshowonlinevisitors', 1);

$jvcstatstype = $params->get('jvcstatstype', 'default');
$jvccachetime = (int) $params->get('jvccachetime', 1);

/** Get time offset from global configuration **/
$config	= JFactory::getConfig();
$offset	= $config->get('offset');

$iscache = JFactory::getCache();
$jvccachetime *= 60;
if( $jvccachetime < 0 || $jvccachetime > 3600) {
    $jvccachetime = DEFAULT_CACHE_TIMEOUT * 60;
}
$iscache->setLifeTime( $jvccachetime);

$now = time();

$datetime = modJVCounterHelper::getDateTime($offset, $jvcissunday, $now);

/** computing visitors numbers */
// today's visits
$visitorsarray	= JvcounterModelJvcounter::getVisits();
$todayvisitors = $visitorsarray['visits'];

if( $jvcshowyesterday ) {
    if( $iscache ) {
        $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), $datetime["localyesterdaystart"], $datetime["localdaystart"]);
    }
    else {
        $visitorsarray = JvcounterModelJvcounter::getVisits( $datetime["localyesterdaystart"], $datetime["localdaystart"]);
    }
    $yesterdayvisitors = $visitorsarray['visits'];
}

if( $jvcshowthisweek ) {
    if( $iscache ) {
        $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), $datetime["localweekstart"], $datetime["localdaystart"]);
    }
    else {
        $visitorsarray = JvcounterModelJvcounter::getVisits( $datetime["localweekstart"], $datetime["localdaystart"]);
    }
    $thisweekvisitors = $visitorsarray["visits"];
    $thisweekvisitors += $todayvisitors ;
}

if( $jvcshowlastweek ) {
    if( $iscache ) {
        $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), $datetime["locallastweekstart"], $datetime["localweekstart"]);
    }
    else {
        $visitorsarray = JvcounterModelJvcounter::getVisits( $datetime["locallastweekstart"], $datetime["localweekstart"]);
    }
    $lastweekvisitors = $visitorsarray['visits'];
}

if( $jvcshowthismonth ) {
    if( $iscache ) {
        $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), $datetime["localmonthstart"], $datetime["localdaystart"]);
    }
    else {
        $visitorsarray = JvcounterModelJvcounter::getVisits( $datetime["localmonthstart"], $datetime["localdaystart"]);
    }
    $thismonthvisitors = $visitorsarray['visits'];
    $thismonthvisitors += $todayvisitors;
}

if( $jvcshowlastmonth ) {
    if( $iscache ) {
        $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), $datetime["locallastmonthstart"], $datetime["localmonthstart"]);
    }
    else {
        $visitorsarray = JvcounterModelJvcounter::getVisits( $datetime["locallastmonthstart"], $datetime["localmonthstart"]);
    }
    $lastmonthvisitors = $visitorsarray['visits'];
}

if( $iscache ) {
    $visitorsarray = $iscache->call(array('JvcounterModelJvcounter', 'getVisits'), 0, $datetime["localdaystart"]);
}
else {
    $visitorsarray = JvcounterModelJvcounter::getVisits( 0, $datetime["localdaystart"]);
}
$allvisitors = $visitorsarray['visits'];
$allvisitors += $todayvisitors ;

$online_time	= ONLINE_DEFAULT_TIME;
$online_time	*=	60;

if( $jvcshowonlinevisitors ) {
    $onlinevisitorsarray =  JvcounterModelJvcounter::getVisits( 0, 0, $online_time);
    $onlinevisits = $onlinevisitorsarray['visits'];
}

require JModuleHelper::getLayoutPath('mod_jvcounter', $params->get('layout', 'default'));