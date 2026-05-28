<?php

declare(strict_types=1);

require_once __DIR__ . '/Board.php';
require_once __DIR__ . '/Enum/PieceColor.php';
require_once __DIR__ . '/Enum/PieceType.php';
require_once __DIR__ . '/Exception/InvalidMoveException.php';
require_once __DIR__ . '/Exception/NoPieceException.php';
require_once __DIR__ . '/Exception/OccupiedByAllyException.php';
require_once __DIR__ . '/Exception/WrongTurnException.php';
require_once __DIR__ . '/Factory/PieceFactory.php';
require_once __DIR__ . '/Move.php';
require_once __DIR__ . '/Position.php';

class Game
{
    private Board $board;
    private PieceColor $currentPlayer;
    private PieceFactory $pieceFactory;

    public function __construct()
    {
        $this->board = new Board();
        $this->currentPlayer = PieceColor::WHITE;
        $this->pieceFactory = new PieceFactory();
    }

    public function start(): void
    {
        $this->board = new Board();
        $this->currentPlayer = PieceColor::WHITE;
        $this->setupPieces();
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getCurrentPlayer(): PieceColor
    {
        return $this->currentPlayer;
    }

    public function play(Move $move): void
    {
        $from = $move->getFrom();
        $to = $move->getTo();
        $piece = $this->board->getPieceAt($from);

        if ($piece === null) {
            throw new NoPieceException('Aucune pièce sur la case source.');
        }

        if ($piece->getColor() !== $this->currentPlayer) {
            throw new WrongTurnException('Ce n’est pas le tour de cette couleur.');
        }

        $targetPiece = $this->board->getPieceAt($to);

        if ($targetPiece !== null && $targetPiece->getColor() === $piece->getColor()) {
            throw new OccupiedByAllyException('La case cible contient une pièce alliée.');
        }

        if (!$piece->canMove($this->board, $to)) {
            throw new InvalidMoveException('Déplacement invalide.');
        }

        $this->board->movePiece($from, $to);
        $this->switchPlayer();
    }

    public function isCheck(PieceColor $color): bool
    {
        $kingPosition = $this->board->getKingPosition($color);

        if ($kingPosition === null) {
            return false;
        }

        foreach ($this->board->getPieces() as $piece) {
            if ($piece->getColor() === $color) {
                continue;
            }

            if ($piece->canMove($this->board, $kingPosition)) {
                return true;
            }
        }

        return false;
    }

    private function setupPieces(): void
    {
        $backRank = [
            PieceType::ROOK,
            PieceType::KNIGHT,
            PieceType::BISHOP,
            PieceType::QUEEN,
            PieceType::KING,
            PieceType::BISHOP,
            PieceType::KNIGHT,
            PieceType::ROOK,
        ];

        for ($column = 0; $column < 8; $column++) {
            $this->board->placePiece($this->pieceFactory->create(
                $backRank[$column],
                PieceColor::BLACK,
                new Position(0, $column)
            ));
            $this->board->placePiece($this->pieceFactory->create(
                PieceType::PAWN,
                PieceColor::BLACK,
                new Position(1, $column)
            ));
            $this->board->placePiece($this->pieceFactory->create(
                PieceType::PAWN,
                PieceColor::WHITE,
                new Position(6, $column)
            ));
            $this->board->placePiece($this->pieceFactory->create(
                $backRank[$column],
                PieceColor::WHITE,
                new Position(7, $column)
            ));
        }
    }

    private function switchPlayer(): void
    {
        $this->currentPlayer = $this->currentPlayer->opposite();
    }
}
