    <!-- Main container -->
    <div class="main-content" id="main-content_equipments">
        <!--
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Zero configuration
        |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        !-->
        {{--<button type="button" id="create_button_equipments" class="btn btn-outline btn-purple col-lg-4 offset-lg-8">--}}
            {{--{{trans('pages.view.CREATE', [ 'name' => 'Equipamento' ])}}--}}
        {{--</button>--}}
        <div class="card">
            <h4 class="card-title"><strong>{{count($prices)}}</strong> Registros</h4>

            <div class="card-content">
                <div class="card-body">

                    <table class="table table-striped table-bordered" cellspacing="0" data-provide="datatables">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tabela</th>
                            <th>Margem</th>
                            <th>Preço Venda</th>
                            <th>Margem Mínima</th>
                            <th>Preço Venda Mínimo</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tabela</th>
                            <th>Margem</th>
                            <th>Preço Venda</th>
                            <th>Margem Mínima</th>
                            <th>Preço Venda Mínimo</th>
                            <th>Ações</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($prices as $sel)
                            <tr>
                                <td>{{$sel['id']}}</td>
                                <td>{{$sel->getPriceTableName()}}</td>
                                <td data-order="{{$sel['range']}}">{{$sel['range_formatted']}}</td>
                                <td data-order="{{$sel['price']}}">{{$sel['price_formatted']}}</td>
                                <td data-order="{{$sel['range_min']}}">{{$sel['range_min_formatted']}}</td>
                                <td data-order="{{$sel['price_min']}}">{{$sel['price_min_formatted']}}</td>
                                <td></td>
                                {{--<td>--}}
                                    {{--@include('layouts.inc.buttons.active',['active'=>$sel['active']])--}}
                                    {{--@include('layouts.inc.buttons.edit',[--}}
                                        {{--'field_edit_route'=> '#',--}}
                                        {{--'role_name' => 'equipment'--}}
                                    {{--])--}}
                                    {{--@include('layouts.inc.buttons.delete',['field_delete_route' => '/ajax/settings/equipments/'.$sel['id'],'field_delete'=>'Equipment'])--}}
                                {{--</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div><!--/.main-content -->

@section('script_content')
    @include('layouts.inc.active.js')

    <!-- Sample data to populate jsGrid demo tables -->
    @include('layouts.inc.datatable.js')

@endsection