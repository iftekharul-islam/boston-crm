<div class="role-box role-edit-{{ $role->id }} d-none">
    <h2>{{ __('messages.role_view.update_role') }}</h2>
    <div class="d-flex align-items-start justify-content-between">
        <div class="max-w-424 mgb-32">
            <div class="mgb-20">
                <input type="text" id="updateName{{ $role->id }}" class="dashboard-input w-100"
                       value="{{ $role->name }}"
                       placeholder="Name here...">
                <p class="text-danger updateNameErrorMsg{{ $role->id }}"></p>
            </div>
            <textarea id="updateDescription{{ $role->id }}" class="dashboard-textarea w-100" id="" cols="30"
                      rows="2"
                      placeholder="Description here..."> {{ $role->description }} </textarea>
            <p class="text-danger updateDescriptionErrorMsg{{ $role->id }}"></p>
        </div>
    </div>
    @foreach($permissions as $permission)
        <div class="d-flex permission-check flex-wrap">
            <p class="mb-0 fw-bold text-light-black permission"><span
                        class="text-capitalize">{{ $permission }}</span>
                {{ __('messages.role_view.permission') }}</p>
            @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                <div class="checkbox-group">
                    <input type="checkbox" class="checkbox-input check-data-{{ $role->id }} edit-data-{{ $role->id }}"
                           onclick="editRoleCheck({{ $role->id }});"
                           name="update_permission_{{ $role->id }}"
                           data-name="{{ $permission_type . '.' . $permission }}"
                           data-model-name="{{ $permission }}"
                           value="{{ $permission_type . '.' . $permission }}"
                           @if(in_array($permission_type. '.' . $permission, $permission_list)) checked @endif>
                    <label for=""
                           class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="text-end">
        <button type="button" class="button button-primary h-32 py-1 px-4" onclick="updateRole({{ $role->id }})">{{ __('messages.update') }}</button>
    </div>
</div>
