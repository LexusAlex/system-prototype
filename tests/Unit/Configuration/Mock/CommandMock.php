<?php

declare(strict_types=1);

namespace Test\Unit\Configuration\Mock;

use Symfony\Component\Validator\Constraints as Assert;

class CommandMock
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public string $email = '';
    /**
     * @Assert\NotBlank
     * @Assert\Length(min=6, allowEmptyString=true)
     */
    public string $password = '';
    /**
     * @Assert\NotBlank
     * @Assert\EqualTo("Test")
     */
    public string $equals = '';
}
