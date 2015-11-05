Feature: test the notification functionality
new notification appear in side menu when created
disappear when clicked on notification
manager and others should see notifications

    Scenario: Failed Login
    Given I am on "/sign/in"
    When I fill in the following:
      | username | nouser@nomail.com |
      | password | nopassword |
    And I press "login"
    Then I should be on "/sign/in"

  Scenario: Successful Login
    Given I am on "/sign/in"
    When I fill in the following:
      | username | admin |
      | password | admin |
    And I press "login"
    Then I should be on "/index"

