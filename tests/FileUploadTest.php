<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
            'file' => UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertResponseStatus(201);
    }
}
