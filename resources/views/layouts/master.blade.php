<!DOCTYPE html>
<html lang="en">
    @include('layouts.components.header')
   
  <body class="app sidebar-mini">
    <!-- Navbar-->
    @include('layouts.components.navbar')

    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    {{-- @include('layouts.components.sidebar') --}}
    @include('test')
    
    <main class="app-content">
        @yield('content')
    </main>

    <!-- Essential javascripts for application to work-->
    @include('layouts.components.scripts')

    {{-- Scripts tambahan dari view --}}
    @stack('scripts')
  </body>
</html>
