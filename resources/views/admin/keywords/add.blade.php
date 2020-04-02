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

  div.noUi-tooltip {
    margin-top: 10px;
    width: 25px;
  }

  div.card-btns {
    margin: 0 15px 10px;
    padding: 0;
    padding-top: 10px;
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
            <i class="material-icons">label</i>
          </div>
          <h4 class="card-title">Add Keyword</h4>
        </div>
        <form action="{{url('keywords')}}" method="post" enctype="multipart/form-data">
          <div class="card-body ">
            {{ csrf_field() }}
            <div class="form-group bmd-form-group">
              <label for="keyword">Keyword/Phrase*</label>
              <input name="keyword" type="text" class="form-control" id="keyword" placeholder="Enter keyword" required>
            </div>
            <div class="form-group bmd-form-group">
              <label for="weight">Weight*</label>
              <input type="hidden" name="weight" id="weight" value="0" />

              <div id="sliderRegular" class="slider"></div>
            </div>

            <div class="form-label-group">
              <label for="audio">Upload audio</label>
              <br />
              <input class="file-upload" name="audio" type="file" accept="audio/*" />
            </div>

            <div class="form-group bmd-form-group">
              <label for="supportType">Support Type</label>
              <select id="supportType" name="support_type" class="form-control selectpicker">
                <option value="">Select Support Type</option>
                @foreach($supportTypes as $supportType)
                <option value="{{$supportType->id}}">{{$supportType->name}}</option>
                @endforeach
              </select>
            </div>

          </div>
          <div class="card-btns">
            <button type="submit" class="btn btn-fill btn-rose">Add</button>
            <a href="{{ url('keywords') }}" class="btn">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-scripts')
<script src="{{asset('js/nouislider.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script type="text/javascript">
  // slider
  let slider = document.getElementById('sliderRegular');
  noUiSlider.create(slider, {
    start: 0,
    connect: [true, false],
    range: {
      min: 0,
      max: 100
    },
    format: {
      to: function(value) {
        return value;
      },
      from: function(value) {
        return value
      }
    },
    step: 1,
    tooltips: true,
  });

  slider.noUiSlider.on('change', function(values) {
    $('#weight').val(values[0]);
  });
</script>
@endsection