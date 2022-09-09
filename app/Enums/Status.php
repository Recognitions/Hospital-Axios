<?php

namespace App\Enums;

enum Status: int
{
    case Available = 1;
    case Occupied = 2;

    public function getLabel()
    {
        return match(this)
        {
            Status::Available => [
                'color' => 'sucess',
                'name' => 'Disponível',
            ],

            Status::Occupied => [
                'color' => 'warning',
                'name' => 'Ocupado'
            ]
        };
    }
}