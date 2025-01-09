<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * このリクエストに適用されるバリデーションルールを取得
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', // 必須
                'string',   // 文字列
                'max:255',  // 最大255文字
            ],
            'email' => [
                'required',  // 必須
                'string',    // 文字列
                'lowercase', // 小文字に変換
                'email',     // メール形式
                'max:255',   // 最大255文字
                Rule::unique(User::class)->ignore($this->user()->id), // 他のユーザと重複しない
            ],
        ];
    }
}
