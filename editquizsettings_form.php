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
 * Settings form for the editquizsettings report.
 *
 * @package    quiz_editquizsettings
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/quiz/report/reportlib.php');
require_once($CFG->dirroot . '/lib/formslib.php');

/**
 * Settings form for the editquizsettings report.
 *
 * @copyright  2012 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quiz_report_editquizsettings_form extends moodleform {

    /**
     * Define the form.
     */
    protected function definition() {
        global $CFG;
        $mform = $this->_form;
        $this->_form->updateAttributes(['id' => 'quiz_editquizsettings_form']);

        $mform->addElement('header', 'heading', get_string('editquizsettings', 'quiz_editquizsettings'));

        $mform->addElement('static', 'quiznamestr',
                            get_string('name', 'quiz_editquizsettings'),
                            html_writer::tag('strong', $this->_customdata['quizname']));
        $mform->addElement('static', 'idnumberstr',
                            get_string('idnumber', 'quiz_editquizsettings'),
                            html_writer::tag('strong', $this->_customdata['idnumber']));

        $mform->addElement('header', 'timing', get_string('timing', 'quiz'));

        // Open and close dates.
        $mform->addElement('date_time_selector', 'timeopen', get_string('quizopen', 'quiz'),
            ['optional' => true, 'step' => 1]);
        $mform->addHelpButton('timeopen', 'quizopenclose', 'quiz');

        $mform->addElement('date_time_selector', 'timeclose', get_string('quizclose', 'quiz'),
            ['optional' => true, 'step' => 1]);

        $this->add_action_buttons(true, get_string('savechanges', 'quiz_editquizsettings'), false);
    }

    #[\Override]
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Check open and close times are consistent.
        if ($data['timeopen'] != 0 && $data['timeclose'] != 0 &&
                $data['timeclose'] < $data['timeopen']) {
            $errors['timeclose'] = get_string('closebeforeopen', 'quiz');
        }
        return $errors;
    }
}
