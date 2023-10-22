@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/invitations-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/messages/messages-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-9 border-right" >
    <div class="p-3 py-5">
        <div class="main-body">
            @if (count($errors) > 0)
            <div class = "alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            @if(session()->get('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
            @endif
            @if(isset($msg))
            <div class="alert alert-success">
                {{ $msg }}
            </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">REFER & EARN CREDIT</h4>
            </div>
            <div>
                <p>
                    Do you party? then throw a few email below and you're on your way!
                    <br><br>
                    If user signup with your given link, You will get credit ${{ $referral_fee }}
                </p>
            </div>
            <div>
                <form action="{{ route('send-referral-program') }}" method="POST">
                    @csrf
                    <textarea class="form-control" required name="emails" id="" placeholder="eg. richard@gmail.com, simon@hotmail.com" rows="5" cols="50" style="height:150px; width:100%; resize:none"></textarea>
                    <div class="action-btn d-flex align-items-center justify-content-end">
                        <button class="btn mt-2">Send Referral Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')


<script type="text/javascript">


</script>
@endsection