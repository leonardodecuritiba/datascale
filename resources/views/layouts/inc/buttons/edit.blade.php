{{--<a href="{{(isset($field_edit_route) ? $field_edit_route : route($Page->entity.'.edit',$sel['id']))}}"--}}
{{--class="btn btn-simple btn-info btn-xs btn-icon edit"--}}
{{--data-toggle="tooltip"--}}
{{--data-placement="top"--}}
{{--title="Editar"><i class="material-icons">edit</i></a>--}}

<a href="{{(isset($field_edit_route) ? $field_edit_route : route($Page->entity.'.edit',$sel['id']))}}"
   class="btn btn-square btn-xs btn-outline btn-info"
   data-toggle="tooltip"
   data-placement="top"
   data-action="edit{{isset($role_name)?'-'.$role_name:''}}"
   title="Editar"
   id="{{$sel['id']}}"
><i class="fa fa-edit"></i>
</a>