@canany(['dashboard.'.$entity.'.edit', 'dashboard.'.$entity.'.delete'])
<div class="dropdown d-inline-block">
    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri-more-fill align-middle"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end">
        @can('dashboard.'.$entity.'.edit')
            <li><a class="dropdown-item edit-item-btn" onclick="showEditModal({{ $value->id }})"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
{{--            <li><a class="dropdown-item edit-item-btn" href="{{ route("dashboard.$entity.edit", [ 'id' => $value->id]) }}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>--}}
        @endcan
        @can('dashboard.'.$entity.'.delete')
                <li>
                    <a class="dropdown-item remove-item-btn" onclick="singleDelete({{ $value->id }})">
                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                    </a>
                </li>
        @endcan
    </ul>
</div>
@endcanany