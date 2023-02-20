<?php

namespace App\Adapters;

use App\Contracts\EmailClient;
use Exception;
use PhpImap\Exceptions\InvalidParameterException;
use PhpImap\IncomingMail;
use PhpImap\Mailbox;

class PhpImapMailboxClient implements EmailClient
{
    /** @var Mailbox $mailbox */
    private Mailbox $mailbox;

    /**
     * @throws InvalidParameterException
     */
    public function __construct(
        string $host,
        string $port,
        string $user,
        string $password
    )
    {
        $this->mailbox = new Mailbox(
            sprintf('{%s:%s/imap/ssl}INBOX', $host, $port),
            $user,
            $password,
            null,
            'US-ASCII',
        );
    }

    /**
     * Get the IMAP mailbox connection stream.
     *
     * @return void
     */
    public function connect(): void
    {
        $this->mailbox->getImapStream();
    }

    /**
     * Switch mailbox using the same connection.
     *
     * @param string $mailbox
     * @return $this
     * @throws Exception
     */
    public function mailbox(string $mailbox): self
    {
        $this->mailbox->switchMailbox($mailbox);

        return $this;
    }

    /**
     * Search mailbox using the imap_search().
     * @param $criteria - https://www.php.net/manual/en/function.imap-search.php
     * @return array
     */
    public function search(string $criteria = 'ALL'): array
    {
        return $this->mailbox->searchMailbox($criteria);
    }

    /**
     * Get the mail by id.
     *
     * @param int $mailId
     * @return IncomingMail
     */
    public function getById(int $mailId): IncomingMail
    {
        return $this->mailbox->getMail($mailId);
    }

    /**
     * Sets flag on the email using imap_setflag_full().
     * @see https://www.php.net/manual/en/function.imap-setflag-full.php
     *
     * @param int $mailId
     * @param $flag
     * @return void
     */
    public function setFlag(int $mailId, $flag): void
    {
        $this->mailbox->setFlag([$mailId], $flag);
    }

    /**
     * Closes the IMAP stream using imap_close().
     * @see https://www.php.net/manual/en/function.imap-close.php
     *
     * @return void
     */
    public function close(): void
    {
        $this->mailbox->disconnect();
    }
}
