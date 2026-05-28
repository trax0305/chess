<?php

declare(strict_types=1);

require_once __DIR__ . '/../Contract/Renderable.php';
require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';
require_once __DIR__ . '/../Position.php';

abstract class Piece implements Renderable
{
    protected PieceColor $color;
    protected Position $position;
    protected PieceType $type;

    public function __construct(PieceColor $color, Position $position)
    {
        $this->color = $color;
        $this->position = $position;
    }

    public function getColor(): PieceColor
    {
        return $this->color;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

    public function getType(): PieceType
    {
        return $this->type;
    }

    public function render(): string
    {
        $symbol = match ($this->type) {
            PieceType::KING => 'K',
            PieceType::QUEEN => 'Q',
            PieceType::ROOK => 'R',
            PieceType::BISHOP => 'B',
            PieceType::KNIGHT => 'N',
            PieceType::PAWN => 'P',
        };

        return $this->color === PieceColor::WHITE ? $symbol : strtolower($symbol);
    }

    public function canMove(Board $board, Position $target): bool
    {
        if ($this->position->equals($target)) {
            return false;
        }

        if (!$this->isValidMovementShape($target)) {
            return false;
        }

        if (!$this->canCapture($board, $target)) {
            return false;
        }

        if ($this->type !== PieceType::KNIGHT && !$board->isPathClear($this->position, $target)) {
            return false;
        }

        return true;
    }

    abstract protected function isValidMovementShape(Position $target): bool;

    protected function canCapture(Board $board, Position $target): bool
    {
        $targetPiece = $board->getPieceAt($target);

        if ($targetPiece === null) {
            return true;
        }

        return $targetPiece->getColor() !== $this->color;
    }
}
