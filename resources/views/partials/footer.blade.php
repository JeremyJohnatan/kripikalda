@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}">
@endpush

{{-- PERHATIKAN: id="footer" ditambahkan di sini agar menu Contact berfungsi --}}
<footer id="footer" class="footer-style-two">
    <div class="footer-two-top-wrap">
        <div class="container">
            <div class="footer-two-widgets-wrap">
                <div class="row justify-content-between">
                    
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="footer-widget">
                            <div class="footer-logo logo">
                                <a href="{{ url('/') }}">
                                    {{-- Menggunakan asset() agar gambar tidak broken --}}
                                    <img src="{{ asset('assets/img/alda/mascot.png') }}" alt="Logo">
                                </a>
                            </div>
                            <div class="footer-text">
                                <p><strong>Alamat:</strong><br> RT 01 RW 05 Dusun Sreten Desa Jangul, Kec. Ngancar, Kab. Kediri</p>
                                <p><i class="fas fa-envelope"></i> <a href="mailto:example@mail.com">example@mail.com</a></p>
                                <p><i class="fas fa-phone"></i> 0898786542083</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Jam Buka</h4>
                            <ul class="list-wrap">
                                <li><strong>Senin - Sabtu:</strong> 00:00 - 21:00</li>
                                <li><strong>Minggu:</strong> 10:00 - 20:00</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Ikuti Kami</h4>
                            <div class="footer-social">
                                {{-- Format WA diubah ke 62 agar direct link berfungsi global --}}
                                <a href="https://wa.me/62898786542083" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                <a href="https://www.instagram.com/keripikjamur_/" target="_blank"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>