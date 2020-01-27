{{--Picture--}}
@if(isset($Data) && $Data->hasPicture())
    <div class="form-row">

        <div class="col-md-3" data-provide="photoswipe">
            <a href="#">
                <img style="max-height: 240px;" class="img-fluid" data-original-src="{{$Data->getFileView()}}" src="{{$Data->getFileView()}}">
            </a>
        </div>

        <div class="form-group col-md-9">
            {!! Html::decode(Form::label('picture', 'Alterar Foto <i class="fa fa-question-circle"
                data-provide="tooltip"
                data-placement="right"
                data-tooltip-color="primary"
                data-original-title="'.config('system.pictures.message').'"></i>', array('class' => 'col-form-label'))) !!}
            <input name="picture" type="file" data-provide="dropify">
        </div>
    </div>
@else
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('picture', 'Foto <i class="fa fa-question-circle"
                data-provide="tooltip"
                data-placement="right"
                data-tooltip-color="primary"
                data-original-title="'.config('system.pictures.message').'"></i>', array('class' => 'col-form-label'))) !!}
            <input name="picture" type="file" data-provide="dropify">
        </div>
    </div>

@endif