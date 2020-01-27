<script>
    $_INPUT_STATE_ = 'select#select-state';
    $_INPUT_CITY_ = 'select#select-city';
    $(document).ready(function(){
        // $($_INPUT_STATE_).selectpicker();
        // $($_INPUT_CITY_).selectpicker();
        $($_INPUT_STATE_).change(function(){
            var $this = $_INPUT_STATE_;
            $($_INPUT_CITY_).empty();
            $($_INPUT_CITY_).append("<option value=''>Escolha a Cidade</option>");
            // $($_INPUT_CITY_).val('').selectpicker('render');
            if($($_INPUT_STATE_).val() == ""){
                return false;
            }
//            console.log($(this).val());


            $.ajax({
                url: '{{route('ajax.get.state-city')}}',
                data: {id : $($_INPUT_STATE_).val()},
                type: 'GET',
                dataType: "json",
                beforeSend: function (xhr, textStatus) {
                    // loadingCard('show',$_INPUT_STATE_);
                },
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                    // loadingCard('hide',$_INPUT_STATE_);
                },
                success: function (json) {
//                    console.log(json);
                    $(json).each(function(i,v){
                        $($_INPUT_CITY_).append('<option value="' + v.id + '">' + v.name + '</option>')
                    });

                    if(_CITY_ID_ != ''){
                        $($_INPUT_CITY_).val(_CITY_ID_).change();
                    }
                    // $($_INPUT_CITY_).selectpicker("refresh");
                    // $_LOADING_.waitMe('hide');
                }
            });
        })

        // $($_INPUT_STATE_).

        if(_STATE_ID_ != ''){
            $($_INPUT_STATE_).val(_STATE_ID_).change();
        }
    })
</script>