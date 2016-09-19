<?php
namespace Schweppesale\Module\Access\Domain\Values;

/**
 * Class EmailAddress
 * @package Schweppesale\Module\Access\Domain\Values
 */
class EmailAddress
{

    /**
     * @var string
     */
    private $email;

    /**
     * EmailAddress constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('Invalid email address: ' . $email);
        }
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->email;
    }
}