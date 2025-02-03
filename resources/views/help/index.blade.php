<x-app-layout>
    <!-- ページタイトル -->
    <x-slot name="title">
        {{ __('RMSヘルプページ') }}
    </x-slot>

    <!-- メタディスクリプション -->
    <x-slot name="metaDescription">
        {{ __('RMSの使い方やよくある質問をまとめたヘルプページです。') }}
    </x-slot>

    <!-- ページヘッダー -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('RMSヘルプページ') }}
        </h2>
    </x-slot>

    <!-- メインコンテンツ -->
    <div class="container mt-5 help-page">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <!-- カードのヘッダー -->
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('RMS ヘルプ＆ガイド') }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">
                            RMS（Relation Management System）の基本的な使い方や、よくある質問をまとめました。
                            不明点がある場合は、まずこちらのヘルプをご確認ください。
                        </p>

                        <!-- 目次 -->
                        <h5 class="mt-4">目次</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a href="#how-to-register">アカウントの登録方法</a></li>
                            <li class="list-group-item"><a href="#how-to-add-company">会社情報の登録</a></li>
                            <li class="list-group-item"><a href="#how-to-manage-contacts">人物情報の管理</a></li>
                            <li class="list-group-item"><a href="#data-export-import">データのエクスポートとインポート</a></li>
                            <li class="list-group-item"><a href="#faq">よくある質問</a></li>
                        </ul>

                        <!-- 各セクション -->
                        <div class="mt-5">
                            <h4 id="how-to-register">アカウントの登録方法</h4>
                            <p>RMSを利用するには、まずアカウントを作成する必要があります。以下の手順で登録を行ってください。</p>
                            <ol>
                                <li>トップページの「ユーザ登録」ボタンをクリック</li>
                                <li>必要な情報（氏名、メールアドレス、パスワードなど）を入力し、「登録」ボタンを押す</li>
                                <li>登録完了後、確認メールが送信されるので、メール内のリンクをクリックして認証を完了</li>
                            </ol>

                            <h4 id="how-to-add-company" class="mt-5">会社情報の登録</h4>
                            <p>RMSでは、取引先などの会社情報を簡単に管理できます。</p>
                            <ol>
                                <li>ダッシュボードから「新しい会社を作成」ボタンをクリック</li>
                                <li>会社名、URL、ステータス、備考などの情報を入力し、「登録」ボタンを押す</li>
                                <li>登録後、会社一覧ページで確認・編集・削除が可能</li>
                            </ol>

                            <h4 id="how-to-manage-contacts" class="mt-5">人物情報の管理</h4>
                            <p>取引先担当者や関係者の情報を登録・管理できます。</p>
                            <ol>
                                <li>ダッシュボードから「新しい人物を作成」ボタンをクリック</li>
                                <li>名前、連絡先、所属会社などの情報を入力し、「登録」ボタンを押す</li>
                                <li>登録後、人物一覧ページで確認・編集・削除が可能</li>
                            </ol>

                            <h4 id="data-export-import" class="mt-5">データのエクスポートとインポート</h4>
                            <p>RMSでは、登録データをCSV/Excel形式でエクスポートしたり、外部ファイルからデータをインポートすることが可能です。</p>

                            <h5>データのエクスポート</h5>
                            <ol>
                                <li>ダッシュボードのメニューから「Export Data」を開く</li>
                                <li>エクスポート種別（会社または人物）とエクスポート形式（CSVまたはExcel）から好みのオプションを選ぶ</li>
                                <li>選択したデータがファイルとしてダウンロードされる</li>
                            </ol>

                            <h5>データのインポート</h5>
                            <ol>
                                <li>ダッシュボードのメニューから「Import Data」を開く</li>
                                <li>アップロードしたいCSV/Excelファイルを選択し、「アップロード」ボタンを押す</li>
                                <li>データがシステムに追加されたのを確認する</li>
                            </ol>

                            <h4 id="faq" class="mt-5">よくある質問</h4>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqHeading1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
                                            ログインできません。どうすればいいですか？
                                        </button>
                                    </h2>
                                    <div id="faqCollapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            メールアドレスとパスワードが正しいか確認してください。
                                            パスワードを忘れた場合は、ログインページの「パスワードを忘れた場合」リンクからリセットできます。
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqHeading2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
                                            会社情報を削除するとどうなりますか？
                                        </button>
                                    </h2>
                                    <div id="faqCollapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            会社情報を削除すると、関連する人物情報は未所属の人物として残存します。削除する際には、その旨ご留意ください。
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqHeading3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
                                            登録したデータはセキュリティ上安全ですか？
                                        </button>
                                    </h2>
                                    <div id="faqCollapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            RMSに登録されたデータは、他のユーザーからは見えない仕組みになっており、安全に管理されています。
                                            ただし、システム管理者はすべてのデータにアクセスできる権限を有しています。
                                            そのため、管理者のアクセスが気になる場合は、ローカル環境やオンプレミスのサーバーにシステムをクローンし、独自に運用することも検討してください。
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faqHeading4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4">
                                            システムの不具合を報告したい場合は？
                                        </button>
                                    </h2>
                                    <div id="faqCollapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>不具合を発見した場合は、下記リンク先からご連絡ください。</p>
                                            <ul>
                                                <li><a href="{{ route('contact') }}">RMSお問い合わせページ</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- FAQ セクション終了 -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- フッター -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; {{ now()->year }} {{ config('app.name', 'Relation Management System (RMS)') }}</p>
    </footer>
</x-app-layout>
