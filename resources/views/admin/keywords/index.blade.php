@extends('templates.dashboard')
@section('page-styles')
<style>
  h3 {
    margin-top: 0;
    font-weight: bold;
  }

  .main-panel>.content {
    margin-top: 0px;
  }

  audio {
    height: 32px;
    margin-top: 8px;
  }

  .swal2-popup .swal2-styled:focus {
    box-shadow: none !important;
  }
</style>
@endsection
@section('page-content')

<div class="content">
  <div class="container-fluid">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                <i class="material-icons">label</i>
              </div>
              <h4 class="card-title ">Keywords</h4>
            </div>
            <div class="card-body">
              <div class="float-right">
                <a class="btn btn-success btn-sm" href="{{ url('keywords/add') }}">Add New</a>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <th>Keyword/Phrase</th>
                    <th>Weight</th>
                    <th>Action</th>
                  </thead>

                  <tbody>
                    @if(count($keywords))
                    @foreach($keywords as $keyword)
                    <tr>
                      <td>{{ $keyword->keyword }}
                        @if($keyword->audio && file_exists(public_path("{$keyword->audio}")))
                        <div class="audio-container">
                          <audio id="my-audio" class="" controls>
                            <source src="{{ asset($keyword->audio) }}" type="audio/mpeg">
                          </audio>
                        </div>
                        @endif
                      </td>
                      <td>
                        <div class="progress-container progress-info text-center" style="width:80%;">
                          {{ $keyword->weight }}
                          <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ $keyword->weight }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $keyword->weight }}%">
                            </div>
                          </div>
                        </div>
                      </td>
                      <td><a class="btn btn-sm btn btn-info" href="{{ url('keywords/edit/'.$keyword->id) }}">Edit</a>
                        <a class="btn btn-sm btn btn-danger" deleteLink="{{ url('keywords/delete/'.$keyword->id) }}" href="#" onclick="confirmDelete(this)">Delete</a></td>

                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="3" class="text-center"><strong>No data found.</strong></td>
                    </tr>
                    @endif
                  </tbody>
                </table>
                <nav aria-label="pagination" class="float-right">
                  {{$keywords->links('vendor.pagination.bootstrap-4')}}
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('page-scripts')
<script src="{{asset('js/sweetalert2.js')}}"></script>
<script type="text/javascript">
  function confirmDelete(obj) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#4caf50',
      cancelButtonColor: '#f44336',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        var link = $(obj).attr('deleteLink');
        window.location.href = link;
      }
    })
  };
</script>
@endsection