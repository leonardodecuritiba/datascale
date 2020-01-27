<script>
    function removeDataTableByAjax($el) {
        if($($el).data('refresh')){
            window.location.href = $($el).data('href');
            return false;
        }

        $.ajax({
            url: $($el).data('href'),
            type: 'post',
            data: {"_method": 'delete', "_token": "{{ csrf_token() }}"},
            dataType: "json",

            beforeSend: function () {
                loadingCard('show',$el);
            },
            error: function (xhr, textStatus) {
                loadingCard('hide', $el);
                console.log('xhr-error: ' + xhr);
                console.log('textStatus-error: ' + textStatus);
            },
            /**/
            success: function (json) {
                loadingCard('hide', $el);
                console.log(json);
                // return false;
                if(json){
                    if($($el).data('alert')){
                        swal(
                            "",
                            "<b>" + $($el).data('entity') + "</b> removido (a) com sucesso!",
                            "success"
                        )
                    }
                    var $_table_ = $($el).parents('table').DataTable();
                    $_table_
                        .row($($el).parents('tr'))
                        .remove()
                        .draw();
                } else {
                    swal(
                        "",
                        "<b>Erro!</b> Nenhuma alteração realizada",
                        "error"
                    )
                }
            }
        });
    }



    function showDeleteTableMessage($el) {
        var entity = $($el).data('entity');

        if($($el).data('alert')){
            swal({
                title: "Você tem certeza?",
                text: "Esta ação será irreversível!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
//            confirmButtonText: "<i class='em em-triumph'></i> Sim! ",
//            cancelButtonText: "<i class='em em-cold_sweat'></i> Não, cancele por favor! ",
                confirmButtonText: "Sim! ",
                cancelButtonText: "Não, cancelar! "
            }).then(
                function (isConfirm) {
                    if (typeof isConfirm.dismiss == 'undefined') {
                        removeDataTableByAjax($el);
                    } else {
                        swal(
                            "Cancelado",
                            "Nenhuma alteração realizada!",
                            //                    "<i class='em em-heart_eyes'></i>",
                            //                    "Ufa, <b>" + entity + "</b> está a salvo :)",
                            "error"
                        )
                    }
                }
            );
        } else {
            removeDataTableByAjax($el);
        }

    }
</script>
