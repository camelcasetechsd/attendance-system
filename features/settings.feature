Feature: Settings

Scenario: Successful Login
    Given I am on "/sign/in"
    When I fill in the following:
      | username | admin |
      | password | admin |
    And I press "login"
    Then I should be on "/index"

  

Scenario: open vacations 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "vacation"
    Then I should be on "/settings/vacation/index"
Scenario: list create vacation form 
    Given I mock the login session
    And I am on "/settings/vacation/index"
    And I follow "Create new Vacation"
    Then I should be on "/settings/vacation/new"
Scenario: create new vacation
    Given I mock the login session
    And I am on "/settings/vacation/new"
    When I fill in "type" with "Test Vacation"
    When I fill in "description" with "Test Vacation"
    When I fill in "balance" with "1"
    And I press "Create"
    Then I should be on "/settings/vacation/index"


Scenario: open branches 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "branches"
    Then I should be on "/settings/branches/index"
Scenario: list create branch form 
    Given I mock the login session
    And I am on "/settings/branches/index"
    And I follow "Create new Branch"
    Then I should be on "/settings/branches/new"
Scenario: create new branch
    Given I mock the login session
    And I am on "/settings/branches/new"
    When I fill in "name" with "Test Branch"
    When I fill in "description" with "Test Branch"
    When I fill in "address" with "Giza"
    When I select "Manager Manager" from "manager"
    And I press "Create"
    Then I should be on "/settings/branches/index"


Scenario: open department 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "departments"
    Then I should be on "/settings/departments/index"
Scenario: list create department form 
    Given I mock the login session
    And I am on "/settings/departments/index"
    And I follow "Create new Department"
    Then I should be on "/settings/departments/new"
Scenario: create new department
    Given I mock the login session
    And I am on "/settings/departments/new"
    When I fill in "name" with "Test Department"
    When I fill in "description" with "Test Department"
    When I fill in "address" with "Giza"
    When I select "Manager Manager" from "manager"
    And I press "Create"
    Then I should be on "/settings/departments/index"


Scenario: open holidays 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "holidays"
    Then I should be on "/settings/holiday/index"
Scenario: list create holiday form 
    Given I mock the login session
    And I am on "/settings/holiday/index"
    And I follow "Create new Holiday"
    Then I should be on "/settings/holiday/new"
Scenario: create new holiday
    Given I mock the login session
    And I am on "/settings/holiday/new"
    When I fill in "name" with "Test holiday"
    When I fill in "dateFrom" with "08/19/2015"
    When I fill in "dateTo" with "08/25/2015"
    And I press "Create"
    Then I should be on "/settings/holiday/index"


Scenario: open attendance 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "attendance"
    Then I should be on "/settings/attendance/index"
  Scenario: list create attendance form 
    Given I mock the login session
    And I am on "/settings/attendance/index"
    And I follow "Create new Attendance"
    Then I should be on "/settings/attendance/new"
  Scenario: create new attendance
    Given I mock the login session
    And I am on "/settings/attendance/new"
    When I fill in "startTime" with "00:00:00"
    When I fill in "endTime" with "01:00:00"
    When I select "Test Branch" from "branch"
    And I press "Create"
    Then I should be on "/settings/attendance/index"


Scenario: open Positions 
    Given I mock the login session
    And I am on "/index"
    And I follow "settings"
    And I follow "positions"
    Then I should be on "/settings/position/index"
Scenario: list create position form 
    Given I mock the login session
    And I am on "/settings/position/index"
    And I follow "Create new Position"
    Then I should be on "/settings/position/new"
Scenario: create new position
    Given I mock the login session
    And I am on "/settings/position/new"
    When I fill in "name" with "Tester"
    When I fill in "description" with "Testing Tests :D"
    And I press "Create"
    Then I should be on "/settings/position/index"