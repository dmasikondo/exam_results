@if(isset($examResults))
  @if(!$examResults->isEmpty())
    <div class="w-3/4 py-2 my-4">
        <p class="flex justify-between sm:space-x-6"><span class="font-bold">CANDIDATE NUMBER:</span><span>{{$leadingResults['candidate_number']}}</span></p>
        <p class="flex justify-between sm:space-x-6"><span class="font-bold">COMMENT:</span><span>{{$leadingResults['comment']}}</span></p>
        <p class="flex justify-between"><span class="font-bold">SURNAME:</span><span>{{$leadingResults['surname']}}</span></p>
        <p class="flex justify-between"><span class="font-bold">FIRST NAMES:</span><span>{{$leadingResults['names']}}</span></p>
        <p class="flex justify-between"><span class="font-bold">INSTITUTION NAME:</span>
            <span>Harare Polytechnic</span> {{$leadingResults['is_btec'] ? 'in collaboration with N.U.S.T' : ''}}
        </p>
        <p class="flex justify-between"><span class="font-bold">
            {{$leadingResults['is_btec']? 'PROGRAMME': 'COURSE'}} LEVEL:
            </span><span>{{$leadingResults['course_code']}}</span>
        </p>
        <p class="flex justify-between">
            <span class="font-bold">
                {{$leadingResults['is_btec']? 'PROGRAMME': 'COURSE'}} TITLE:
            </span>
         @if($leadingResults['is_btec'])
            <span class="text-red-700">{{strtoupper($leadingResults['programme'])}}</span>
        @else
            <span class="text-red-700">{{$leadingResults['discipline']}}</span>
        @endif
        </p>
    </div>

    @foreach($examResults as $intake=>$intakeExamResults)
        <h3 class="my-4">
            <x-list.section class="text-gray-400">{{$intakeExamResults[0]->intake->title}} Exam Session</x-list.section>


        </h3>

    <table class="w-full">
        <thead>

            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">

            <th class="px-4 py-3">PAPER No./ COURSE CODE</th>
            <th class="px-4 py-3">APPROVED SUBJECT / COURSE TITLES </th>
            <th class="px-4 py-3">GRADE</th>
            <th class="px-4 py-3">Date</th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

        @foreach($intakeExamResults as $examResult)
            <tr class="text-gray-700 bg-gray-100 divide-y">

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
@endif
