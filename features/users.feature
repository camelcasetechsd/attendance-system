Feature: Users

Scenario: Successful Login As Admin
    Given I am on "/sign/in"
    When I fill in the following:
      | username | admin |
      | password | admin |
    And I press "login"
    Then I should be on "/index"

Scenario: List create user
    Given I mock the login session
    And I am on "/index"
    And I follow "users"
    Then I should be on "/users"

Scenario: open user form 
    Given I mock the login session
    And I am on "/users"
    And I follow "Create new User"
    Then I should be on "/users/index/new"

Scenario: create user
    Given I mock the login session
    And I am on "/users/index/new"
    When I fill in "username" with "TestUser"
    When I fill in "password" with "password"
    When I fill in "confirmPassword" with "password"
    When I fill in "name" with "User"
    When I fill in "mobile" with "01115991948"
    When I fill in "dateOfBirth" with "02/15/1992"
    When I fill in "startDate" with "07/01/2015"
    When I fill in "description" with "New Employee"
    When I select "Single" from "maritalStatus"
    When I select "Cairo Branch" from "branch"
    When I select "CSI Department" from "department"
    When I select "Manager Manager" from "manager"
    When I select "Junior Software Developer" from "position"
    Then I should be on "/users/index/new"
