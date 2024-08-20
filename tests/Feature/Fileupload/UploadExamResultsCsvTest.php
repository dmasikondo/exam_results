<?php

namespace Tests\Feature\Fileupload;

use App\Services\CsvUploadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Volt\Volt;
use Tests\TestCase;

class UploadExamResultsCsvTest extends TestCase
{
    use WithFileUploads;
    public $file;

    public function test_can_upload_csv_file_for_exam_results()
    {



    //    Storage::fake('public/uploaded-files');

    //     $file = UploadedFile::fake()->create('results.csv');

    //     Volt::test('examResults.upload-results-csv-file')
    //         ->set('file', $file)
    //         ->call('uploadFile', 'results.csv')
    //         ->assertSee('CSV File Uploaded Successfully');

        //Storage::disk('public/uploaded-files')->assertExists('uploaded-avatar.png');




    }
}
