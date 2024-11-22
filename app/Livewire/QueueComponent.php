<?php

namespace App\Livewire;

use App\Models\App;
use App\Models\Queue;
use App\Models\Service;
use Illuminate\Support\Str;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;

class QueueComponent extends Component
{
    public $services=[];
    public $app;
    public function mount(){
        $this->services=Service::addSelect(['jumlah' => Queue::selectRaw('count(id)')
                                            ->whereColumn('service_id', 'services.id')
                                            ->whereDay('created_at',date('d'))
                                            ->whereMonth('created_at',date('m'))
                                            ->whereYear('created_at',date('Y'))
                                            ->limit(1)
                                            ])
        ->where('is_active',1)
        ->get();
        $this->app=App::first();
    }
    public function addQueue($id){
        $service=Service::find($id);
        $lastQueue=Queue::where('service_id',$id)
                        ->whereDay('created_at',date('d'))
                        ->whereMonth('created_at',date('m'))
                        ->whereYear('created_at',date('Y'))
                        ->latest()->first();
        if(!$lastQueue){
            $urutan=1;
        }else{
            $urutan=Str::of($lastQueue->queue)->substr(1)->value()+1;
            // $urutan=(int)$urutan_+1;
        }
        $queue=$service->initial.$urutan;
        Queue::create(['queue' => $queue,'service_id' => $service->id]);
        $this->services=Service::addSelect(['jumlah' => Queue::selectRaw('count(1)')
                                            ->whereColumn('service_id', 'services.id')
                                            ->whereDay('created_at',date('d'))
                                            ->whereMonth('created_at',date('m'))
                                            ->whereYear('created_at',date('Y'))
                                            ->limit(1)
                                            ])
        ->where('is_active',1)
        ->get();
        if($this->app->use_printer){
            if($this->app->printer_name != null && $this->app->computer_name != null){
                $x=$this->print($queue,$service->name);
                if(!$x){
                    session()->flash('error', 'Gagal terhubung ke printer');
                }
            }
            session()->flash('error', 'Cetak Nomor Antrian Gagal karena Printer Belum disetting');
        }
        session()->flash('error', 'Cetak Nomor Antrian Gagal karena Printer Belum disetting');

    }
    public function print($no,$layanan){
        $app=App::find(1);
        $profile = CapabilityProfile::load("default");
        $connector = new WindowsPrintConnector("smb://".$app->computer_name."/".$app->printer_name);
        $printer = new Printer($connector, $profile);

        $printer -> setPrintLeftMargin(1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer -> setTextSize(2,1);
        $printer -> setEmphasis(true);
        $printer -> text($app->institution."\n");
        $printer -> setEmphasis(false);
        $printer -> setTextSize(1, 1);
        $printer -> text($app->description);
        $printer -> feed(2);
        $printer -> setTextSize(2, 2);
        $printer -> text("NOMOR ANTRIAN\n");
        $printer ->feed();
        $printer -> setTextSize(3, 3);
        $printer ->setEmphasis(true);
        $printer ->text($no);
        $printer ->setEmphasis(false);
        $printer ->feed(2);
        $printer -> setTextSize(2, 2);
        $printer ->setEmphasis(true);
        $printer ->text($layanan);
        $printer ->setEmphasis(false);
        $printer ->feed(2);
        $printer -> setTextSize(2, 1);
        $printer ->text(now()->format('d/m/Y H:i'));
        $printer ->feed(2);

        $printer -> cut();
        $printer -> close();
    }
    public function render()
    {
        return view('livewire.queue-component');
    }
}
