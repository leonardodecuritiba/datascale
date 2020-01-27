@role(['admin','tecnico','tech-franchise'])

@role(['admin'])

<a class="nav-link @if(Menu::isRoute('certificates.create')) active @endif"
   href="{{route('certificates.create')}}">CADASTRO CERTIFICADO</a>

<a class="nav-link @if(Menu::isRoute('certificates.recreate')) active @endif"
   href="{{route('certificates.recreate')}}">RECERTIFICAÇÃO</a>

<a class="nav-link" href="#">BAIXAR RASTREIO</a>

@endrole

<a class="nav-link @if(Menu::isRoute('certificates.requests')) active @endif"
   href="{{route('certificates.requests')}}">REQUISIÇÕES DE PADRÕES</a>

<a class="nav-link @if(Menu::isRoute(['certificates.index','certificates.edit',])) active @endif"
   href="{{route('certificates.index')}}">LISTAR - EDITAR</a>

@endrole