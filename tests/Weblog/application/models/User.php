<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity(repositoryClass="User_repository")
 *
 * @Table(name="user")
 */
#[ORM\Entity(repositoryClass: User_repository::class)]
#[ORM\Table(name: 'user')]
class User extends CI_Model
{
    /**
     * @Id @GeneratedValue
     *
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     *
     * @var integer
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', length: 10, nullable: false)]
    protected $_id;

    /**
     * @Column(name="name", type="string", length=200, nullable=FALSE, unique=FALSE)
     *
     * @var string
     */
    #[ORM\Column(name: 'name', type: 'string', length: 200, nullable: false)]
    protected $_name;

    /**
     * @Column(name="age", type="integer", length=2, nullable=FALSE, unique=FALSE)
     *
     * @var integer
     */
    #[ORM\Column(name: 'age', type: 'integer', length: 2, nullable: false)]
    protected $_age;

    /**
     * @Column(name="gender", type="string", length=10, nullable=FALSE, unique=FALSE)
     *
     * @var string
     */
    #[ORM\Column(name: 'gender', type: 'string', length: 10, nullable: false)]
    protected $_gender;

    /**
     * @return integer
     */
    public function get_id()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return $this->_name;
    }
}
