<?php

namespace App\Exports;

use App\Models\Person;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeopleExport implements FromCollection, WithHeadings
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
        // 人物データと会社名を結合して取得
        return DB::table('people')
            ->select(
                'people.id AS person_id',
                'people.name AS person_name',
                'people.contact',
                'people.status',
                'people.remarks',
                'companies.name AS company_name', // 会社名を結合
                'people.created_at',
                'people.updated_at'
            )
            ->leftJoin('companies', 'people.company_id', '=', 'companies.id') // 会社IDで結合
            ->where('people.user_id', $this->userId) // 現在のユーザのデータのみ
            ->get();
    }

    /**
     * エクスポートする列の見出しを定義
     */
    public function headings(): array
    {
        return [
            'Person ID',
            'Person Name',
            'Contact',
            'Status',
            'Remarks',
            'Company Name',
            'Created At',
            'Updated At',
        ];
    }
}
