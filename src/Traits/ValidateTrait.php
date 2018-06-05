<?php

namespace Rougin\Credo\Traits;

/**
 * Validate Trait
 *
 * @package Credo
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 *
 * @property array               $validation_rules
 * @property \CI_Form_validation $form_validation
 * @property \CI_Loader          $load
 */
trait ValidateTrait
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var array
     */
    protected $rules = array();

    /**
     * Returns a listing of error messages.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Validates the specified data based on the validation rules.
     *
     * @param  array $data
     * @return boolean
     */
    public function validate(array $data = array())
    {
        $this->rules = $this->validation_rules;

        $this->load->library('form_validation');

        $validation = $this->form_validation;

        $validation->set_data((array) $data);

        $validation->set_rules($this->rules);

        if ($validation->run() === false) {
            $errors = $validation->error_array();

            $this->errors = (array) $errors;
        }

        return $validation->run() === true;
    }

    /**
     * Returns a listing of error messages.
     *
     * @return array
     */
    public function validationErrors()
    {
        return $this->errors();
    }
}
