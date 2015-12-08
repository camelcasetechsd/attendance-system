<?php

namespace Utilities\Service\Validator;

use Zend\Validator\AbstractValidator;
use Zend\Config\Config;

/**
 * Date Validator
 * 
 * Validate date against other date being less than itself,
 * Validator is used with the end date to check start date is less than end date
 * 
 * @author Mohamed Labib <mohamed.labib@camelcasetech.com>
 * 
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
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
class DateValidator extends AbstractValidator {

    /**
     * Error codes
     * @const string
     */
    const NOT_GREATER = 'notGreater';
    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_GREATER => "DateTo should be more than DateFrom",
        self::MISSING_TOKEN => 'No token was provided to match against',
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
     * @return \Utilities\Service\Validator\DateValidator
     */
    public function setToken($token) {
        $this->tokenString = $token;
        $this->token = $token;
        return $this;
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
     * @return \Utilities\Service\Validator\DateValidator
     */
    public function setStrict($strict) {
        $this->strict = (boolean) $strict;
        return $this;
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

        $isValid = true;
        if ($token === null) {
            $this->error(self::MISSING_TOKEN);
            $isValid = false;
        }

        if ($isValid === true) {
            $strict = $this->getStrict();

            $valueDate = new \DateTime($value);
            $tokenDate = new \DateTime($token);
            if (($strict && ($valueDate < $tokenDate)) || (!$valueDate && ($value < $tokenDate))) {
                $this->error(self::NOT_GREATER);
                $isValid = false;
            }
        }
        return $isValid;
    }

}
