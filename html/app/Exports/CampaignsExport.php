<?php

namespace App\Exports;

use Maatwebsite\Excel\{Excel,Sheet};
use Maatwebsite\Excel\Concerns\{FromArray,WithHeadings,ShouldAutoSize};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use Maatwebsite\Excel\Events\AfterSheet;

class CampaignsExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public $campaigns;

    public function __construct(array $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    public function array() :array
    {
        return $this->campaigns;
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
             'Link PDF',
             'Nombre archivo',
             'Mes gasto',
             'Tipo Gasto',
             'proveedor gasto',
             'talento gasto',
             'Concepto',
             'Importe Gasto'
         ];
     }

     public function custom()
     {
         Excel::extend(static::class, function(CampaignsExport $export, Sheet $sheet){
             /** @var Worksheet $sheet */
             foreach ($sheet->getColumnIterator('I') as $row){
                foreach ($row->getCellIterator() as $cell){
                    if( !is_null($cell->getValue()) && str_contains($cell->getValue(), '://') ){
                        $cell->setHyperlink( new Hyperlink($cell->getValue(), 'Ver documento') );
                    }
                }
             }
         }, AfterSheet::class);
     }
}
