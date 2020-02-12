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

  .audio-remove-btn {
    padding: 0px 7px;
    height: 30px;
    vertical-align: middle;
    margin-top: 12px;
    margin-left: 10px;
  }

  .swal2-popup .swal2-styled:focus {
    box-shadow: none !important;
  }

  .audio-container {
    display: flex;
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
          <h4 class="card-title">Edit Keyword</h4>
        </div>
        <form action="{{url('keywords') . '/' .  $keyword->id }}" method="post" enctype="multipart/form-data">
          <div class="card-body ">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="form-group bmd-form-group">
              <label for="keyword">Keyword/Phrase*</label>
              <input name="keyword" type="text" value="{{ $keyword->keyword }}" class="form-control" id="keyword" placeholder="Enter keyword" required>
              <span class="error">{{ $errors->first('keyword') }}</span>
            </div>
            <div class="form-group bmd-form-group">
              <label for="weight">Weight</label>
              <input type="hidden" name="weight" id="weight" value="{{ $keyword->weight }}" />
              <div id="sliderRegular" class="slider"></div>
            </div>
            <div class="form-label-group">
              <label for="audio">Upload audio</label>
              <br />
              @if(!empty($keyword->audio) && file_exists(public_path("{$keyword->audio}")))
              <div class="audio-container">
                <audio id="my-audio" class="" controls>
                  <source src="{{ asset($keyword->audio) }}" type="audio/mpeg">
                </audio>
                <button class="btn btn-danger audio-remove-btn" type="button">Remove</button>
              </div>
              <br />
              @endif

              <input class="file-upload" name="audio" type="file" accept="audio/*" />
            </div>

          </div>
          <div class="card-btns">
            <button type="submit" class="btn btn-fill btn-rose">Update</button>
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
<script src="{{asset('js/sweetalert2.js')}}"></script>

<script type="text/javascript">
  // slider
  let slider = document.getElementById('sliderRegular');
  noUiSlider.create(slider, {
    start: document.getElementById('weight').value,
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

  $(document).ready(function() {
    $('.audio-remove-btn').click(function() {
      $.ajax({
        type: 'post',
        url: '<?php echo url('/keywords/remove-audio/'); ?>',
        data: {
          '_token': '<?php echo csrf_token() ?>',
          'keywordId': '<?php echo $keyword->id; ?>'
        },
        success: function(data) {
          Swal.fire('Success', 'Audio file deleted successfully!', 'success')
          $('.audio-container').remove();
        }
      });
    });
  });
</script>
@endsection