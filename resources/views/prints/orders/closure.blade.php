<tr>
    <td colspan="7" style="height: 3px !important;">
        <table border="1" class="table table-condensed table-bordered">
            <tr class="fundo_titulo">
                <th class="linha_titulo" colspan="8">FECHAMENTO DE VALORES</th>
            </tr>

            <?php $services = $Order->getServicesClosure(); ?>
            @if($services->count())
                <?php $total = DataHelper::getFloat2Currency($services->sum('total')); ?>
                @include('prints.orders.services')
            @endif

	        <?php $parts = $Order->getPartsClosure(); ?>
            @if($parts->count())
		        <?php $total = DataHelper::getFloat2Currency($parts->sum('total')); ?>
                @include('prints.orders.parts')
            @endif

            <tr class="fundo_titulo_3">
                <th class="linha_titulo" colspan="8">OUTROS</th>
            </tr>
            <tr class="campo">
                <th colspan="7">DESCRIÇÃO</th>
                <th>V. TOTAL</th>
            </tr>
            <tr>
                <td colspan="7">Deslocamento</td>
                <td class="valor">{{$Order->getTravelCostFormatted()}}</td>
            </tr>
            <tr>
                <td colspan="7">Pedágios</td>
                <td class="valor">{{$Order->getTollsFormatted()}}</td>
            </tr>
            <tr>
                <td colspan="7">Outros Custos</td>
                <td class="valor">{{$Order->getOtherCostFormatted()}}</td>
            </tr>
            <tr>
                <td colspan="7">Descontos</td>
                <td class="valor">{{$Order->getDiscountTecFormatted()}}</td>
            </tr>
            <tr>
                <td colspan="7">Acréscimos</td>
                <td class="valor">{{$Order->getIncreaseTecFormatted()}}</td>
            </tr>
            <tr>
                <th colspan="7">Total da Ordem de Serviço</th>
                <th class="valor">{{$Order->getFinalValueFormatted()}}</th>
            </tr>
        </table>
    </td>
</tr>


