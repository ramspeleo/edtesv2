<div class="modal fade"
     id="profileModal"
     tabindex="-1"
     aria-labelledby="profileModalLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header gov-modal-header">
                <div>
                    <h5 class="modal-title mb-0" id="profileModalLabel">
                        <i class="bi bi-person-badge-fill me-2"></i>
                        User Profile
                    </h5>

                    <small class="text-white-50">
                        System Account Information
                    </small>
                </div>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">

                            <!-- Profile Photo -->
                            <div class="me-2">
                                <img src="{{ Auth::user()->profile_photo_url ?? asset('assets/images/default-user.png') }}"
                                alt="Profile Photo"
                                class="profile-photo-square">

                                {{-- <img src="{{ Auth::user()->profile_photo ?? asset('/assets/images/default-user.png') }}"
                                    alt="Profile Photo"
                                    class="profile-photo-square"> --}}
                            </div>

                            <!-- User Details -->
                            {{-- <div>
                                <h5 class="mb-1 fw-bold">
                                    {{ Auth::user()->name ?? 'N/A' }}
                                </h5>

                                <div class="text-muted">
                                    {{ Auth::user()->emp_title ?? 'N/A' }}
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
                <div class="card border-0 bg-light">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-4">
                                <small class="text-muted fw-bold">
                                    FULL NAME
                                </small>
                            </div>
                            <div class="col-8">
                                {{ Auth::user()->name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <small class="text-muted fw-bold">
                                    EMAIL
                                </small>
                            </div>
                            <div class="col-8">
                                {{ Auth::user()->email ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <small class="text-muted fw-bold">
                                    ROLE
                                </small>
                            </div>
                            <div class="col-8">
                                {{ Auth::user()->role ?? 'N/A' }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer">

                <button type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>
                    Close
                </button>

                <a href="{{ route('profile.edit') }}"
                   class="btn btn-gov-primary">
                    <i class="bi bi-pencil-square me-1"></i>
                    Update Profile
                </a>

            </div>

        </div>
    </div>
</div>