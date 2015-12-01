<?php

namespace Utilities\Service\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Config\Config;

/**
 * Description of CustomTimeValidator
 *
 * @author ahmed
 */
class TimeValidator extends AbstractValidator {

    const NOT_GREATER = 'notGreater';

//    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_GREATER => "End time should be greater than start time",
//        self::MISSING_TOKEN => 'No token was provided to match against',
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
     *
     * @param mixed $token
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
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }

    /**
     * Set token against which to compare
     *
     * @param  mixed $token
     * @return TimeValidator
     */
    public function setToken($token) {
        $this->tokenString = $token;
        $this->token = $token;
        return $this;
    }

    protected function explodeToken($token) {
        $startTime = explode(":", $token);
        $token = $startTime;
        return $token;
    }

    /**
     * Returns the strict parameter
     *
     * @return boolean
     */
    public function getStrict() {
        return $this->strict;
    }

    /**
     * Sets the strict parameter
     *
     * @param bool $strict
     * @return TimeValidator
     */
    public function setStrict($strict) {
        $this->strict = (boolean) $strict;
        return $this;
    }

    protected function explodeValue($value) {
        $endTime = explode(":", $value);
        $value = $endTime;
        return $value;
    }

    /**
     * Returns true if and only if a token has been set and the provided value
     * matches that token.
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null) {

        #$endTime=  explode(":", $value);
        #$value=$endTime[0];
        $this->setValue($value);

        if (($context !== null) && isset($context) && array_key_exists($this->getToken(), $context)) {
            $token = $context[$this->getToken()];
        } else {
            $token = $this->getToken();
        }


        $strict = $this->getStrict();
        $token = $this->explodeToken($token);
        $value = $this->explodeValue($value);


        //compare hours
        if (($strict && ($value[0] < $token[0]))) {
            $this->error(self::NOT_GREATER);
            return false;
            //compare minutes
        } else if ($strict && ($value[0] == $token[0]) && ( ($value[1] == $token[1]) || ($value[1] < $token[1]))) {
            $this->error(self::NOT_GREATER);
            return false;
        } else {
            return true;
        }
    }

}
