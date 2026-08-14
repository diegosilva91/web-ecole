<div
    id="navbar-mobile"
    class="align-items-center"
>
    <div class="container">
        <div class="row p-2">
            <a class="col-6" href="/es">
                <img class="ml-20" src="{{ asset('assets/images/home/logo_life_purple.svg') }}" height="22" width="120" alt="logo">
            </a>
            <div class="col-6 d-flex justify-content-end">
                <div class="mr-20" onclick="openNav()">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="mySidebar" class="sidebar">

    @guest
    <a href="javascript:void(0)" class="closebtn text-light" onclick="closeNav()">&times;</a>

    <a id="courseMobile" class="text-right">
        <span class="link-menu-mob mr-mob-10 mr-tb-10 mt-20 mt-tb-60 mb-mob-10 mb-tb-10">
            Oferta educativa
        </span>
        <span
            id="iconExpand"
            class="mr-20"
            style="vertical-align: text-bottom; font-size: 24px; line-height: 1"
        >@php echo Mdi::mdi('chevron-down', 'v-icon__svg'); @endphp</span>
    </a>
    <div class="d-none" id="dropdownCourses">
        <a class="text-right" href="/es/cursos-anuales">
            <span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">
                Trayectorias educativas
            </span>
        </a>
        <a class="text-right" href="/es/campus-verano">
            <span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">
                Campus de verano
            </span>
        </a>
        <a class="text-right" href="/es/cursos">
            <span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">
                Cursos intensivos
            </span>
        </a>
    </div>
    <a class="text-right" href="/es/sobre-mi-empresa"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">¿Quiénes somos?</span></a>
    <a class="text-right" href="/es/contacto"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Contacto</span></a>
        <a class="text-right" data-toggle="modal" data-target="#Login">
            <span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Iniciar sesión</span>
        </a>

    @if (Route::has('register'))
        <a class="text-right" data-toggle="modal" data-target="#Register">
            <span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10 btn-register-mob">Registrarse</span>
        </a>

        <a class="text-right" data-toggle="modal" data-target="#Register">
            <div class="btn-getMember-mob d-flex ml-25"><img src="{{ asset('assets/images/menu/present.svg') }}" height="23" width="23" alt=""><span class="link-getMember-mob">Invitar amigos</span></div>
        </a>

        <hr class="col-9 mx-auto pt-0 pb-0 mt-12" style="opacity: 0.36;
        border: solid 1px #979797;">
        <a class="text-right" href="/es/dar-clases"><span class="link-menu-mob mr-20 mb-mob-100 mb-tb-100">Dar clases</span></a>
        <div class="row col-9 mx-auto d-inline pt-0 pb-0 mt-12">
            <div class="d-inline mr-4"><a class="d-inline" href="https://wa.me/+34633651856?text=Hola!%20Estoy%20intersado%20en%20hacer%20un%20curso%20en%20Mi-empresa"><img src="{{ asset('assets/images/menu/whatsapp.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.facebook.com/LifeColeEdu/"><img src="{{ asset('assets/images/menu/facebook.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.instagram.com/mi-empresaedu/"><img src="{{ asset('assets/images/menu/instagram.svg') }}" alt="icon"></a></div>
            <div class="d-inline"><a class="d-inline" href="https://twitter.com/mi-empresaedu"><img src="{{ asset('assets/images/menu/twitter.svg') }}" alt="icon"></a></div>
        </div>
    @endif

    {{-- MENU TEACHER --}}
    @elseif (Auth::user()->hasRole('teacher'))
        <a href="javascript:void(0)" class="closebtn text-light" onclick="closeNav()">&times;</a>
        <div class="perfil-position">
            <img src="@image(Auth::user()->avatar)" alt="" style="vertical-align: middle; width: 35px; height: 35px; border-radius: 50%;">
            <span class="guest-name text-light pl-2">{{ Auth::user()->name }}</span>
            <a href="{{ url('/es/lf/profesor/'.Auth::id().'/model') }}" class="h8-txt-reg text-light p-0 ml-45 ml-dk-50">Ver perfil</a>
        </div>

        <div class="col-10 mx-auto mt-mob-20 mt-tb-50" style="opacity: 0.36;border-bottom: solid 1px #979797;"></div>

        <a class="text-right" href="{{ url('/es/mis-cursos?subject=portal-professor') }}"><span class="link-menu-mob mr-20 mt-20 mt-tb-60 mb-mob-10 mb-tb-10"> Mis Cursos </span></a>
        <a class="text-right" href="{{ url('/es/lf/promociones/'.Auth::id()) }}"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Disponibilidad</span></a>
        <a class="text-right" href="/es/contacto"><span class="link-menu-mob mr-20 mb-300">Contacto</span></a>

        <div class="row col-9 mx-auto d-inline pt-0 pb-0">
            <div class="d-inline mr-4"><a class="d-inline" href="https://wa.me/+34633651856?text=Hola!%20Estoy%20intersado%20en%20hacer%20un%20curso%20en%20Mi-empresa"><img src="{{ asset('assets/images/menu/whatsapp.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.facebook.com/LifeColeEdu/"><img src="{{ asset('assets/images/menu/facebook.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.instagram.com/mi-empresaedu/"><img src="{{ asset('assets/images/menu/instagram.svg') }}" alt="icon"></a></div>
            <div class="d-inline"><a class="d-inline" href="https://twitter.com/mi-empresaedu"><img src="{{ asset('assets/images/menu/twitter.svg') }}" alt="icon"></a></div>
        </div>

        <a class="text-right mt-7" href="{{ route('logout')  }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><span class="link-menu-mob mr-20 mt-30" style="font-size: 14px !important">Cerrar sesión</span></a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    {{-- MENU STUDENT --}}
    @else
        <a href="javascript:void(0)" class="closebtn text-light" onclick="closeNav()">&times;</a>
        <div class="perfil-position">
            <img src="@image(Auth::user()->avatar)" alt="" style="vertical-align: middle; width: 35px; height: 35px; border-radius: 50%;">
            <span class="guest-name text-light pl-2">{{ Auth::user()->name }}</span>
            <a href="{{ url('es/lf/miperfil/'.Auth::id().'/view')  }}" class="h8-txt-reg text-light p-0 ml-45 ml-dk-50">Ver perfil</a>
        </div>

        <div class="col-10 mx-auto mt-mob-20 mt-tb-50" style="opacity: 0.36;border-bottom: solid 1px #979797;"></div>

        <a class="text-right" href="{{ url('/es/lf/mis_cursos/'.Auth::id())  }}">
            <span class="link-menu-mob mr-20 mt-20 mt-tb-20 mb-mob-10 mb-tb-10"> Mis Cursos </span></a>
        <a id="courseMobile" class="text-right">
            <span class="link-menu-mob mr-mob-10 mr-tb-10 mt-tb-10 mb-mob-10 mb-tb-10">
                Oferta educativa
            </span>
            <span
                id="iconExpand"
                class="mr-20"
                style="vertical-align: text-bottom; font-size: 24px; line-height: 1"
            >@php echo Mdi::mdi('chevron-down', 'v-icon__svg'); @endphp</span>
        </a>
        <div class="d-none" id="dropdownCourses">
            <a class="text-right" href="/es/cursos"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">Cursos intensivos</span></a>
            <a class="text-right" href="/es/cursos-anuales"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10" style="font-size:18px;font-weight:400;">Trayectorias educativas</span></a>
        </div>
        <a class="text-right"  href="/es/campus-verano"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Campus de verano</span></a>
        <a class="text-right" href="/es/sobre-mi-empresa"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">¿Quiénes somos?</span></a>
        <a class="text-right" href="/es/contacto"><span class="link-menu-mob mr-20 mb-mob-10 mb-tb-10">Contacto</span></a>

        {{-- PONER MODAL GTM --}}
        <a class="text-right" data-toggle="modal" data-target="#modalGetmember" onclick="document.getElementById('modalGetmember').classList.replace('d-none','show')">
            <div class="btn-getMember-mob d-flex ml-25"><img src="{{ asset('assets/images/menu/present.svg') }}" alt=""><span class="link-getMember-mob">Invitar amigos</span></div>
        </a>

        <hr class="col-9 mx-auto pt-0 pb-0 mt-12" style="opacity: 0.36;
        border: solid 1px #979797;">
        <a class="text-right" href="/es/dar-clases"><span class="link-menu-mob mr-20 mb-mob-100 mb-tb-100">Dar clases</span></a>

        <div class="row col-9 mx-auto d-inline pt-0 pb-0">
            <div class="d-inline mr-4"><a class="d-inline" href="https://wa.me/+34633651856?text=Hola!%20Estoy%20intersado%20en%20hacer%20un%20curso%20en%20Mi-empresa"><img src="{{ asset('assets/images/menu/whatsapp.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.facebook.com/LifeColeEdu/"><img src="{{ asset('assets/images/menu/facebook.svg') }}" alt="icon"></a></div>
            <div class="d-inline mr-4"><a class="d-inline" href="https://www.instagram.com/mi-empresaedu/"><img src="{{ asset('assets/images/menu/instagram.svg') }}" alt="icon"></a></div>
            <div class="d-inline"><a class="d-inline" href="https://twitter.com/mi-empresaedu"><img src="{{ asset('assets/images/menu/twitter.svg') }}" alt="icon"></a></div>
        </div>

        <a class="text-right mt-7" href="{{ route('logout')  }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><span class="link-menu-mob mr-20 mt-30" style="font-size: 14px !important">Cerrar sesión</span></a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
</div>

@push('scripts')
<script>
    let appliedEventSubmenu = false;

    function openNav() {
        document.getElementById("mySidebar").style.width = "300px";
        let a=document.getElementById("mySidebar");
        applySubmenu();
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
    }

    function applySubmenu() {
        if (appliedEventSubmenu) {
            return;
        }

        appliedEventSubmenu = true;
        let subCourses = document.getElementById("courseMobile");
        if (subCourses) {
            subCourses.addEventListener("click", function (e) {
                document.getElementById('dropdownCourses').classList.toggle('d-none');
                if (document.getElementById('dropdownCourses').classList.contains('d-none')) {
                    document.getElementById('iconExpand').firstChild.style.transform = 'rotate(0deg)';
                } else {
                    document.getElementById('iconExpand').firstChild.style.transform = 'rotate(180deg)';
                }
            });
        }
    }

    let lastScrollPosition = 0;
    document.addEventListener('scroll', function(e) {
        const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        if (window.scrollY >= 132) {
            document.getElementById('navbar-mobile').classList.add('is-stuck');
            if (currentScrollPosition > lastScrollPosition) {
                document.getElementById('navbar-mobile').classList.add('is-hidden');
                lastScrollPosition = currentScrollPosition;
            } else {
                document.getElementById('navbar-mobile').classList.remove('is-hidden'); 
                lastScrollPosition = currentScrollPosition;
            }
        } else {
            document.getElementById('navbar-mobile').classList.remove('is-stuck');
        }
    });
    
</script>
@endpush
