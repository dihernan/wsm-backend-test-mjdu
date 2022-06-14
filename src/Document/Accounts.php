<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="Accounts")
 * @MongoDB\HasLifecycleCallbacks
 */
class Accounts
{
    /**
     * @MongoDB\Id(type="int")
     */
    private $_id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $accountId;

    /**
     * @MongoDB\Field(type="int")
     */
    private $externalAccountId;

    /**
     * @MongoDB\Field(type="string")
     */
    private $currencyCode;

    /**
     * @MongoDB\Field(type="string")
     */
    private $status;

    /**
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @MongoDB\Field(type="string")
     */
    private $accountName;
}