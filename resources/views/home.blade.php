@extends('layouts.app')

@section('content')



<div class="container">
    <h1 class="text-center band pt-5" >AUTHENTICITY</h1>
    
    <div class="row pt-5">
    <div class="col-md-6"> 
        <div class="row">
            <div class="col-md-5 text-sm-center">
                <h4 class="num-1">Certifcation Number:</h4>
                <p  class="num-2">where can I find the certifcation number?</p>
            </div>
            <div class="col-md-6">
                <input type="number" min="0" class="form-control validate_cert_field" required>
                <div class="">
                    <button type="button" class="btn btn-secondary validate_cert">Submit</button>
                </div>
            </div>
            <div class="validate_cert_message"></div>
        </div>


        <div class="card">
          <div class="card-body">
            <div class="row">
                <div class="col-md-4">Name</div>
                <div class="col-md-8 name"></div>
            </div>
            <div class="row">
                <div class="col-md-4">Signed By</div>
                <div class="col-md-8 signed_by"></div>
            </div>
            <div class="row">
                <div class="col-md-4">Cert #</div>
                <div class="col-md-8 cert_no"></div>
            </div>
            <div class="row">
                <div class="col-md-4">Amount</div>
                <div class="col-md-8 amount"></div>
            </div>
            <div class="row">
                <div class="col-md-4 ">Sold</div>
                <div class="col-md-8 sold"></div>
            </div>
          </div>
        </div>



        {{-- <div class="cert mb-5"> --}}




        {{-- <form>
            <div class="form-group mb-5">
              <label for="exampleInputEmail1">Item Name: </label>
              <input type="email" class="form-control form-custom" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group mb-3">
              <label for="exampleInputPassword1">Signer Name: </label>
              <input type="password" class="form-control  form-custom" id="exampleInputPassword1" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary mt-3 form-btn">Verify another Certificate</button>
          </form> --}}

        {{-- </div> --}}

    </div>
    <div class="col-md-6">
        <div class="iiim text-center">
            <img src="{{ asset('assets/images/ball.png') }}" class="img-fluid">
        </div>
    </div>
    </div>
</div>


@endsection


@push('page_scripts')
<script type="text/javascript">

$(document).ready(function() {

    $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

    $('body').on('click', '.validate_cert', function(event) {
        event.preventDefault();
        var cert_no = $('.validate_cert_field').val();

        if (cert_no == '') {
            alert('Required Certificate Number');
            return false;
        }

        $('.validate_cert_message').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

        $('.name').html('');
        $('.signed_by').html('');
        $('.cert_no').html('');
        $('.amount').html('');
        $('.sold').html('');


        $.post('{{ route('item.verified') }}', {cert_no: cert_no}, function(data, textStatus, xhr) {
            /*optional stuff to do after success */

            if (data.success) {
                $('.validate_cert_message').addClass('alert').addClass('alert-success').html(data.success);

                if (data.data) {
                    $('.name').html(data.data.name);
                    $('.signed_by').html(data.data.signed_by);
                    $('.cert_no').html(data.data.cert_no);
                    $('.amount').html(data.data.amount);
                    $('.sold').html(data.data.sold);
                }

            }

            if (data.fail) {
                $('.validate_cert_message').addClass('alert').addClass('alert-danger').html(data.fail);
            }

            

        });


    });
});



    /**/

</script>
@endpush