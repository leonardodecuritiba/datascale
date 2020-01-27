
    <!-- Main container -->
<div class="main-content">


@include('layouts.inc.alerts')

<!--
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    | Zero configuration
    |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
    !-->
    <button type="button" id="back_button_instrument" class="btn btn-outline btn-purple col-lg-4 offset-lg-8">
        Voltar
    </button>
    <div class="card">

        @if(isset($Data))
            {{Form::model($Data,
            array(
                'route' => ['clients.store', $Data->id],
                'method'=>'PATCH',
                'data-provide'=> "validation",
                'data-disable'=>'false'
            )
            )}}
        @else
            {{Form::open(array(
                'route' => ['clients.store'],
                'method'=>'POST',
                'data-provide'=> "validation",
                'data-disable'=>'false'
            )
            )}}
        @endif
            @include('pages.human_resources.clients.instruments.form.data')
        {{Form::close()}}
    </div>


</div><!--/.main-content -->

   