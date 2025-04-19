<!-- Vendor JS Files -->
<script src="{{ asset('website/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('website/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('website/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('website/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('website/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('website/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('website/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('website/js/main.js') }}"></script>

<!-- bagian handle toast -->
@if(session('status'))
<div class="toast align-items-center text-white bg-{{ session('status') }} border-0" role="alert" id="toastNotif" data-delay="3000">
    <div class="d-flex">
        <div class="col toast-body flex-grow-1 w-100">
            {{ session('message') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>
<script>
    // Ambil elemen toast
    const toastElement = document.getElementById('toastNotif');
    const toast = new bootstrap.Toast(toastElement);

    // Tampilkan toast
    toast.show();
</script>
@endif

@yield('scripts')