<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between mx-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Exam Results') }}
            </h2>
            <p class ="text-gray-400.text-sm">
                 for candidate No. - {{$candidateNumber}}
            </p>
        </div>

    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-4 mb-16">
        @livewire('examResults.result-check')
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-4">
                        <livewire:examResults.suppressed/>
                    </div>

                    <P>{{$examResults}}</P>

@if(!$examResults->isEmpty())
<div class="w-1/2 py-2 my-4">
    <p class="flex justify-between sm:space-x-6"><span class="font-bold">CANDIDATE NUMBER:</span><span>{{$leadingResults['candidate_number']}}</span></p>
    <p class="flex justify-between sm:space-x-6"><span class="font-bold">COMMENT:</span><span>{{$leadingResults['comment']}}</span></p>
    <p class="flex justify-between"><span class="font-bold">SURNAME:</span><span>{{$leadingResults['surname']}}</span></p>
    <p class="flex justify-between"><span class="font-bold">FIRST NAMES:</span><span>{{$leadingResults['names']}}</span></p>
    <p class="flex justify-between"><span class="font-bold">INSTITUTION NAME:</span><span>Harare Polytechnic</span></p>
    <p class="flex justify-between"><span class="font-bold">COURSE LEVEL:</span><span>{{$leadingResults['course_code']}}</span></p>
    <p class="flex justify-between"><span class="font-bold">COURSE TITLE:</span><span class="text-red-700">{{$leadingResults['discipline']}}</span></p>
</div>

@foreach($examResults as $intake=>$intakeExamResults)
    <h3 class="my-4">{{$intakeExamResults[0]->intake->title}} Exam Session</h3>

<table class="w-full">
    <thead>

        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">

        <th class="px-4 py-3">PAPER No.</th>
        <th class="px-4 py-3">APPROVED SUBJECT TITLES </th>
        <th class="px-4 py-3">GRADE</th>
        <th class="px-4 py-3">Date</th>
        </tr>
    </thead>

    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">


      @foreach($intakeExamResults as $examResult)
        <tr class="text-gray-700 bg-gray-100 divide-y">
    {{--         <div class="space-y-2 text-4xl opacity-25 text-gray-50 container__watermark" style=" transform: rotate(-45deg); position:absolute; width: 100%; margin: 0 auto; opacity: 0.25;">
    <p>Not for Official Use Not for Official Use</p>
    </div> --}}




            <td class="px-4 py-3 text-sm">{{$examResult->subject}}</td>
            <td class="px-4 py-3 text-sm">{{$examResult->subject_code}}</td>
            <td class="px-4 py-3 text-sm">{{$examResult->grade}}</td>
            <td class="px-4 py-3 text-sm">{{$examResult->exam_session}} </td>

        </tr>
      @endforeach

    </tbody>
</table>
@endforeach
@endif





                </div>
            </div>
        </div>
    </div>
</x-app-layout>
