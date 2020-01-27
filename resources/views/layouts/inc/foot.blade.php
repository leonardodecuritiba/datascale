<!-- Scripts -->
<script>

    var $_LOADING_ = {};
    var $_TABLE_ = {};
    var $_DATATABLE_OPTIONS_ = {
        "dom": 'Bfrtip',
        "responsive": true,
        "buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json"
        },
        "pageLength": 10,
        "order": [2, "asc"]
    };

    function loadingCard(type, $this){
        var $field = $($this).closest('.card-content, .modal-content').next();
        if (type == 'show') {
            $_LOADING_ = $($field).addClass('reveal');
        } else {
            $_LOADING_ = $($field).removeClass('reveal');
        }
    }
</script>
{{--{{Html::script('assets/vendor/bootstrap-validator/pt_BR.js')}}--}}