<?php
/**
 * Admin\Graph Model.
 */

namespace App\Model\Admin;

class Graph
{
    protected $title;
    protected $values = [];

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function addPoint($caption, $value)
    {
        $this->values[] = ['caption' => $caption, 'value' => $value];
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function __toArray(): array
    {
        return ['title' => $this->getTitle(), 'values' => $this->getValues()];
    }
}
