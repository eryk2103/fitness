<?php

namespace App\Enum;

enum UnitType : string 
{
    case g = 'gram';
    case kg = 'kilogram';
    case ml = 'milliliter';
    case l = 'liter';
}