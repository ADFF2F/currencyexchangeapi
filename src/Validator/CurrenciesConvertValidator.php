<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\CurrencyRepository;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CurrenciesConvertValidator
{
    private ValidatorInterface $validator;
    private CurrencyRepository $currencyRepository;
    private CurrencyAssert $currencyAssert;

    private array $errors = [];

    public function __construct(ValidatorInterface $validator, CurrencyRepository $currencyRepository, CurrencyAssert $currencyAssert)
    {
        $this->validator = $validator;
        $this->currencyRepository = $currencyRepository;
        $this->currencyAssert = $currencyAssert;
    }

    public function validate(array $optionalParameters)
    {
        $constraints = new Assert\Collection([
            'from' => [
                ($this->currencyAssert)(),
                new Assert\NotBlank(),
            ],
            'to' => [
                ($this->currencyAssert)(),
                new Assert\NotBlank()
            ],
            'amount' => [
                new Assert\PositiveOrZero([]),
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => "@^\d+$@",
                    'message' => 'Expected int value'
                ]),
            ],
        ]);

        $violations = $this->validator->validate($optionalParameters, $constraints);

        if (0 !== count($violations)) {
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $this->errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}