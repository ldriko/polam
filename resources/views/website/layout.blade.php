<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>FlexStart Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  @include('website.partials.style')
</head>

<body>

  <!-- ======= Header ======= -->
  @include('website.partials.navbar')
  <!-- End Header -->

  <main id="main">
    @yield('content')
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @include('website.partials.footer')
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  @include('website.partials.script')
</body>

</html>
