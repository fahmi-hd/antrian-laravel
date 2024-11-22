<div>
    <div class="layout">
        <main class="layout-main px-4">
          <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @session('success')
                        <div class="alert alert-success" role="alert">
                            <div class="d-flex gap-4">
                            <span><i class="fa-solid fa-circle-check icon-success"></i></span>
                            <div>
                                {{ session('success') }}
                            </div>
                            </div>
                        </div>
                        @endsession
                        <h5 class="card-title">Setting</h5>
                        <form wire:submit="update">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Aplikasi</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" wire:model="appName" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Institusi</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" wire:model="institution">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Logo</label>
                                <div class="col-sm-10">
                                  @if ($logoPath)
                                      <img src="{{ asset('storage/'.$logoPath) }}" alt="logo" width="100" height="100">
                                  @endif
                                  <input type="file" class="form-control" wire:model="logo" accept="image/*">
                                  <div wire:loading wire:target="logo">Uploading...</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Keterangan (Alamat,Hp dll)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" wire:model="description" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Computer Name</label>
                                <div class="col-sm-10">
                                  <input type="text" wire:model="computerName" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Cetak No Antrian</label>
                                <div class="col-sm-10">
                                  <select wire:model="use_printer" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                  </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Printer</label>
                                <div class="col-sm-10">
                                  @if ($listPrinter)
                                  <select wire:model="printerName" class="form-control">
                                    <option value="">- Pilih Printer -</option>
                                    @foreach ($listPrinter as $printer)
                                    <option value="{{ $printer }}">{{ $printer }}</option>
                                    @endforeach
                                  </select>
                                  @else
                                  <input type="text" wire:model="printerName" class="form-control">
                                  <p>*Sesuaikan dengan nama printer yang ada di windows</p>
                                  @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label">Gunakan Voice Online</label>
                              <div class="col-sm-10">
                                <select wire:model="audio_online" class="form-control">
                                  <option value="1">Ya</option>
                                  <option value="0">Tidak</option>
                                </select>
                              </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Video Display</label>
                                <div class="col-sm-10">
                                    <p>{{ $videoPath }}</p>
                                  <input type="file" class="form-control" wire:model="video"  accept="video/*">
                                  <div wire:loading wire:target="video">Uploading...</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Banner di Index</label>
                                <div class="col-sm-10">
                                  @if ($banner) 
                                  <img src="{{ $banner->temporaryUrl() }}" class="img-fluid">
                                  @else
                                  <img src="{{ asset('storage/'.$bannerPath) }}" class="img-fluid">
                                  @endif
                                  <input type="file" class="form-control" wire:model="banner" accept=".png,.jpg,.jpeg">
                                  <div wire:loading wire:target="banner">Uploading...</div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <button type="submit" class="btn btn-discovery">Update</button>
                                <button onclick="speak()" >click</button>
                                <script>
                                  function speak() {
                                  let utterance = new SpeechSynthesisUtterance("nomor antrian 10, silahkan ke loket 1");
                                  utterance.lang="id-ID";
                                  utterance.rate="0.8";
                                  speechSynthesis.speak(utterance);
                                  }
                                </script>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </main>
        <aside class="layout-sidebar border-end h-100 bg-white">
            <ul class="list-group border-0" style="width:250px;">
              <li class="list-group-item list-group-item-action {{ Request::is('/')? 'active':'' }}">
                <a href="/"><i class="fa-solid fa-home"></i> Home</a>
              </li>
              <li class="list-group-item list-group-item-action {{ Request::is('loket')? 'active':'' }}">
                <a href="/layanan"><i class="fa-solid fa-table-cells"></i> Layanan</a>
              </li>
              <li class="list-group-item list-group-item-action {{ Request::is('loket')? 'active':'' }}">
                <a href="/loket"><i class="fa-solid fa-headset"></i> Loket</a>
              </li>
              <li class="list-group-item list-group-item-action {{ Request::is('appsetting')? 'active':'' }}">
                <a href="/appsetting"><i class="fa-solid fa-gears"></i> App Setting</a>
              </li>
            </ul>
          </aside>
      </div>
</div>
