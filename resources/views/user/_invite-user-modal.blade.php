<!-- Modal -->
<div class="modal fade user-modal" id="userInviteModal" tabindex="-1" aria-labelledby="userInviteModalLabel"
     aria-hidden="true">
    <div class="user-dialog modal-dialog modal-dialog-centered">
        <div class="modal-content user-content">
            <h4 class="mgb-32 fw-bold fs-20">{{ __('messages.user_view.add_user') }}</h4>
            <div class="modal-body p-0 mgb-24">
                <div class="group">
                    <label for="role"
                           class="d-block text-light-black mb-2">{{ __('messages.user_view.role_name') }}</label>
                    <div class="position-relative">
                        <select name="role" id="role" class="login-input w-100 role-error">
                            <option value="">Please select role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                        class="text-capitalize">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="icon-arrow-down bottom-arrow-icon"></span>
                    </div>
                    <span id="roleErrorMsg" class="error"></span>
                </div>
                <div class="group">
                    <label for="" class="d-block mb-2 dashboard-label">{{ __('messages.email') }}</label>
                    <input type="email" name="email" id="email" class="login-input w-100 email-error">
                    <span id="emailErrorMsg" class="error"></span>
                </div>
            </div>
            <div class="footer d-flex align-items-center justify-content-end">
                <button type="button" class="button button-transparent"
                        data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                <button type="button" class="button button-primary px-5 py-2 h-40"
                        onclick="inviteUser();">{{ __('messages.user_view.invite') }}</button>
            </div>
        </div>
    </div>
</div>
