@extends('layouts.auth')

@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
  <div class="bg-body d-flex flex-column flex-center rounded-4 p-15 shadow-xs">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
      <div class="d-flex flex-center flex-column flex-column-fluid">
        <form class="form w-100" action="{{ route('forgot') }}" method="POST" id="loginForm">
          @csrf
          <div class="mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3 fs-2qx">Forgot Password?</h1>
            <div class="text-gray-500 fw-semibold fs-5">Please enter your email to reset your password</div>
          </div>
  
          <div class="fv-row mb-8">
            <input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}" />
            @error('email')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="d-grid mb-3">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-dark">
              <span class="indicator-label">Reset Password</span>
              <span class="indicator-progress" style="display: none;">Loading... 
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
          </div>
          <div>
            <a href="{{ route('login') }}" class="btn btn-light w-100">back</a>
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
