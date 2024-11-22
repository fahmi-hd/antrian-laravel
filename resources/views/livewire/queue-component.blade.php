<div>
    <div class="row">
        <div class="col-12">
            @session('error')
            <div class="alert alert-danger" role="alert">
                <div class="d-flex gap-4">
                  <span><i class="fa-solid fa-circle-exclamation icon-danger"></i></span>
                  <div>
                      {{ session('error') }}
                  </div>
                </div>
            </div>
            @endsession
        </div>
    </div>
    <div class="row justify-content-md-center">
        @php
            $jumlah=$services->count();
            if($jumlah<=4){
                $class="col-lg-6";
            }elseif ($jumlah>4) {
                $class="col-lg-4";
            }elseif ($jumlah>6) {
                $class="col-lg-3";
            }else{
                $class="col";
            }
        @endphp
        @foreach ($services as $service)
        <div class="{{ $class }}">
            <button wire:click="addQueue({{ $service->id }})" wire:transition class="border-0 w-100 ">
                <div class="card text-bg-{{ $service->color }} mb-3 border-0 shadow-md" style="min-height: 250px;">
                    <div class="card-header"><h4>{{ $service->initial.' - '.$service->jumlah }}</h4></div>
                    <div class="card-body">
                      <h2 class="card-title">{{ $service->name }}</h2>
                      <p class="card-text fw-bold">{!! $service->description !!}</p>
                      <div wire:loading wire:target="addQueue({{ $service->id }})"> 
                        <i class="fa fa-spinner" aria-hidden="true"></i>
                    </div>
                    </div>
                  </div>
            </button>
        </div>
        @endforeach
    </div>
</div>
