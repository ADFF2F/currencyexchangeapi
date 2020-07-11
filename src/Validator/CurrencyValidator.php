<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\CurrencyRepository;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CurrencyValidator
{
    private ValidatorInterface $validator;
    private CurrencyRepository $currencyRepository;
    private array $errors = [];
    const EXPECTED_ISO_4217 = 'Expected 3-letter ISO 4217 currency name';

    public function __construct(ValidatorInterface $validator, CurrencyRepository $currencyRepository)
    {
        $this->validator = $validator;
        $this->currencyRepository = $currencyRepository;
    }

    public function validate(array $optionalParameters)
    {
        $constraints = new Assert\Collection([
            'currency' => [new Assert\Currency([
                'message' => self::EXPECTED_ISO_4217
            ])],
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