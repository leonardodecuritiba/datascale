
<script>
    $_URL_CHANGE_PART_PRICE_ = '{{route('prices.parts.update')}}';
    $_URL_CHANGE_SERVICE_PRICE_ = '{{route('prices.services.update')}}';
    $(document).ready(function(){
        $("div#changePrice").on("show.bs.modal", function (event) {
            var $button = $(event.relatedTarget);
            var json = $($button).data('json');
            var type = $($button).data('type');

            console.log(json);
            if(type == 'service'){
                $(this).find('form').attr('action', $_URL_CHANGE_PART_PRICE_);
            } else {
                $(this).find('form').attr('action', $_URL_CHANGE_SERVICE_PRICE_);
            }

            var $parent = $(this).find('div.modal-body');
            $($parent).find('span#part-name').html($($button).parents('tr').find('td.data-name').clone());
            $($parent).find('span#part-price').html(json.original_price_formatted);

            $($parent).find('input[name=id]').val(json.id);
            $($parent).find('input[name=price]').val(json.price_formatted);
            $($parent).find('input[name=range]').val(json.range_formatted);
            $($parent).find('input[name=price_min]').val(json.price_min_formatted);
            $($parent).find('input[name=range_min]').val(json.range_min_formatted);

            /*
            $loading_modal = $(this).find('div.loading');
            $($loading_modal).show();
            */
            {{--$.ajax({--}}
            {{--url: "{{route('get_sintegra_params')}}",--}}
            {{--type: 'GET',--}}
            {{--dataType: "json",--}}
            {{--error: function (xhr, textStatus) {--}}
            {{--console.log('xhr-error: ' + xhr.responseText);--}}
            {{--console.log('textStatus-error: ' + textStatus);--}}
            {{--},--}}
            {{--success: function (result) {--}}
            {{--console.log(result);--}}
            {{--$($loading_modal).hide();--}}
            {{--$($parent).find("img").attr("src", result.captchaBase64);--}}
            {{--$($parent).find("input[name=paramBot]").val(result.paramBot);--}}
            {{--$($parent).find("input[name=cookie]").val(result.cookie);--}}
            {{--}--}}
            {{--});--}}
        });
    })
</script>