@extends('layouts.auth')

@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
  <div class="bg-body d-flex flex-column flex-center rounded-4 p-15 shadow-xs">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
      <div class="d-flex flex-center flex-column flex-column-fluid">
        <form class="form w-100" action="{{ route('reset', $token) }}" method="POST" id="loginForm">
          @csrf
          <div class="mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3 fs-2qx">Reset Password</h1>
            <div class="text-gray-500 fw-semibold fs-5">Please enter your new password </div>
          </div>
  
          <div class="fv-row mb-8">
            <div class="alert alert-dismissible bg-light-dark border border-dashed border-dark border-2 d-flex align-items-center flex-column flex-sm-row">
              <div class="symbol-label">
                <div class="symbol symbol-circle symbol-40px overflow-hidden me-5">
                    <div class="symbol-label">
                      <img src="https://ui-avatars.com/api/?bold=true&name={{ $user->name }}" alt="" class="w-100">
                    </div>
                </div>
              </div>
              <div class="d-flex flex-column pe-0 pe-sm-10">
                  <h4 class="mb-1 fs-6">{{ $user->name }}</h4>
                  <span class="text-muted fs-7">{{ $user->email }}</span>
              </div>
            </div>
            <input type="hidden" placeholder="email" name="email" value="{{ $user->email }}" />
          </div>
  
          <div class="fv-row mb-8">
            <input type="password" placeholder="Password Baru" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" value="{{ old('password') }}" />
            @error('password')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="d-grid mb-3">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-dark">
              <span class="indicator-label">Change Password</span>
              <span class="indicator-progress" style="display: none;">Loading... 
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
          <div>
            <a href="{{ route('login') }}" class="btn btn-light w-100">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  document.getElementById('loginForm').addEventListener('submit', function() {
    var submitButton = document.getElementById('kt_sign_in_submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection
