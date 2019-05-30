<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();

        return response()->json($files, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, File::rules());

        $file = File::uploadAndSave($request);

        return response()->json($file, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::findOrFail($id);

        return response()->json($file, 200);
    }

    /**
     * Download the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $file = File::findOrFail($id);

        $filePath = $file->getFilePath();

        if (!Storage::exists($filePath)) {
            throw new FileNotFoundException();
        }

        return Storage::download($filePath, $file->name);
    }

    /**
     * Return total used storage space.
     *
     * @return \Illuminate\Http\Response
     */
    public function total()
    {
        $total = File::getFormattedTotalUsedSpace();

        return response()->json($total, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = File::findOrFail($id);

        $filePath = $file->getFilePath();

        if (!Storage::exists($filePath)) {
            throw new FileNotFoundException();
        }

        if (Storage::delete($filePath)) {
            $file->delete();
        }

        return response()->json(null, 204);
    }
}
