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
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Add WhatsApp Template</h4>
                </div>
                <form action="{{url('whatsapp-template/')}}" method="post">
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="form-group bmd-form-group">
                            <label for="name">Name*</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" placeholder="Enter template name" required>
                        </div>
                        
                        <br />

                        <div class="form-group bmd-form-group">
                        <a href="javascript:void(0)" type="button" title="Instructions" class="float-right" id="instruction-btn" onclick="openInstructionModel()"><i style="color:#333333;" class="material-icons">info</i></a>
                            <label for="user_name">Template text*</label>
                            <textarea name="template_text" class="form-control" placeholder="Enter template text" ></textarea>
                        </div>
                    </div>
                    <div class="card-btns" style="padding: 20px;">
                        <button type="submit" class="btn btn-fill btn-rose">Save</button>
                        <a href="{{ url('whatsapp-templates') }}" class="btn">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Instructions modal START -->
<div class="modal fade" id="instructionModal" tabindex="-1" role="dialog" aria-labelledby="instructionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionModalLabel">Instructions</h5>
            </div>
            <div class="modal-body">
                You can put text placeholders in the format <strong>@{{text_placeholder}}</strong> to enable dynamic text content to be added in the template when it is used, or use the Add placeholder button
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Instructions modal END -->

@endsection

@section('page-scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script type="text/javascript">
    function openInstructionModel() {
        $("#instructionModal").modal('show');
    }
</script>
@endsection