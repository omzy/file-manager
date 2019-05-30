<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\File;

class FileUploadTest extends TestCase
{
    /**
     * File upload test.
     *
     * @return void
     */
    public function testFileUpload()
    {
        Storage::fake('public');

        $response = $this->call('POST', '/api/files', [], [], [
            'file' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        // assert the generated filename matches the database entry
        $this->assertEquals($file->hashName(), File::latest()->first()->name);

        // assert the response status code
        $this->assertResponseStatus(201);
    }
}
