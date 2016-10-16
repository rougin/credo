<?php

/**
 * @Entity
 * @Table(name="post")
 */
class Post extends \Rougin\Credo\CodeigniterModel
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_id;

    /**
     * @Column(name="subject", type="string", length=200, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $_subject;

    /**
     * @Column(name="message", type="string", length=2, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_message;

    /**
     * @Column(name="description", type="string", length=10, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $_description;

    /**
     * Gets the subject.
     *
     * @return string
     */
    public function get_subject()
    {
        return $this->_subject;
    }
}
