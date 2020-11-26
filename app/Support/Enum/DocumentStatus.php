<?php


namespace Vanguard\Support\Enum;


class DocumentStatus
{
    const UNCONFIRMED = 'Unconfirmed';
    const CONFIRMED = 'Confirmed';
    const REJECTED = 'Rejected';

    public static function lists()
    {
        return [
            self::CONFIRMED => trans('document.status.'. self::CONFIRMED),
            self::UNCONFIRMED => trans('document.status.' . self::UNCONFIRMED),
            self::REJECTED => trans('document.status.' . self::REJECTED)
        ];
    }
}
