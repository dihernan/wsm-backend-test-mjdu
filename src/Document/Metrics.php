<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="Metrics")
 * @MongoDB\HasLifecycleCallbacks
 */
class Metrics
{
    /**
     * @MongoDB\Id(type="string")
     */
    private $_id;

    /**
     * @MongoDB\Field(type="date")
     */
    private $date;

    /**
     * @MongoDB\Field(type="string")
     */
    private $accountId;

    /**
     * @MongoDB\Field(type="int")
     */
    private $impressions;

    /**
     * @MongoDB\Field(type="int")
     */
    private $clicks;

    /**
     * @MongoDB\Field(type="float")
     */
    private $ctr;

    /**
     * @MongoDB\Field(type="float")
     */
    private $conversions;

    /**
     * @MongoDB\Field(type="float")
     */
    private $costPerClick;

    /**
     * @MongoDB\Field(type="float")
     */
    private $spend;
}