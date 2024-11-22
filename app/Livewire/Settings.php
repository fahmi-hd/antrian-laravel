<?php

namespace App\Livewire;

use App\Models\App;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public $appName;
    public $video;
    public $videoPath;
    public $banner;
    public $bannerPath;
    public $description;
    public $institution;
    public $printerName;
    public $computerName;
    public $logo;
    public $logoPath;
    public $audio_online;
    public $use_printer;
    public $listPrinter;
    
    public function mount(){
        $app=App::first();
        $this->appName = $app->name;
        $this->videoPath = $app->video;
        $this->bannerPath = $app->banner;
        $this->description = $app->description;
        $this->institution = $app->institution; 
        $this->computerName = $app->computer_name;
        $this->printerName = $app->printer_name;
        // $this->logo = $app->logo;
        $this->logoPath = $app->logo;
        $this->use_printer = $app->use_printer;
        $this->audio_online = $app->audio_online;
        $printers = shell_exec("wmic printer get name");
        $printersArray = explode("\n", $printers);
        $printersArray = array_filter($printersArray); // Menghapus elemen kosong
        $printersArray = array_map('trim', $printersArray); // Menghapus spasi di awal dan akhir
        $x=[0];
        foreach($printersArray as $key => $n){
            if (array_key_exists($key,$x)){
                unset($printersArray[$key]);
            }
        }
        $this->listPrinter=$printersArray;
        $this->computerName=gethostname();
    }
    public function update(){
        ini_set('memory_limit', '512M');
        ini_set('upload_max_filesize','100M');
        ini_set('post_max_size','100M');
        $app=App::first();
        if($this->video!=null){
            $newVideo=$this->video->storePublicly(path:'video');
        }else{
            $newVideo=$app->video;
        }
        if($this->banner !=null){
            $newBanner=$this->banner->storePublicly(path:'images');
        }else{
            $newBanner=$app->banner;
        }
        if($this->logo !=null){
            $newLogo=$this->logo->storePublicly(path:'images');
        }else{
            $newLogo=$app->logo;
        }
        $update=App::where('id',$app->id)
                    ->update([
                        'name'=>$this->appName,
                        'institution' => $this->institution,
                        'description' => $this->description,
                        'printer_name' => $this->printerName,
                        'computer_name' => $this->computerName,
                        'use_printer' => $this->use_printer,
                        'audio_online' => $this->audio_online,
                        'video' => $newVideo,
                        'banner' => $newBanner,
                        'logo' => $newLogo,
                    ]);
        $app=App::first();
        $this->appName = $app->name;
        $this->videoPath = $app->video;
        $this->bannerPath = $app->banner;
        $this->description = $app->description;
        $this->institution = $app->institution; 
        $this->computerName = $app->computer_name;
        $this->printerName = $app->printer_name;
        $this->logoPath = $app->logo;
        $this->use_printer = $app->use_printer;
        $this->audio_online = $app->audio_online;
        if($update){
            session()->flash('success', 'Sukses Menambahkan data');
        }else{
            session()->flash('error', 'Gagal Menambahkan data');
        }

    }
    public function render()
    {
        return view('livewire.settings');
    }
}
