
<!DOCTYPE html>
<html lang="en">
    @include('layouts.components.header')
   
  <body class="app sidebar-mini">
     @yield('scripts')
    <!-- Navbar-->
    @include('layouts.components.navbar')

    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    @include('layouts.components.sidebar')
    
    <main class="app-content">
      
            @yield('content')
        
    </main>

    <!-- Essential javascripts for application to work-->
    @include('layouts.components.scripts')
  </body>
</html>