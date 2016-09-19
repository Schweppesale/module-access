<?php
namespace Schweppesale\Module\Access\Domain\Values\User;

/**
 * Class Status
 * @package Schweppesale\Module\Access\Domain\Values\User
 */
class Status
{

    const ACTIVE = 0x01;

    const BANNED = 0x02;

    const DISABLED = 0x00;

    /**
     * @var string
     */
    private $status;

    /**
     * UserStatus constructor.
     * @param string $status
     */
    public function __construct(string $status)
    {
        if (in_array($status, [self::ACTIVE, self::BANNED, self::DISABLED], false) === false) {
            throw new \InvalidArgumentException('Invalid user status: ' . $status);
        }
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    public function jsonSerialize()
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->status;
    }
}