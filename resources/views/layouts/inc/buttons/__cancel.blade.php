<button data-href="{{(isset($field_cancel_route) ? $field_cancel_route : route($Page->entity.'.cancel',$sel['id']))}}"
        data-refresh="{{(isset($refresh) ? $refresh : 1)}}"
        class="btn btn-square btn-outline btn-danger"
        onclick="showDeleteTableMessage(this)"
        type="button"
        data-entity="{{(isset($field_cancel) ? $field_cancel : $Page->name).': '.$sel['name']}}">
    <i class="fa fa fa-ban"></i></button>