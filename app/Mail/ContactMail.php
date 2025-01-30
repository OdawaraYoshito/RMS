<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // フォームデータを格納

    /**
     * ContactMail コンストラクタ
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data; // お問い合わせデータを保存
    }

    /**
     * メールの構築
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from($this->data['email']) // ユーザーのメールアドレスを送信者として設定
                     ->subject($this->data['subject']) // メールの件名を設定
                     ->markdown('emails.contact') // 使用するビューを指定
                     ->with([
                         'name'    => $this->data['name'],
                         'email'   => $this->data['email'],
                         'subject' => $this->data['subject'],
                         'messageContent' => $this->data['message'],
                     ]);

        // 添付ファイルがある場合
        if (!empty($this->data['attachment'])) {
            $path = storage_path('app/public/' . $this->data['attachment']);
            if (file_exists($path)) {
                $email->attach($path, [
                    'as'   => basename($path), // ファイル名をそのまま使用
                    'mime' => mime_content_type($path), // MIMEタイプを取得
                ]);
            }
        }

        return $email;
    }
}
