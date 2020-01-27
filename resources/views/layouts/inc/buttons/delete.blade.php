<button data-href="{{(isset($field_delete_route) ? $field_delete_route : route($Page->entity.'.destroy',$sel['id']))}}"
        data-refresh="{{(isset($refresh) ? $refresh : 0)}}"
        data-alert="{{(isset($alert) ? $alert : 1)}}"
        class="btn btn-square btn-xs btn-outline btn-danger"
        onclick="showDeleteTableMessage(this)"
        type="button"
        data-entity="{{(isset($field_delete) ? $field_delete : $Page->name).': '.$sel['name']}}"><i
            class="fa fa-trash"></i></button>
