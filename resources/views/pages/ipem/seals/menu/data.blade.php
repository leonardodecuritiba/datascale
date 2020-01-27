@role(['admin'])

<a class="nav-link @if(Menu::isRoute('seals.create')) active @endif"
   href="{{route('seals.create')}}">Entrada</a>

<a class="nav-link"
   href="#">
    <del>REQUISIÇAO FORNECEDOR</del>
</a>

<a class="nav-link"
   href="#">
    <del>REDIRECIONAMENTO</del>
</a>

<a class="nav-link"
   href="#">
    <del>BLOQUEIO</del>
</a>

@endrole

<a class="nav-link @if(Menu::isRoute('seals.index')) active @endif"
   href="{{route('seals.index')}}">Rastreio</a>
<a class="nav-link @if(Menu::isRoute('seals.tracking')) active @endif"
   href="{{route('seals.tracking')}}">Requisição de Técnicos</a>