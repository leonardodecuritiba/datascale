
<a class="nav-link @if(Menu::isRoute('billings.clients.report')) active @endif" href="{{route('billings.clients.report')}}">RELATÓRIO</a>
<a class="nav-link @if(Menu::isRoute('billings.clients.index')) active @endif" href="{{route('billings.clients.index')}}">PARCIAL MATRIZ</a>
<a class="nav-link @if(Menu::isRoute('billings.clients.cost_center')) active @endif" href="{{route('billings.clients.cost_center')}}">PARCIAL MATRIZ CENTRO DE CUSTO</a>
<a class="nav-link" href="#">
    <del>PÓS FECHAMENTO</del>
</a>
<a class="nav-link" href="#">
    <del>DIRETO FRANQUEADO</del>
</a>