<?php

declare(strict_types=1);

namespace FizzBuzz\Tests;

use FizzBuzz\FizzBuzz;
use PHPUnit\Framework\TestCase;

final class FizzBuzzTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('provideCompleteSequences')]
    public function testSequenceMatchesExpectedOutput(int $limit, ?array $rules, array $expectedSequence): void
    {
        $sequence = iterator_to_array(FizzBuzz::sequence($limit, $rules));

        $this->assertSame($expectedSequence, $sequence);
    }

    /**
     * @return iterable<string, array{int, array<int, array{divisor:int, word:string}>|null, array<int, int|string>}>
     */
    public static function provideCompleteSequences(): iterable
    {
        yield 'default_rules_up_to_fifteen' => [
            15,
            null,
            [
                1,
                2,
                'Fizz',
                4,
                'Buzz',
                'Fizz',
                7,
                8,
                'Fizz',
                'Buzz',
                11,
                'Fizz',
                13,
                14,
                'FizzBuzz',
            ],
        ];

        yield 'complete_default_sequence_up_to_twenty' => [
            20,
            null,
            [
                1,
                2,
                'Fizz',
                4,
                'Buzz',
                'Fizz',
                7,
                8,
                'Fizz',
                'Buzz',
                11,
                'Fizz',
                13,
                14,
                'FizzBuzz',
                16,
                17,
                'Fizz',
                19,
                'Buzz',
            ],
        ];

        yield 'custom_rules_sequence' => [
            6,
            [
                ['divisor' => 2, 'word' => 'Even'],
                ['divisor' => 3, 'word' => 'Three'],
            ],
            [
                1,
                'Even',
                'Three',
                'Even',
                5,
                'EvenThree',
            ],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('provideIndexedExpectations')]
    public function testSequenceSpecificValues(int $limit, int $index, int|string $expectedValue): void
    {
        $sequence = iterator_to_array(FizzBuzz::sequence($limit));

        $this->assertSame($expectedValue, $sequence[$index]);
    }

    /**
     * @return iterable<string, array{int, int, int|string}>
     */
    public static function provideIndexedExpectations(): iterable
    {
        yield 'fizz_at_three' => [10, 2, 'Fizz'];
        yield 'fizz_at_six' => [10, 5, 'Fizz'];
        yield 'fizz_at_nine' => [10, 8, 'Fizz'];
        yield 'buzz_at_five' => [10, 4, 'Buzz'];
        yield 'buzz_at_ten' => [10, 9, 'Buzz'];
        yield 'fizzbuzz_at_fifteen' => [30, 14, 'FizzBuzz'];
        yield 'fizzbuzz_at_thirty' => [30, 29, 'FizzBuzz'];
        yield 'number_one_is_plain' => [10, 0, 1];
        yield 'number_two_is_plain' => [10, 1, 2];
        yield 'number_four_is_plain' => [10, 3, 4];
        yield 'number_seven_is_plain' => [10, 6, 7];
        yield 'number_eight_is_plain' => [10, 7, 8];
        yield 'fizzbuzz_in_large_range' => [100, 44, 'FizzBuzz'];
        yield 'fizzbuzz_in_large_range_sixty' => [100, 59, 'FizzBuzz'];
        yield 'fizzbuzz_in_large_range_seventy_five' => [100, 74, 'FizzBuzz'];
        yield 'fizzbuzz_in_large_range_ninety' => [100, 89, 'FizzBuzz'];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('provideSequenceLengths')]
    public function testSequenceLengthMatchesLimit(int $limit): void
    {
        $sequence = iterator_to_array(FizzBuzz::sequence($limit));

        $this->assertCount($limit, $sequence);
    }

    /**
     * @return iterable<string, array{int}>
     */
    public static function provideSequenceLengths(): iterable
    {
        yield 'minimum_bound' => [1];
        yield 'medium_bound' => [15];
        yield 'large_bound' => [100];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('provideInvalidInputs')]
    public function testSequenceThrowsForInvalidInput(int $limit, ?array $rules, string $expectedMessage): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);

        iterator_to_array(FizzBuzz::sequence($limit, $rules));
    }

    /**
     * @return iterable<string, array{int, array<int, array{divisor:int, word:string}>|null, string}>
     */
    public static function provideInvalidInputs(): iterable
    {
        yield 'zero_limit' => [
            0,
            null,
            'N must be an integer >= 1.',
        ];

        yield 'negative_limit' => [
            -1,
            null,
            'N must be an integer >= 1.',
        ];

        yield 'missing_divisor' => [
            10,
            [
                ['word' => 'Fizz'],
            ],
            'Each rule must contain keys "divisor" and "word".',
        ];

        yield 'missing_word' => [
            10,
            [
                ['divisor' => 3],
            ],
            'Each rule must contain keys "divisor" and "word".',
        ];

        yield 'non_positive_divisor' => [
            10,
            [
                ['divisor' => 0, 'word' => 'Fizz'],
            ],
            '"divisor" must be a positive integer.',
        ];

        yield 'empty_word' => [
            10,
            [
                ['divisor' => 3, 'word' => ''],
            ],
            '"word" must be a non-empty string.',
        ];
    }

    public function testSequenceReturnsGenerator(): void
    {
        $generator = FizzBuzz::sequence(5);

        $this->assertInstanceOf(\Generator::class, $generator);

        $values = [];
        foreach ($generator as $value) {
            $values[] = $value;
        }

        $this->assertSame([1, 2, 'Fizz', 4, 'Buzz'], $values);
    }
}

