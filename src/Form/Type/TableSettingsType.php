<?php

namespace App\Form\Type;

class TableSettingsType
{
    /**
     * @var array
     */
    private $visibility;
    private $columns;
    private $tableCode;
    private $limit;

    public function __construct()
    {
        $this->visibility = [];
        $this->columns = [];
        $this->limit = 10;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function setColumns($columns): TableSettingsType
    {
        $this->columns = $columns;

        return $this;
    }

    public function getVisibility(): array
    {
        return $this->visibility;
    }

    public function addVisibility(string $visibility): TableSettingsType
    {
        $this->visibility[] = $visibility;

        return $this;
    }

    public function removeVisibility(string $value): TableSettingsType
    {
        if (false !== ($key = array_search($value, $this->visibility))) {
            unset($this->visibility[$key]);
        }

        return $this;
    }

    public function setAllVisibility(array $visibility): TableSettingsType
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function unsetVisibility(array $hideColumns): TableSettingsType
    {
        foreach ($hideColumns as $hideColumn) {
            $this->removeVisibility($hideColumn);
        }

        return $this;
    }

    public function getHideColumns(): array
    {
        return array_diff($this->columns, $this->visibility);
    }

    public function getTableCode(): string
    {
        return $this->tableCode;
    }

    public function setTableCode($tableCode): TableSettingsType
    {
        $this->tableCode = $tableCode;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): TableSettingsType
    {
        $this->limit = $limit;

        return $this;
    }
}
