<?php

namespace App\Enums;

enum MembershipFunctionType: string
{
    case TrapezoidLeft = 'trapezoid_left';
    case Triangle = 'triangle';
    case TrapezoidRight = 'trapezoid_right';
    case Trapezoid = 'trapezoid';
}
