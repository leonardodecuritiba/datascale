@extends('layout.app')

@section('title', $Page->title)

@section('page_header-title',   $Page->title)

@section('page_header-subtitle',  $Page->subtitle)

@section('page_content')

    <div class="main-content">

<!--
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
| Zero configuration
|‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
!-->
        <div class="card">
            <h4 class="card-title"><strong>{{count($Page->response)}}</strong> {{$Page->names}}</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered table-responsive-sm" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Data</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($Page->response as $sel)
                            <tr @if($sel['read_at'] != NULL) class="bg-pale-success" @endif>
                                <td data-order="{{$sel['created_at_time']}}">{{DataHelper::getFullPrettyDateTime($sel['created_at'])}}</td>
                                <td>{{$sel->data['title']}}</td>
                                <td>{{$sel->data['description']}}</td>
                                <td>
                                    @if($sel['read_at'] == NULL)
                                        <button data-href="{{ route('ajax.human_resources.notification.read',$sel['id'])}}"
                                           class="btn btn-square btn-outline btn-info"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="Marcar como lida"
                                           onclick="readNotification(this)"
                                           id="{{$sel['id']}}"
                                        >
                                            <i class="ti ti-check-box"></i>
                                        </button>
                                    @endif

                                    @include('layout.inc.buttons.delete',['alert' => 0])

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('layout.inc.loading')
        </div>
    </div><!--/.main-content -->

@endsection

@section('script_content')
{{--    @include('admin.layout.inc.active.js')--}}

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layout.inc.datatable.js')

    @include('layout.inc.sweetalert.js')
<script>
    function readNotification($el) {

        $.ajax({
            url: $($el).data('href'),
            type: 'POST',
            data: {"_method": 'POST', "_token": "{{ csrf_token() }}"},
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
                    $($el).closest('tr').addClass('bg-pale-success');
                    $($el).remove();
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
</script>

@endsection
