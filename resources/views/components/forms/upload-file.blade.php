<form wire:submit="{{$formAction}}">

    <div
        x-data="{ uploading: false, progress: 0}"
        x-init="$store.fileUpload = {originalFileName: ''}"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        x-on:change="$store.fileUpload.originalFileName = $event.target.files[0]?.name"
    >
        <div class="p-4 my-8 border border-indigo-500 rounded-md shadow-md bg-gray-50 w-36 hover:bg-">
            <label for="upload" class="flex flex-col items-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 fill-white stroke-indigo-500" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="font-medium text-gray-600">Upload .csv File</span>
                <span class="text-sm"> (max 2MB)</span>
            </label>
            <input id="upload" type="file" class="hidden" wire:model="file" accept=".csv, text/csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" wire:click='hideRecordsCount' required {{-- @if ($showRefreshButton) disabled @endif --}}>
        </div>
        
        <p>
            <span x-text="$store.fileUpload.originalFileName"></span>
        </p>
        
        <x-input-error :messages="$errors->get('file')" class="mt-2" />

        <div x-show="uploading" style="display: none;">
            <progress max="100" x-bind:value="progress"></progress>
        </div>
    

    <div class="flex gap-4">
      <template x-if="progress == 100">
        <div>
            <button type="button" class="inline px-4 py-3 font-bold text-white bg-blue-300 rounded-full cursor-pointer hover:bg-blue-100 hover:text-blue-900" wire:click="{{$formAction}}" @click="progress = 0" {{-- @if ($showRefreshButton) disabled @endif --}}>
                Save File
            </button>
            <x-action-message class="text-green-500 me-3" on="file-uploaded">
                {{ __('CSV File Uploaded Successfully') }}
            </x-action-message>

            <button type="reset" wire:click='resetForm' @click="progress = 0; $store.fileUpload.originalFileName=''">
                Cancel
            </button>
        
            <div wire:loading.delay>
                Processing ...
            </div>

        </div>
      </template>


    </div>
   </div>

</form>