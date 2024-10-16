<?php

namespace Core\Validation;

use Core\Validation\interface\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{

    private array $errors = [];

    /**
     * @inheritDoc
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $validators) if (isset($data[$field])) {
            foreach ($validators as $validator) {
                if (!$validator->validate($data[$field])) {
                    $this->errors[$field][] = $validator::class;
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * @inheritDoc
     */
    public function errors(): array
    {
        return $this->errors;
    }
}