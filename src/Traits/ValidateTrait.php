<?php

namespace Rougin\Credo\Traits;

/**
 * @property array               $rules
 * @property \CI_Form_validation $form_validation
 * @property \CI_Loader          $load
 *
 * @package Credo
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
trait ValidateTrait
{
    /**
     * @var array<string, string>
     */
    protected $errors = array();

    /**
     * Returns a listing of error messages.
     *
     * @return array<string, string>
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Validates the specified data based on the validation rules.
     *
     * @param array $data
     *
     * @return boolean
     */
    public function validate(array $data)
    {
        $this->load->library('form_validation');

        $validation = $this->form_validation;

        $validation->set_data($data);

        $validation->set_rules($this->rules);

        $valid = true;

        if (! $validation->run())
        {
            $this->errors = $validation->error_array();

            $valid = false;
        }

        return $valid;
    }
}
