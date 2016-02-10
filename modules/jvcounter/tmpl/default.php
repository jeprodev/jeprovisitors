<?php
/**
 * @version     1.0.3
 * @package     Components
 * @subpackage  com_jvcounter
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
$doc = JFactory::getDocument();
$doc->addStyleSheet('modules/mod_jvcounter/assets/jvcounter.css');
?>
<div id="jvcounter">
    <?php if( $jvcshowstatistics ) {?>
    <div id="jvcounter_stats">
        <table cellpadding="2px;" cellspacing="0">
            <?php $statistics = "";
            if( $jvcshowtoday ){
            $timeline = modJVCounterHelper::showtimeline( $datetime["localdaystart"], 0, $offset);
            $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 't_visits', $timeline, JText::_('MOD_JVCOUNTER_TODAY_LABEL'), $todayvisitors);
            }
            if ( $jvcshowyesterday ) {
                $timeline = modJVCounterHelper::showtimeline( $datetime["localyesterdaystart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'y_visits', $timeline, JText::_('MOD_JVCOUNTER_YESTERDAY_LABEL'), $yesterdayvisitors);
            }
            if ( $jvcshowthisweek ) {
                $timeline = modJVCounterHelper::showTimeLine( $datetime["localweekstart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'w_visits', $timeline, JText::_('MOD_JVCOUNTER_THIS_WEEK_LABEL'), $thisweekvisitors);
            }
            if ( $jvcshowlastweek ) {
                $timeline = modJVCounterHelper::showTimeLine( $datetime["locallastweekstart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'lw_visits', $timeline, JText::_('MOD_JVCOUNTER_LAST_WEEK_LABEL'), $lastweekvisitors);
            }
            if ( $jvcshowthismonth) {
                $timeline = modJVCounterHelper::showtimeline( $datetime["localmonthstart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'm_visits', $timeline, JText::_('MOD_JVCOUNTER_THIS_MONTH_LABEL'), $thismonthvisitors);
            }
            if ( $jvcshowlastmonth) {
                $timeline = modJVCounterHelper::showTimeLine( $datetime["locallastmonthstart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'lm_visits', $timeline, JText::_('MOD_JVCOUNTER_LAST_MONTH_LABEL'), $lastmonthvisitors);
            }
            if ( $jvcshowall ) {
                $timeline = modJVCounterHelper::showTimeLine( $datetime["localyesterdaystart"], 0, $offset);
                $statistics .= modJVCounterHelper::showStatisticsRows($jvcstatstype, 'all_visits', $timeline, JText::_('MOD_JVCOUNTER_ALL_LABEL'), $allvisitors);
            }
            echo $statistics;
            ?>
        </table>
    </div>
    <?php } ?>
    <?php if( $jvcshowdigit ) { ?>
    <div id="jvcounterdigit">
        <?php
        $arr = modJVCounterHelper::getDigits($allvisitors, $jvcnumberofdigits);
        $digit_img = '';
        foreach( $arr as $digit ){
            $digit_img .= modJVCounterHelper::showDigitImage( $jvcdigittype, $digit);
        }
        echo $digit_img;
        ?>
    </div>
    <?php }?>
    <?php if( $showhrline ){?>
    <hr />
    <?php } ?>
    <?php if( $showonlinevisits ){  ?>
    <div id="jvcounter-online">
        <?php
        $onlinevisitscounts = $onlinevisitorsarray['guests'] + $onlinevisitorsarray['bots'] + $onlinevisitorsarray['members'];
        $onlinevisits = JText::_('MOD_JVCOUNTER_THERE_ARE_VISITORS_ONLINE' ).': &nbsp;'.$onlinevisitscounts .' ' . JText::_('MOD_JVCOUNTER_ONLINE_LABEL').'<br>';
        $online_str = '';

        if ( $onlinevisitorsarray['guests']) {
            $online_str .=  $onlinevisitorsarray['guests'].' '.JText::_('MOD_JVCOUNTER_GUESTS_LABEL' ) . '<br>';
        }
        if ( $onlinevisitorsarray['members']) {
            $online_str .= $onlinevisitorsarray['members'].' '.JText::_('MOD_JVCOUNTER_MEMBERS_LABEL') . '<br>';
        }
        if ( $onlinevisitorsarray['bots']) {
            $online_str .= $onlinevisitorsarray['bots'].' '. JText::_('MOD_JVCOUNTER_BOTS_LABEL' ) . '<br>';
        }
        echo $onlinevisits;
        echo $online_str;
        ?>
    </div>
    <?php } ?>
</div>