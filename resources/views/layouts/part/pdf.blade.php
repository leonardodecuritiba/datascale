{{--Picture--}}
@if(isset($Data) && $Data->hasFile())
    <div class="form-row">

        <div class="col-md-1">
            <a class="btn btn-float btn-info" href="{{$Data->getFileView()}}" target="_blank"><i
                        class="ti-file"></i></a>
        </div>

        <div class="form-group col-md-11">
            {!! Html::decode(Form::label('file', 'PDF do certificado original <i class="fa fa-question-circle"
                data-provide="tooltip"
                data-placement="right"
                data-tooltip-color="primary"
                data-original-title="'.config('system.pdfs.message').'"></i>', array('class' => 'col-form-label'))) !!}
            <input name="file" type="file" data-provide="dropify">
        </div>
    </div>
@else
    <div class="form-row">
        <div class="form-group col-md-12">
            {!! Html::decode(Form::label('file', 'PDF do certificado original <i class="fa fa-question-circle"
                data-provide="tooltip"
                data-placement="right"
                data-tooltip-color="primary"
                data-original-title="'.config('system.pdfs.message').'"></i>', array('class' => 'col-form-label'))) !!}
            <input name="file" type="file" data-provide="dropify">
        </div>
    </div>

@endif
