<?php

declare(strict_types=1);

class Position
{
    private int $row;
    private int $column;

    public function __construct(int $row, int $column)
    {
        if ($row < 0 || $row > 7) {
            throw new InvalidArgumentException("row must be between 0 and 7. Given: $row");
        }

        if ($column < 0 || $column > 7) {
            throw new InvalidArgumentException("column must be between 0 and 7. Given: $column");
        }

        $this->row = $row;
        $this->column = $column;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function getColumn(): int
    {
        return $this->column;
    }

    public function equals(Position $other): bool
    {
        return $this->row === $other->getRow() && $this->column === $other->getColumn();
    }

    public function toKey(): string
    {
        return sprintf('%d:%d', $this->row, $this->column);
    }

    public static function fromKey(string $key): Position
    {
        if (!preg_match('/^\d+:\d+$/', $key)) {
            throw new InvalidArgumentException("Invalid key format, expected 'row:column'. Given: $key");
        }

        [$row, $column] = array_map('intval', explode(':', $key));

        return new Position($row, $column);
    }
}
