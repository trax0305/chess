<?php

declare(strict_types=1);

require_once __DIR__ . '/Piece.php';

class Knight extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::KNIGHT;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDifference = abs($target->getRow() - $this->position->getRow());
        $columnDifference = abs($target->getColumn() - $this->position->getColumn());

        return ($rowDifference === 2 && $columnDifference === 1)
            || ($rowDifference === 1 && $columnDifference === 2);
    }
}
