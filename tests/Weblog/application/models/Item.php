<?php

/**
 * @Entity(repositoryClass="Item_repository")
 *
 * @Table(name="item")
 */
class Item extends CI_Model
{
    /**
     * @Id @GeneratedValue
     *
     * @Column(name="id", type="integer", length=10, nullable=false, unique=false)
     *
     * @var integer
     */
    protected $id;

    /**
     * @Column(name="name", type="string", length=200, nullable=false, unique=false)
     *
     * @var string
     */
    protected $name;

    /**
     * @Column(name="created_at", type="datetime", nullable=false, unique=false)
     *
     * @var string
     */
    protected $created_at;

    /**
     * @Column(name="updated_at", type="datetime", nullable=true, unique=false)
     *
     * @var string|null
     */
    protected $updated_at = null;

    /**
     * @Column(name="deleted_at", type="datetime", nullable=true, unique=false)
     *
     * @var string|null
     */
    protected $deleted_at = null;

    /**
     * @return string
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @param string $created_at
     *
     * @return self
     */
    public function set_created_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @param string|null $deleted_at
     *
     * @return self
     */
    public function set_deleted_at($deleted_at = null)
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|null $updated_at
     *
     * @return self
     */
    public function set_updated_at($updated_at = null)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
