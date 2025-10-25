<?php

namespace Ro749\FullListingTemplate\Enums;

enum UnitsStatus: int
{
    case Disponible = 0;
    case Vendido = 1;
    case Apartado = 2;
    case Bloqueado = 3;
}