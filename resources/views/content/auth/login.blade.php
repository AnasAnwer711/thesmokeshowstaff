@extends('layouts.app')
<style>
input {
    background: #00696d !important;
    border: 1px solid #00595d !important;
}

input,
input:focus {
    color: #fff !important;
}

input::placeholder {
    color: #9aaaaa !important;
}
</style>
@section('content')
<div id="content" class="site-content d-flex align-items-center justify-content-center"
    style="background-color: #009398;" ng-controller='authCtrl'>
    <div class="col-md-4">
        <div class="card py-3 shadow" style="background-color: #007377d1">
            <!-- ;background-repeat: no-repeat;background-size: contain;background-position: right;background-image:
            url('/images/cropped-Logo_SmokeShowStaff-180x180.png')">  -->
            <div class="c-header p-3">
                <h5 class="text-white">LOGIN</h5>
            </div>
            <div class="card-body">
                <form ng-submit="loginUser()">
                    @csrf
                    <div class="form-groups">
                        <div class="mb-3">
                            <input type="email" ng-model="loginForm.email" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <input type="password" ng-model="loginForm.password" class="form-control"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-end">
                        <button type="submit" class="btn bg-theme-pink text-white">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="tran row py-5 form-res-indnbus d-none" style="background-color: #009398;">
        <div class="d-flex flex-column align-items-center">
        </div>

    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
</div><!-- #content -->
@endsection

@section('javascripts')
<script src="{{ ('/app/auth-controller.js') }}"></script>
@endsection