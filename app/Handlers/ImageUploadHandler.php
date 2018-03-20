<?php

namespace App\Handlers;

class ImageUploadHandler
{
    protected $allowed_ext = ["png", "jpg", 'jpeg'];

    /**
     * 保存文件
     *
     * @param $file
     * @param $folder
     * @param $file_prefix
     * @return array|bool
     */
    public function save($file, $folder, $file_prefix)
    {
        $folder_name = "/img/$folder/" . date("Ym/d/", time());
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;
        $path = public_path() . $folder_name;

        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }

        $file->move($path, $filename);

        return [
            'path' => $folder_name . $filename
        ];
    }
}