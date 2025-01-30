@component('mail::message')
# お問い合わせがありました

以下の内容でお問い合わせを受け付けました。

---

**お名前:** {{ $data['name'] }}

**メールアドレス:** {{ $data['email'] }}

**件名:** {{ $data['subject'] }}

**メッセージ:**
{{ $data['message'] }}

---

@if (!empty($data['attachment']))
### 添付ファイル:
添付ファイルが送信されました。
@endif

このメッセージはシステムからの自動送信です。
返信が必要な場合は、上記のメールアドレスにご連絡ください。

@endcomponent
