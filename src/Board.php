<?php

declare(strict_types=1);

require_once __DIR__ . '/Contract/Renderable.php';
require_once __DIR__ . '/Enum/PieceColor.php';
require_once __DIR__ . '/Enum/PieceType.php';
require_once __DIR__ . '/Piece/Piece.php';
require_once __DIR__ . '/Position.php';

class Board implements Renderable
{
    private array $pieces = [];

    public function placePiece(Piece $piece): void
    {
        $this->pieces[$piece->getPosition()->toKey()] = $piece;
    }

    public function getPieceAt(Position $position): ?Piece
    {
        return $this->pieces[$position->toKey()] ?? null;
    }

    public function hasPieceAt(Position $position): bool
    {
        return $this->getPieceAt($position) !== null;
    }

    public function removePieceAt(Position $position): void
    {
        unset($this->pieces[$position->toKey()]);
    }

    public function movePiece(Position $from, Position $to): void
    {
        $piece = $this->getPieceAt($from);

        if ($piece === null) {
            return;
        }

        $this->removePieceAt($from);
        $piece->setPosition($to);
        $this->placePiece($piece);
    }

    public function isPathClear(Position $from, Position $to): bool
    {
        $rowDiff = $to->getRow() - $from->getRow();
        $columnDiff = $to->getColumn() - $from->getColumn();
        $isStraight = $rowDiff === 0 || $columnDiff === 0;
        $isDiagonal = abs($rowDiff) === abs($columnDiff);

        if (!$isStraight && !$isDiagonal) {
            return false;
        }

        $rowStep = $rowDiff <=> 0;
        $columnStep = $columnDiff <=> 0;
        $row = $from->getRow() + $rowStep;
        $column = $from->getColumn() + $columnStep;

        while ($row !== $to->getRow() || $column !== $to->getColumn()) {
            if ($this->hasPieceAt(new Position($row, $column))) {
                return false;
            }

            $row += $rowStep;
            $column += $columnStep;
        }

        return true;
    }

    public function getPieces(): array
    {
        return array_values($this->pieces);
    }

    public function getKingPosition(PieceColor $color): ?Position
    {
        foreach ($this->pieces as $piece) {
            if ($piece->getType() === PieceType::KING && $piece->getColor() === $color) {
                return $piece->getPosition();
            }
        }

        return null;
    }

    public function render(): string
    {
        $rows = [];

        for ($row = 0; $row < 8; $row++) {
            $columns = [];

            for ($column = 0; $column < 8; $column++) {
                $piece = $this->getPieceAt(new Position($row, $column));
                $columns[] = $piece === null ? '.' : $piece->render();
            }

            $rows[] = implode(' ', $columns);
        }

        return implode("\n", $rows) . "\n";
    }
}
