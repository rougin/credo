<?php

use Doctrine\ORM\Mapping as ORM;
use Rougin\Credo\Model;
use Rougin\Credo\Traits\PaginateTrait;
use Rougin\Credo\Traits\ValidateTrait;

/**
 * @Entity
 *
 * @Table(name="post")
 */
#[ORM\Entity]
#[ORM\Table(name: 'post')]
class Post extends Model
{
    use PaginateTrait;
    use ValidateTrait;

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
    protected $id;

    /**
     * @Column(name="subject", type="string", length=200, nullable=FALSE, unique=FALSE)
     *
     * @var string
     */
    #[ORM\Column(name: 'subject', type: 'string', length: 200, nullable: false)]
    protected $subject;

    /**
     * @Column(name="message", type="string", length=2, nullable=FALSE, unique=FALSE)
     *
     * @var string
     */
    #[ORM\Column(name: 'message', type: 'string', length: 2, nullable: false)]
    protected $message;

    /**
     * @Column(name="description", type="string", length=10, nullable=FALSE, unique=FALSE)
     *
     * @var string
     */
    #[ORM\Column(name: 'description', type: 'string', length: 10, nullable: false)]
    protected $description;

    /**
     * Additional configuration to Pagination Class.
     *
     * @link https://codeigniter.com/userguide3/libraries/pagination.html?highlight=pagination#customizing-the-pagination
     *
     * @var array<string, mixed>
     */
    protected $pagee = array();

    /**
     * An array of validation rules. This needs to be the same format
     * as validation rules passed to the Form Validation library.
     *
     * @link https://codeigniter.com/userguide3/libraries/form_validation.html#setting-rules-using-an-array
     *
     * @var array<string, string>[]
     */
    protected $rules = array(
        array('field' => 'subject', 'label' => 'Subject', 'rules' => 'required'),
    );

    /**
     * Gets the subject.
     *
     * @return string
     */
    public function get_subject()
    {
        return $this->subject;
    }
}
