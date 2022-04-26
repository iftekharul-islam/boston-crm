<div class="role-box view-role-{{ $role->id }}">
    <div class="d-flex justify-content-between mb-3">
        <p class="mb-0 text-light-black fs-20 fw-bold text-capitalize">{{ $role->name }}</p>
        <div class="d-flex align-items-center">
            @if($role->name !== 'admin')
                <span class="delete me-3"
                      data-id="{{ $role->id }}"
                      data-action="{{ route('roles.destroy',$role->id) }}"
                      onclick="deleteConfirmation({{$role->id}})">
                                    <span class="icon-trash fs-20"><span class="path1"></span><span
                                                class="path2"></span><span
                                                class="path3"></span><span class="path4"></span></span>
                                </span>
                <button class="edit-btn h-32 inline-flex-center"
                        onclick="editRoleView({{ $role->id }});">
                    {{ __('messages.edit') }}
                    <span class="icon-edit ms-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </span>
                </button>
            @endif
        </div>
    </div>
    <p class="text-light-black mgb-32">
        {{ $role->description ?? '' }}
    </p>
    @foreach($permissions as $permission)
        <div class="d-flex permission-check flex-wrap">
            <p class="mb-0 fw-bold text-light-black permission"><span
                        class="text-capitalize">{{ $permission }}</span>
                {{ __('messages.role_view.permission') }}</p>
            @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input" style="cursor: default;"
                           @if(in_array($permission_type. '.' . $permission, $permission_list)) checked
                           @endif disabled>
                    <label for="" class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
