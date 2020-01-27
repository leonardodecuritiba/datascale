
<!-- Bootstrap Select Css -->
{{Html::style('bower_components/select2/dist/css/select2.css')}}
<style>
    span.select2-container{
        width: 100% !important;
    }

     select.form-control:not([size]):not([multiple]) {
         height: 36px;
     }
    .select2-container .select2-selection--single {
        border-color: #ebebeb;
        height: 36px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #8b95a5;
        padding-left: 15px;
        line-height: 36px;
    }

    .select2-selection__arrow {

        color: #ebebeb;
        margin-top: 4px;
    }
</style>
