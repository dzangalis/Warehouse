<?php

namespace Warehouse;

use Carbon\Carbon;

class Product
{
    private int $id;
    private string $name;
    private Carbon $creationTime;
    private Carbon $updateTime;
    private int $units;

    public function __construct(int $id, string $name, int $units)
    {
        $this->id = $id;
        $this->name = $name;
        $this->creationTime = Carbon::now();
        $this->updateTime = Carbon::now();
        $this->units = $units;
    }

    public function updateUnits(int $units): void
    {
        $this->units = $units;
        $this->updateTime = Carbon::now();
    }

    public function withdrawUnits(int $units): void
    {
        if ($units > $this->units) {
            throw new \Exception("Not enough units in stock.");
        }
        $this->units -= $units;
        $this->updateTime = Carbon::now();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'creationTime' => $this->creationTime->toDateTimeString(),
            'updateTime' => $this->updateTime->toDateTimeString(),
            'units' => $this->units,
        ];
    }
}
