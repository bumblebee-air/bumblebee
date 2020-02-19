<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhatsappMessage extends Model
{
    protected $table = 'whatsapp_messages';

    public function audio_transcript(){
        return $this->hasOne(AudioTextTranscript::class, 'message_id', 'id');
    }
}
