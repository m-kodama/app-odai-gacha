<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GachaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gacha.gachaName' => 'required|string|max:50',
            'gacha.description' => 'max:500',
            'gacha.needUsePass' => 'required|boolean',
            'gacha.needEditPass' => 'required|boolean',
            'gacha.needDeletePass' => 'required|boolean',
            'gacha.password' => [
                'max:16',
                function ($attribute, $value, $fail) {
                    $input_data = $this->all();
                    if ($input_data['gacha']['needUsePass'] 
                        || $input_data['gacha']['needEditPass']
                        || $input_data['gacha']['needDeletePass']) {
                        if(is_null($value) || $value === "") {
                            $fail('使用、編集、削除にロックをかける場合は、パスワードが必須です');
                        }
                    } else {
                        if(!is_null($value)) {
                            $fail('使用、編集、削除にロックをかけない場合は、パスワードは設定できません');
                        }
                    }
                }
            ],
            'topics' => 'required|array|min:1|max:200',
            'topics.*.topic' => 'required|string|max:30',
            'topics.*.rarity' => 'required',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gacha.gachaName.required' => 'タイトルは必須です',
            'gacha.gachaName.max' => 'タイトルは50文字以内で入力してください',
            'gacha.description.max' => '説明は500文字以内で入力してください',
            'gacha.password.max' => 'パスワードは16文字以内で入力してください',
            'topics.required' => 'お題は必須です',
            'topics.min' => 'お題は1件以上入力してください',
            'topics.max' => 'お題は200件以内で入力してください',
            'topics.*.required' => 'お題には1文字以上入力してください',
            'topics.*.max' => 'お題は30文字以内で入力してください',
        ];
    }
}
