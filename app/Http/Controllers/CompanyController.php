<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    /**
     * 会社情報の一覧表示
     */
    public function index(Request $request)
    {
        // ログインユーザに紐付いた会社情報を取得し、検索条件を適用
        $companies = Company::query()
            ->ownedBy(Auth::id()) // ログインユーザのデータに限定
            ->filter($request->only(['name', 'status'])) // 検索条件を適用
            ->paginate($request->input('per_page', 10)); // ページネーション

        return view('companies.index', compact('companies'));
    }

    /**
     * 新しい会社を作成するフォームを表示
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * 新しい会社情報を保存
     */
    public function store(Request $request)
    {
        // バリデーションを実行し、データを取得
        $validated = $this->validateCompany($request);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // ログインユーザに紐付けて会社情報を作成
        $user->companies()->create($validated);

        return redirect()->route('companies.index')->with('success', __('messages.company_added'));
    }

    /**
     * 会社情報の編集画面を表示
     */
    public function edit(Company $company)
    {
        $this->authorize('update', $company); // 認可処理

        return view('companies.edit', compact('company'));
    }

    /**
     * 会社情報を更新
     */
    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company); // 認可処理

        // バリデーションを実行し、データを取得
        $validated = $this->validateCompany($request);

        // 会社情報を更新
        $company->update($validated);

        return redirect()->route('companies.index')->with('success', __('messages.company_updated'));
    }

    /**
     * 会社情報を削除
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company); // 認可処理

        // 関連する人物の`company_id`を`null`に更新し、会社情報を削除
        $company->people()->update(['company_id' => null]);
        $company->delete();

        return redirect()->route('companies.index')->with('success', __('messages.company_deleted'));
    }

    /**
     * 入力データのバリデーション
     *
     * @param Request $request
     * @return array
     */
    protected function validateCompany(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255', // 必須、文字列、最大255文字
            'url' => 'nullable|url|max:255',     // 任意、URL形式
            'status' => 'required|string|in:active,inactive', // 必須、特定の値のみ
            'remarks' => 'nullable|string|max:1000', // 任意、文字列、最大1000文字
        ]);
    }
}
