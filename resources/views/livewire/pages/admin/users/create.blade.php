@extends('livewire.pages.components.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account"></i>
                </span> Add Users
            </h3>
        </div>


        <div class="row">
            <div class=" col-12 grid-margin">

                <div class="card">
                    <div class="card-body">
                        {{-- tombol kembali start--}}
         <a  href="{{ route('user') }}" class="btn btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Back
         </a>
         {{-- tombol kembali end--}}
           <div class="table-responsive">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='name' id="name" required placeholder="Please Use Long Name">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">E-mail</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name='email' id="email" required placeholder="Enter E-mail">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='phone' id="phone" required placeholder="Enter Phone Number">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="submit" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





