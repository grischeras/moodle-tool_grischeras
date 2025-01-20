@tool @tool_grischeras @javascript
Feature: Creating, editing and deleting entries
  In order to manage entries
  As a teacher
  I need to be able to add, edit and delete entries

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher | teacher   | test       | teacher@moodle.com |
    And the following "courses" exist:
      | fullname | shortname | format |
      | Course1  | cs1 | weeks |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher  | cs1     | editingteacher |

  Scenario: I must be able to edit a record
    When I log in as "teacher"
    And I am on "Course1" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    When I follow "Insert new item"
    And I logout