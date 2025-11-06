# FizzBuzz Implementation

Clean and extensible FizzBuzz implementation in PHP.

## Features

- **Default rules**: 3 → Fizz, 5 → Buzz, 15 → FizzBuzz
- **Extensible**: pass custom rules to the API
- **Scalable**: uses a generator (iterator) to avoid loading everything in memory
- **Modern PHP**: strict types, comprehensive test suite with PHPUnit

## Requirements

- PHP ≥ 8.1
- Composer (for dependencies and tests)

## Installation

```bash
git clone <repository-url>
cd Algo
composer install
```

## Usage

### CLI

```bash
php bin/fizzbuzz 15
```

Output:
```
1
2
Fizz
4
Buzz
Fizz
7
8
Fizz
Buzz
11
Fizz
13
14
FizzBuzz
```

### API Usage

```php
require __DIR__ . '/vendor/autoload.php';

use FizzBuzz\FizzBuzz;

foreach (FizzBuzz::sequence(15) as $value) {
    echo $value, PHP_EOL;
}
```

### Custom Rules

```php
require __DIR__ . '/vendor/autoload.php';

use FizzBuzz\FizzBuzz;

$rules = [
    ['divisor' => 2, 'word' => 'Even'],
    ['divisor' => 3, 'word' => 'Three'],
];

foreach (FizzBuzz::sequence(10, $rules) as $value) {
    echo $value, PHP_EOL;
}
```

## Testing

Run the test suite:

```bash
./vendor/bin/phpunit
```

Or using Composer:

```bash
composer test
```

## Implementation Details

- **Generator pattern**: Memory-efficient for large sequences
- **Strict typing**: All parameters and return types are explicitly typed
- **Input validation**: Comprehensive validation with clear error messages
- **Data providers**: PHPUnit tests use data providers for better maintainability
- **PSR-4 autoloading**: Standard PHP namespace structure

