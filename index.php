<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Position.php';
require_once __DIR__ . '/src/Enum/PieceColor.php';
require_once __DIR__ . '/src/Enum/PieceType.php';
require_once __DIR__ . '/src/Contract/Renderable.php';
require_once __DIR__ . '/src/Exception/ChessException.php';
require_once __DIR__ . '/src/Exception/InvalidMoveException.php';
require_once __DIR__ . '/src/Exception/NoPieceException.php';
require_once __DIR__ . '/src/Exception/WrongTurnException.php';
require_once __DIR__ . '/src/Exception/OccupiedByAllyException.php';
require_once __DIR__ . '/src/Piece/Piece.php';
require_once __DIR__ . '/src/Piece/King.php';
require_once __DIR__ . '/src/Piece/Queen.php';
require_once __DIR__ . '/src/Piece/Rook.php';
require_once __DIR__ . '/src/Piece/Bishop.php';
require_once __DIR__ . '/src/Piece/Knight.php';
require_once __DIR__ . '/src/Piece/Pawn.php';
require_once __DIR__ . '/src/Move.php';
require_once __DIR__ . '/src/Board.php';
require_once __DIR__ . '/src/Factory/PieceFactory.php';
require_once __DIR__ . '/src/Game.php';

try {
    $game = new Game();
    $game->start();

    echo "Plateau initial :\n";
    echo $game->getBoard()->render();

    $game->play(new Move(new Position(6, 4), new Position(4, 4)));
    $game->play(new Move(new Position(1, 4), new Position(3, 4)));
    $game->play(new Move(new Position(7, 6), new Position(5, 5)));
    $game->play(new Move(new Position(0, 1), new Position(2, 2)));

    echo "\nPlateau après les coups :\n";
    echo $game->getBoard()->render();
    echo "\nJoueur courant : " . $game->getCurrentPlayer()->name . "\n";
} catch (ChessException $exception) {
    echo "Erreur métier : " . $exception->getMessage() . PHP_EOL;
} catch (Throwable $exception) {
    echo "Erreur inattendue : " . $exception->getMessage() . PHP_EOL;
}
