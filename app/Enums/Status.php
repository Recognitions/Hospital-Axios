<?php

namespace App\Enums;

enum Status: int
{
    case PossibleInfected = 0;
    case InfectedPotential = 1;
    case InsufficientSymptoms = 2;
    case NotMet = 3;

    public function getLabel()
    {
        return match(this)
        {
            Status::PossibleInfected => [
                'color' => 'sucess',
                'name' => 'POSSÍVEL INFECTADO'
            ],
            Status::InfectedPotential => [
                'color' => 'warning',
                'name' => 'POTENCIAL INFECTADO'
            ],
            Status::InsufficientSymptoms => [
                'color' => 'warning',
                'name' => 'SINTOMAS INSUFICIENTES'
            ],
            Status::NotMet => [
                'color' => 'grey',
                'name' => 'Não Atendido'
            ],
            
        };
    }
}