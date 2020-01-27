
<!-- Select2 -->
{{Html::script('bower_components/select2/dist/js/select2.js')}}
{{Html::script('bower_components/select2/dist/js/i18n/pt-BR.js')}}
<script>
    $.fn.select2.defaults.set('language', 'pt-BR');
    $(document).ready(function () {
        $(".select2_single").select2({
            width: 'resolve'
        });
    });
</script>
