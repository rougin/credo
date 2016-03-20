<?php

/**
 * @Entity(repositoryClass="User_repository")
 * @Table(name="user")
 */
class User extends CI_Model {

    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_id;

    /**
     * @Column(name="name", type="string", length=200, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $_name;

    /**
     * @Column(name="age", type="integer", length=2, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $_age;

    /**
     * @Column(name="gender", type="string", length=10, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $_gender;

}