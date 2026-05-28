<?php

declare(strict_types=1);

require_once __DIR__ . '/Piece.php';

class Pawn extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::PAWN;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $direction = $this->color === PieceColor::WHITE ? -1 : 1;
        $startRow = $this->color === PieceColor::WHITE ? 6 : 1;
        $rowDifference = $target->getRow() - $this->position->getRow();
        $columnDifference = abs($target->getColumn() - $this->position->getColumn());

        $simpleForwardMove = $columnDifference === 0 && $rowDifference === $direction;
        $doubleForwardMove = $columnDifference === 0
            && $this->position->getRow() === $startRow
            && $rowDifference === 2 * $direction;
        $diagonalCaptureShape = $columnDifference === 1 && $rowDifference === $direction;

        return $simpleForwardMove || $doubleForwardMove || $diagonalCaptureShape;
    }
}
