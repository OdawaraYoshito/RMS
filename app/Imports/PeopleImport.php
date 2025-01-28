<?php

namespace App\Imports;

use App\Models\Person;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeopleImport implements ToModel, WithValidation, WithHeadingRow, WithMapping
{
    private $userId; // ログイン中のユーザID

    /**
     * コンストラクタで現在のユーザIDを受け取る
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
        Log::info("PeopleImport initialized for user ID: {$this->userId}");
    }

    /**
     * ヘッダーを内部キーにマッピング
     *
     * @param array $row
     * @return array
     */
    public function map($row): array
    {
        return [
            'name' => $row['person_name'] ?? null,           // `Person Name` → `name`
            'contact' => $row['contact'] ?? null,           // 連絡先
            'status' => $row['status'] ?? 'active',         // ステータス
            'remarks' => $row['remarks'] ?? null,           // 備考
            'company_name' => $row['company_name'] ?? null, // 会社名
            'created_at' => $row['created_at'] ?? now(),    // 作成日時
            'updated_at' => $row['updated_at'] ?? now(),    // 更新日時
        ];
    }

    /**
     * インポートされたデータをモデルに変換
     *
     * @param array $row
     * @return Person|null
     */
    public function model(array $row)
    {
        try {
            $companyId = null;

            // `company_name` が存在する場合のみ会社データを作成または取得
            if (!empty($row['company_name'])) {
                $company = Company::firstOrCreate(
                    [
                        'name' => $row['company_name'], // 会社名
                        'user_id' => $this->userId,    // 現在のユーザID
                    ],
                    [
                        'url' => null,                 // URLはデフォルトでnull
                        'status' => 'active',          // デフォルトステータス
                        'remarks' => null,             // 備考はnull
                    ]
                );

                $companyId = $company->id;

                if ($company->wasRecentlyCreated) {
                    Log::info("Created new company for user ID: {$this->userId}, company name: {$row['company_name']}");
                } else {
                    Log::info("Company already exists for user ID: {$this->userId}, company name: {$row['company_name']}");
                }
            } else {
                Log::info("No company name provided, registering person without a company for user ID: {$this->userId}");
            }

            Log::info("Importing person data for user ID: {$this->userId}", $row);

            // 新規人物データの作成
            return new Person([
                'name' => $row['name'],                       // 人物名
                'contact' => $row['contact'],                 // 連絡先
                'status' => $row['status'],                   // ステータス
                'remarks' => $row['remarks'],                 // 備考
                'company_id' => $companyId,                   // 所属会社ID (NULLを許容)
                'user_id' => $this->userId,                   // 現在のユーザID
                'created_at' => $row['created_at'],           // 作成日時
                'updated_at' => $row['updated_at'],           // 更新日時
            ]);
        } catch (\Exception $e) {
            // エラーをログに記録し再スロー
            Log::error("Error importing person data for user ID: {$this->userId}. Row data: ", [
                'row' => $row,
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * インポートデータのバリデーションルールを定義
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',                  // 人物名
            'contact' => 'nullable|email',                        // 連絡先
            'status' => ['required', Rule::in(['active', 'inactive'])], // ステータス
            'remarks' => 'nullable|string|max:1000',              // 備考
            'company_name' => 'nullable|string|max:255',          // 会社名 (NULLを許容)
            'created_at' => 'nullable|date',                      // 作成日時
            'updated_at' => 'nullable|date',                      // 更新日時
        ];
    }
}
