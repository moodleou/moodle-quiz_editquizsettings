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
 * Post-install script for the quiz editquizsettings report.
 * @package   quiz_editquizsettings
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post-install script
 */
function xmldb_quiz_editquizsettings_install() {
    global $DB;

    $dbman = $DB->get_manager();

    $record = new stdClass();
    $record->name         = 'editquizsettings';
    $record->displayorder = 2000;
    $record->cron         = 0;
    $record->capability   = 'quiz/editquizsettings:editquizsettingsreport';

    $DB->insert_record('quiz_reports', $record);
}
