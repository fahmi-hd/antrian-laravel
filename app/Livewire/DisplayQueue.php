<?php

namespace App\Livewire;

use App\Models\App;
use App\Models\Queue;
use App\Models\Service;
use Livewire\Attributes\On; 
use Livewire\Component;

class DisplayQueue extends Component
{

    public $antrianBroad = null;
    public $status=null;
    public $queues=[];
    public $audioFiles = ['audio/bell.wav']; // Contoh array audio
    public $currentAudioIndex = 0;
    public $playNext = false;
    public $pendingQueue = []; // Menyimpan antrian yang ditunda
    public $app;
    public $counter;
    public $audio_online;
    public $messages=[];

    public function mount(){
        $this->queues=Service::where('is_active',1)
                             ->get();
        $this->app=App::find(1);
    }

    #[On('echo:call-queue,CallQueueEvent')]
    public function listenForMessage($data)
    {
        // Jika tidak ada antrian yang sedang diputar
            if ($this->status == null) {
                $this->status="ada";
                $this->antrianBroad = $data["antrian"];
                $this->audioFiles = $data["audio"];
                $this->counter=$data["counter"];
                //jika fitur audio online diaktifkan maka akan di dispatch ke tts event
                if($this->app->audio_online){
                    $this->audio_online="Nomor antrian ".$data["antrian"].", silahkan menuju ".$data["counter"];
                    $this->dispatch('tts',['text' => $this->audio_online]);
                }else{
                    $this->dispatch('play-audio', ['index' => $this->currentAudioIndex]);
                }
            } else {
                // Jika ada antrian yang sedang diputar, tambahkan ke antrian yang ditunda
                $this->pendingQueue[] = $data;
            }
        // }

    }

    public function nextAudio()
    {
        //jika fitur audio online diaktifkan
        if($this->app->audio_online){
            if (!empty($this->pendingQueue)) {
                $next = array_shift($this->pendingQueue); // Ambil antrian berikutnya
                $this->antrianBroad = $next["antrian"];
                $this->audioFiles = $next["audio"];
                $this->counter=$next["counter"];
                $this->audio_online="Nomor antrian ".$next["antrian"].", silahkan menuju ".$next["counter"];
                $this->dispatch('tts',['text' => $this->audio_online]);
            } else {
                // Tidak ada antrian yang ditunda, hentikan pemutaran
                $this->status=null;
                $this->dispatch('stop-audio'); // Dispatch event untuk menghentikan audio
                return $this->blank(); // Keluar dari metode
            }
        }else{
            //jika fitur audio online nonaktif maka akan memutar audio offline
            if ($this->currentAudioIndex < count($this->audioFiles) - 1) {
                $this->currentAudioIndex++;
                if(!$this->app->audio_online){}
                $this->dispatch('play-audio', [
                    'url' => asset($this->audioFiles[$this->currentAudioIndex]),
                ]);
            } else {
                // Reset index jika semua audio sudah diputar
                $this->currentAudioIndex = 0;
        
                // Cek apakah ada antrian yang ditunda
                if (!empty($this->pendingQueue)) {
                    $next = array_shift($this->pendingQueue); // Ambil antrian berikutnya
                    $this->antrianBroad = $next["antrian"];
                    $this->audioFiles = $next["audio"];
                    $this->counter=$next["counter"];
                    $this->dispatch('play-audio', [
                            'url' => asset($this->audioFiles[$this->currentAudioIndex]),
                        ]);
                    
                } else {
                    // Tidak ada antrian yang ditunda, hentikan pemutaran
                    $this->status=null;
                    $this->dispatch('stop-audio'); // Dispatch event untuk menghentikan audio
                    return $this->blank(); // Keluar dari metode
                }
        }
        }
    
        // Dispatch event dengan URL audio

    }
    function blank(){
        
    }

    public function render()
    {

        return view('livewire.display-queue');
    }
}
