@extends('layouts.auth')

@section('content')
<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
  <div class="bg-body d-flex flex-column flex-center rounded-4 p-15 shadow-xs">
    <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
      <div class="d-flex flex-center flex-column flex-column-fluid">
        <form class="form w-100" action="{{ route('login') }}" method="POST" id="loginForm">
          @csrf
          <div class="mb-11">
            <h1 class="text-gray-900 fw-bolder mb-3 fs-2qx">Sign-In</h1>
            <div class="text-gray-500 fw-semibold fs-5">Welcome!, Please enter your credential</div>
          </div>
  
          <div class="fv-row mb-8">
            <input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') ?? 'johndoe@example.com' }}" />
            @error('email')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="fv-row mb-3">
            <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" value="password" />
            @error('password')
            <div class="text-sm text-danger">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <a href="{{ route('forgot') }}" class="link-dark">Forgot Password ?</a>
          </div>
          <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-dark">
              <span class="indicator-label">Sign-in</span>
              <span class="indicator-progress" style="display: none;">Loading... 
              <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
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
