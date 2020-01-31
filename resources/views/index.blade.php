@extends('layouts.master')

@section('content')

<h2 class="text-center bg-dark p-4 text-white">Image Upload with Dropify using AJAX</h2>

<div class="container">
    <form method="POST" id="saveForm" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <input type="file" name="picture" id="input-file-now" class="dropify" />
            <button type="button" class="btn btn-primary btn-block" id="saveImage">Save</button>
        </div>
    </form>
</div>
@endsection


@section('javascript')
<script>
    $('.dropify').dropify();

    $(function () {
        $(document).on("click", "#saveImage", function (event) {
            let myForm = document.getElementById('saveForm');
            let formData = new FormData(myForm);
            uploadImage(formData);
            console.log(formData);

        });
    });


    function uploadImage(formData) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            url: "{{ route('save_image') }}",
            success: function (data) {
                if (data.status) {
                    showCustomSucces(data.message);
                } else {
                    showCustomError(data.error)
                }
            },
            error: function (err) {
                showCustomError('Something went Wrong!')
            }
        });
    }
</script>
@endsection
