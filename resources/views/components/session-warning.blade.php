<div>
  <!-- session warning message -->
  @if(session()->has('warning'))
    <div class="flex items-center justify-center px-2 py-1 m-1 font-medium text-red-700 bg-white bg-red-100 border border-red-300 rounded-md "  x-data="{ show: true }" x-show="show" x-init="setTimeout(()=>show=false, 10000)">
            <div slot="avatar" class="mr-2">
                <x-icon name="exclamation" class="w-4 h-4 mr-2 space-x-2"/>
            </div>
            <div class="flex-initial max-w-full text-sm font-normal">
                {{session('warning')}}
            </div>
            <div class="flex flex-row-reverse flex-auto">
                <div @click="show = false">
                    <x-icon name="x" class="w-4 h-4 cursor-pointer"/>
                </div>
            </div>
        </div>
      @endif
  <!-- end of session message -->
</div>
