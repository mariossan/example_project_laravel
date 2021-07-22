<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromArray,WithHeadings,ShouldAutoSize};

class SingleCampaignExport implements FromArray, ShouldAutoSize,WithHeadings
{

    public $campaign;

    public function __construct(array $campaign)
    {
        $this->campaign = $campaign;
    }

    public function array(): array
    {
        return $this->campaign;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Mes',
            'Tipo',
            'Proveedor',
            'Talento',
            'Concepto',
            'Comentarios',
            'Presupuesto',
            'Gastos',
            'Pdte. aplicar',
            'Var'
        ];
    }
}
