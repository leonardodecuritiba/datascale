<tr>
    <td colspan="7" style="height: 3px !important;">
        <table class="table table-condensed table-bordered">
            @if($Apparatu->has_instrument())
                @include('prints.orders.instrument')
            @else
                @include('prints.orders.equipment')
            @endif
            @if($Apparatu->call_number != NULL)
                <tr class="campo">
                    <td colspan="2">NÚMERO CHAMADO CLIENTE</td>
                    <td colspan="3">DEFEITO</td>
                    <td colspan="3">SOLUÇÃO</td>
                </tr>
                <tr>
                    <td colspan="2">{{$Apparatu->call_number}}</td>
                    <td colspan="3">{{$Apparatu->defect}}</td>
                    <td colspan="3">{{$Apparatu->solution}}</td>
                </tr>
            @else
                <tr class="campo">
                    <td colspan="4">DEFEITO</td>
                    <td colspan="4">SOLUÇÃO</td>
                </tr>
                <tr>
                    <td colspan="4">{{$Apparatu->defect}}</td>
                    <td colspan="4">{{$Apparatu->solution}}</td>
                </tr>
            @endif
        </table>
    </td>
</tr>
<tr>
    <td colspan="7" style="height: 3px !important;">
        <table border="1" class="table table-condensed table-bordered">
            <?php $services = $Apparatu->apparatu_services; ?>

            @if($services->count())
                <?php $total = $Apparatu->getTotalServicesFormatted(); ?>

                @include('prints.orders.services')
            @endif

            <?php $parts = $Apparatu->apparatu_parts; ?>

            @if($parts->count())
                <?php $total = $Apparatu->getTotalPartsFormatted();?>

                @include('prints.orders.parts')
            @endif

        </table>
    </td>
</tr>