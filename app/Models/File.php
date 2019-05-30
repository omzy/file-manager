<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
     * Return the storage file path.
     *
     * @return string
     */
    public function getFilePath()
    {
        return 'media/' . $this->name;
    }

    /**
     * Return total used storage space.
     *
     * @return string
     */
    public static function getTotalUsedSpace()
    {
        return DB::table('files')->sum('size');
    }

    /**
     * Return formated total used storage space.
     *
     * @return array
     */
    public static function getFormattedTotalUsedSpace()
    {
        $divisor = 1024;

        $bytes = self::getTotalUsedSpace();
        $kilobytes = number_format($bytes / $divisor, 2);
        $megabytes = number_format($kilobytes / $divisor, 2);
        $gigabytes = number_format($megabytes / $divisor, 2);

        return compact('bytes', 'kilobytes', 'megabytes', 'gigabytes');
    }

    /**
     * Upload the file and save metadata to database.
     *
     * @return array
     */
    public static function uploadAndSave($request)
    {
        $file = $request->file('file');

        if ($file->isValid()) {
            if ($file->store('media')) {
                return self::create([
                    'name' => $file->hashName(),
                    'type' => $file->extension(),
                    'size' => $file->getSize(),
                ]);
            }
        }
    }
}
