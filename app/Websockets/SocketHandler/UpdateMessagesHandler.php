<?php

namespace App\Websockets\SocketHandler;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class UpdateMessagesHandler extends BasesSocketHandler implements MessageComponentInterface
{


    function onMessage(ConnectionInterface $from, MessageInterface $msg)
    {
    }
}
