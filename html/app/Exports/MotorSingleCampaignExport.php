<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{FromCollection,FromArray,ShouldAutoSize,WithHeadings};

class MotorSingleCampaignExport implements FromArray,ShouldAutoSize,WithHeadings
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array():array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Campaña',
            'Ingreso total',
            'Gasto Total',
            'Margen'
        ];
    }
}
