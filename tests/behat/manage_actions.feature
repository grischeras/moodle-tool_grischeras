@tool @tool_grischeras
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
  @javascript
  Scenario: I must be able to edit a record
    When I log in as "admin"
    And I am on "Course1" course homepage
    And I navigate to "My first Moodle plugin" in current page administration
    When I follow "Insert new item"
    And I set the following fields to these values:
      | Name      | Foo 1   |
      | Priority  | 10      |
    And I press "Save changes"
    Then the following should exist in the "tool_grischeras_list" table:
      | name      | completed   | priority |
      | Foo 1     | 0           | 10        |
    And I follow "edit"
    And I set the following fields to these values:
      | Name      | Foo 2   |
      | Priority  | 5     |
    And I press "Save changes"
    Then the following should exist in the "tool_grischeras_list" table:
      | name      | completed   | priority |
      | Foo 2     | 0           | 5        |
    And I log out
