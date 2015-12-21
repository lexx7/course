<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 19.12.2015
 * Time: 23:27
 */

namespace Course\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="courses") */
class Courses
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="integer") */
    private $numCode;

    /** @ODM\Field(type="string") */
    private $charCode;

    /** @ODM\Field(type="integer") */
    private $nominal;

    /** @ODM\Field(type="string") */
    private $name;

    /** @ODM\Field(type="float") */
    private $value;

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param field_type $id
     * @return Courses
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param field_type $name
     * @return Courses
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumCode()
    {
        return $this->numCode;
    }

    /**
     * @param mixed $numCode
     * @return Courses
     */
    public function setNumCode($numCode)
    {
        $this->numCode = $numCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharCode()
    {
        return $this->charCode;
    }

    /**
     * @param mixed $charCode
     * @return Courses
     */
    public function setCharCode($charCode)
    {
        $this->charCode = $charCode;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNominal()
    {
        return $this->nominal;
    }

    /**
     * @param mixed $nominal
     * @return Courses
     */
    public function setNominal($nominal)
    {
        $this->nominal = $nominal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return Courses
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}