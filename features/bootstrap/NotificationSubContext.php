<?php

use Behat\Behat\Context\BehatContext;
use Behat\Mink\Exception\ExpectationException;

/**
 * Specific feature context for notifications
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 */
class NotificationSubContext extends BehatContext
{
    /**
     *
     * @var array key hold user name and value is unseen notifications count  
     */
    private $_notificationCountPerUser;
    /**
     *
     * @var array key hold user name and value is last request id
     */
    private $_lastRequestPerUser;
    
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
    }
    
    /**
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @When /^I store notifications count for "([^"]*)"$/
     * 
     * @param string $userName
     */
    public function iStoreNotificationsCount($userName)
    {
        $this->_notificationCountPerUser[$userName] = 0;
        if($this->getMainContext()->getSession()->getPage()->has("css",".notification_count")){
            $this->_notificationCountPerUser[$userName] = $this->getMainContext()->getSession()->getPage()->find("css",".notification_count")->getText();
        }
    }

    /**
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @Given /^I store request "([^"]*)" for "([^"]*)"$/
     * 
     * @param string $requestType
     * @param string $userName
     */
    public function iStoreRequestFor($requestType, $userName)
    {
        $requests = $this->getMainContext()->getSession()->getPage()->findAll("css","table.$requestType a");
        $lastRequest = end($requests);
        $link = $lastRequest->getAttribute("href");
        $requestId = filter_var($link, FILTER_SANITIZE_NUMBER_INT);
        $this->_lastRequestPerUser[$userName] = $requestId;
    }

    
    /**
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @Given /^I check notifications count "([^"]*)" for "([^"]*)"$/
     * 
     * @param string $countChange ,possible values are "increased" or "decreased"
     * @param string $userName
     */
    public function iCheckNotificationsCount($countChange, $userName)
    {
        if($this->getMainContext()->getSession()->getPage()->has("css",".notification_count")){
            $newNotificationCountPerUser = $this->getMainContext()->getSession()->getPage()->find("css",".notification_count")->getText();
        }
        $oldNotificationCountPerUser = $this->_notificationCountPerUser[$userName];
        if(($countChange == "increased" && $newNotificationCountPerUser <= $oldNotificationCountPerUser)
                || ($countChange == "decreased" && $newNotificationCountPerUser >= $oldNotificationCountPerUser) ){
            throw new ExpectationException(/*$message =*/"Notifications count is not $countChange", $this->getMainContext()->getSession());
        }
    }

    /**
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * @access public
     * 
     * @Given /^I "([^"]*)" employee "([^"]*)" request for "([^"]*)"$/
     * 
     * @param string $requestAction
     * @param string $userName
     * @param string $requestType
     */
    public function iProcessEmployeeRequestFor($requestAction, $userName, $requestType)
    {
        $requestId = $this->_lastRequestPerUser[$userName];
        $page = "/requests/myrequests/$requestAction/id/$requestId/requesttype/$requestType";
        $this->getMainContext()->getSession()->visit($this->getMainContext()->locatePath($page));
    }

}