<?php

use App\Livewire\CallerComponent;
use App\Livewire\CounterComponent;
use App\Livewire\DisplayQueue;
use App\Livewire\Home;
use App\Livewire\QueueComponent;
use App\Livewire\ServiceComponent;
use App\Livewire\Settings;
use App\Livewire\TextToSpeech;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',Home::class)->name('home');

Route::get('/layanan',ServiceComponent::class)->name('layanan');
Route::get('/loket',CounterComponent::class)->name('loket');
Route::get('/tiket',QueueComponent::class)->name('tiket');
Route::get('/caller',CallerComponent::class)->name('caller');
Route::get('/display',DisplayQueue::class)->name('display');
Route::get('/appsetting',Settings::class)->name('appsetting');