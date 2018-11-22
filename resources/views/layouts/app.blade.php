<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
  @include('includes.head')
</head>

<body>

  <div id="app">

    @unless(isset($sidebar)) @include('includes.header-sidebar') @else @include('includes.header') @endif

    <div id="page-wrapper">
      <div class="row">
        @yield('content')
      </div>
    </div>
    <!-- /#page-wrapper -->

  </div>

  </div>

  <script src="{{ asset('js/app.js') }}"></script>
  @yield('page_scripts')
</body>

</html>

