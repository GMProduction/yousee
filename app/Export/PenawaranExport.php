<?php

namespace App\Export;

use App\Models\Item;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenawaranExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithStyles
{
    private $rowNumber = 0;

    private $title;
    private $id;

    /**
     * @param $title
     */
    public function __construct($id, $title)
    {
        $this->title = $title;
        $this->id    = $id;
    }

    /**
     * @return Builder|Builder|Collection|Model|Relation|\Illuminate\Database\Query\Builder|null
     */
    public function query()
    {
        // TODO: Implement query() method.
        return Project::with(['items.city', 'items.item'])->find($this->id);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        $title = [$this->title];
        $rowHeader = [
            '#',
            'Kota / Kab',
            'Lokasi',
            'Vertikal',
            'Horizontal',
            'Posisi',
            'Status',
            'Harga',
        ];

        $data = [
            $title,
            [''],
            $rowHeader
        ];
        $totalPrice = 0;
        foreach ($this->query()->items as $key => $d) {
            $this->rowNumber = (int)$this->rowNumber + 1;
            $row             = [
                $this->rowNumber,
                $d->city->name,
                $d->item->location,
                $d->item->width,
                $d->item->height,
                $d->item->position,
                $d->available == 'Tersedia' ? $d->available : 'Tersedia tgl '.$d->available,
                $d->end_price,
            ];
            $totalPrice += $d->end_price;
            array_push($data, $row);
        }
        $grandTotal = $this->query()->total_price == 0 ? $totalPrice : $this->query()->total_price;
        $footer = ['Total Harga', '', '', '', '', '', '', $grandTotal];
        array_push($data, $footer);

        return $data;
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function (AfterSheet $sheet) {
                $sheet->sheet->getDelegate()->mergeCells('A1:H1');
                $sheet->sheet->getDelegate()->mergeCells('A'.((int)$this->rowNumber + 4).':G'.((int)$this->rowNumber + 4));
                $sheet->sheet->getDelegate()->getStyle(1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                             ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->getStyle(3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                             ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->getStyle('A'.((int)$this->rowNumber + 4).':G'.((int)$this->rowNumber + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                             ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // TODO: Implement styles() method.
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            3 => ['font' => ['bold' => true]],
            ((int)$this->rowNumber + 4) => ['font' => ['bold' => true]]
        ];
    }
}
