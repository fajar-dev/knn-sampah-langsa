@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Dataset</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">{{ $data->total() }} Total Data</span>
                </h3>
                <div class="card-toolbar">
                    <div class="d-md-flex flex-stack flex-wrap gap-4">
                        <form method="GET" class="position-relative my-1 mb-md-0 mb-5">
                            <input type="hidden" name="page" value="{{ request('page', 1) }}">
                            <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4"></i>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control w-200px fs-7 ps-12" placeholder="Search" />
                        </form>
                        <a href="#" class="btn btn-icon btn-light" data-bs-toggle="modal" data-bs-target="#add">
                          <i class="ki-outline ki-plus fs-1"></i>                        
                        </a>
                        <a href="#" class="btn btn-icon btn-dark" data-bs-toggle="modal" data-bs-target="#import">
                          <i class="ki-outline ki-file-up fs-1"></i>                      
                        </a>
                        <button id="{{ route('data.destroy.all') }}" class="btn btn-icon btn-danger btn-del">
                          <i class="ki-outline ki-trash fs-1"></i>                      
                        </button>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" id="add">
                  <div class="modal-dialog modal-dialog-centered">
                      <form method="POST" action="{{ route('data.store') }}" class="modal-content" id="form">
                        @csrf
                          <div class="modal-header">
                              <h3 class="modal-title">Add New Dataset</h3>
                              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Year</label>
                              <input type="number" name="year" class="form-control form-control-solid @error('year') is-invalid @enderror"  value="{{ old('year') }}" placeholder="Year" required/>
                              @error('year')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Organic</label>
                              <input type="number" name="organic" class="form-control form-control-solid @error('organic') is-invalid @enderror" step="any" value="{{ old('organic') }}" placeholder="0" required/>
                              @error('organic')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Unorganic</label>
                              <input type="number" name="unorganic" class="form-control form-control-solid @error('unorganic') is-invalid @enderror" step="any" value="{{ old('unorganic') }}" placeholder="0" required/>
                              @error('unorganic')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" id="submit" class="btn btn-dark">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress" style="display: none;">Loading... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                              </button>
                          </div>
                      </form>
                  </div>
                </div>

                <div class="modal fade" tabindex="-1" id="import">
                  <div class="modal-dialog modal-dialog-centered">
                      <form method="POST" action="{{ route('data.import') }}" enctype="multipart/form-data" class="modal-content" id="form">
                        @csrf
                          <div class="modal-header">
                              <h3 class="modal-title">Import Itemset</h3>
                              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class="col mb-5">
                                <div id="dropZone" class="drop-zone border-2 border-dashed rounded p-4 text-center bg-light py-20 cursor-pointer">
                                    <p class="mb-0 fs-5 fw-semibold">Drag and drop a file here or click to select</p>
                                    <input type="file" name="file" id="fileInput" class="form-control d-none @error('file') is-invalid @enderror" required/>
                                </div>
                                @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" id="submit" class="btn btn-dark">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress" style="display: none;">Loading... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                              </button>
                          </div>
                      </form>
                  </div>
                </div>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Year</th>
                            <th class="min-w-150px">Organic</th>
                            <th class="min-w-150px">Unorganic</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                      @if ($data->total() == 0)
                        <tr class="max-w-10px">
                          <td colspan="4" class="text-center">
                            No data available in table
                          </td>
                        </tr>
                      @else
                        @foreach ($data as $item)
                          <tr>
                              <td>
                                  <span class="text-gray-800">{{ $item->year }}</span>
                              </td>
                              <td>{{ $item->organic }}</td>
                              <td>{{ $item->unorganic }}</td>
                              <td class="text-end">
                                <a href="#" class="btn btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                  <i class="ki-outline ki-dots-vertical fs-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                  <div class="menu-item px-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}" class="menu-link px-3">Edit</a>
                                  </div>
                                  <div class="menu-item px-3">
                                    <a id="{{ route('data.destroy', $item->id) }}" class="menu-link px-3 btn-del">Hapus</a>
                                  </div>
                                </div>
                              </td>
                          </tr>
                        @endforeach
                      @endif  
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
              <div class="d-flex flex-stack justify-content-md-between justify-content-center flex-wrap my-3">
                <div class="fs-6 fw-semibold text-gray-700 mb-5 mb-md-0">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() }} of {{ $data->total() }}  records
                </div>
                <ul class="pagination">
                    @if ($data->onFirstPage())
                        <li class="page-item previous">
                            <a href="#" class="page-link"><i class="previous"></i></a>
                        </li>
                    @else
                        <li class="page-item previous">
                            <a href="{{ $data->previousPageUrl() }}" class="page-link bg-light"><i class="previous"></i></a>
                        </li>
                    @endif
            
                    @php
                        $start = max($data->currentPage() - 2, 1);
                        $end = min($start + 4, $data->lastPage());
                    @endphp
            
                    @if ($start > 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
            
                    @foreach ($data->getUrlRange($start, $end) as $page => $url)
                        <li class="page-item{{ ($page == $data->currentPage()) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
            
                    @if ($end < $data->lastPage())
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
            
                    @if ($data->hasMorePages())
                        <li class="page-item next">
                            <a href="{{ $data->nextPageUrl() }}" class="page-link bg-light"><i class="next"></i></a>
                        </li>
                    @else
                        <li class="page-item next">
                            <a href="#" class="page-link"><i class="next"></i></a>
                        </li>
                    @endif
            </div>
        </div>
    </div>
</div>

@foreach ($data as $item)
<div class="modal fade" tabindex="-1" id="edit{{$item->id}}">
  <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ route('data.update', $item->id) }}" class="modal-content" id="form">
        @csrf
          <div class="modal-header">
              <h3 class="modal-title">Edit Dataset</h3>
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
              </div>
          </div>
          <div class="modal-body">
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Year</label>
              <input type="number" name="year" class="form-control form-control-solid @error('year') is-invalid @enderror"  value="{{ old('year') ?? $item->year }}" placeholder="Year" required/>
                @error('year')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Organic</label>
              <input type="number" name="organic" class="form-control form-control-solid @error('organic') is-invalid @enderror" step="any" value="{{ old('organic') ?? $item->organic }}" placeholder="0" required/>
                @error('organic')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-5">
              <label for="exampleFormControlInput1" class="required form-label">Unorganic</label>
              <input type="number" name="unorganic" class="form-control form-control-solid @error('unorganic') is-invalid @enderror" step="any" value="{{ old('unorganic') ?? $item->unorganic }}" placeholder="0" required/>
                @error('unorganic')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" id="submit" class="btn btn-dark">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress" style="display: none;">Loading... 
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
          </div>
      </form>
  </div>
</div>
@endforeach
@endsection

@section('script')
<script>
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');

  dropZone.addEventListener('click', () => {
      fileInput.click();
  });

  dropZone.addEventListener('dragover', (event) => {
      event.preventDefault();
      dropZone.classList.add('drag-over');
  });

  dropZone.addEventListener('dragleave', () => {
      dropZone.classList.remove('drag-over');
  });

  dropZone.addEventListener('drop', (event) => {
      event.preventDefault();
      dropZone.classList.remove('drag-over');
      if (event.dataTransfer.files.length) {
          fileInput.files = event.dataTransfer.files;
      }
  });

  fileInput.addEventListener('change', () => {
      const fileName = fileInput.files[0] ? fileInput.files[0].name : 'Drag and drop a file here or click to select';
      dropZone.querySelector('p').textContent = fileName;
  });
</script>

<script>
  document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      var submitButton = form.querySelector('button[type="submit"]');
      submitButton.querySelector('.indicator-label').style.display = 'none';
      submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
      submitButton.setAttribute('disabled', 'disabled');
    });
  });
</script>
<script>
  document.getElementById('form').addEventListener('submit', function() {
    var submitButton = document.getElementById('submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection

