<?php

namespace App\Utils;

class ServerTime
{
    /**
     * @return \DateTime
     *
     * @throws \Exception
     */
    public static function get()
    {
        $serverTime = \DateTime::createFromFormat('U', time());
        $serverTime->setTimezone(new \DateTimeZone('Europe/Kiev'));

        return new \DateTime($serverTime->format('Y-m-d H:i:s'));
    }

    /**
     * @return bool|\DateTime
     */
    public static function getUts()
    {
        $serverTime = \DateTime::createFromFormat('U', time());
        $serverTime->setTimezone(new \DateTimeZone('Europe/Kiev'));

        return $serverTime;
    }

    public static function strDateTimeToUts($strDateTime)
    {
        $serverTime = \DateTime::createFromFormat('Y-m-d H:i:s', $strDateTime);
        $serverTime->setTimezone(new \DateTimeZone('Europe/Kiev'));

        return $serverTime->getTimestamp();
    }
}
