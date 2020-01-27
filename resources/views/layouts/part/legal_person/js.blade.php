
<script>
    function toggleType(val) {
        if (val == "1") {
            $('input[name="type"]#pj').prop('checked', true);
            $('section.section-pf').hide();
            $('section.section-pj').fadeIn('fast');
            $('section.section-pj').find('input').not("input#exemption_ie,input#ie").attr('required', true);
            $('section.section-pf').find('input').attr('required', false);
        } else {
            $('input[name="type"]#pf').prop('checked', true);
            $('section.section-pj').hide();
            $('section.section-pf').fadeIn('fast');
            $('section.section-pf').find('input').attr('required', true);
            $('section.section-pj').find('input').attr('required', false);
        }
    }

    $(document).ready(function () {
        $('input[name="type"]').change(function () {
            toggleType($(this).val());
        });
        var type = '{{isset($Data) ? $Data->isLegalPerson() : 1}}';
        toggleType(type);
    });

</script>

<script>

    $(function(){
        $('#exemption_ie').bind('click', function(){
            if($('input#exemption_ie:checked').val()!='on'){
                $('input#ie').attr('disabled', 'disabled');
                $('input#ie').val(null);
            }else{
                $('input#ie').removeAttr('disabled');
            }
        });
    });

</script>