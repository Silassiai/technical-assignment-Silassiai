<?php

namespace App\Contracts;

use PhpImap\IncomingMail;

interface EmailClient
{
    public function connect(): void;
    public function mailbox(string $mailbox): self;
    public function search(string $criteria = 'ALL'): array;
    public function getById(int $mailId): IncomingMail;
    public function setFlag(int $mailId, $flag): void;
    public function close(): void;
}
