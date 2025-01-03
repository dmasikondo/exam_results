<?php 

use App\Abstract\BaseFileUploadComponent;
use App\Services\CsvUploadService;

new class extends BaseFileUploadComponent
{
    
    protected function getRowDataKeys(): array
    {
        return ['national_id_name', 'department', 'level',  'intake_id'];
    }

    protected function getModelClass(): string
    {
        return App\Models\ClearedStudent::class;
    }


};?>

<div>
    <div class="flex flex-wrap px-4 py-6 text-blue-400 border-t">

        <div class="w-full lg:w-1/2">
            <div class="relative my-4 ml-40 text-gray-400">
                @if($showRecordsCount)
                    <div class="absolute top-0 left-0 " wire:transition>
                        <p>Uploaded file: <span x-text="$store.fileUpload.originalFileName"></span></p>
                        <p>Total No. of  Records: {{$totalRecords}}</p>
                        <p>No. of Records Uploaded: {{$uploadedRecords}}</p>
                    </div>
                @endif
            </div>
            <x-forms.upload-file formAction="uploadFile"/>

            @if($showRefreshButton)
            <div class="">
                <button type="button" class="inline px-4 py-3 font-bold text-white bg-green-300 rounded-full cursor-pointer hover:bg-green-100 hover:text-green-900" wire:click="enableForm"  @click="$store.fileUpload.originalFileName = '' ">
                    Add Another CSV
                </button>
            </div>
            @endif   
        </div>
        <div class="w-full text-gray-500 lg:w-1/2">
            <div class="my-">
                @livewire('examResults.create-exam-session')
            </div>
            <p><span class="font-extrabold text-orange-500">Important!</span> The .csv file must have <span class="font-bold">four </span>(4) column headings, and these column names included in your data from left to right strictly in the order of:</p>
            <x-list.section class="text-gray-400">National ID No. and Student Name</x-list.section>
            <x-list.section class="text-gray-400">Student's Department</x-list.section>
            <x-list.section class="text-gray-400">Student's level e.g one of NC / ND</x-list.section>
            <x-list.section class="text-gray-400">Intake ID (as guided by the system on this page)</x-list.section>
        </div>

    </div>
</div>
