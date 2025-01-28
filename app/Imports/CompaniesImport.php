<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompaniesImport implements ToModel, WithValidation, WithHeadingRow
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
        Log::info("CompaniesImport initialized for user ID: {$this->userId}");
    }

    /**
     * インポートされたデータをモデルに変換
     *
     * @param array $row
     * @return Company|null
     */
    public function model(array $row)
    {
        try {
            // 現在のユーザに紐づく同一会社名のデータをチェック
            $existingCompany = Company::where('name', $row['name'])
                ->where('user_id', $this->userId)
                ->first();

            // 重複データが存在する場合はスキップ
            if ($existingCompany) {
                Log::info("Company already exists for user ID: {$this->userId}, skipping import for name: {$row['name']}");
                return null;
            }

            Log::info("Importing company data for user ID: {$this->userId}", $row);

            // 新規会社データの作成
            return new Company([
                'name' => $row['name'],                       // 会社名
                'url' => $row['url'] ?? null,                 // 会社URL
                'status' => $row['status'] ?? 'active',       // ステータス
                'remarks' => $row['remarks'] ?? null,         // 備考
                'user_id' => $this->userId,                   // 現在のユーザID
                'created_at' => $row['created_at'] ?? now(),  // 作成日時
                'updated_at' => $row['updated_at'] ?? now(),  // 更新日時
            ]);
        } catch (\Exception $e) {
            // エラーをログに記録し再スロー
            Log::error("Error importing company data for user ID: {$this->userId}. Row data: ", [
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
            'name' => 'required|string|max:255',                  // 会社名
            'url' => 'nullable|url',                              // 会社URL
            'status' => ['required', Rule::in(['active', 'inactive'])], // ステータス
            'remarks' => 'nullable|string|max:1000',              // 備考
            'created_at' => 'nullable|date',                      // 作成日時
            'updated_at' => 'nullable|date',                      // 更新日時
        ];
    }
}
