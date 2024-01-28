<?php

/*
 * Copyright (c) Alexandre Gomes Gaigalas <alganet@gmail.com>
 * SPDX-License-Identifier: MIT
 */

declare(strict_types=1);

namespace Respect\Validation\Exceptions;

use DirectoryIterator;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use ReflectionClass;
use Respect\Validation\Test\TestCase;

use function class_exists;
use function mb_substr;
use function sprintf;

#[CoversNothing]
final class CheckExceptionsTest extends TestCase
{
    #[Test]
    #[DataProvider('provideListOfRuleNames')]
    public function ruleHasAnExceptionWhichHasValidApi(string $ruleName): void
    {
        $exceptionClass = 'Respect\\Validation\\Exceptions\\' . $ruleName . 'Exception';
        self::assertTrue(
            class_exists($exceptionClass),
            sprintf('Expected exception class to exist: %s.', $ruleName)
        );

        $reflectionClass = new ReflectionClass($exceptionClass);
        self::assertTrue(
            $reflectionClass->isSubclassOf(ValidationException::class),
            'Every Respect/Validation exception must extend ValidationException.'
        );
    }

    /**
     * @return string[][]
     */
    public static function provideListOfRuleNames(): array
    {
        $rulesDirectory = 'library/Rules';
        $rulesDirectoryIterator = new DirectoryIterator($rulesDirectory);
        $ruleNames = [];
        foreach ($rulesDirectoryIterator as $fileInfo) {
            if ($fileInfo->isDir()) {
                continue;
            }

            $ruleName = mb_substr($fileInfo->getBasename(), 0, -4);
            if (($fileInfo->getExtension() !== 'php')) {
                continue;
            }

            $className = 'Respect\\Validation\\Rules\\' . $ruleName;
            if (!class_exists($className)) {
                continue;
            }

            $reflectionClass = new ReflectionClass($className);
            if ($reflectionClass->isAbstract() || $reflectionClass->isInterface()) {
                continue;
            }

            $ruleNames[] = [$ruleName];
        }

        return $ruleNames;
    }
}
