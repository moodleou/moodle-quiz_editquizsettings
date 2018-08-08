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
 * This tool allows selected users to edit selected quiz settings.
 *
 * @package   quiz_editquizsettings
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/report/default.php');

/**
 * This tool allows selected users to edit selected quiz settings.
 *
 * The 'selected users' are those with 'quiz/editquizsettings:editquizsettingsreport'.
 * Then can then edit the settings this report lets them edit, without
 * needing full permissions to edit this quiz.
 *
 * This class extends quiz_default_report class and the display() method
 * runs by /mod/quiz/report.php script. All other methods are private and
 * are not used outside this class.
 *
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quiz_editquizsettings_report extends quiz_default_report {
    /**
     * @var array fields that can be edited using this report.
     */
    private $editablefields = array('timeopen', 'timeclose');

    /**
     * Displays the results for this report
     *
     * @param object $quiz, the current quiz object
     * @param object $cm, the current course module object
     * @param object $course, the current course object
     */
    public function display($quiz, $cm, $course) {
        global $CFG, $DB;
        $modcontext = context_module::instance($cm->id);

        // If the user has 'quiz/editquizsettings:editquizsettingsreport' allow dates to be modified.
        require_capability('quiz/editquizsettings:editquizsettingsreport', $modcontext);
        require_once($CFG->dirroot . '/mod/quiz/report/editquizsettings/editquizsettings_form.php');

        $pageoptions = array();
        $pageoptions['id'] = $cm->id;
        $pageoptions['mode'] = 'editquizsettings';
        $reporturl = new moodle_url('/mod/quiz/report.php', $pageoptions);

        $mform = new quiz_report_editquizsettings_form($reporturl,
                array('quizname' => $quiz->name, 'idnumber' => $cm->idnumber), 'get');

        $data = new stdClass();
        foreach ($this->editablefields as $field) {
            $data->$field = $quiz->$field;
        }
        $mform->set_data($data);

        if ($mform->is_cancelled()) {
            redirect(new moodle_url('/mod/quiz/view.php', array('id' => $cm->id)));

        } else if ($fromform = $mform->get_data()) {
            $loginfo = '';
            $modifiedquiz = new stdClass();
            $modifiedquiz->id = $quiz->id;
            foreach ($this->editablefields as $field) {
                if ($fromform->$field == $quiz->$field) {
                    continue;
                }
                // Log that the field has been changed via editquizsettings report.
                $oldvalue = $quiz->$field;
                $newvalue = $fromform->$field;
                if ($loginfo) {
                    $loginfo .= ', ';
                }
                $loginfo .= "$field from $oldvalue to $newvalue";
                $modifiedquiz->$field = $fromform->$field;
            }
            // If quiz has been modified update quiz table and log the changes.
            if ($loginfo) {
                $DB->update_record('quiz', $modifiedquiz);
                $info = "updated quiz table: $loginfo";

                // Log quiz settings edit event.
                $event = \quiz_editquizsettings\event\quiz_settings_edited::create(
                     array('objectid' => $quiz->id, 'context' => context_module::instance($cm->id)));
                $event->set_loginfo($info);
                $event->trigger();

                // Update the calendar relating to this quiz.
                quiz_update_events($quiz);

                // Update related grade item.
                quiz_grade_item_update($quiz);

                // At the moment, it does not seem to be necessary to trigger the
                // mod_updated event for this change, because none of the code
                // that catches that event seems to care about dates.
            }
            redirect(new moodle_url('/mod/quiz/view.php', array('id' => $cm->id)));
        }
        $this->print_header_and_tabs($cm, $course, $quiz, 'editquizsettings');
        $mform->display();
    }
}
