<?php

namespace App\Livewire;

use App\Events\AntrianEvent;
use App\Events\CallQueue;
use App\Events\CallQueueEvent;
use App\Jobs\ProcessCallQueueJob;
use App\Models\Counter;
use App\Models\Queue;
use App\Models\Service;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Livewire\Attributes\On; 
use Livewire\Component;

class CallerComponent extends Component
{
    public $services;
    public $service_id;
    public $counters;
    public $counter_id;
    public $counter_jenis;
    public $queues=[];
    public $antrianIndex=0;
    public $antrian_sekarang;
    public $antrian_dipanggil=0;
    public $antrian_sisa=0;
    public $antrian_dilewati=0;
    public $jumlahAntrian=0;
    public $progress=0;
    public $habisAntrian=false;
    public $pendingCallBack=false;
    public $audioFiles = [
        'audio/bell.wav',
    ];
    public $currentAudioIndex = 0;

    public $modalConfirm=false;


    public function mount(){
        $this->services=Service::where('is_active',1)->get();
        $this->counters=Counter::all();

    }
    public function play()
    {
        $audio1='audio/bell.wav';
        $audio2='audio/nomor_antrian.wav';
        $initial=Str::substr($this->antrian_sekarang,0,1);
        $audio3='audio/'.$initial.'.wav';
        $initial2=Str::substr($this->antrian_sekarang,1);
        $audio4='audio/'.$initial2.'.wav';
        $audio5='audio/silahkan-menuju.wav';
        $audio6='audio/'.$this->counter_jenis.'.wav';
        $audio7='audio/'.$this->counter_id.'.wav';
        $ct=Counter::find($this->counter_id);

        $this->audioFiles=[$audio1,$audio2,$audio3,$audio4,$audio5,$audio6,$audio7];
        ProcessCallQueueJob::dispatch($this->antrian_sekarang,$this->audioFiles,$this->counter_jenis.' '.$ct->name); //send data to Jobs
    }

    public function nextAudio()
    {
        if ($this->currentAudioIndex < count($this->audioFiles) - 1) {
            $this->currentAudioIndex++;
            $this->dispatch('play-audio', ['index' => $this->currentAudioIndex]);
        }else{
            $this->currentAudioIndex=0;
        }
    }

    public function selectService(){
        $this->clear();
        $this->counter_jenis=Counter::find($this->counter_id)->jenis;

        $data1=Queue::where('service_id',$this->service_id)
        ->whereDate('created_at',now()->format('Y-m-d'))
        ->orderBy('id','asc')->count();
        $this->jumlahAntrian=$data1;

        $data2=Queue::where('service_id',$this->service_id)
        ->whereDate('created_at',now()->format('Y-m-d'))
        ->where('status','telah dilayani')
        ->orderBy('id','asc')->count();
        $this->antrian_dipanggil=$data2;

        $data3=Queue::where('service_id',$this->service_id)
        ->whereDate('created_at',now()->format('Y-m-d'))
        ->where('status','pending')
        ->orderBy('id','asc')->count();
        $this->antrian_dilewati=$data3;

        $this->progress();

        $data4=Queue::where('service_id',$this->service_id)
        ->whereDate('created_at',now()->format('Y-m-d'))
        ->where('status','belum dilayani')
        ->orderBy('id','asc');
        $this->queues=$data4->get();
        $this->antrian_sisa=$data4->count();
        if($this->antrian_sisa > 0){
            $this->antrian_sekarang=$this->queues[$this->antrianIndex]->queue;
        }elseif($this->jumlahAntrian==0){
            session()->flash('error','Belum ada antrian');
        }
        else{
            session()->flash('error','Seluruh Antrian telah dipanggil');
        }

        if($this->antrian_sisa==0 && $this->antrian_dilewati>0){
            $this->pendingCallBack=true;
        }
        // Redis::lpush('audio_queue', json_encode(['antrian'=>$this->antrian_sekarang,'audioFiles'=>$this->audioFiles]));

    }

    public function progress(){
        if($this->jumlahAntrian>0){
            $this->progress=($this->antrian_dipanggil/$this->jumlahAntrian)*100;
        }else{
            $this->progress=0;
        }
    }

    public function nextAntrean(){
        $data=[
            'counter_id' => $this->counter_id,
            'status' => 'telah dilayani',
        ];
        Queue::where('queue',$this->antrian_sekarang)->update($data);

        $this->selectService();

        if($this->antrian_sisa==0 && $this->antrian_dilewati>0){
            $this->pendingCallBack=true;
        }

    }
    public function pendingAntrean(){
        $data=[
            'counter_id' => $this->counter_id,
            'status' => 'pending',
        ];
        Queue::where('queue',$this->antrian_sekarang)->update($data);

        // if($this->antrianIndex < $this->jumlahAntrean){
        //     $this->antrianIndex=$this->antrianIndex+1;
        // }
        $this->selectService();

    }
    public function callBack(){
        $data=[
            'status' => 'belum dilayani',
        ];
        Queue::where('service_id',$this->service_id)
            ->where('status','pending')
            ->update($data);
        $this->pendingCallBack=false;
        $this->selectService();

    }
    public function clear(){
        $this->antrian_sekarang=0;
        $this->antrian_dipanggil=0;
        $this->antrian_sisa=0;
    }
    public function confirmResetQueue(){
        $this->modalConfirm=true;
    }
    public function closeModal(){
        $this->modalConfirm=false;
    }
    public function resetQueue(){
        Queue::whereDate('created_at',now()->format('Y-m-d'))
                ->where('service_id',$this->service_id)
                ->delete();
        $this->modalConfirm=false;
        $this->selectService();
    }
    public function render()
    {
        return view('livewire.caller-component');
    }
}
