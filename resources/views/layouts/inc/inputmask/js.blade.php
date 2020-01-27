
{!! Html::script('bower_components/inputmask/dist/min/inputmask/inputmask.min.js') !!}
{!! Html::script('bower_components/inputmask/dist/min/jquery.inputmask.bundle.min.js') !!}
{{--PACIENTES--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('.show-cpf').inputmask({'mask': '999.999.999-99', 'removeMaskOnSubmit': true});
        $('.show-credit-card').inputmask({'mask': '9999 9999 9999 9999', 'removeMaskOnSubmit': true});
        $('.show-rg').inputmask({'mask': '99.999.999-9', 'removeMaskOnSubmit': true});
        $('.show-celular, .show-cellphone').inputmask({'mask': '(99) 99999-9999', 'removeMaskOnSubmit': true});
        $('.show-telefone, .show-phone').inputmask({'mask': '(99) 9999-9999', 'removeMaskOnSubmit': true});
        $('.show-cep').inputmask({'mask': '99999-999', 'removeMaskOnSubmit': true});
        $('.show-cnpj').inputmask({'mask': '99.999.999/9999-99', 'removeMaskOnSubmit': true});
        
        $('.show-ie').inputmask({'mask': '999.999.999.999', 'removeMaskOnSubmit': true});
        $('.show-date').inputmask({ alias: "date", 'removeMaskOnSubmit': true});
        // $('.show-date-year').inputmask({alias: "date", 'removeMaskOnSubmit': true, placeholder: "y", yearrange: { minyear: 1900, maxyear: (new Date()).getFullYear() }});
        $('.show-date-month').inputmask("99", { 'removeMaskOnSubmit': true, postValidation: function (buffer, opts) {
                var txt = buffer.join('');
                if(txt == '00') return false;

                var _date = parseInt(txt);
                console.log(_date)
                return  (_date >= 0 && _date <= 12);
            } });
        $('.show-date-year').inputmask("9999", { 'removeMaskOnSubmit': true, postValidation: function (buffer, opts) {
                var _date = parseInt(buffer.join(''));
                var _now = (new Date()).getFullYear();
                return  (_date <= _now + 20);
            } });
        $('.show-only-numbers').inputmask({ regex: "\\d*", 'removeMaskOnSubmit': true});
        

    });
</script>