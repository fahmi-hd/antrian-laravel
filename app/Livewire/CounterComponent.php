<?php

namespace App\Livewire;

use App\Models\Counter;
use Illuminate\Support\Str;
use Livewire\Component;

class CounterComponent extends Component
{
    public $name;
    public $counters;
    public $id;
    public $jenis;
    public $submitType="save";
    public $deleteConfirm="no";
    public $number=[1,2,3,4,5,6,7,8];

    public function mount(){
        $this->counters=Counter::all();
        $this->cekNumber();
        
    }
    public function cekNumber(){
        $finded=Counter::select('name')->get();
        $x=[];
        foreach($finded as $f){
            $x[]=$f->name;
        }
        foreach($this->number as $key => $n){
            if (array_key_exists($key,$x)){
                unset($this->number[$key]);
            }
        }
    }
    public function save(){
        $finded=Counter::select('name')->get();
        $x=[];
        foreach($finded as $f){
            $x[]=$f->name;
        }
        foreach($this->number as $key => $n){
            if (array_key_exists($key,$x)){
                unset($this->number[$key]);
            }
        }
        
        $data=[
            'name' => Str::upper($this->name),
            'jenis' => $this->jenis,
        ];
        $save=Counter::create($data);
        if($save){
            session()->flash('success', 'Sukses Menambahkan loket');
        }else{
            session()->flash('error', 'Gagal Menambahkan loket');
        }
        $this->counters=Counter::all();
        $this->clearForm();
        $this->cekNumber();
    }
    public function edit($id){
        $counter=Counter::find($id);
        $this->id=$counter->id;
        $this->name=$counter->name;
        $this->jenis=$counter->jenis;
        $this->submitType="update";

    }
    public function update(){
        $data=[
            'jenis' => $this->jenis,
        ];
        $update=Counter::where('id',$this->id)
                ->update($data);
        if($update){
            session()->flash('success', 'Sukses Mengubah loket');
        }else{
            session()->flash('error', 'Gagal Menambahkan loket');
        }
        $this->counters=Counter::all();
        $this->clearForm();
        $this->cekNumber();
        $this->submitType="save";
    }
    public function confirmDelete($id){
        $this->id=$id;
        $this->deleteConfirm="yes";
    }
    public function delete(){
        Counter::where('id',$this->id)->delete();
        $this->counters=Counter::all();
        $this->id="";
        $this->deleteConfirm="no";
        $this->cekNumber();
    }
    public function cancelDelete(){
        $this->id="";
        $this->deleteConfirm="no";
    }
    public function cancelUpdate(){
        $this->clearForm();
        $this->cekNumber();
        $this->submitType="save";
    }
    public function clearForm(){
        $this->id="";
        $this->name="";
        $this->jenis="";
    }
    public function render()
    {
        return view('livewire.counter-component');
    }
}
