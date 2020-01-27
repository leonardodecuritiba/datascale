<style>

.sidebar-header {
        background-color: #3f4a59 !important;
}

</style>


<!-- Sidebar -->
<aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-lg sidebar-expand-lg">
    <header class="sidebar-header">
        <a class="logo-icon" href="{{route('index')}}"><img src="{{asset('assets/images/logo/sidebar-white.png')}}"
                                                            alt="logo icon" border="0" width="30"></a>
        <span class="logo">
          <a href="{{route('index')}}">
            {{ config('app.name', 'Datascale') . ' v' . config('app.version', '2.0') . '.'. config('app.rev', '1') }}
          </a>
        </span>
    </header>

    <nav class="sidebar-navigation">
        <ul class="menu menu-xs">

        <?php




        $submenu = Route::getCurrentRoute()->getActionMethod();
            $route_name = Route::getCurrentRoute()->getName();
            $route_prefix = Route::getCurrentRoute()->getPrefix();
            $main_menu = NULL;
            if( strpos( $route_prefix, 'human_resources' ) !== false ){
                $main_menu = 'human_resources';
            } else if( strpos( $route_prefix, 'parts' ) !== false ){
                $main_menu = 'parts';
            } else if( strpos( $route_prefix, 'settings' ) !== false ){
                $main_menu = 'settings';
            }

        $route_name_item = explode( '.', $route_name )[0];





//        e rror_log($route_name);
//            error_log($main_menu);
//            error_log($route_prefix);
//            echo  $submenu . ' + ' . $route_name.' + ' . $route_prefix . ' + ' . $main_menu;


        ?>
            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | INTELIGÊNCIA
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            @role(['admin'])

                <li class="menu-item">
                    <a class="menu-link" href="#">
                        <span class="icon ti-world"></span>
                        <span class="title">ADMINISTRATIVO</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="menu-submenu">


                        {{--OP. BANCÁRIAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('banking_operations')}}">
                                <span class="dot"></span>
                                <span class="title"><del>OP. BANCÁRIAS</del></span>
                            </a>
                        </li>

                        {{--METAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('goals')}}">
                                <span class="dot"></span>
                                <span class="title"><del>METAS</del></span>
                            </a>
                        </li>

                        {{--GRÁFICOS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('graphs')}}">
                                <span class="dot"></span>
                                <span class="title"><del>GRÁFICOS</del></span>
                            </a>
                        </li>

                        {{--PAGAMENTOS - RECEBIMENTOS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('payments')}}">
                                <span class="dot"></span>
                                <span class="title"><del>PAGAMENTOS - RECEBIMENTOS</del></span>
                            </a>
                        </li>

                        {{--RELATÓRIOS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('reports')}}">
                                <span class="dot"></span>
                                <span class="title"><del>RELATÓRIOS</del></span>
                            </a>
                        </li>

    <?php /*

                        {{--AGENDA--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">AGENDA</span>
                            </a>
                        </li>


                        {{--ALERTAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">ALERTAS</span>
                            </a>
                        </li>


                        {{--COMISSÃO--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">COMISSÃO</span>
                            </a>
                        </li>


                        {{--DIRETOR--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">DIRETOR</span>
                            </a>
                        </li>


                        {{--META DO MÊS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('goals')}}">
                                <span class="dot"></span>
                                <span class="title">META DO MÊS</span>
                            </a>
                        </li>


                        {{--REQUISIÇÕES--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">REQUISIÇÕES</span>
                            </a>
                        </li>


                        {{--REQUISIÇÃO DA MATRIZ--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">REQUISIÇÃO DA MATRIZ</span>
                            </a>
                        </li>


                        {{--SCORE PRODUÇÃO--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">SCORE PRODUÇÃO</span>
                            </a>
                        </li>

     */
    ?>


                    </ul>
                </li>

            @endrole

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | COMUNICAÇÃO
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon ti-headphone-alt"></span>
                    <span class="title">COMUNICAÇÃO</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">

                    {{--AGENDA--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('schedules')}}">
                            <span class="dot"></span>
                            <span class="title"><del>AGENDA</del></span>
                        </a>
                    </li>

                    {{--AVISOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('notices')}}">
                            <span class="dot"></span>
                            <span class="title"><del>AVISOS</del></span>
                        </a>
                    </li>

                    {{--NOTIFICAÇÃO--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('notifications')}}">
                            <span class="dot"></span>
                            <span class="title"><del>NOTIFICAÇÃO</del></span>
                        </a>
                    </li>

                    {{--CHAMADOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('calls')}}">
                            <span class="dot"></span>
                            <span class="title"><del>CHAMADOS</del></span>
                        </a>
                    </li>

                </ul>
            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | FINANCEIRO
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            @role(['admin','tech-franchise'])

                <li class="menu-item @if(Menu::isMenu('financial')) active open @endif">
                    <a class="menu-link open" href="#">
                        <span class="icon ti-money"></span>
                        <span class="title">FINANCEIRO</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="menu-submenu">

                        @role(['admin','tech-franchise'])

                            {{--Franquia Técnica--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>FRANQUIA TÉCNICA</del></span>
                                </a>
                            </li>

                        @endrole

                        @role(['admin'])

                            {{--Franquia Comercial--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>FRANQUIA COMERCIAL</del></span>
                                </a>
                            </li>

                            {{--Visão Geral--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>VISÃO GERAL</del></span>
                                </a>
                            </li>


                            {{--APIs BANCARIAS--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('bank_apis')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>APIs BANCARIAS</del></span>
                                </a>
                            </li>

                            {{--Contas a Pagar--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>CONTAS A PAGAR</del></span>
                                </a>
                            </li>

                            {{--Contas a Receber--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>CONTAS A RECEBER</del></span>
                                </a>
                            </li>

                            {{--Impostos--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>IMPOSTOS</del></span>
                                </a>
                            </li>

                            {{--COTAÇÕES APROVADAS--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>COTAÇÕES APROVADAS</del></span>
                                </a>
                            </li>

                            {{--TAXAS BANCÁRIAS--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('bank_charges')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>TAXAS BANCÁRIAS</del></span>
                                </a>
                            </li>


                            {{--INSTITUIÇÕES BANCÁRIAS--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('banks')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>INSTITUIÇÕES BANCÁRIAS</del></span>
                                </a>
                            </li>


                            {{--FATURAMENTO--}}
                            <li class="menu-item @if(Menu::isRoute([
                                    'billings.clients.report',
                                    'billings.clients.cost_center',
                                    'billings.clients.index'
                                    ])) active @endif">
                                <a class="menu-link" href="{{route('billings.clients.report')}}">
                                    <span class="dot"></span>
                                    <span class="title">FATURAMENTO P/ CLIENTES</span>
                                </a>
                            </li>


                            {{--FATURAMENTO--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('billings.franchisees')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>FATURAMENTO  P/ FRANQUEADOS</del></span>
                                </a>
                            </li>


                            {{--PAGAMENTOS - RECEBIMENTOS--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('payments')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>PAGAMENTOS - RECEBIMENTOS</del></span>
                                </a>
                            </li>


                            {{--TABELAS DE PREÇO--}}
                            <li class="menu-item @if($main_menu == 'parts' &&
                                ($submenu == 'prices' || $route_name == 'prices.index' || $route_name == 'prices.edit')) active @endif">
                                <a class="menu-link" href="{{route('prices.index')}}">
                                    <span class="dot"></span>
                                    <span class="title">TABELAS DE PREÇO</span>
                                </a>
                            </li>


                            {{--ESTOQUE VALORES--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('stock_values')}}">
                                    <span class="dot"></span>
                                    <span class="title"><del>ESTOQUE VALORES</del></span>
                                </a>
                            </li>

                        @endrole

                    </ul>

                </li>

            @endrole

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | FISCAL
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            @role(['admin'])

                <li class="menu-item @if(Menu::isMenu('fiscal')) active open @endif">
                    <a class="menu-link open" href="#">
                        <span class="icon ti-money"></span>
                        <span class="title">FISCAL</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="menu-submenu">

                        {{--CERTIFICADOS MATRIZ \ FILIAIS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title"><del>CERTIFICADOS MATRIZ \ FILIAIS</del></span>
                            </a>
                        </li>

                        {{--CERTIFICADO FRANQUIAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title"><del>CERTIFICADO FRANQUIAS</del></span>
                            </a>
                        </li>

                        {{--NFE \ NFSE CONSULTAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title"><del>NFE \ NFSE CONSULTAS</del></span>
                            </a>
                        </li>

                        {{--API FISCAL--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('fiscals')}}">
                                <span class="dot"></span>
                                <span class="title"><del>API FISCAL</del></span>
                            </a>
                        </li>

                    </ul>

                </li>

            @endrole


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | IPEM
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            @role(['admin','tecnico','tech-franchise'])

                <li class="menu-item @if(Menu::isMenu('ipem')) active open @endif">
                    <a class="menu-link open" href="#">
                        <span class="icon ti-stats-up"></span>
                        <span class="title">IPEM</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="menu-submenu">


                        {{--PADRÕES - CERTIFICADOS--}}
                        <li class="menu-item @if(Menu::isRoute([
                                'certificates.requests',
                                'certificates.create',
                                'certificates.recreate',
                                'certificates.index',
                                'certificates.edit',
                                ])) active @endif">
                            <a class="menu-link" href="{{route('certificates.create')}}">
                                <span class="dot"></span>
                                <span class="title">PADRÕES - CERTIFICADOS</span>
                            </a>
                        </li>


                        {{--CAPACIDADE TÉCNICA--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('technical_capacity')}}">
                                <span class="dot"></span>
                                <span class="title"><del>CAPACIDADE TÉCNICA</del></span>
                            </a>
                        </li>


                        {{--Identificação do Técnico--}}
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">IDENTIFICAÇÃO DO TÉCNICO</span>
                            </a>
                        </li>


                        {{--MARCAS DE REPARO--}}
                        <li class="menu-item @if(Menu::isRoute([
                                'labels.create',
                                'labels.index',
                                'labels.tracking',
                                ])) active @endif">
                            <a class="menu-link" href="{{route('labels.create')}}">
                                <span class="dot"></span>
                                <span class="title">MARCAS DE REPARO</span>
                            </a>
                        </li>


                        {{--LACRES--}}
                        <li class="menu-item @if(Menu::isRoute([
                                'seals.create',
                                'seals.index',
                                'seals.tracking',
                                ])) active @endif">
                            <a class="menu-link" href="{{route('seals.create')}}">
                                <span class="dot"></span>
                                <span class="title">LACRES</span>
                            </a>
                        </li>


                        @role(['admin'])
                            
                            {{--PAM--}}
                            <li class="menu-item">
                                <a class="menu-link" href="{{route('pams.index')}}">
                                    <span class="dot"></span>
                                    <span class="title">PAM</span>
                                </a>
                            </li>

                        @endrole

                        {{--INSPEÇÃO--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('inspections.index')}}">
                                <span class="dot"></span>
                                <span class="title">INSPEÇÃO</span>
                            </a>
                        </li>


                        @role(['admin'])

                            {{--Logística Saída--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>LOGÍSTICA SAÍDA</del></span>
                                </a>
                            </li>

                            {{--Cadastro de Regionais IPEM--}}
                            <li class="menu-item">
                                <a class="menu-link" href="#">
                                    <span class="dot"></span>
                                    <span class="title"><del>CADASTRO DE REGIONAIS IPEM</del></span>
                                </a>
                            </li>

                        @endrole


                        {{--MASSAS--}}
                        <li class="menu-item">
                            <a class="menu-link" href="{{route('bulks')}}">
                                <span class="dot"></span>
                                <span class="title"><del>!r! MASSAS</del></span>
                            </a>
                        </li>


                    </ul>

                </li>


            @endrole
            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | AJUSTES DE COMPLEMENTOS
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->
            <li class="menu-item @if(Menu::isMenu('settings')) active open @endif">
                <a class="menu-link open" href="#">
                    <span class="icon ti-stats-up"></span>
                    <span class="title">AJUSTES</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">

                    {{--MARCAS - DE - INSTRUMENTOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'instrument_brands' || $route_name_item == 'instrument_brands')) active @endif">
                        <a class="menu-link" href="{{route('instrument_brands.index')}}">
                            <span class="dot"></span>
                            <span class="title">MARCAS DE INSTRUMENTOS</span>
                        </a>
                    </li>

                    {{--MODELOS - DE - INSTRUMENTOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'instrument_models' || $route_name_item == 'instrument_models')) active @endif">
                        <a class="menu-link" href="{{route('instrument_models.index')}}">
                            <span class="dot"></span>
                            <span class="title">MODELOS DE INSTRUMENTOS</span>
                        </a>
                    </li>

                    {{--SETORES - DE - INSTRUMENTOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'instrument_setors' || $route_name_item == 'instrument_setors')) active @endif">
                        <a class="menu-link" href="{{route('instrument_setors.index')}}">
                            <span class="dot"></span>
                            <span class="title">SETORES DE INSTRUMENTOS</span>
                        </a>
                    </li>

                    {{--MARCAS - MODELOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'brands' || $route_name_item == 'brands')) active @endif">
                        <a class="menu-link" href="{{route('brands.index')}}">
                            <span class="dot"></span>
                            <span class="title">MARCAS</span>
                        </a>
                    </li>


                    {{--NCM--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'ncms' || $route_name_item == 'ncms')) active @endif">
                        <a class="menu-link" href="{{route('ncms.index')}}">
                            <span class="dot"></span>
                            <span class="title">NCM</span>
                        </a>
                    </li>


                    {{--REGIOES--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'regions' || $route_name_item == 'regions')) active @endif">
                        <a class="menu-link" href="{{route('regions.index')}}">
                            <span class="dot"></span>
                            <span class="title">REGIÕES</span>
                        </a>
                    </li>

                    {{--SEGMENTOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'segments' || $route_name_item == 'segments')) active @endif">
                        <a class="menu-link" href="{{route('segments.index')}}">
                            <span class="dot"></span>
                            <span class="title">SEGMENTOS</span>
                        </a>
                    </li>


                    {{--GRUPOS--}}
                    <li class="menu-item @if($main_menu == 'settings' &&
                        ($submenu == 'groups' || $route_name_item == 'groups')) active @endif">
                        <a class="menu-link" href="{{route('groups.index')}}">
                            <span class="dot"></span>
                            <span class="title">GRUPOS</span>
                        </a>
                    </li>
                </ul>

            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | RH
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item @if(Menu::isMenu('human_resources')) active open @endif">
                <a class="menu-link open" href="#">
                    <span class="icon ti-id-badge"></span>
                    <span class="title">RH</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">


                    {{--GRUPOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('roles.index')}}">
                            <span class="dot"></span>
                            <span class="title"><del>GRUPOS</del></span>
                        </a>
                    </li>


                    {{--CLIENTE--}}
                    <li class="menu-item @if($main_menu == 'human_resources' &&
                        ($submenu == 'clients' || $route_name == 'clients.index')) active @endif">
                        <a class="menu-link" href="{{route('clients.index')}}">
                            <span class="dot"></span>
                            <span class="title">CLIENTES</span>
                        </a>
                    </li>


                    {{--FORNECEDOR--}}
                    <li class="menu-item @if($main_menu == 'human_resources' &&
                        ($submenu == 'providers' || $route_name == 'providers.index')) active @endif">
                        <a class="menu-link" href="{{route('providers.index')}}">
                            <span class="dot"></span>
                            <span class="title">FORNECEDORES</span>
                        </a>
                    </li>


                    {{--USUÁRIOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('users.index')}}">
                            <span class="dot"></span>
                            <span class="title">USUÁRIOS</span>
                        </a>
                    </li>

                </ul>

            </li>

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | OPERAÇÕES
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item @if(Menu::isMenu('transactions')) active open @endif">
                <a class="menu-link open" href="#">
                    <span class="icon ti-pulse"></span>
                    <span class="title">OPERAÇÕES</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">


                    {{--OP. TÉCNICAS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('technical_operations')}}">
                            <span class="dot"></span>
                            <span class="title">OP. TÉCNICAS</span>
                        </a>
                    </li>


                    {{--OP. COMERCIAIS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('comercial_operations')}}">
                            <span class="dot"></span>
                            <span class="title"><del>OP. COMERCIAIS</del></span>
                        </a>
                    </li>


                </ul>

            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | PEÇAS - PRODUTOS - SERVIÇOS
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item @if(Menu::isMenu('parts')) active open @endif">
                <a class="menu-link" href="#">
                    <span class="icon ti-package"></span>
                    <span class="title">SERVIÇOS - PRODUTOS</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">


                    {{--PEÇAS--}}
                    <li class="menu-item @if($main_menu == 'parts' &&
                        ($submenu == 'parts' || $route_name == 'parts.index' || $route_name == 'parts.edit')) active @endif">
                        <a class="menu-link" href="{{route('parts.index')}}">
                            <span class="dot"></span>
                            <span class="title">PEÇAS/PRODUTOS</span>
                        </a>
                    </li>

                    {{--PRODUTOS--}}
                    {{--<li class="menu-item @if($main_menu == 'parts' &&--}}
                    {{--($submenu == 'products' || $route_name == 'products.index')) active @endif">--}}
                    {{--<a class="menu-link" href="{{route('products.index')}}">--}}
                    {{--<span class="dot"></span>--}}
                    {{--<span class="title">PRODUTOS</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}


                    {{--SERVIÇOS--}}
                    <li class="menu-item @if($main_menu == 'parts' &&
                        ($submenu == 'services' || $route_name == 'services.index' || $route_name == 'services.edit')) active @endif">
                        <a class="menu-link" href="{{route('services.index')}}">
                            <span class="dot"></span>
                            <span class="title">SERVIÇOS</span>
                        </a>
                    </li>



                    {{--ESTOQUE - QTDA--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('stocks')}}">
                            <span class="dot"></span>
                            <span class="title"><del>ESTOQUE - QTDA</del></span>
                        </a>
                    </li>


                    {{--TABELAS DE ITENS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('item_tables')}}">
                            <span class="dot"></span>
                            <span class="title"><del>TABELAS DE ITENS</del></span>
                        </a>
                    </li>

                    <?php
                    /*

                    {{--EQUIPAMENTOS DE BKP--}}
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">EQUIPAMENTOS DE BKP</span>
                        </a>
                    </li>


                    {{--ESTOQUE--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('stocks')}}">
                            <span class="dot"></span>
                            <span class="title">ESTOQUE</span>
                        </a>
                    </li>


                    {{--REQUISIÇÕES--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requests')}}">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÕES</span>
                        </a>
                    </li>


                    {{--REQUISIÇÕES--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requests2')}}">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÕES 2</span>
                        </a>
                    </li>


                    {{--TABELAS--}}
                    <li class="menu-item @if($main_menu == 'parts' &&
                        ($submenu == 'prices' || $route_name == 'prices.index' || $route_name == 'prices.edit')) active @endif">
                        <a class="menu-link" href="{{route('prices.index')}}">
                            <span class="dot"></span>
                            <span class="title">* TABELAS</span>
                        </a>
                    </li>

                    */
                    ?>

                </ul>

            </li>

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | REQUISIÇÕES / PEDIDOS
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item @if(Menu::isMenu('requestions')) active open @endif">
                <a class="menu-link open" href="#">
                    <span class="icon ti-write"></span>
                    <span class="title">REQUISIÇÃO</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">

                    {{--PEDIDO CERTIFICADO DE PADRÕES--}}
                    <li class="menu-item @if(Menu::isRoute([
                            'requestions.patterns.index',
                            'requestions.patterns.create-by-due',
                            'requestions.patterns.create-by-buy',
                            'requestions.patterns.create-by-degradation',
                            'requestions.patterns.create-by-entity',
                            ])) active @endif">
                        <a class="menu-link" href="{{route('requestions.patterns.index')}}">
                            <span class="dot"></span>
                            <span class="title">REQUERIMENTO DE PADRÕES</span>
                        </a>
                    </li>


                    {{--PEDIDO PEÇAS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requestions.parts')}}">
                            <span class="dot"></span>
                            <span class="title"><del>PEDIDO PEÇAS</del></span>
                        </a>
                    </li>


                    {{--PEDIDO MATRIZ FORNECEDOR--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requestions.main_provider')}}">
                            <span class="dot"></span>
                            <span class="title"><del>PEDIDO MATRIZ FORNECEDOR</del></span>
                        </a>
                    </li>


                    {{--PEÇAS E PRODUTOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requestions.products')}}">
                            <span class="dot"></span>
                        <span class="title"><del>PEDIDO PRODUTOS</del></span>
                        </a>
                    </li>


                    {{--PEDIDO MARCAS REPARO--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requestions.labels.create')}}">
                            <span class="dot"></span>
                            <span class="title">PEDIDO MARCAS REPARO</span>
                        </a>
                    </li>


                    {{--PEDIDO LACRES--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('requestions.seals.create')}}">
                            <span class="dot"></span>
                            <span class="title">PEDIDO LACRES</span>
                        </a>
                    </li>


                </ul>

            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | CONTROLE DE PATRIMONIO
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon ti-write"></span>
                    <span class="title">CONTROLE DE PATRIMONIO</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu">


                    {{--PATRIMONIO PADROES--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('patrimonies.patterns')}}">
                            <span class="dot"></span>
                            <span class="title"><del>PADRÕES</del></span>
                        </a>
                    </li>


                    {{--PATRIMONIO PEÇAS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('patrimonies.parts')}}">
                            <span class="dot"></span>
                            <span class="title"><del>PEÇAS</del></span>
                        </a>
                    </li>


                    {{--PATRIMONIO PRODUTOS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('patrimonies.products')}}">
                            <span class="dot"></span>
                            <span class="title"><del>PRODUTOS</del></span>
                        </a>
                    </li>


                    {{--PATRIMONIO EQUIPAMENTO DE BKP--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('patrimonies.equipments')}}">
                            <span class="dot"></span>
                            <span class="title"><del>EQUIPAMENTO DE BKP</del></span>
                        </a>
                    </li>


                    {{--FERRAMENTAS--}}
                    <li class="menu-item">
                        <a class="menu-link" href="{{route('patrimonies.tools')}}">
                            <span class="dot"></span>
                            <span class="title"><del>FERRAMENTAS</del></span>
                        </a>
                    </li>


                </ul>

            </li>





            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | FROTAS
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon ti-harddrives"></span>
                    <span class="title">FROTAS</span>
                    <span class="arrow"></span>
                </a>

            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | FERRAMENTAS
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon ti-harddrives"></span>
                    <span class="title">FERRAMENTAS</span>
                    <span class="arrow"></span>
                </a>

            </li>

        </ul>
    </nav>

</aside>
<!-- END Sidebar -->
