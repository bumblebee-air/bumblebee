@extends('templates.dashboard')
@section('page-styles')
<style>
  .main-panel>.content {
    margin-top: 0;
  }

  h3 {
    margin-top: 0;
    margin-bottom: 25px;
    font-weight: bold;
  }
</style>
@endsection
@section('page-content')
<div class="content">
  <div class="container-fluid">
    <div class="col-md-8">
      <div class="card ">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">home_work</i>
          </div>
          <h4 class="card-title">Add Client</h4>
        </div>
        <form action="{{url('client/add')}}" method="post">
          <div class="card-body">
            {{ csrf_field() }}
            <div class="form-group bmd-form-group">
              <label for="name">Name*</label>
              <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="Enter client name" required>
            </div>
            <div class="form-group bmd-form-group">
              <label for="user_name">User Name*</label>
              <input id="user_name" name="user_name" value="{{ old('user_name') }}" type="text" class="form-control" placeholder="Enter user name" required>
            </div>

            <div class="form-group bmd-form-group">
              <label for="email">Email*</label>
              <input id="email" name="email" type="text" value="{{ old('email') }}"  class="form-control" placeholder="Enter email address" required>
            </div>
          </div>
          <div class="card-btns" style="padding: 20px;">
            <button type="submit" class="btn btn-fill btn-rose">Save</button>
            <a href="{{ url('clients') }}" class="btn">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script type="text/javascript">
</script>
@endsection