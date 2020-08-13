<?php

namespace App\Exports;

use App\Faturacao_detalhada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

Writer::macro('setCreator', function (Writer $writer, string $creator) {
    $writer->getDelegate()->getProperties()->setCreator($creator);
});

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

Sheet::macro('setOrientation', function (Sheet $sheet, $orientation) {
    $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
});

class CapturaExport implements FromArray, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $entradas;

    public function __construct(array $entradas)
    {
        $this->entradas = $entradas;
    }

    public function array(): array
    {
        return $this->entradas;
    }


    public function headings(): array
    {
        return [
            'Nº',
            'EMBARCAÇÃO' ,
            'DATA' ,
            'HR_INICIO' ,
            'HR_FIM' ,
            'SONDA' ,
            'LAT1' ,
            'LONG1' ,
            'LAT2' ,
            'LONG2',
            'ESPECIE',
            'QTD'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'L' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }


    public function registerEvents(): array
    {

        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('solucao-binaria.com');
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                $border_color = '00000000';
                $fundo_header = 'FFfcb322';

                $event->sheet->styleCells(
                    'A1:L1',
                    [
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                                'color' => ['argb' => $border_color ],
                            ]
                        ]
                    ]
                );

                for($i=1;$i<=(sizeof($this->entradas)+1);$i++)
                {
                    $event->sheet->styleCells(
                        'A'.$i.':L'.$i,
                        [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                                    'color' => ['argb' => $border_color ],
                                ]
                            ]
                        ]
                    );
                }

                $event->sheet->getStyle('A1:L1')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($fundo_header);

                $event->sheet->getStyle('L'.(sizeof($this->entradas)+1))->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($fundo_header);

            },
        ];
    }

}
