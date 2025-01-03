<?php

namespace App\Abstract;

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Services\CsvUploadService;
use Illuminate\Support\Str;

abstract class BaseFileUploadComponent extends Component
{
    use WithFileUploads;

    #[Validate('required|file|mimes:csv,txt')]
    public $file;


    public $totalRecords, $uploadedRecords;
    public $showRecordsCount = false;
    public $showRefreshButton = false;

    abstract protected function getRowDataKeys(): array;
    abstract protected function getModelClass(): string;

    public function uploadFile(CsvUploadService $csvUploadService)
    {
        if ($this->file) {
           $this->storeFile();
        }        
       
        $uploadResult = $csvUploadService->processCSVFile($this->file, $this->getRowDataKeys(), $this->getModelClass());

        $this->handleUploadResult($uploadResult);
    }

    private function storeFile()
    {
        $extension = $this->file->extension();
        $url = Str::slug($this->file->getClientOriginalName() . uniqid()) . '.' . $extension;
        $this->file = $this->file->storePubliclyAs('uploaded-files', $url);
    }

    private function handleUploadResult($uploadResult)
    {
        $this->showRecordsCount = true;
        $this->totalRecords = $uploadResult['totalRecordsCount'];
        $this->uploadedRecords = $uploadResult['uploadedRecordsCount'];

        if ($uploadResult['errorMessage']) {
            $this->addError('file', $uploadResult['errorMessage']);
            $this->disableForm();
        } else {
            $this->dispatch('file-uploaded');
            $this->file = '';
            $this->disableForm();
        }
    }

    public function hideRecordsCount()
    {
        $this->showRecordsCount = false;
        $this->showRefreshButton = false;
    }

    public function disableForm()
    {
        $this->showRefreshButton = true;
    }

    public function enableForm()
    {
        $this->reset();
        $this->showRefreshButton = false;
    }

    public function resetForm()
    {
        $this->reset();
    }
}