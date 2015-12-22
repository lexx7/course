<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 19.12.2015
 * Time: 23:27
 */

namespace Course\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="logsClient") */
class LogsClient
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="string") */
    private $request;

    /** @ODM\Field(type="string") */
    private $headers;

    /** @ODM\Field(type="string") */
    private $ipAddress;

    /** @ODM\Field(type="date") */
    private $datetime;

    /** @ODM\Field(type="string") */
    private $duration;

    /** @ODM\Field(type="string") */
    private $response;

    /**
     * @return $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $request
     * @return LogsClient
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $headers
     * @return LogsClient
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     * @return LogsClient
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     * @return LogsClient
     */
    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     * @return LogsClient
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     * @return LogsClient
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}