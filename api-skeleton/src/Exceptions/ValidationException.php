<?php

namespace Laudis\Calculators\Exceptions;

use Rakit\Validation\Validation;
use RuntimeException;

/**
 * Class ValidationException
 * Encapsulates the behaviour of a validation failing in the current state of the application.
 *
 * @package Laudis\Calculators\Exceptions
 */
final class ValidationException extends RuntimeException
{
    /** @var Validation */
    private $validation;

    /**
     * ValidationException constructor.
     * @param Validation $validation
     */
    public function __construct(Validation $validation)
    {
        parent::__construct('De opgegeven data is niet correct');
        $this->validation = $validation;
    }

    /**
     * @return Validation
     */
    public function getValidation(): Validation
    {
        return $this->validation;
    }
}
