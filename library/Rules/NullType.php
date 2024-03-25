<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Rules;

use Respect\Validation\Message\Template;
use Respect\Validation\Rules\Core\Simple;

use function is_null;

#[Template(
    '{{name}} must be null',
    '{{name}} must not be null',
)]
final class NullType extends Simple
{
    protected function isValid(mixed $input): bool
    {
        return is_null($input);
    }
}
