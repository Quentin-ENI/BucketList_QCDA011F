<?php

namespace App\Model;

class EventDTO
{
    private int $nhits;
    private mixed $parameters;
    private mixed $records;

    public function getNhits(): int
    {
        return $this->nhits;
    }

    public function setNhits(int $nhits): void
    {
        $this->nhits = $nhits;
    }

    public function getParameters(): mixed
    {
        return $this->parameters;
    }

    public function setParameters(mixed $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getRecords(): mixed
    {
        return $this->records;
    }

    public function setRecords(mixed $records): void
    {
        $this->records = $records;
    }


}
