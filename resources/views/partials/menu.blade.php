<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--begin::Menu wrapper-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
        <!--begin::Scroll wrapper-->
        <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true"
            data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">
                <!--begin:Menu item-->
                <div class="menu-item pt-5">
                    <!--begin:Menu content-->
                    <div class="menu-content">
                        {{-- <span class="menu-heading fw-bold text-uppercase fs-7">MENUS</span> --}}
                        <span class="fs-7 text-white fw-boldn">MENUS</span>
                    </div>
                    <!--end:Menu content-->
                </div>
                <!--end:Menu item-->

                {{-- @if (Auth::user()->isAdmin()) --}}
                    <div data-kt-menu-trigger="click"
                        class="menu-item menu-accordion {{ Request::is('usuario/*', 'rol/*', 'sucursal/*', 'producto/*', 'categoria/*','subCategoria/*') ? 'show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-university"></i>
                            </span>
                            <span class="menu-title text-white">Administracion</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <div class="menu-sub menu-sub-accordion">

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('sucursal/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Sucursales</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('usuario/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Usuario</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('rol/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Rol</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('producto/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Productos</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'servicio.listado' ? 'active' : '' }}"
                                    href="{{ route('servicio.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Servicios</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('cliente/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Cliente</span>
                                </a>
                            </div>

                            {{-- <div class="menu-item">
                                <a class="menu-link" href="{{ url('tiporeceta/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Tipo Receta</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('motivo/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Motivo</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('referencia/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Referencia</span>
                                </a>
                            </div>



                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('marca/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Marca</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('color/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Color</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('tipoMontura/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Tipo Montura</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('montura/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Montura</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('oftalmologo/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Especialista</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('solicitud/listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Solicitudes</span>
                                </a>
                            </div> --}}

                            {{-- <div class="menu-item">
                                <a class="menu-link" href="{{ route('solicitudAnulacion.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Solicitud Anulaciones</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'pago.listado' ? 'active' : '' }}"
                                    href="{{ route('pago.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Ventas del Dia</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'categoria.listado' ? 'active' : '' }}"
                                    href="{{ route('categoria.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Categorias</span>
                                </a>
                            </div>

                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'subCategoria.listado' ? 'active' : '' }}"
                                    href="{{ route('subCategoria.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Sub Categorias</span>
                                </a>
                            </div> --}}
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Request::is('fondoAcumulado/*') ? 'show' : '' }}">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="fa fa-university"></i>
                            </span>
                            <span class="menu-title text-white">Fondo Acumulado</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        {{-- <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'fondoAcumulado.categoria' ? 'active' : '' }} " href="{{ route('fondoAcumulado.categoria') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Categoria</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        <!--end:Menu sub-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" {{ Route::currentRouteName() == 'fondoAcumulado.subCategoria' ? 'active' : '' }} " href="{{ route('fondoAcumulado.subCategoria') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Sub Categoria</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        <!--end:Menu sub-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" {{ Route::currentRouteName() == 'fondoAcumulado.listaIngresoSinRecepcion' ? 'active' : '' }} " href="{{ route('fondoAcumulado.listaIngresoSinRecepcion') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Ingreso sin Recepcionar</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        <!--end:Menu sub-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link {{ Route::currentRouteName() == 'fondoAcumulado.cajaFuerte' ? 'active' : '' }} " href="{{ route('fondoAcumulado.cajaFuerte') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Caja Fuerte</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                        </div>
                        <!--end:Menu sub--> --}}
                    </div>
                {{-- @endif --}}


                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ Request::is('pago/*', 'cotizacion/*') ? 'show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa fa-university"></i>
                        </span>
                        <span class="menu-title text-white">Ventas</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('caja.listado') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Cajas de dia</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ url('factura/formulario') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Nueva venta</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ url('factura/listado') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Listado Facturas</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ url('pago/listadoDeuda') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Cuentas por Cobrar</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'pago.listado' ? 'active' : '' }}"
                                href="{{ route('pago.listado') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Ventas del Dia</span>
                            </a>
                        </div>
                    </div>

                    {{-- <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('caja.listado') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Cajas de dia</span>
                            </a>
                        </div>
                    </div>

                    @if (Auth::user()->isCajero() || Auth::user()->isAdmin())
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link" href="{{ url('pago/listadoDeuda') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Cuentas por Cobrar</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if (Auth::user()->isCajero())
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ Route::currentRouteName() == 'pago.listado' ? 'active' : '' }}"
                                    href="{{ route('pago.listado') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title text-white">Ventas del Dia</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('montura.busquedaProducto') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Busqueda Prod.</span>
                            </a>
                        </div>
                    </div> --}}
                </div>
                <!--end:Menu item-->

                {{-- <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ Request::is('pago/*', 'cotizacion/*') ? 'show' : '' }}">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="fa fa-university"></i>
                        </span>
                        <span class="menu-title text-white">Reportes</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->

                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('reporte.listado') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title text-white">Lista</span>
                            </a>
                        </div>
                    </div>
                </div> --}}
                <!--end:Menu item-->
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Scroll wrapper-->
    </div>
    <!--end::Menu wrapper-->
</div>
