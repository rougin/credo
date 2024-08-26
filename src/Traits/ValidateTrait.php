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
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function validate($data)
    {
        $this->load->library('form_validation');

        $validation = $this->form_validation;

        $validation->set_data((array) $data);

        $validation->set_rules($this->rules);

        if ($validation->run() === false)
        {
            $errors = $validation->error_array();

            $this->errors = (array) $errors;
        }

        return $validation->run() === true;
    }
}
