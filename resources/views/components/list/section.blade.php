<div>
    <li {{ $attributes->merge(['class'=>"py-3.5 w-full flex items-center text-blue-500 hover:text-blue-700 hover:bg-blue-50"])}}>
            <span class="ml-5 mr-2.5 w-1 h-7 bg-blue-500 rounded-r-md"></span>
            {{$slot}}
    </li>

</div>
