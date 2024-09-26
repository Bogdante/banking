<?php

namespace App\Modules\Common;

class Money
{
  private const DECIMAL_SCALE = 3;
  private const COMPARE_EQUALS = 0;

  private const COMPARE_GREATER = 1;

  private const COMPARE_LESS = -1;

  private $value;

  private function __construct(string $value)
  {
    $this->value = self::normalize($value);
  }

  public static function createFromInteger(int $value): self
  {
    return new self((string)$value);
  }

  public static function createZero(): self
  {
    return new self('0');
  }

  public static function createFromString(string $value): self
  {
    return new self($value);
  }

  public function toString(): string
  {
    return $this->value;
  }

  public function add(Money $amount): Money
  {
    return self::createFromString(bcadd($this->value, $amount->value, self::DECIMAL_SCALE));
  }

  public function substract(Money $amount): Money
  {
    return self::createFromString(bcsub($this->value, $amount->value, self::DECIMAL_SCALE));
  }

  public function multiply(Money $amount): Money
  {
    return self::createFromString(bcmul($this->value, $amount->value, self::DECIMAL_SCALE));
  }

  public function isGreaterOrEqual(Money $amount): bool
  {
    $compare = $this->compare($amount);

    return $compare === self::COMPARE_EQUALS || $compare === self::COMPARE_GREATER;
  }

  public function isZero(): bool
  {
    return $this->equals(self::createZero());
  }

  public function invertSign(): Money
  {
    $zero = self::createZero();
    return $zero->substract($this);
  }

  private static function normalize(string $value): string
  {
    if (($value === '') || !preg_match('/^(-)?[0-9]+(\\.[0-9]+)?$/', $value)) {
      throw new \LogicException("Неподдерживаемый формат денег: {$value}");
    }

    return bcadd('0', $value, self::DECIMAL_SCALE);
  }

  private function equals(Money $money): bool
  {
    return bccomp($this->value, $money->value, self::DECIMAL_SCALE) === 0;
  }

  private function compare(Money $money): int
  {
    return bccomp($this->value, $money->value, self::DECIMAL_SCALE);
  }

  public function toFrontAsString(): string
  {
    return bcadd('0', $this->value, self::DECIMAL_SCALE);
  }

  public function toInteger(): int
  {
    return (int)$this->value;
  }
}
