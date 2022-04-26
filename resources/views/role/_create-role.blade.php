<form id="createRole" class="mb-4">
    <div class="role-add mgt-32 new-role">
        <div class="role-box">
            <div class="d-flex align-items-start justify-content-between">
                <div class="max-w-424 mgb-32">
                    <div class="mgb-20">
                        <input type="text" id="createName" class="dashboard-input w-100"
                               placeholder="Name here...">
                        <p class="text-danger createNameErrorMsg"></p>
                    </div>
                    <textarea id="createDescription" class="dashboard-textarea w-100" id="" cols="30" rows="2"
                              placeholder="Description here..."></textarea>
                    <p class="text-danger createDescriptionErrorMsg"></p>
                </div>
                <span class="delete" onclick="showNewRoleCreate();">
                            <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span
                                        class="path3"></span><span class="path4"></span>
                            </span>
                        </span>
            </div>
            @foreach($permissions as $permission)
                <div class="d-flex permission-check flex-wrap">
                    <p class="mb-0 fw-bold text-light-black permission"><span
                                class="text-capitalize">{{ $permission }}</span>
                        {{ __('messages.role_view.permission') }}</p>
                    @foreach(['view', 'create', 'update', 'delete'] as $permission_type)
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input check-data"
                                   name="create_permission"
                                   data-name="{{ $permission_type . '.' . $permission }}"
                                   data-model-name="{{ $permission }}"
                                   value="{{ $permission_type . '.' . $permission }}">
                            <label for="" class="checkbox-label text-capitalize">{{ $permission_type }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="text-end">
                <button class="button button-primary h-32 py-1 px-4">{{ __('messages.save') }}</button>
            </div>
        </div>
    </div>
</form>
