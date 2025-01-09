<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PersonController extends Controller
{
    use AuthorizesRequests;

    /**
     * 人物情報の一覧表示と検索
     */
    public function index(Request $request)
    {
        // ログインユーザに紐付いた人物情報を取得し、検索条件を適用
        $people = Person::query()
            ->where('user_id', Auth::id()) // ログインユーザに限定
            ->filter($request->only(['name', 'company_id', 'status'])) // 検索条件
            ->paginate($request->input('per_page', 10)); // ページネーション

        // 検索フォーム用の会社リストを取得
        $companies = Auth::user()->companies;

        return view('people.index', compact('people', 'companies'));
    }

    /**
     * 新しい人物を作成するフォームを表示
     */
    public function create()
    {
        // ログインユーザに紐付いた会社情報を取得
        $companies = Auth::user()->companies;

        return view('people.create', compact('companies'));
    }

    /**
     * 新しい人物情報を保存
     */
    public function store(Request $request)
    {
        // バリデーションを実行し、データを取得
        $validated = $this->validatePerson($request);
        $validated['user_id'] = Auth::id(); // ログインユーザに紐付け

        // 人物情報を作成
        Person::create($validated);

        return redirect()->route('people.index')->with('success', __('messages.person_added'));
    }

    /**
     * 人物情報の編集画面を表示
     */
    public function edit(Person $person)
    {
        $this->authorize('update', $person); // 認可処理

        // ログインユーザに紐付いた会社情報を取得
        $companies = Auth::user()->companies;

        return view('people.edit', compact('person', 'companies'));
    }

    /**
     * 人物情報を更新
     */
    public function update(Request $request, Person $person)
    {
        $this->authorize('update', $person); // 認可処理

        // バリデーションを実行し、データを取得
        $validated = $this->validatePerson($request);

        // 人物情報を更新
        $person->update($validated);

        return redirect()->route('people.index')->with('success', __('messages.person_updated'));
    }

    /**
     * 人物情報を削除
     */
    public function destroy(Person $person)
    {
        $this->authorize('delete', $person); // 認可処理

        // 人物情報を削除
        $person->delete();

        return redirect()->route('people.index')->with('success', __('messages.person_deleted'));
    }

    /**
     * 入力データのバリデーション
     *
     * @param Request $request
     * @return array
     */
    protected function validatePerson(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',         // 必須、文字列、最大255文字
            'company_id' => 'nullable|exists:companies,id', // 任意、存在する会社ID
            'contact' => 'nullable|email|max:255',      // 任意、メール形式
            'status' => 'required|string|in:active,inactive', // 必須、特定の値のみ
            'remarks' => 'nullable|string|max:1000',    // 任意、文字列、最大1000文字
        ]);
    }
}
