<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    /**
     * 会社データのエクスポート
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportCompanies(Request $request)
    {
        Log::info('Exporting companies data by user ID: ' . Auth::id());

        // フォーマットの取得 (デフォルトは Excel)
        $format = $request->query('format', 'xlsx');

        // ファイル名の決定
        $fileName = "companies.{$format}";

        // エクスポート処理
        return Excel::download(new \App\Exports\CompaniesExport(Auth::id()), $fileName);
    }

    /**
     * 人物データのエクスポート
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPeople(Request $request)
    {
        Log::info('Exporting people data by user ID: ' . Auth::id());

        // フォーマットの取得 (デフォルトは Excel)
        $format = $request->query('format', 'xlsx');

        // ファイル名の決定
        $fileName = "people.{$format}";

        // エクスポート処理
        return Excel::download(new \App\Exports\PeopleExport(Auth::id()), $fileName);
    }

    /**
     * 会社データのインポート
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importCompanies(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Log::info('Starting import of companies data by user ID: ' . Auth::id());

            // 会社データのインポート処理
            Excel::import(new \App\Imports\CompaniesImport(Auth::id()), $request->file('file'));

            Log::info('Successfully imported companies data by user ID: ' . Auth::id());
            return back()->with('success', '会社データをインポートしました。');
        } catch (\Exception $e) {
            Log::error('Error importing companies data: ' . $e->getMessage());
            return back()->withErrors('会社データのインポート中にエラーが発生しました。');
        }
    }

    /**
     * 人物データのインポート
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importPeople(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Log::info('Starting import of people data by user ID: ' . Auth::id());

            // 人物データのインポート処理
            Excel::import(new \App\Imports\PeopleImport(Auth::id()), $request->file('file'));

            Log::info('Successfully imported people data by user ID: ' . Auth::id());
            return back()->with('success', '人物データをインポートしました。');
        } catch (\Exception $e) {
            Log::error('Error importing people data: ' . $e->getMessage());
            return back()->withErrors('人物データのインポート中にエラーが発生しました。');
        }
    }
}
