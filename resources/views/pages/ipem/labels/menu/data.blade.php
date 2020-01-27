@role(['admin'])

<a class="nav-link @if(Menu::isRoute('labels.create')) active @endif"
   href="{{route('labels.create')}}">Entrada</a>

<a class="nav-link"
   href="#">
    <del>Requisição IPEM</del>
</a>

<a class="nav-link"
   href="#">
    <del>REDIRECIONAMENTO</del>
</a>

<a class="nav-link"
   href="#">
    <del>BLOQUEIO</del>
</a>

<a class="nav-link"
   href="#">
    <del>EXPORTA PORTAL PSI</del>
</a>

@endrole

<a class="nav-link @if(Menu::isRoute('labels.tracking')) active @endif"
   href="{{route('labels.tracking')}}">Requisição de Técnicos</a>

<a class="nav-link @if(Menu::isRoute('labels.index')) active @endif"
   href="{{route('labels.index')}}">Rastreio</a>