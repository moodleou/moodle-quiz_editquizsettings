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
    And I am on "Course 1" course homepage
    And I turn editing mode on
    And I add a "Quiz" to section "1" and I fill the form with:
      | Name                 | Quiz 1             |
      | Description          | Quiz 1 description |
      | id_timeopen_enabled  | 1                  |
      | id_timeopen_day      | 20                 |
      | id_timeopen_month    | March              |
      | id_timeopen_year     | 2018               |
      | id_timeopen_hour     | 14                 |
      | id_timeopen_minute   | 30                 |
      | id_timeclose_enabled | 1                  |
      | id_timeclose_day     | 20                 |
      | id_timeclose_month   | October            |
      | id_timeclose_year    | 2018               |
      | id_timeclose_hour    | 14                 |
      | id_timeclose_minute  | 30                 |
    And I log out

  @javascript
  Scenario: Manager goes to Quiz administration => Results => Edit quiz settings and edits the open and close dates, then admin user checks the Timing section in quiz form.
    When I log in as "manager"
    And I am on "Course 1" course homepage
    And I follow "Quiz 1"
    Given I navigate to "Edit quiz settings" node in "Quiz administration > Results"
    Then I should see "Edit quiz settings"
    And I set the field "id_timeopen_day" to "30"
    And I set the field "id_timeopen_month" to "April"
    And I set the field "id_timeclose_day" to "30"
    And I set the field "id_timeclose_month" to "November"
    And I press "Save changes"
    And I log out

    When I log in as "admin"
    And I am on "Course 1" course homepage
    And I follow "Quiz 1"
    Given I navigate to "Edit settings" node in "Quiz administration"
    Then I should see "Edit settings"
    And I follow "Edit settings"
    And I should see "Timing"
    And I follow "Timing"
    Then the field "id_timeopen_day" matches value "30"
    And the field "id_timeopen_month" matches value "April"
    And the field "id_timeclose_day" matches value "30"
    And the field "id_timeclose_month" matches value "November"

  @javascript
  Scenario: Manager goes to Quiz administration => Results => Edit quiz settings and edits the dates, then admin user checks the Timing section in quiz form.
    When I log in as "manager"
    And I am on "Course 1" course homepage
    And I follow "Quiz 1"
    Given I navigate to "Edit quiz settings" node in "Quiz administration > Results"
    Then I should see "Edit quiz settings"
    And I set the field "id_timeopen_day" to "1"
    And I set the field "id_timeopen_month" to "May"
    And I press "Save changes"
    And I log out

    When I log in as "admin"
    And I am on "Course 1" course homepage
    And I follow "Quiz 1"
    Given I navigate to "Edit settings" node in "Quiz administration"
    Then I should see "Edit settings"
    And I follow "Edit settings"
    And I should see "Timing"
    And I follow "Timing"
    Then the field "id_timeopen_day" matches value "1"
    And the field "id_timeopen_month" matches value "May"
