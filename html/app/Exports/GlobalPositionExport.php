<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection,FromArray,ShouldAutoSize,WithHeadings};

class GlobalPositionExport implements FromArray,ShouldAutoSize,WithHeadings
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Mes',
            'ID Campaña',
            'Nombre Campaña',
            'Cliente',
            'Anunciante',
            'Ingreso Real',
            'Ing. Aux1',
            'Talentos',
            'Prod. Interna',
            'Prod. Externa',
            'Prod. Delivery',
            'Prov. Gasto Generada',
            'Res 1',
            'Res 2',
            'Producers',
            'Ultima Fecha Mod.',
            'Estado',
        ];
    }
}
