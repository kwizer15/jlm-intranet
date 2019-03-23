<?php

declare(strict_types=1);

namespace Tests\HM\Common\Domain\Fixtures;

use HM\Common\Domain\Event\Event;

class SimpleIamCreated implements Event
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @param $id
     * @param $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
