<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Services\CsvUploadService;

new class extends Component {

    use WithFileUploads;


    #[Validate('required|file|mimes:csv,txt')]
    public $file;

    public $url;
    public $totalRecords;
    public $uploadedRecords;
    public $showRecordsCount = false;
    public $showRefreshButton = false;
    public $intakeId;
    public $intakeTitle;

    public function uploadFile(CsvUploadService $csvUploadService)
    {
        $rowDataKeys = ['discipline', 'course_code', 'candidate_number', 'surname', 'names', 'subject_code', 'subject', 'grade', 'exam_session', 'comment', 'intake_id'];

        $modelClass = \App\Models\Result::class;

        if($this->file){
            $extension = $this->file->extension();
            $this->url = Str::slug($this->file->getClientOriginalName() . uniqid()) . '.' . $extension;
            $this->file = $this->file->storePubliclyAs(path:'uploaded-files', name: $this->url);

        }

        $uploadResult = $csvUploadService->processCSVFile($this->file, $rowDataKeys, $modelClass);

            $this->showRecordsCount = true;
            $this->totalRecords = $uploadResult['totalRecordsCount'];
            $this->uploadedRecords = $uploadResult['uploadedRecordsCount'];

        if($uploadResult['errorMessage']) {
           // $this->addError('file', $uploadResult['errorMessage']);
           $this->addError('file', 'An error occurred during file upload');
            $this->disableForm();
        }
        else {
            $this->disableForm();
            $this->dispatch('file-uploaded');
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

}; ?>

<div>
    <div class="flex flex-wrap px-4 py-6 text-blue-400 border-t">

        <div class="w-full lg:w-1/2">
            <div class="relative my-4 ml-40">
                @if($showRecordsCount)
                    <div class="absolute top-0 left-0 " wire:transition>
                        <p>Total No. of File Records: {{$totalRecords}}</p>
                        <p>Total No. of File Records Uploaded: {{$uploadedRecords}}</p>
                    </div>
                @endif
            </div>
            <form wire:submit="uploadFile">
                <div
                    x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                >

                    <div class="p-4 my-8 border border-indigo-500 rounded-md shadow-md bg-gray-50 w-36">
                        <label for="upload" class="flex flex-col items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 fill-white stroke-indigo-500" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-medium text-gray-600">Upload CSV File</span>
                        <span class="text-sm"> (max 2MB)</span>
                        </label>
                        <input id="upload" type="file" class="hidden" wire:model="file" accept=".csv, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" wire:click='hideRecordsCount' required @if ($showRefreshButton) disabled @endif>
                    </div>
                    <p>{{$file}}</p>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />

                    <div x-show="uploading" style="display: none;">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="inline px-4 py-3 font-bold text-white bg-blue-300 rounded-full cursor-pointer hover:bg-blue-100 hover:text-blue-900" @if ($showRefreshButton) disabled @endif>
                        Save File
                    </button>
                    <x-action-message class="text-green-500 me-3" on="file-uploaded">
                        {{ __('CSV File Uploaded Successfully') }}
                    </x-action-message>
                    <div>
                        <span wire:loading>
                            Processing ...
                    </span>

                    <button type="reset" wire:click='resetForm'>Cancel

                    </button>
                    </div>
                @if($showRefreshButton)
                    <div class="">
                        <button type="button" class="inline px-4 py-3 font-bold text-white bg-green-300 rounded-full cursor-pointer hover:bg-green-100 hover:text-green-900" wire:click="enableForm" >
                            Add Another CSV
                        </button>
                    </div>
                @endif
                </div>

            </form>
        </div>
        <div class="w-full text-gray-500 lg:w-1/2">
            <p class="inline px-4 py-3 font-bold text-gray-400 rounded-full">
                Upload a .csv file with results to the database <small>(size must be less than 2MB)</small>
            </p>
            <div class="my-">
                @livewire('examResults.create-exam-session')
            </div>
            <p><span class="font-extrabold text-orange-500">Important!</span> The .csv file must have <span class="font-bold">thirteen </span>(13) column headings, and these column names included in your data from left to right strictly in the order of:</p>
            <x-list.section class="text-gray-400">Discipline e.g Biological Sciences</x-list.section>
            <x-list.section class="text-gray-400">Course Code or Programme Code</x-list.section>
            <x-list.section class="text-gray-400">Candidate Number</x-list.section>
            <x-list.section class="text-gray-400">Candidate's Surname</x-list.section>
            <x-list.section class="text-gray-400">Candidate's Names</x-list.section>
            <x-list.section class="text-gray-400">Subject / Module Code</x-list.section>
            <x-list.section class="text-gray-400">Subject / Module Title</x-list.section>
            <x-list.section class="text-gray-400">Candidate's Grade for that module/ subject</x-list.section>
            <x-list.section class="text-gray-400">Exam Session e.g 06/2024</x-list.section>
            <x-list.section class="text-gray-400">Commennt e.g. Pass / Deferred</x-list.section>
            <x-list.section class="text-gray-400">Intake ID (as guided by the system on this page)</x-list.section>
            <x-list.section class="text-gray-400">Is BTech? (1 for yes or 0 for no)</x-list.section>
            <x-list.section class="text-gray-400">Course / Programme Title</x-list.section>
        </div>

    </div>
</div>
