<?php

namespace App\Exports;

use App\Models\ProductImport as ModelsImport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class ExcelImport implements WithHeadings,WithMultipleSheets,FromQuery
{
    public function headings():array{
        return [
            'donnhap_id',
            'madonnhap',
            'ngaynhap',
            'tongtien',
            'trangthai',
            'nhacungcap_id',
            'admin_id'
        ];
    }
    use Exportable;

    public function __construct($fromday,$today)
    {
        $this->fromday = $fromday;
        $this->today = $today;
    }

    public function query()
    {
        return ModelsImport::query()->whereDate('donnhaphang_ngay_nhap','>=', $this->fromday)
        ->whereDate('donnhaphang_ngay_nhap','<=', $this->today);
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ExcelImport($this->fromday,$this->today);
        $sheets[] = new ExcelImportSize($this->fromday,$this->today);
        $sheets[] = new ExcelImportProduct($this->fromday,$this->today);
        $sheets[] = new ExcelImportDetail($this->fromday,$this->today);
        return $sheets;
    }
}
