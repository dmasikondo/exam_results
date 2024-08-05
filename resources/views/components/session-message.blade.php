<div>
  <!-- session message -->
  @if(session()->has('message'))
    <div class="flex items-center justify-center px-2 py-1 m-1 font-medium text-green-700 bg-white bg-green-100 border border-green-300 rounded-md "  x-data="{ show: true }" x-show="show" x-init="setTimeout(()=>show=false, 10000)">
            <div slot="avatar" class="mr-2">
                <x-icon name="check-circle" class="w-4 h-4 mr-2 space-x-2"/>
            </div>
            <div class="flex-initial max-w-full text-sm font-normal">
                {{session('message')}}
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
