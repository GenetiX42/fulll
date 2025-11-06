<?php

declare(strict_types=1);

namespace FizzBuzz;

/**
 * Extensible and efficient FizzBuzz.
 * - Uses a generator for scalability (no large in-memory arrays)
 * - Configurable rules via an array like [ ['divisor' => int, 'word' => string], ... ]
 */
final class FizzBuzz
{
    private const DEFAULT_RULES = [
        ['divisor' => 3, 'word' => 'Fizz'],
        ['divisor' => 5, 'word' => 'Buzz'],
    ];

    public static function sequence(int $n, ?array $rules = null): \Generator
    {
        $effectiveRules = $rules ?? self::DEFAULT_RULES;
        self::assertValidInput($n, $effectiveRules);

        for ($i = 1; $i <= $n; $i++) {
            $accumulator = '';
            foreach ($effectiveRules as $rule) {
                if ($i % $rule['divisor'] === 0) {
                    $accumulator .= $rule['word'];
                }
            }
            yield $accumulator !== '' ? $accumulator : $i;
        }
    }

    private static function assertValidInput(int $n, array $rules): void
    {
        if ($n < 1) {
            throw new \InvalidArgumentException('N must be an integer >= 1.');
        }

        foreach ($rules as $rule) {
            if (!isset($rule['divisor'], $rule['word'])) {
                throw new \InvalidArgumentException('Each rule must contain keys "divisor" and "word".');
            }
            if (!is_int($rule['divisor']) || $rule['divisor'] <= 0) {
                throw new \InvalidArgumentException('"divisor" must be a positive integer.');
            }
            if (!is_string($rule['word']) || $rule['word'] === '') {
                throw new \InvalidArgumentException('"word" must be a non-empty string.');
            }
        }
    }
}


