<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Str;

class ServiceComponent extends Component
{
    public $name;
    public $description;
    public $initial;
    public $editInitial;
    public $services;
    public $isActive;
    public $color;
    public $id;
    public $submitType="save";
    public $deleteConfirm="no";

    public function mount(){
        $this->services=Service::all();
    }
    public function save(){
        $validated = $this->validate([ 
            'initial' => 'unique:services',
        ]);
        $data=[
            'name' => Str::upper($this->name),
            'description' => $this->description,
            'initial' => Str::upper($this->initial),
            'is_active' => $this->isActive,
            'color' => $this->color
        ];
        $save=Service::create($data);
        if($save){
            session()->flash('success', 'Sukses Menambahkan data');
        }else{
            session()->flash('error', 'Gagal Menambahkan data');
        }
        $this->services=Service::all();
        $this->clearForm();
    }
    public function edit($id){
        $service=Service::find($id);
        $this->id=$service->id;
        $this->name=$service->name;
        $this->description=$service->description;
        $this->initial=$service->initial;
        $this->editInitial=$service->initial;
        $this->isActive=$service->is_active;
        $this->color=$service->color;
        $this->submitType="update";

    }
    public function update(){
        if($this->initial != $this->editInitial){
            $validated = $this->validate([ 
                'initial' => 'unique:services',
            ]);
        }
        $data=[
            'name' => Str::upper($this->name),
            'description' => $this->description,
            'initial' => Str::upper($this->initial),
            'is_active' => $this->isActive,
            'color' => $this->color
        ];
        $update=Service::where('id',$this->id)
                ->update($data);
        if($update){
            session()->flash('success', 'Sukses Mengubah data');
        }else{
            session()->flash('error', 'Gagal Mengubah data');
        }
        $this->services=Service::all();
        $this->clearForm();
        $this->submitType="save";
    }
    public function confirmDelete($id){
        $this->id=$id;
        $this->deleteConfirm="yes";
    }
    public function delete(){
        $delete=Service::where('id',$this->id)->delete();
        if($delete){
            session()->flash('success', '1 data berhasil dihapus');
        }else{
            session()->flash('error', 'Gagal Menghapus data');
        }
        $this->services=Service::all();
        $this->id="";
        $this->deleteConfirm="no";
    }
    public function cancelDelete(){
        $this->id="";
        $this->deleteConfirm="no";
    }
    public function clearForm(){
        $this->id="";
        $this->name="";
        $this->description="";
        $this->initial="";
        $this->isActive="";
        $this->color="";
    }
    public function render()
    {
        return view('livewire.service-component');
    }
}
