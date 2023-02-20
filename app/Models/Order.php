<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    | The following constants are equal to the table columns.
    |
    */
    public const ID = 'id';
    public const MAIL_ID = 'mail_id';
    public const SUBJECT = 'subject';
    public const BODY = 'body';
    public const RECEIVED_AT = 'received_at';
    public const RECEIVED_FROM = 'received_from';
    public const REPLIED_AT = 'replied_at';
    public const REPLY_MESSAGE = 'reply_message';
    public const SEEN_AT = 'seen_at';

    /** @var string[] $fillable */
    protected $fillable = [
        self::MAIL_ID,
        self::SUBJECT,
        self::BODY,
        self::RECEIVED_AT,
        self::RECEIVED_FROM,
        self::REPLIED_AT,
        self::REPLY_MESSAGE,
        self::SEEN_AT,
    ];

    /**
     * Tells the notification to use the received_from column instead of the default email column.
     *
     * @return string
     */
    public function routeNotificationForMail(): string
    {
        return $this->{self::RECEIVED_FROM};
    }
}
