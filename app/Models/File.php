<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type', 'size'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'file' => 'required|file'
        ];
    }

    /**
     * Upload the file and save metadata to database.
     *
     * @return array
     */
    public static function uploadAndSave($request)
    {
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $type = $file->getClientOriginalExtension();
        $size = $file->getClientSize();

        if ($file->isValid()) {
            $file->move('media', $name);

            return self::create([
                'name' => $name,
                'type' => $type,
                'size' => $size,
            ]);
        }
    }
}
