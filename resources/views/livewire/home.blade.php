<div>
    <div class="row">
        <div class="col-12">
            <img class="img-fluid" src="{{ asset('storage/'.$app->banner) }}" />
        </div>
    </div>
    <div class="row pt-3">
        <div class="col">
            <a href="/tiket" class="text-decoration-none">
            <div class="card border-0 shadow-md">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{ asset('images/tiket.png') }}" class="img-fluid rounded-start">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">Tiket</h5>
                    </div>
                  </div>
                </div>
              </div>
            </a>
        </div>
        <div class="col">
            <a href="/caller" target="popup" onclick="window.open('/caller','name','width=1200,height=700')" class="text-decoration-none">
            <div class="card border-0 shadow-md">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{ asset('images/caller.png') }}" class="img-fluid rounded-start">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">Caller</h5>
                    </div>
                  </div>
                </div>
              </div>
            </a>
        </div>
        <div class="col">
            <a href="/display" target="popup" onclick="window.open('/display','name','width=1200,height=700')" class="text-decoration-none">
            <div class="card border-0 shadow-md">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{ asset('images/display.png') }}" class="img-fluid rounded-start">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">Display</h5>
                    </div>
                  </div>
                </div>
              </div>
            </a>
        </div>
        <div class="col">
            <a href="/appsetting" class="text-decoration-none">
            <div class="card border-0 shadow-md">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="{{ asset('images/setting.png') }}" class="img-fluid rounded-start">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">Setting</h5>
                    </div>
                  </div>
                </div>
              </div>
            </a>
        </div>
    </div>
    <nav class="navbar fixed-bottom">
        <div class="container-fluid">
          <span class="navbar-text">
            SN Code Tech Antrian App Versi 1.0
          </span>
        </div>
      </nav>
</div>
