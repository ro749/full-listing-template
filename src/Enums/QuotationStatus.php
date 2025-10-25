<?php

namespace Ro749\FullListingTemplate\Enums;

enum QuotationStatus: int
{
    case Pendiente = 0;
    case Aprobado = 1;
    case Rechazado = 2;
    case Cerrado = 3;
}