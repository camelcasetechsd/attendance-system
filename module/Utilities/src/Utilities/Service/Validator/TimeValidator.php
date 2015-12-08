<?php

namespace Utilities\Service\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Config\Config;

/**
 * Time Validator
 * 
 * Validate time against other time being less than itself,
 * Validator is used with the end time to check start time is less than end time
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * @author ahmed
 * 
 * @property array $messageTemplates Error messages
 * @property array $messageVariables
 * @property string $tokenString Original token against which to validate
 * @property string $token
 * @property bool $strict ,default is bool true
 * 
 * @package utilities
 * @subpackage validator
 */
class TimeValidator extends AbstractValidator {

    /**
     * Error codes
     * @const string
     */
    const NOT_GREATER = 'notGreater';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_GREATER => "End time should be greater than start time",
    );

    /**
     * @var array
     */
    protected $messageVariables = array(
        'token' => 'tokenString'
    );

    /**
     * Original token against which to validate
     * @var string
     */
    protected $tokenString;
    protected $token;
    protected $strict = true;

    /**
     * Sets validator options
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param mixed $token ,default is null
     */
    public function __construct($token = null) {
        if ($token instanceof Config) {
            $token = $token->toArray();
        }

        if (is_array($token) && array_key_exists('token', $token)) {
            if (array_key_exists('strict', $token)) {
                $this->setStrict($token['strict']);
            }

            $this->setToken($token['token']);
        } else if (null !== $token) {
            $this->setToken($token);
        }
        
        parent::__construct();
    }

    /**
     * Retrieve token
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return string token
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set token against which to compare
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param  mixed $token
     * @return \Utilities\Service\Validator\TimeValidator
     */
    public function setToken($token) {
        $this->tokenString = $token;
        $this->token = $token;
        return $this;
    }

    /**
     * Explode token 'startTime' by ':' delimiter
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access protected
     * @param string $token
     * @return array token exploded by ':' delimiter
     */
    protected function explodeToken($token) {
        return explode(":", $token);
    }

    /**
     * Returns the strict parameter
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @return boolean strict
     */
    public function getStrict() {
        return $this->strict;
    }

    /**
     * Sets the strict parameter
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param bool $strict
     * @return \Utilities\Service\Validator\TimeValidator
     */
    public function setStrict($strict) {
        $this->strict = (boolean) $strict;
        return $this;
    }

    /**
     * Explode value 'endTime' by ':' delimiter
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     *  
     * @access protected
     * @param string $value
     * @return array value exploded by ':' delimiter
     */
    protected function explodeValue($value) {
        return explode(":", $value);
    }

    /**
     * Returns true if and only if a token has been set and the provided value
     * is greater than that token's.
     * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
     * 
     * @access public
     * @param  mixed $value
     * @param  array $context
     * @return boolean valid or not
     */
    public function isValid($value, $context = null) {

        $this->setValue($value);

        if (($context !== null) && isset($context) && array_key_exists($this->getToken(), $context)) {
            $token = $context[$this->getToken()];
        } else {
            $token = $this->getToken();
        }


        $strict = $this->getStrict();
        $token = $this->explodeToken($token);
        $value = $this->explodeValue($value);


        $isValid = true;
        //compare hours
        if (($strict && ($value[0] < $token[0]))) {
            $this->error(self::NOT_GREATER);
            $isValid = false;
            //compare minutes
        } else if ($strict && ($value[0] == $token[0]) && ( ($value[1] == $token[1]) || ($value[1] < $token[1]))) {
            $this->error(self::NOT_GREATER);
            $isValid = false;
        }
        return $isValid;
    }

}
