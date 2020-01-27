<!-- Sidebar -->
<aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-lg sidebar-expand-lg">
    <header class="sidebar-header">
        <a class="logo-icon" href="{{route('index')}}"><img src="{{asset('assets/images/logos/logo-w-p.png')}}"
                                                                  alt="logo icon"></a>
        <span class="logo">
          <a href="{{route('index')}}">
              {{ config('app.name', 'Datascale') }}
          </a>
        </span>
        <span class="sidebar-toggle-fold"></span>
    </header>

    <nav class="sidebar-navigation">
        <ul class="menu menu-xs">

            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">Inteligência</li>

            {{--Adm Franquia--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Franquia</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">

                    @role(['admin-office', 'admin-franchise', 'root'])
                        <li class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="dot"></span>
                                <span class="title">SCORE PRODUÇÃO</span>
                            </a>
                        </li>
                    @endrole
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">CONTAS A PAGAR E RECEBER</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">META DO MÊS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ALERTAS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">DIRETOR</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AGENDA</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">COMISSÃO</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÕES</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{--Adm Oficina--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Oficina</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">SCORE PRODUÇÃO</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">CONTAS A PAGAR E RECEBER</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">META DO MÊS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ALERTAS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">DIRETOR</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">COMISSÃO</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{--Téc. Franquia--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Téc. Franquia</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">SCORE PRODUÇÃO</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">CONTAS A PAGAR E RECEBER</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">META DO MÊS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ALERTAS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AGENDA</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">COMISSÃO</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÃO DA MATRIZ</span>
                        </a>
                    </li>

                </ul>
            </li>


            {{--Téc. Oficina--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Téc. Oficina</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">SCORE PRODUÇÃO</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">META DO MÊS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ALERTAS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÃO DA MATRIZ</span>
                        </a>
                    </li>

                </ul>
            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">Comunicação</li>

            {{--CHAMADOS--}}
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-folder-open"></span>
                    <span class="title">CHAMADOS</span>
                </a>
            </li>

            {{--CHAT--}}
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-folder-open"></span>
                    <span class="title">CHAT</span>
                </a>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">GESTÃO DE RECURSOS</li>

            {{--Adm Franquia--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Franquia</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">IPEM</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">APIs</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">VEÍCULOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">FERRAMENTAS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">LOGISTICA</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">VOID</span>
                        </a>
                    </li>


                </ul>
            </li>

            {{--Adm Oficina--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Oficina</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">IPEM</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">APIs</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">VEÍCULOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">FERRAMENTAS</span>
                        </a>
                    </li>


                </ul>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">RH</li>

            {{--Adm Franquia--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Franquia</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AJUSTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">CLIENTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">FORNECEDOR</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">USUÁRIOS</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{--Adm Oficina--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Oficina</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AJUSTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">CLIENTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">FORNECEDOR</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">USUÁRIOS</span>
                        </a>
                    </li>

                </ul>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->


            <li class="menu-category">PEÇAS - PRODUTOS - SERVIÇOS</li>

            {{--Adm Franquia--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Franquia</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AJUSTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">PEÇAS</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">PRODUTOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">SERVIÇOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ESTOQUE</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">EQUIPAMANTOS DE BKP</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÕES</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{--Adm Oficina--}}
            <li class="menu-item">
                <a class="menu-link open" href="#">
                    <span class="icon fa fa-tv"></span>
                    <span class="title">Adm Oficina</span>
                    <span class="arrow"></span>
                </a>

                <ul class="menu-submenu" style="display: block;">
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">AJUSTE</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">PEÇAS</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">PRODUTOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">SERVIÇOS</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">ESTOQUE</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">EQUIPAMANTOS DE BKP</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a class="menu-link" href="#">
                            <span class="dot"></span>
                            <span class="title">REQUISIÇÕES</span>
                        </a>
                    </li>

                </ul>
            </li>




            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->


            <li class="menu-category">OPERAÇÕES</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. TÉCNICAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. COMERCIAIS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">PEDIDOS FORNECEDOR</span>
                </a>
            </li>


            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">FINANCEIRO</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">CONTAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">FISCAL</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">FATURAMENTO</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">TABELAS DE PREÇO</span>
                </a>
            </li>




            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">OPERAÇÕES TEC. FRANQUIA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. TÉCNICAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. COMERCIAIS</span>
                </a>
            </li>




            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">OPERAÇÕES TEC. OFICINA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. TÉCNICAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">OP. COMERCIAIS</span>
                </a>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">PEÇAS - PRODUTOS - SERVIÇOS TEC. FRANQUIA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">TABELAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">ESTOQUE DE PEÇAS - PRODUTOS</span>
                </a>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">PEÇAS - PRODUTOS - SERVIÇOS TEC. OFICINA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">TABELAS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">ESTOQUE DE PEÇAS - PRODUTOS</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">ESTOQUE DE PEÇAS USADAS</span>
                </a>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">REQUISIÇÕES \ PEDIDOS TEC. FRANQUIA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">SELOS E LACRES</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">PEÇAS - PRODUTOS REPARO</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">PEÇAS - PRODUTO COMPRA</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">EQUIPAMANTOS DE BKP</span>
                </a>
            </li>



            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Zero configuration
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            !-->

            <li class="menu-category">REQUISIÇÕES \ PEDIDOS TEC. OFICINA</li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">SELOS E LACRES</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">EQUIPAMANTOS DE BKP</span>
                </a>
            </li>

            <li class="menu-item">
                <a class="menu-link" href="#">
                    <span class="icon fa fa-tasks"></span>
                    <span class="title">PEÇAS - PRODUTOS</span>
                </a>
            </li>




        </ul>
    </nav>

</aside>
<!-- END Sidebar -->
