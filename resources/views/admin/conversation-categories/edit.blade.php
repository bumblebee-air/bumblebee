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
            <i class="material-icons">category</i>
          </div>
          <h4 class="card-title">Edit Conversation Category</h4>
        </div>
        <form action="{{url('conversation-category/edit')}}" method="post">
          <div class="card-body">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{$category->id}}"/>
            <div class="form-group bmd-form-group">
              <label for="name">Name*</label>
              <input id="name" name="name" type="text" class="form-control"
                 value="{{$category->name}}" required>
            </div>
          </div>
          <div class="card-btns" style="padding: 20px;">
            <button type="submit" class="btn btn-fill btn-rose">Save</button>
            <a href="{{ url('conversation-categories') }}" class="btn">Cancel</a>
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