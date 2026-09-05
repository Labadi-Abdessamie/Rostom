@extends('admin.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">{{ isset($member) ? 'Edit Team Member' : 'Add Team Member' }}</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.team_members') }}">Team Members</a></li>
                <li class="breadcrumb-item active">{{ isset($member) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ isset($member) ? route('admin.team_members.update', $member->id) : route('admin.team_members.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(isset($member)) @method('PUT') @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name', $member->name ?? '') }}" required maxlength="120">
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role / Job Title <span class="text-danger">*</span></label>
                                        <input type="text" name="role" id="role" class="form-control"
                                               value="{{ old('role', $member->role ?? '') }}" required maxlength="120">
                                        @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="departments" class="form-label">Departments <span class="text-danger">*</span></label>
                                        <select name="departments[]" id="departments" class="form-select" multiple size="4" style="min-height:120px;">
                                            @php
                                                $depts = ['Leadership','Engineering','Design','Operations','Support','Marketing','Sales'];
                                                $selectedDepts = old('departments', isset($member) ? ($member->departments ?? [$member->department ?? '']) : []);
                                                if (!is_array($selectedDepts)) $selectedDepts = [$selectedDepts];
                                            @endphp
                                            @foreach($depts as $d)
                                                <option value="{{ $d }}" {{ in_array($d, $selectedDepts) ? 'selected' : '' }}>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Hold Ctrl (Windows) / Cmd (Mac) to select multiple.</small>
                                        @error('departments') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Biography</label>
                                <textarea name="bio" id="bio" class="form-control" rows="4" maxlength="2000">{{ old('bio', $member->bio ?? '') }}</textarea>
                                @error('bio') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <input type="text" name="skills" id="skills" class="form-control"
                                       value="{{ old('skills', isset($member) && is_array($member->skills) ? implode(', ', $member->skills) : '') }}"
                                       placeholder="e.g. Laravel, PostgreSQL, AWS">
                                <small class="text-muted">Comma-separated list of skills.</small>
                                @error('skills') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               value="{{ old('email', $member->email ?? '') }}">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Profile Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                        <small class="text-muted">Square image recommended. Max 2MB.</small>
                                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter URL</label>
                                        <input type="url" name="twitter" id="twitter" class="form-control"
                                               value="{{ old('twitter', $member->twitter ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="linkedin" class="form-label">LinkedIn URL</label>
                                        <input type="url" name="linkedin" id="linkedin" class="form-control"
                                               value="{{ old('linkedin', $member->linkedin ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="github" class="form-label">GitHub URL</label>
                                        <input type="url" name="github" id="github" class="form-control"
                                               value="{{ old('github', $member->github ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3" style="border-top:1px solid #e2e8f0; padding-top:20px; margin-top:8px;">
                                <label class="form-label d-block" style="font-weight:600;">Visibility</label>
                                <label for="status" class="d-flex align-items-center gap-2 mb-0" style="cursor:pointer; font-weight:500; font-size:.9rem; color:#334155;">
                                    <span id="visibility-eye" style="font-size:1.3rem; color:#4f46e5; transition:all .2s;">
                                        <i class="mdi mdi-eye{{ old('status', $member->status ?? true) ? '' : '-outline' }}"></i>
                                    </span>
                                    <span id="visibility-label">{{ old('status', $member->status ?? true) ? 'Show on Team page' : "Don't show" }}</span>
                                </label>
                                <input type="checkbox" id="status" name="status" value="1"
                                       {{ old('status', $member->status ?? true) ? 'checked' : '' }}
                                       onchange="updateVisibility(this)"
                                       style="position:absolute; opacity:0; width:1px; height:1px;">
                                <script>
                                    function updateVisibility(cb) {
                                        const eye = document.getElementById('visibility-eye');
                                        const label = document.getElementById('visibility-label');
                                        if (cb.checked) {
                                            eye.innerHTML = '<i class="mdi mdi-eye"></i>';
                                            label.textContent = 'Show on Team page';
                                        } else {
                                            eye.innerHTML = '<i class="mdi mdi-eye-outline"></i>';
                                            label.textContent = "Don't show";
                                        }
                                    }
                                </script>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.team_members') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> {{ isset($member) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-header"><h5 class="card-title mb-0">Current Photo</h5></div>
                    <div class="card-body text-center">
                        @if(isset($member) && $member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="img-fluid rounded" style="max-height:240px; object-fit:cover;">
                        @else
                            <img src="{{ asset('frontend/images/No_Image.png') }}" alt="placeholder" class="img-fluid rounded" style="max-height:240px; object-fit:cover; opacity:.6;">
                            <p class="text-muted small mt-2 mb-0">No image uploaded yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
