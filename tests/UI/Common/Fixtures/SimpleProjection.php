<?php

declare(strict_types=1);

namespace Tests\HM\UI\Common\Fixtures;

use HM\UI\Projection\EventSourcedProjection;
use HM\UI\Projection\Projection;
use Tests\HM\Domain\Common\Fixtures\SimpleIamCreated;
use Tests\HM\Domain\Common\Fixtures\SimpleNameChanged;

class SimpleProjection extends EventSourcedProjection
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
     * @return Projection
     */
    public function initialize(): Projection
    {
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

    /**
     * @return Projection
     */
    public function delete(): Projection
    {
        return $this;
    }

    protected function whenSimpleIamCreated(SimpleIamCreated $event): void
    {
        $this->id = $event->getId();
        $this->name = $event->getName();
    }

    protected function whenSimpleNameChanged(SimpleNameChanged $event): void
    {
        $this->name = $event->getNewName();
    }
}
