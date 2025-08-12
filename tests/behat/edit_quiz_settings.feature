@ou @ou_vle @mod @mod_quiz @quiz @quiz_editquizsettings
Feature: Edit quiz settings, in order to edit the settings (dates) we need to
  create a quiz, then using the esitquizsettings report to edit the settings
  such as opening or closing dates.

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email              |
      | manager  | M         | Manager  | manager@moodle.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user    | course | role           |
      | manager | C1     | manager        |
    When I log in as "admin"
    And I am on "Course 1" course homepage with editing mode on
    And the following "activities" exist:
      | activity | name   | intro              | course | section | timeopen   | timeclose  |
      | quiz     | Quiz 1 | Quiz 1 description | C1     | 1       | 1521556200 | 1540045800 |
    And I log out

  @javascript
  Scenario: Manager goes to Quiz administration => Results => Edit quiz settings and edits the open and close dates, then admin user checks the Timing section in quiz form.
    When I am on the "Quiz 1" "quiz_editquizsettings > Report" page logged in as "manager"
    Then I should see "Edit quiz settings"
    And I set the field "id_timeopen_day" to "30"
    And I set the field "id_timeopen_month" to "April"
    And I set the field "id_timeclose_day" to "30"
    And I set the field "id_timeclose_month" to "November"
    And I press "Save changes"
    And I log out

    And I am on the "Quiz 1" "quiz activity editing" page logged in as "admin"
    And I should see "Timing"
    And I follow "Timing"
    And the field "id_timeopen_day" matches value "30"
    And the field "id_timeopen_month" matches value "April"
    And the field "id_timeclose_day" matches value "30"
    And the field "id_timeclose_month" matches value "November"

  @javascript
  Scenario: Manager goes to Quiz administration => Results => Edit quiz settings and edits the dates, then admin user checks the Timing section in quiz form.
    When I am on the "Quiz 1" "quiz_editquizsettings > Report" page logged in as "manager"
    Then I should see "Edit quiz settings"
    And I set the field "id_timeopen_day" to "1"
    And I set the field "id_timeopen_month" to "May"
    And I press "Save changes"
    And I log out

    And I am on the "Quiz 1" "quiz activity editing" page logged in as "admin"
    And I should see "Timing"
    And I follow "Timing"
    And the field "id_timeopen_day" matches value "1"
    And the field "id_timeopen_month" matches value "May"
