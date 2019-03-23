<?php

declare(strict_types=1);

namespace Tests\HM\Common\UI\Fixtures;

use HM\Common\UI\Projection\InMemory\AbstractInMemoryProjection;
use HM\Common\UI\Projection\Projection;
use Tests\HM\Common\Domain\Fixtures\SimpleIamCreated;
use Tests\HM\Common\Domain\Fixtures\SimpleNameChanged;

class SimpleProjection extends AbstractInMemoryProjection
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

    /**
     * @param SimpleIamCreated $event
     *
     * @return Projection
     */
    protected function whenSimpleIamCreated(SimpleIamCreated $event): Projection
    {
        $this->id = $event->getId();
        $this->name = $event->getName();

        return $this;
    }

    /**
     * @param SimpleNameChanged $event
     *
     * @return Projection
     */
    protected function whenSimpleNameChanged(SimpleNameChanged $event): Projection
    {
        $this->name = $event->getNewName();

        return $this;
    }

    /**
     * @return Projection
     */
    public function reset(): Projection
    {
        $this->id = '';
        $this->name = '';

        return $this;
    }
}
