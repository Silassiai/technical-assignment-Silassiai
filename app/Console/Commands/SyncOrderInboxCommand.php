<?php

namespace App\Console\Commands;

use App\Adapters\PhpImapMailboxClient;
use App\Services\MailboxOrderService;
use Illuminate\Console\Command;

class SyncOrderInboxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:inbox-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read the order inbox and store the orders in the database';

    /**
     * @param MailboxOrderService $mailboxOrderService
     */
    public function __construct(
        private readonly MailboxOrderService $mailboxOrderService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->mailboxOrderService->import(
            resolve(PhpImapMailboxClient::class)
        );
    }
}
