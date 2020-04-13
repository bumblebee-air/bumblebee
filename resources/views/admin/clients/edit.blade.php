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
          <h4 class="card-title">Edit Client</h4>
        </div>
        <form action="{{url('client/edit')}}" method="post" enctype="multipart/form-data">
          <div class="card-body">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$client->id}}"/>
            <div class="form-group bmd-form-group">
              <label for="name">Name*</label>
              <input id="name" name="name" type="text" class="form-control"
                 value="{{$client->name}}" required>
            </div>
            <div class="form-group bmd-form-group">
              <label for="user_name">User Name*</label>
              <input id="user_name" name="user_name" type="text" class="form-control" value="{{ !empty($user) ? $user->name : '' }}" placeholder="Enter user name" required >
            </div>

            <div class="form-group bmd-form-group">
              <label for="email">Email*</label>
              <input id="email" name="email" type="text" class="form-control" value="{{ !empty($user) ? $user->email : '' }}" placeholder="Enter email address" required >
            </div>

            <div class="form-group bmd-form-group">
              <label for="sector">Sector</label>
              <select id="sector" name="sector" class="form-control selectpicker">
                <option value="">Select Sector</option>
                <option value="automotive">Automotive</option>
                <option value="non_automotive">Non Automotive</option>
              </select>
            </div>

            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail img-circle img-raised">
                @if($client->logo != null)
                  <img src="{{asset($client->logo)}}" rel="nofollow" alt="Current logo">
                @else
                  <img src="https://epicattorneymarketing.com/wp-content/uploads/2016/07/Headshot-Placeholder-1.png" rel="nofollow" alt="Current logo">
                @endif
              </div>
              <div class="fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
              <div>
                <span class="btn btn-raised btn-round btn-rose btn-file">
                <span class="fileinput-new">Upload logo</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="logo" id="logo" /></span>
                <br />
                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
              </div>
            </div>

            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
              <div class="fileinput-new thumbnail img-circle img-raised">
                @if($client->nav_background_image != null)
                  <img src="{{asset($client->nav_background_image)}}" rel="nofollow" alt="Current nav background">
                @else
                  <img src="https://epicattorneymarketing.com/wp-content/uploads/2016/07/Headshot-Placeholder-1.png" rel="nofollow" alt="Current nav background">
                @endif
              </div>
              <div class="fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
              <div>
                <span class="btn btn-raised btn-round btn-rose btn-file">
                <span class="fileinput-new">Upload nav background</span>
                <span class="fileinput-exists">Change</span>
                <input type="file" name="nav_background" id="nav-background" /></span>
                <br />
                <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
              </div>
            </div>

            <div class="form-group bmd-form-group">
              <label for="nav-highlight-color">Nav highlight color</label>
              <input id="nav-highlight-color" name="nav_highlight_color" type="color" class="form-control" value="{{$client->nav_highlight_color}}" />
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