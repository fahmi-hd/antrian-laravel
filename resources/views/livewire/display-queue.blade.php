<div>
    <div class="row">
        <div class="col-4">
            <div class="card bg-discovery mb-3 h-100 border-0 shadow-md">
                <div class="card-header border-bottom border-5 border-white">
                    <h1 class="text-center text-white">{{ $counter }}</h1>
                </div>
                <div class="card-body align-content-center">
                    <h1 class="text-center text-white">NOMOR ANTRIAN</h1>
                    <h1 class="text-center text-white animate-pulse" style="font-size: 180px">{{ $antrianBroad }}</h1>
                </div>
            </div>
        </div>
        <div class="col-8">
            <video src="{{ asset('storage/'.$app->video) }}" autoplay controls class="w-100" muted>
            </video>
        </div>
    </div>
    <div class="row">
        @forelse ($queues as $queue)
        @php
            $last=App\Models\Queue::where('service_id',$queue["id"])
                ->whereDate('created_at',now()->format('Y-m-d'))
                ->where('status','belum dilayani')
                ->orderBy('id','asc')
                ->limit(1)
                ->first();
        @endphp
        <div class="col">
            <div class="card mt-3 border-0 shadow-md">
                <div class="card-header bg-{{ $queue["color"] }}">
                    <h3 class="text-center text-white">{{ $queue["name"] }}</h3>
                </div>
                <div class="card-body">
                    <h2 class="text-center animate-pulse">{{ $last != null ? $last->queue : '-' }}</h2>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-success mt-5" role="alert">
            <div class="d-flex gap-4">
              <span><i class="fa-solid fa-circle-check icon-success"></i></span>
              <div class="d-flex flex-column gap-2">
                <h6 class="mb-0">Antrian Belum dipanggil</h6>
              </div>
            </div>
          </div>
        @endforelse
        </div>

    <audio id="audioPlayer" preload="auto">
        <source id="audioSource" src="{{ asset($audioFiles[$currentAudioIndex]) }}" type="audio/mpeg">
    </audio>

    <script>
        window.addEventListener('play-audio', event => {
            
            const audioPlayer = document.getElementById('audioPlayer');
            
            // Menggunakan URL yang dikirim dalam event
            audioPlayer.src = event.detail.url; // Menggunakan URL dari event
            audioPlayer.play();
    
            audioPlayer.onended = function() {
                @this.nextAudio(); // Panggil metode nextAudio di Livewire
            };
        });
    
        window.addEventListener('stop-audio', () => {            
            const audioPlayer = document.getElementById('audioPlayer');
            audioPlayer.pause(); // Hentikan pemutaran audio
            audioPlayer.src = ''; // Kosongkan src untuk menghindari pemutaran berulang
        });

        //memutar audio secara online menggunakan speechshyntesis
        window.addEventListener('tts', event => {
            const textValue = event.detail[0].text;
            console.log(textValue);
            let utterance = new SpeechSynthesisUtterance(textValue);
            utterance.lang="id-ID";
            utterance.rate="0.8";
            speechSynthesis.speak(utterance);
            utterance.onend = function(){
                @this.nextAudio();
            }
        });


        </script>
</div>
