<?php

declare(strict_types=1);

require_once __DIR__ . '/Piece.php';

class Rook extends Piece
{
    public function __construct(PieceColor $color, Position $position)
    {
        parent::__construct($color, $position);
        $this->type = PieceType::ROOK;
    }

    protected function isValidMovementShape(Position $target): bool
    {
        $sameRow = $target->getRow() === $this->position->getRow();
        $sameColumn = $target->getColumn() === $this->position->getColumn();

        return ($sameRow && !$sameColumn) || ($sameColumn && !$sameRow);
    }
}
