
{!! Html::script('bower_components/jquery-mask-plugin/dist/jquery.mask.min.js') !!}
{!! Html::script('bower_components/jquery-maskmoney/dist/jquery.maskMoney.min.js') !!}
<script type="text/javascript">
    

    function initMaskMoneyValorReal(selector) {
        $(selector).maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    function initMaskMoneyValorRealFixado(selector) {
        $(selector).maskMoney({
            prefix: 'R$ ',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: true
        });
    }
    function initMaskInt(selector) {
        $(selector).mask('#', {reverse: true});
    }

    function initMaskFloat(selector) {
        $(selector).mask('#.##0,00', {reverse: true});
    }
    function initMaskPercent(selector) {
        $(selector).maskMoney({
            suffix: ' %',
            allowNegative: false,
            allowZero: true,
            thousands: '.',
            decimal: ',',
            affixesStay: false
        });
    }
    

    
    $(document).ready(function () {
        initMaskMoneyValorReal($(".show-price"));
    });
    $(document).ready(function () {
        initMaskMoneyValorRealFixado($(".show-fixed-price"));
    });
    $(document).ready(function () {
        initMaskInt($(".show-int"));
    });
    $(document).ready(function () {
        initMaskFloat($(".show-float"));
    });
    $(document).ready(function () {
        initMaskPercent($(".show-percent"));
    });
</script>