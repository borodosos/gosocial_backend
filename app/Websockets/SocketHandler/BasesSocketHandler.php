<?php

namespace App\Websockets\SocketHandler;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

abstract class BasesSocketHandler  implements MessageComponentInterface
{
    function onOpen(ConnectionInterface $conn)
    {
    }

    function onClose(ConnectionInterface $conn)
    {
    }

    function onError(ConnectionInterface $conn, Exception $e)
    {
        return response()->json($e);
    }
}
