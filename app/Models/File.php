<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    use softDeletes;

    protected $guarded = [];

    /**
     * polymophic commenting relationship (to optionally include text body and files)
     */
    public function fileable()
    {
        return $this->morphTo();
    }

    // public function replies()
    // {
    //     return $this->hasMany(Comment::class,'reply_id','id');
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function getFileTypeAttribute()
    {
        $ext  = pathinfo($this->url, PATHINFO_EXTENSION);

        switch($ext)
        {
            case 'mp4':
            $type='mp4 video';
            break;
            case 'mp3':
            $type='mp3 audio';
            break;
            case 'm4a':
            $type='m4a audio';
            break;
            case 'amr':
            $type='amr audio';
            break;
            case 'aac':
            $type='aac audio';
            break;
            case 'amr':
            $type='amr audio';
            break;
            case 'mov':
            $type='mov video';
            break;
            case 'ogg':
            $type='ogg video';
            break;
            case 'pdf':
            $type='pdf';
            break;
            case 'doc':
            $type='doc word';
            break;
            case 'docx':
            $type='docx word';
            break;
            case 'xlsx':
            $type='xlsx excel';
            break;
            case 'jpg':
            $type='jpg image';
            break;
            case 'jpeg':
            $type='jpeg image';
            break;
            case 'gif image':
            $type='gif image';
            break;
            case 'png':
            $type='png image';
            break;
            default:
            $type='image';
        }

        return $type;
    }

    public function isImage()
    {
        //$ext  = pathinfo($this->url, PATHINFO_EXTENSION);
        if($this->checkExtension()=='png' || $this->checkExtension()=='bmp' ||$this->checkExtension()=='jpg' || $this->checkExtension()=='jpeg' || $this->checkExtension()=='gif')
        {
            return true;
        }
    }

    public function isVideo()
    {
        //$ext  = pathinfo($this->url, PATHINFO_EXTENSION);
        if($this->checkExtension()=='mp4' || $this->checkExtension()=='mov' ||$this->checkExtension()=='ogg')
        {
            return true;
        }
    }

    public function isAudio()
    {
        //$ext  = pathinfo($this->url, PATHINFO_EXTENSION);
        if($this->checkExtension()=='mp3' || $this->checkExtension()=='m4a' || $this->checkExtension()=='opus' ||$this->checkExtension()=='amr'
            || $this->checkExtension()=='aac')
        {
            return true;
        }
    }

    protected function checkExtension()
    {
        $ext  = pathinfo($this->url, PATHINFO_EXTENSION);
        return $ext;
    }

}
