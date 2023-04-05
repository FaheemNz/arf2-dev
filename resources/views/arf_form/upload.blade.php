@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 

        <nav aria-label="breadcrumb" class="">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-dark">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Upload Assets</li>
            </ol>
        </nav>

        <div class="col-md-6" style="box-shadow: 0 5px 10px rgba(0, 0, 0, .2); border-radius: 8px; padding: 24px">
            <h4>Upload Assets to the System..</h4>
            <hr />

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>Assets have been uploaded successfully.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('arfform.upload') }}" method="POST" class="row g-3 mt-4">
                @csrf
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Start Asset From</label>
                    <input type="number" class="form-control" name="asset_from" id="asset_from" required>
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Number of Assets to Add</label>
                    <input type="number" name="number_of_assets" class="form-control" id="number_of_assets" required>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Asset Type</label>
                    <select class="form-control" name="asset_type" id="asset_type" required onchange="loadBrands(this)">
                        <option value="">Select</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Desktop">Desktop</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Mobile">Mobile</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">Asset Brand</label>
                    <select required name="asset_brand" class="form-select" id="asset_brand"></select>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary mx-1">Cancel</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>

            <br />

            @if(isset($last_asset_number))
            <div>Last Asset Number is: {{ $last_asset_number }}</div>
            @endif
        </div>
    </div>
</div>
@endsection