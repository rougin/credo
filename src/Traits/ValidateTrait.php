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
    protected $validationErrors = [];

    /**
     * Validates the specified data based on the validation rules.
     *
     * @param  array $data
     * @return boolean
     */
    public function validate(array $data = [])
    {
        $this->load->library('form_validation');

        if (! empty($data)) {
            $this->form_validation->set_data($data);
        }

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run() === false) {
            $this->validationErrors = $this->form_validation->error_array();

            return false;
        }

        return true;
    }

    /**
     * Returns a listing of error messages.
     *
     * @return array
     */
    public function validationErrors()
    {
        return $this->validationErrors;
    }
}
