<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The quiz_settings_edited event.
 *
 * @package    quiz_editquizsettings
 * @copyright  2014 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 namespace quiz_editquizsettings\event;
 defined('MOODLE_INTERNAL') || die();

 /**
  * Event generated when quissettings are edited via quiz_editquizsettings plugin.
  *
  * @package quiz_editquizsettings
  * @copyright 2014 The Open University
  * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
  */
class quiz_settings_edited extends \core\event\base {
    private $loginfo = '';

    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'quiz';
    }

    public static function get_name() {
        return get_string('quizsettings_edited', 'quiz_editquizsettings');
    }

    public function get_description() {
        return "User {$this->userid} has edited the quiz settings with id {$this->objectid}.";
    }

    public function get_url() {
        return new \moodle_url('/mod/quiz/report/editquizsettings/editquizsettings.php', array('id' => $this->context->instanceid));
    }
    public function set_loginfo($loginfo) {
        $this->loginfo = $loginfo;
    }

    public function get_legacy_logdata() {
        $logaction = 'edit settings';
        $loginfo = $this->loginfo;
        $pluginname = 'quiz_editquizsettings';
        $url = '..//mod/quiz/report.php?id=' . $this->objectid . '&mode=editquizsettings';
        return array($this->courseid, $pluginname, $logaction, $url, $loginfo, $this->objectid, $this->contextinstanceid);
    }
}
