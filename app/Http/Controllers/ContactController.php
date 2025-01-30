<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class ContactController extends Controller
{
    /**
     * お問い合わせフォームの表示
     */
    public function index()
    {
        return view('contact.index'); // お問い合わせフォームのビューを表示
    }

    /**
     * お問い合わせフォームの送信処理
     */
    public function send(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255', // 名前（必須、最大255文字）
            'email'      => 'required|email|max:255', // メールアドレス（必須、最大255文字）
            'subject'    => 'required|string|max:255', // 件名（必須、最大255文字）
            'message'    => 'required|string|max:2000', // メッセージ（必須、最大2000文字）
            'attachment' => 'nullable|file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt' // 添付ファイル（任意、2MB以下、指定拡張子のみ）
        ]);

        // バリデーションエラー時の処理
        if ($validator->fails()) {
            return redirect()->route('contact')->withErrors($validator)->withInput();
        }

        // フォームデータの取得
        $data = $request->only(['name', 'email', 'subject', 'message']);

        // 添付ファイルがある場合の処理
        if ($request->hasFile('attachment')) {
            // ファイルの保存
            $file = $request->file('attachment');
            $filePath = $file->store('attachments', 'public'); // publicディスクに保存
            $data['attachment'] = storage_path('app/public/' . $filePath); // 保存したファイルのパスをセット
            $data['attachment_name'] = $file->getClientOriginalName(); // 元のファイル名を保存
        } else {
            $data['attachment'] = null;
        }

        try {
            // メール送信
            Mail::to(config('mail.from.address'))->send(new ContactMail($data));

            // **送信成功時のログ記録**
            Log::info('お問い合わせメール送信成功', [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'attachment' => $data['attachment'] ?? 'なし'
            ]);

            // 成功メッセージと共にリダイレクト
            return redirect()->route('contact')->with('success', 'お問い合わせ内容が送信されました。');
        } catch (Exception $e) {
            Log::error('お問い合わせメール送信エラー: ' . $e->getMessage());

            // 送信失敗時の処理
            return redirect()->route('contact')->with('error', 'メールの送信に失敗しました。しばらくしてから再度お試しください。');
        }
    }
}
