 <div id="sidebar" class="active">
     <div class="sidebar-wrapper active">
         <div class="sidebar-header">
             <div class="d-flex justify-content-between">
                 <div class="logo text-center">
                     {{-- <a href="index.html"><img src="{{ asset('mazer/dist/assets/images/logo/logo.png') }}" alt="Logo"
                             srcset=""></a> --}}
                     <p>NAMA SEKOLAH</p>
                 </div>
                 <div class="toggler">
                     <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                 </div>
             </div>
         </div>
         <div class="sidebar-menu">
             <ul class="menu">
                 <li class="sidebar-title">Menu</li>

                 {{-- <li class="sidebar-item active ">
                     <a href="index.html" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Dashboard</span>
                     </a>
                 </li> --}}
                 <li class="sidebar-item  {{ Request::is('siswa') ? 'active' : '' }} ">
                     <a href="/siswa" class='sidebar-link'>
                         <span>Siswa</span>
                     </a>
                 </li>
                 <li class="sidebar-item  {{ Request::is('databeasiswa') ? 'active' : '' }} ">
                     <a href="/databeasiswa" class='sidebar-link'>
                         <span>Input Data Beasiswa</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ Request::is('kategoribeasiswa') ? 'active' : '' }} ">
                     <a href="/kategoribeasiswa" class='sidebar-link'>
                         <span>Kategori Beasiswa</span>
                     </a>
                 </li>

                 <li class="sidebar-item {{ Request::is('jurusan') ? 'active' : '' }} ">
                     <a href="/jurusan" class='sidebar-link'>
                         <span>Jurusan</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ Request::is('hasil') ? 'active' : '' }}  ">
                     <a href="/hasil" class='sidebar-link'>
                         <span>Hasil</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ Request::is('ahp') ? 'active' : '' }}  ">
                     <a href="/ahp" class='sidebar-link'>
                         <span>AHP</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ Request::is('user') ? 'active' : '' }}  ">
                     <a href="/user" class='sidebar-link'>
                         <span>User</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ Request::is('logout') ? 'active' : '' }}  ">
                     <a href="/logout" class='sidebar-link'>
                         <span>logout</span>
                     </a>
                 </li>
             </ul>
         </div>
         <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
     </div>
 </div>
