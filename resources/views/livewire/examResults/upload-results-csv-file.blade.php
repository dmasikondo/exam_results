<?php 

use App\Abstract\BaseFileUploadComponent;
use App\Services\CsvUploadService;

new class extends BaseFileUploadComponent
{
    
    protected function getRowDataKeys(): array
    {
        return ['discipline', 'course_code', 'candidate_number', 'surname', 'names', 'subject_code', 'subject', 'grade', 'exam_session', 'comment', 'intake_id','is_btec','programme'];
    }

    protected function getModelClass(): string
    {
        return App\Models\Result::class;
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
            <div class="my-4">
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
