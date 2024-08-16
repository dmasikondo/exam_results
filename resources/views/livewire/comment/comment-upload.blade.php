<div>
    <div class="flex items-center justify-center bg-gray-200 rounded-lg">

        <div class="w-full overflow-x-auto bg-white rounded-xl"
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <div class="flex items-center justify-between px-5 py-3 text-blue-400 border-b">

                <p class="inline px-4 py-3 font-bold rounded-full hover:bg-indigo-100">
                    @if($isFromStudent)
                        Send Payment Proof
                    @else
                        You may message the student if necessary
                    @endif
                </p>
            </div>
            <div class="my-1">
            <x-session-message/>
            </div>

            <form wire:submit="uploadFile">
                <div class="flex p-4 rounded-lg">
                    <div class="flex items-center justify-center w-8 h-8 mb-2 bg-blue-100 rounded-full">
                        <span class="text-sm font-semibold">
                            {{ auth()->user()->userAvatar() }}
                        </span>
                    </div>

                <div class="flex flex-col w-full ml-3">
                    <textarea placeholder="Put in a brief comment" class="w-full h-32 text-xl outline-none resize-none"wire:model="comment"></textarea>
                    <p wire:loading.remove>
                        @error('comment')
                            <span class="text-sm italic text-red-500">{{ $message }}</span>
                        @enderror
                    </p>
                    <div class="mt-4 -ml-4 text-indigo-400">
                    <p class="inline px-4 py-3 rounded-full hover:bg-indigo-100">
                        File should be in pdf or picture format</p>
                    </div>
                </div>
                </div>

                <div class="flex items-center justify-between px-4 py-6 text-indigo-400 border-t">

                    {{-- file input and submit --}}
                    <div x-data="{fileSelected: true}" x-on:livewire-upload-finish="fileSelected = true" class="pb-4 space-y-4 border-b-4">
                        <input id="upload"  type="file" wire:model="fileName" accept="image/*,.pdf" {{-- wire:click="clearErrors" --}}
                        class="text-xs"/>
                        <p wire:loading.remove>
                            @error('fileName')
                                <span class="text-sm italic text-red-500">{{ $message }}</span>
                            @enderror
                        </p>
                    <div x-show="isUploading" style="display: none;">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>

                <div>
                    <button type="submit" class="inline px-4 py-3 font-bold text-white bg-indigo-300 rounded-full cursor-pointer hover:bg-gray-200" wire:click="uploadFile">
                    @if($isFromStudent)
                        Send Payment Proof
                    @else
                        Send message
                    @endif
                    </button>
                    <div>
                        <span wire:loading wire:target="uploadFile">
                            Processing ...
                        </span>
                    </div>

                </div>
                </div>
            </form>
        </div>
    </div>
</div>
