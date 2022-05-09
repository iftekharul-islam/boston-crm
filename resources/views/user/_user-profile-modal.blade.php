<div id="userProfile{{ $user->id }}" class="modal fade user-prev" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered user-prev__dialog">
        <div class="modal-content user-prev__content">
                <button type="button" class="btn close close-btn" data-dismiss="modal" onclick="profileModalClose({{ $user->id }});">
                    <span class="icon-close-circle fs-24"><span class="path1"></span><span class="path2"></span></span>
                </button>
                <div class="user-prev-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="fs-20 fw-bold text-light-black mgb-20">User details</h4>
                            <div class="user-prev-img">
                                <img src="{{ $user->getMedia('profiles')[0] ?? false ? asset($user->getMedia('profiles')[0]->getUrl()) : asset('img/user.png') }}" alt="{{ $user->name }}" class="img-fluid">
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Company name</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $company->name }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Name</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $user->name }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Address</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $profile->address ?? '' }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Joining date</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $user->pivot->join_date ?? '' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="group">
                                <p class="mgb-12 text-light-black">City</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $profile->city ?? '' }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">State</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $profile->state ?? '' }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Phone</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $profile->phone ?? '' }}</p>
                            </div>
                            <div class="group">
                                <p class="mgb-12 text-light-black">Email</p>
                                <p class="mb-0 fw-bold text-light-black">{{ $user->email }}</p>
                            </div>
                            <div class="group d-none">
                                <p class="mgb-12 text-light-black">Total task</p>
                                <p class="mb-0 fw-bold text-light-black">Boston CRM</p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
