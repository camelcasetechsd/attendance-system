Feature: Notifications
  In order to stay notified with all updates
  As a logged in system user
  All updates produce appropriate notifications for users

  Scenario: Notification display for both manager and employee
    Given I mock the login session with "Manager" "manager"
    When I store notifications count for "Manager"
    Then I go to "/sign/out"
    Given I mock the login session with "user" "12345678"
    When I go to "/requests/permission/new"
      And I store notifications count for "user"
      And I fill in "date" with "10/10/2016"
      And I fill in "fromTime" with "00:00:00"
      And I fill in "toTime" with "01:00:00"
      And I press "submit"
    Then I should be on "/requests/myrequests/index"
      And I store request "permission" for "user"
      And I go to "/sign/out"
    Given I mock the login session with "Manager" "manager"
    Then I should see a ".notification_count" element
      And I check notifications count "increased" for "Manager"
      And I "approve" employee "user" request for "Permission"
      And I should be on "/requests/myrequests/index"
      And I go to "/sign/out"
    Given I mock the login session with "user" "12345678"
    Then I should see a ".notification_count" element
      And I check notifications count "increased" for "user"