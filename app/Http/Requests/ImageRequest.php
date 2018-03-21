<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    /**
     * 头像上传验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar' => 'mimes:jpeg,png,jpg|dimensions:min_width=200,min_height=200',
        ];
    }


    /**
     * 验证出错时的提示信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'avatar.mimes' => '头像必须是 jpg 或 png 格式的图片',
            'avatar.dimensions' => '图片分辨率至少为 200×200 px',
        ];
    }
}