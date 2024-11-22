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
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor</label>
                                    <div class="col-sm-10">
                                        @if ($submitType=="update")
                                        <input type="text" value="{{ $name }}" readonly class="form-control">
                                        <small class="text-muted">*hanya dapat mengubah jenis</small>
                                        @else
                                        <select class="form-control" wire:model="name" required>
                                            <option value="">- Pilih -</option>
                                            @foreach ($number as $n)
                                            <option value="{{ $n }}">{{ $n }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="" class="col-sm-2 col-form-label">Jenis</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" wire:model="jenis" required>
                                            <option value="">- Pilih -</option>
                                            <option value="loket">Loket</option>
                                            <option value="counter">Counter</option>
                                            <option value="meja">Meja</option>
                                            <option value="teller">Teller</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-discovery">Simpan</button>
                                @if ($submitType=="update")
                                <button type="button" wire:click="cancelUpdate" class="btn btn-default">Batal Update</button>
                                @else
                                <button type="button" wire:click="clearForm" class="btn btn-default">Batal</button>
                                @endif
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
                                        {{-- <th>No</th> --}}
                                        <th>Nomor Urut</th>
                                        <th>Jenis</th>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($counters as $counter)
                                        <tr>
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
                                            <td>{{ $counter->name }}</td>
                                            <td>{{ $counter->jenis }}</td>
                                            <td>
                                                <button type="button" wire:click="edit({{$counter->id}})" class="btn btn-outline-warning">Edit</button>
                                                <button type="button" wire:click="confirmDelete({{$counter->id}})" class="btn btn-outline-danger">Delete</button>
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
        <aside class="layout-sidebar border-end">
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
