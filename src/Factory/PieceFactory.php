<?php

declare(strict_types=1);

require_once __DIR__ . '/../Enum/PieceColor.php';
require_once __DIR__ . '/../Enum/PieceType.php';
require_once __DIR__ . '/../Piece/Bishop.php';
require_once __DIR__ . '/../Piece/King.php';
require_once __DIR__ . '/../Piece/Knight.php';
require_once __DIR__ . '/../Piece/Pawn.php';
require_once __DIR__ . '/../Piece/Piece.php';
require_once __DIR__ . '/../Piece/Queen.php';
require_once __DIR__ . '/../Piece/Rook.php';
require_once __DIR__ . '/../Position.php';

class PieceFactory
{
    public function create(PieceType $type, PieceColor $color, Position $position): Piece
    {
        return match ($type) {
            PieceType::KING => new King($color, $position),
            PieceType::QUEEN => new Queen($color, $position),
            PieceType::ROOK => new Rook($color, $position),
            PieceType::BISHOP => new Bishop($color, $position),
            PieceType::KNIGHT => new Knight($color, $position),
            PieceType::PAWN => new Pawn($color, $position),
        };
    }
}
