<?php

namespace App\Livewire\Comment;

use App\Models\Fee;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class CommentUpload extends Component
{
    use WithFileUploads;

    public $isFromStudent = false;
    public $possibleNewProofOfPayment = false;
    public $url='';
    public $reply_id;

    #[Locked]
    public $fileableType;

    #[Validate('required|max:1024|mimes:pdf,jpeg,png,jpg,gif', as: 'file', onUpdate: false)]
    public $fileName;

    #[Validate('required|max:1000', message: 'Please provide a brief comment')]
    public $comment;

    public function uploadFile()
    {
        if($this->fileName){
            $extension = $this->fileName->extension();
            $this->url = Str::slug($this->fileName->getClientOriginalName() . uniqid()) . '.' . $extension;
            $this->fileName->storeAs('public/uploaded-files', $this->url);
        }
        $this->validate();
        $this->store();
    }

    private function store()
    {
        $feeId = Fee::where('user_id', auth()->user()->id)->where('is_cleared',false)->latest()->pluck('id')->first();
        $modelInstance =$this->fileableType;
        $model =$modelInstance::findOrFail($feeId);
        $model->files()->create([
        'url' =>$this->url,
        'body' =>$this->comment,
        'user_id' => auth()->user()->id]);

        /**
         * update Fee model if user was declined and is sending a new file
         */
        if($this->possibleNewProofOfPayment)
        {
            if(!is_null($model->clearer_id)){
                $model->update(['clearer_id'=>NULL]);
            }

        }
        $this->resetValidation();
        $this->reset(['fileName','comment','url']);

        //$this->dispatch('updateComments');
        session()->flash('message', 'Your message was successfully sent.');

        if($this->isFromStudent){
            return redirect()->to('/myresults');
        }
    }



    public function render()
    {
        return view('livewire.comment.comment-upload');
    }
}
