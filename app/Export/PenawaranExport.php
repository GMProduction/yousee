<?php

namespace App\Export;

use App\Models\Item;
use App\Models\Project;
use App\Models\ProjectItem;
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
        return Project::with(['items.city', 'items.item.vendorAll', 'items.pic'])->find($this->id);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        $title     = [$this->title];
        $rowHeader = [
            '#',
            'Area',
            'Alamat',
            'Ukuran',
            '',
            '',
            'V/H',
            'Vendor',
            'PIC',
            'Cost',
            'Harga',
            'Margin',
        ];

        $rowHeader2 = [
            '',
            '',
            '',
            'P',
            'x',
            'L',
            '',
            '',
            '',
            '',
            '',
        ];

        $data = [
            $title,
            [''],
            $rowHeader,
            $rowHeader2,
        ];

        $totalPrice        = 0;
        $totalVenbdorPrice = 0;
        $margin            = 0;

        $item = ProjectItem::with(['city','pic','item.vendorAll'])->where('project_id',$this->query()->id)->orderBy('index_number','ASC')->get();
        foreach ($item as $key => $d) {
            $this->rowNumber   = (int)$this->rowNumber + 1;
            $row               = [
                $this->rowNumber,
//                $d->index_number,
                $d->city->name,
                $d->item->address.', '.$d->city->name.', '.$d->city->province->name.' ( '.$d->item->location.' )',
                $d->item->width,
                'x',
                $d->item->height,
                substr($d->item->position, 0, 1),
                $d->item->vendorAll->name,
                $d->pic->nama,
                $d->vendor_price,
                $d->end_price,
                '0',
            ];
            $totalVenbdorPrice += $d->vendor_price;
            $totalPrice        += $d->end_price;
            array_push($data, $row);
        }
        $grandTotal = $this->query()->total_price == 0 ? $totalPrice : $this->query()->total_price;
        $footer     = ['Total Harga', '', '', '', '', '', '', '', '', $totalVenbdorPrice, $grandTotal, $grandTotal - $totalVenbdorPrice];
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
            'J' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function (AfterSheet $sheet) {
                $sheet->sheet->getDelegate()->mergeCells('A1:L1')->getStyle(1)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('A3:A4')->getStyle('A3:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('B3:B4')->getStyle('B3:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('C3:C4')->getStyle('C3:C4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('D3:F3')->getStyle('D3:F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('G3:G4')->getStyle('G3:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('H3:H4')->getStyle('H3:H4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('I3:I4')->getStyle('I3:I4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('J3:J4')->getStyle('J3:J4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('K3:K4')->getStyle('K3:K4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('L3:L4')->getStyle('L3:L4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->getStyle('D4:F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->sheet->getDelegate()->mergeCells('A'.((int)$this->rowNumber + 5).':I'.((int)$this->rowNumber + 5))->getStyle(
                    'A'.((int)$this->rowNumber + 5).':I'.((int)$this->rowNumber + 5)
                )->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

//                $sheet->sheet->getDelegate()->getStyle(3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
//                             ->setVertical(Alignment::VERTICAL_CENTER);
//                $sheet->sheet->getDelegate()->getStyle('A'.((int)$this->rowNumber + 4).':G'.((int)$this->rowNumber + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
//                             ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // TODO: Implement styles() method.
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
//            3 => ['font' => ['bold' => true]],
//            ((int)$this->rowNumber + 4) => ['font' => ['bold' => true]]
        ];
    }
}
