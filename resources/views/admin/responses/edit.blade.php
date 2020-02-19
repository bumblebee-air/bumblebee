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

  .keywords-badges span {
    margin-left: 5px;
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
            <i class="material-icons">audiotrack</i>
          </div>
          <h4 class="card-title">Edit Response</h4>
        </div>
        <form action="{{url('response' . '/' . $response->id)}}" method="post">
          <div class="card-body">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group bmd-form-group">
              <label for="keywords">Keywords*</label>
              <br />
              <div class="keywords-badges info-badge">
                @foreach($response->keywords as $keyword)
                <span class="badge badge-info"> {{ $keyword }} </span>
                @endforeach
              </div>
              <input type="hidden" name="audio_keywords" id="audio-keywords" value="{{ implode(',',  $response->keywords) }}" />
              <select title="Select Keywords" data-style="select-with-transition" name="keywords[]" id="keywords" class="selectpicker" data-live-search="true" multiple>
                @foreach($keywords as $keyword)
                <option value="{{ $keyword->id }}">{{ $keyword->keyword }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="card-btns" style="padding: 20px;">
            <button type="submit" class="btn btn-fill btn-rose">Save</button>
            <a href="{{ url('responses') }}" class="btn">Cancel</a>
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
  var selectedKeywords = [];

  $("#keywords").on("changed.bs.select",
    function(e, clickedIndex, isSelected, oldValue) {
      var selected = $(e.currentTarget).val();
      var clickedValue = this.options[clickedIndex].value;
      var text = this.options[clickedIndex].text;

      if (isSelected) {
        if (selected.includes(clickedValue)) {
          selectedKeywords.push(clickedValue);
        }
      } else {
        if (selectedKeywords.includes(clickedValue)) {
          selectedKeywords = selectedKeywords.filter(function(keyword) {
            return keyword !== clickedValue;
          });
        }
      }
      $('.keywords-badges').empty();
      $('#audio-keywords').val('');
      if (selectedKeywords.length > 0) {

        $.each(selectedKeywords, function(index, value) {
          var text = $('#keywords option[value="' + value + '"]').text();
          $('.keywords-badges').append('<span id="' + value + '" class="badge badge-info">' + text + '</span>')
        });
        var selectedKeywordsStr = selectedKeywords.toString();
        $('#audio-keywords').val(selectedKeywordsStr);
      }
    });
</script>
@endsection