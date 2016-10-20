<?php

/**
 * @Entity
 * @Table(name="post")
 */
class Post extends \Rougin\Credo\CodeigniterModel
{
    use \Rougin\Credo\Traits\ValidateTrait;

    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $id;

    /**
     * @Column(name="subject", type="string", length=200, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $subject;

    /**
     * @Column(name="message", type="string", length=2, nullable=FALSE, unique=FALSE)
     * @var integer
     */
    protected $message;

    /**
     * @Column(name="description", type="string", length=10, nullable=FALSE, unique=FALSE)
     * @var string
     */
    protected $description;

    /**
     * Gets the subject.
     *
     * @return string
     */
    public function get_subject()
    {
        return $this->subject;
    }

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form_validation library.
     *
     * @var array
     */
    protected $validation_rules = array(
        array('field' => 'subject', 'label' => 'Subject', 'rules' => 'required'),
    );
}
