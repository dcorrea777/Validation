<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use DateTimeImmutable;
use DateTimeInterface;
use Respect\Validation\Message\Template;
use Respect\Validation\Rules\Core\Simple;

use function is_scalar;

#[Template(
    '{{name}} must be leap date',
    '{{name}} must not be leap date',
)]
final class LeapDate extends Simple
{
    public function __construct(
        private readonly string $format
    ) {
    }

    protected function isValid(mixed $input): bool
    {
        if ($input instanceof DateTimeInterface) {
            return $input->format('m-d') === '02-29';
        }

        if (is_scalar($input)) {
            return $this->isValid(DateTimeImmutable::createFromFormat($this->format, (string) $input));
        }

        return false;
    }
}
