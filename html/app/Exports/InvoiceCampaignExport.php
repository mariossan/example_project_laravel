<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection,FromArray,WithHeadings};

class InvoiceCampaignExport implements FromArray, WithHeadings
{
    public $campaign;

    public function __construct(array $campaign)
    {
        $this->campaign = $campaign;
    }

    public function array():array
    {
        return $this->campaign;
    }

    public function headings(): array
    {
        return [
            'Campaña',
            'Mes',
            'No. de Factura',
            'Importe bruto',
            'Importe neto',
            'Aplicada Totalmente',
            'Condiciones de pago',
            'ok pago?',
            'PDF',
            '',
            'Mes gasto',
            'Tipo Gasto',
            'proveedor gasto',
            'talento gasto',
            'Concepto',
            'Importe Gasto'
        ];
    }
}
