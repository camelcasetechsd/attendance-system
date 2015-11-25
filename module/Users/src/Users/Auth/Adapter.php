<?php

namespace Users\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Users\Entity\User;
use Utilities\Service\Query\Query;
use Zend\Authentication\Adapter\Exception\RuntimeException;
use Zend\Authentication\Result;

class Adapter implements AdapterInterface
{

    /**
     * @var Query
     */
    protected $_query = null;

    /**
     * $_identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $_identityColumn = null;

    /**
     * $_credentialColumn - columns to be used as the credentials
     *
     * @var string
     */
    protected $_credentialColumn = null;

    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;

    /**
     * __construct() - Sets configuration options
     *
     * @param  Query                    $query
     * @param  string                   $identityColumn
     * @param  string                   $credentialColumn
     * @param  string                   $credentialTreatment
     * @return void
     */
    public function __construct($query = null, $identityColumn = null, $credentialColumn = null)
    {
        if (null !== $query) {
            $this->setQuery($query);
        }

        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) {
            $this->setCredentialColumn($credentialColumn);
        }
    }

    /**
     * 
     * setQuery() - set the Query
     * @param Query $query
     */
    public function setQuery($query)
    {
        $this->_query = $query;
        return $this;
    }

    /**
     * setIdentityColumn() - set the column name to be used as the identity column
     *
     * @param  string $identityColumn
     * @return Adapter Provides a fluent interface
     */
    public function setIdentityColumn($identityColumn)
    {
        $this->_identityColumn = $identityColumn;
        return $this;
    }

    /**
     * setCredentialColumn() - set the column name to be used as the credential column
     *
     * @param  string $credentialColumn
     * @return Adapter Provides a fluent interface
     */
    public function setCredentialColumn($credentialColumn)
    {
        $this->_credentialColumn = $credentialColumn;
        return $this;
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param  string $value
     * @return Adapter Provides a fluent interface
     */
    public function setIdentity($value)
    {
        $this->_identity = $value;
        return $this;
    }

    /**
     * setCredential() - set the credential value to be used
     *
     * @param  string $credential
     * @return Adapter Provides a fluent interface
     */
    public function setCredential($credential)
    {
        $this->_credential = $credential;
        return $this;
    }

    /**
     * authenticate() - defined by AdapterInterface.  This method is called to 
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws RuntimeException if answering the authentication query is impossible
     * @return Result
     */
    public function authenticate()
    {
        $this->_authenticateSetup();
        $entities = $this->_query->findBy(/*$userName = */'Users\Entity\User',array(
            'username' => $this->_identity,
        ));
        
        return $this->_validateResult($entities);
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with making sure
     * that this adapter was indeed setup properly with all required peices of information.
     *
     * @throws RuntimeException - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup()
    {
        $exception = null;

        if ($this->_query === null) {
            $exception = 'A database connection was not set, nor could one be created.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the Adapter authentication adapter.';
        } elseif ($this->_credentialColumn == '') {
            $exception = 'A credential column must be supplied for the Adapter authentication adapter.';
        } elseif ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with Adapter.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with Adapter.';
        }

        if (null !== $exception) {
            /**
             * @see RuntimeException
             */
            throw new RuntimeException($exception);
        }

        $this->_authenticateResultInfo = array(
            'code' => Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
        );

        return true;
    }

    /**
     * _validateResult() - This method attempts to validate that the record in the 
     * result set is indeed a record that matched the identity provided to this adapter.
     *
     * @param array $resultIdentities
     * @return Result
     */
    protected function _validateResult($resultIdentities)
    {        
        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->_authenticateResultInfo['code'] = Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) == 1) {
            $resultIdentity = $resultIdentities[0];
            $password = $resultIdentity->{$this->_credentialColumn};
            
            if (! User::verifyPassword($this->_credential, $password)) {
                $this->_authenticateResultInfo['code'] = Result::FAILURE_CREDENTIAL_INVALID;
                $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            } else {
                $this->_authenticateResultInfo['code'] = Result::SUCCESS;
                $this->_authenticateResultInfo['identity'] = $this->_identity;
                $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
            }
        } else {
            $this->_authenticateResultInfo['code'] = Result::FAILURE_UNCATEGORIZED;
        }

        return $this->_authenticateCreateAuthResult();
    }

    /**
     * _authenticateCreateAuthResult() - This method creates a Result object
     * from the information that has been collected during the authenticate() attempt.
     *
     * @return Result
     */
    protected function _authenticateCreateAuthResult()
    {
        return new Result(
                $this->_authenticateResultInfo['code'], $this->_authenticateResultInfo['identity'], $this->_authenticateResultInfo['messages']
        );
    }

}
