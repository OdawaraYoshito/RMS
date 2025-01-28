<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesExport implements FromCollection, WithHeadings
{
    private $userId;

    /**
     * コンストラクタでユーザIDを受け取る
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * エクスポートするデータのコレクションを取得
     */
    public function collection()
    {
        return Company::select(
            'id',
            'name',
            'url',
            'status',
            'remarks',
            'user_id',
            'created_at',
            'updated_at'
        )
        ->where('user_id', $this->userId) // 現在のユーザのデータのみをエクスポート
        ->get();
    }

    /**
     * エクスポートする列の見出しを定義
     */
    public function headings(): array
    {
        return [
            'Company ID',
            'Name',
            'URL',
            'Status',
            'Remarks',
            'User ID',
            'Created At',
            'Updated At',
        ];
    }
}
