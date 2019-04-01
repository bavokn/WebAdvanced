<?php

namespace Laudis\Calculators\Presenters;

use Rakit\Validation\Validation;

/**
 * Class ValidationPresenter
 * Presents the validation.
 *
 * @package Laudis\Calculators\Presenters
 */
final class ValidationPresenter
{
    /**
     * Presents the validation as an array.
     *
     * @param Validation $validation
     * @return array
     */
    public function present(Validation $validation): array
    {
        return $validation->errors()->toArray();
    }
}
