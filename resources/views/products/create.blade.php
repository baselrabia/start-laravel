@extends('offers.nav')
{{-- title --}}
@section('title', __('products.add-product'))

@section('content')

  {{-- {{ dd($errors->all()) }} --}}

  <div class="container">
    <div class="row mt-5">
      <div class="col-sm-12">
        {{-- Add new product --}}
        <h1>{{ __('products.add-product') }}</h1>

      </div>
    </div>


    {{-- create Message --}}
    <div class="col-sm-6 mt-3">
      <div class="alert alert-danger" role="alert" style="display: none" id="createMessage">

      </div>
    </div>

  </div>
  <div class="container">
    <div class="row my-5">
      <div class="col-sm-12">
        <form method="" action="" id="createForm">
          @csrf

          <div class="mb-3">
            {{-- product name --}}
            <label for="name" class="form-label">{{ __('products.product-name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
              aria-describedby="emailHelp" value="{{ old('name') }}" placeholder="{{ __('products.product-name') }}">
            @error('name')
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            {{-- offer price --}}
            <label for="price" class="form-label">{{ __('products.product-price') }}</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
              aria-describedby="emailHelp" value="{{ old('price') }}" placeholder="{{ __('products.product-price') }}">
            @error('price')
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            {{-- product details --}}
            <label for="details" class="form-label"> {{ __('products.product-details') }}</label>
            <textarea name="details" id="details" cols="10" rows="5"
              class="form-control @error('details') is-invalid @enderror"
              placeholder="{{ __('products.product-details') }}">{{ old('details') }}</textarea>
            @error('details')
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <div class="mb-3">
            {{-- product image --}}
            <label for="image" class="form-label"> {{ __('products.product-image') }}</label>

            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
              aria-describedby="emailHelp" value="{{ old('image') }}" placeholder="{{ __('products.product-image') }}">

            @error('image')
              <div id="validationServerUsernameFeedback" class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
          </div>

          <button id="storeBtn" class="btn btn-primary" style="font-size: 12px; width:fit-content; padding:15px 20px;">
            {{ __('products.product-save') }}</button>
        </form>

      </div>
    </div>

  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      $('#storeBtn').click(function(e) {
        e.preventDefault();
        var form = new FormData($('#createForm')[0]);
        // console.log(form);
        $.ajax({

          type: 'POST',
          enctype: "multipart/form-data",
          url: "{{ route('products.store') }}",

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },

          data: form,
          cache: false,
          contentType: false,
          processData: false,

          success: function(data) {
            console.log(data.message);
            // alert(data.message);
          },
          error: function(reject) {
            console.log(reject);
            // alert(reject.responseJSON.message);
            $('#createMessage').show().html(reject.responseJSON.message);

            // var arr = reject.responseJSON.message;



            // for (let key in arr) {

            //   let error = arr[key];
            //   $(`input[name="${key}"]`).parent().append(
            //     `<span class="alert alert-danger mt-5" role="alert">${error[0]}</span>`)

            // }

            // alert(reject.message);
          },
        });
      });
    });

  </script>
@endsection