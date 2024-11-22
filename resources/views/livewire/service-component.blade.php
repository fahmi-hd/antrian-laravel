<div>
    <div class="layout">
        <main class="layout-main px-4">
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
            <div class="row">
                <div class="col">
                    <div class="card border-0">
                        <div class="card-body">
                            <form wire:submit="{{ $submitType }}">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Pelayanan</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model="name" class="form-control" required >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        {{-- <input type="text" wire:model="description" class="form-control" required> --}}
                                        <textarea wire:model="description" cols="30" rows="4" class="form-control">{!! $description !!}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Inisial</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" wire:model="initial" required>
                                            <option value="">- Pilih -</option>
                                            <option value="A" @if ($this->initial=="A") selected @endif>A</option>
                                            <option value="B" @if ($this->initial=="B") selected @endif>B</option>
                                            <option value="C" @if ($this->initial=="C") selected @endif>C</option>
                                            <option value="D" @if ($this->initial=="D") selected @endif>D</option>
                                            <option value="E" @if ($this->initial=="E") selected @endif>E</option>
                                            <option value="F" @if ($this->initial=="F") selected @endif>F</option>
                                            <option value="G" @if ($this->initial=="G") selected @endif>G</option>
                                            <option value="H" @if ($this->initial=="H") selected @endif>H</option>
                                        </select>
                                        <input type="hidden" wire:model="editInitial">
                                        <div class="d-block">@error('initial') {{ $message }} @enderror</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Warna</label>
                                    <div class="col-sm-10">
                                        <select wire:model="color" class="form-control" required>
                                            <option value="">- Pilih Warna Background -</option>
                                            <option value="primary" @if ($this->color=="primary") selected @endif>BIRU</option>
                                            <option value="discovery" @if ($this->color=="discovery") selected @endif>VIOLET</option>
                                            <option value="success" @if ($this->color=="success") selected @endif>HIJAU</option>
                                            <option value="warning" @if ($this->color=="warning") selected @endif>KUNING</option>
                                            <option value="danger" @if ($this->color=="danger") selected @endif>MERAH</option>
                                            <option value="dark" @if ($this->color=="dark") selected @endif>DARK BLUE</option>
                                            <option value="dark-subtle" @if ($this->color=="dark-subtle") selected @endif>ABU-ABU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Aktif</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" wire:model="isActive" required>
                                            <option value="">- Pilih -</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-discovery">Simpan</button>
                                <button type="button" wire:click="clearForm" class="btn btn-default">Batal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card border-0 mt-2">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-dark">
                                        <th>No</th>
                                        <th>Layanan</th>
                                        <th>Inisial</th>
                                        <th>Keterangan</th>
                                        <th>Aktif</th>
                                        <th>Warna</th>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td><b>{{ $service->initial }}</b></td>
                                            <td>{{ $service->description }}</td>
                                            <td><span class="badge @if ($service->is_active==1)bg-success @else bg-danger @endif">@if ($service->is_active==1)Ya @else Tidak @endif</span></td>
                                            <td><button class="btn btn-{{ $service->color }}"></button></td>
                                            <td>
                                                <button type="button" wire:click="edit({{$service->id}})" class="btn btn-outline-warning">Edit</button>
                                                <button type="button" wire:click="confirmDelete({{$service->id}})" class="btn btn-outline-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if ($deleteConfirm=="yes")
            <div wire:ignore.self  class="modal fade show" tabindex="-1" style="display: block">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                      <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                      Yakin ingin menghapus data ini ?
                    </div>
                    <div class="modal-footer">
                      <button wire:click="cancelDelete" type="button" class="btn btn-subtle" data-bs-dismiss="modal">Batal</button>
                      <button  wire:click="delete" type="button" class="btn btn-danger">Confirm</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-backdrop fade show"></div>
            @endif
        </main>
        <aside class="layout-sidebar border-end h-100 bg-white">
            <ul class="list-group border-0" style="width:250px;">
                <li class="list-group-item list-group-item-action {{ Request::is('/')? 'active':'' }}">
                    <a href="/"><i class="fa-solid fa-home"></i> Home</a>
                  </li>
                <li class="list-group-item list-group-item-action {{ Request::is('layanan')? 'active':'' }}">
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
