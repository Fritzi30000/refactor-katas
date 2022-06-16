<?php

namespace RefactorKatas\TellDontAsk\Domain;

/**
 * Class OrderStatus
 * @package Archel\TellDontAsk\Domain
 */
class OrderStatus
{
    public const APPROVED = 'APPROVED';
    public const REJECTED = 'REJECTED';
    public const SHIPPED = 'SHIPPED';
    public const CREATED = 'CREATED';

    /**
     * OrderStatus constructor.
     * @param string $type
     */
    private function __construct(private string $type)
    {
    }

    public static function approved() : self
    {
        return new static(self::APPROVED);
    }

    public static function rejected() : self
    {
        return new static(self::REJECTED);
    }

    public static function shipped() : self
    {
        return new static(self::SHIPPED);
    }

    public static function created() : self
    {
        return new static(self::CREATED);
    }

    public function getType() : string
    {
        return $this->type;
    }
}