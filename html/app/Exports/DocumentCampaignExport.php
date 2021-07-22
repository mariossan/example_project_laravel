<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection,FromArray,ShouldAutoSize,WithHeadings};

class DocumentCampaignExport implements FromArray,ShouldAutoSize,WithHeadings
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
            'Campaña',
            'Nombre',
            'Descripción',
            'Fecha',
            'Usuario'
        ];
    }
}
