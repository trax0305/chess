<?php

declare(strict_types=1);

require_once __DIR__ . '/Piece.php';

class Bishop extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::BISHOP;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $rowDifference = abs($target->getRow() - $this->position->getRow());
        $columnDifference = abs($target->getColumn() - $this->position->getColumn());

        return $rowDifference === $columnDifference && $rowDifference > 0;
    }
}
