<div>
    <div class="row">
        <div class="col">
            <form wire:submit="selectService" class="mb-3">
                <div class="row">
                    <div class="col-lg-4">
                        <select wire:model.live="counter_id" class="form-control mb-2" required>
                            <option value="">- Pilih Loket -</option>
                            @foreach ($counters as $counter)
                                <option value="{{ $counter->name }}">{{ $counter->jenis.' '.$counter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <select wire:model.live="service_id" class="form-control mb-2" required>
                            <option value="">- Pilih Layanan -</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-dark">Pilih</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card w-100 mb-2 border-0 shadow-md">
                <div class="card-body">
                    @if ($service_id != null)
                    <button wire:click="confirmResetQueue" class="btn btn-danger float-end">Reset Antrian</button>
                    @endif
                    <div class="justify-content-center">
                        @if (session('error'))
                        <div class="alert alert-success" role="alert">
                            <div class="d-flex gap-4">
                              <span><i class="fa-solid fa-circle-check icon-success"></i></span>
                              <div class="d-flex flex-column gap-2">
                                <h6 class="mb-0">{{ session('error') }}</h6>
                              </div>
                            </div>
                          </div>                            
                        @endif
                        <h1 class="text-center" style="font-size: 100px">{{ $antrian_sekarang!=null?$antrian_sekarang:'-' }}</h1>
                        <center>
                        <button wire:click="pendingAntrean" class="btn btn-secondary m-3 transition ease-out duration-300" style="
                        --bs-btn-padding-y: 0.75rem; 
                        --bs-btn-padding-x: 1.25rem; 
                        --bs-btn-font-size: 1.5rem;" {{ $antrian_sisa==0 ? 'disabled':'' }}><i class="fa-solid fa-clock-rotate-left"></i> Lewati</button>
                        <button wire:click="play" class="btn btn-discovery m-3 ease-out duration-300" style="
                        --bs-btn-padding-y: 0.75rem; 
                        --bs-btn-padding-x: 1.25rem; 
                        --bs-btn-font-size: 1.5rem;" {{ $antrian_sisa==0 ? 'disabled':'' }}><i class="fa-regular fa-bell"></i> Panggil</button>
                        <button wire:click="nextAntrean" class="btn btn-success m-3 ease-out duration-300" style="
                        --bs-btn-padding-y: 0.75rem; 
                        --bs-btn-padding-x: 1.25rem; 
                        --bs-btn-font-size: 1.5rem;" {{ $antrian_sisa==0 ? 'disabled':'' }}>Selanjutnya >></button>
                        @if ($pendingCallBack)
                        <button wire:click="callBack" class="btn btn-default m-3 ease-out duration-300" style="
                        --bs-btn-padding-y: 0.75rem; 
                        --bs-btn-padding-x: 1.25rem;">Panggil Antrian Pending</button>
                        @endif
                        </center>

                        <div class="progress d-inline-flex w-100">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>  
                        </div>
                        <span class="fs-sm text-muted me-2">{{ $antrian_dipanggil }} of {{ $jumlahAntrian }}</span>

                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mb-2 border-0 mt-3">
                <div class="card-header bg-dark bg-opacity-75 bg-gradient">
                    <h3 class="text-center text-white">Jumlah Antrian</h3>
                </div>
                <div class="card-body">
                    <h1 class="text-center">{{ $jumlahAntrian }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mb-2 border-0 mt-3">
                <div class="card-header bg-success bg-opacity-75 bg-gradient">
                    <h3 class="text-center text-white">Dilayani</h3>
                </div>
                <div class="card-body">
                    <h1 class="text-center">{{ $antrian_dipanggil }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mb-2 border-0 mt-3">
                <div class="card-header bg-discovery bg-opacity-75 bg-gradient">
                    <h3 class="text-center text-white">Dilewati</h3>
                </div>
                <div class="card-body">
                    <h1 class="text-center">{{ $antrian_dilewati }}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mb-2 border-0 mt-3">
                <div class="card-header bg-warning bg-opacity-75 bg-gradient">
                    <h3 class="text-center text-white">Sisa</h3>
                </div>
                <div class="card-body">
                    <h1 class="text-center">{{ $antrian_sisa }}</h1>
                </div>
            </div>
        </div>
    </div>

    @if ($modalConfirm)
    <div class="modal" tabindex="-1" style="display: block">
        <div class="modal-dialog shadow">
          <div class="modal-content">
            <div class="modal-header bg-discovery">
              <h5 class="modal-title text-white">Konfirmasi Reset</h5>
              <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="mt-3">Apakah Anda Yakin akan Mereset antrian pada layanan ini ?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-subtle" wire:click="closeModal">Batal</button>
              <button type="button" class="btn btn-discovery" wire:click="resetQueue">Ya, Reset</button>
            </div>
          </div>
        </div>
      </div>
    @endif
</div>
