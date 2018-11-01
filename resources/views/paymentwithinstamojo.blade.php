
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Error Alert!</strong> {{ $message }}
            </div>
            @endif
            {!! Session::forget('error') !!}
            @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <strong>Success Alert!</strong> {{ $message }}
            </div>
            @endif
            {!! Session::forget('success') !!}
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-10">
                            <strong>Pay With Paypal</strong>

                            <h3> For testing use :-

                            "card_type" :"visa"
                            "card_no" :"4311192669157704"
                            "exp_date" :"112022"
                            </h3>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ URL::route('payment') }}">
                        @csrf
                        <div class="form-group">
                            <label for="purpose" class="col-md-12 col-form-label">Card Type</label>
                            <div class="col-md-12">
                                <input id="purpose" type="text" class="form-control" name="card_type" value="" required>
                                @if ($errors->has('card_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('card_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-md-12 col-form-label">Exp Date( Should be in 112022 format )</label>
                            <div class="col-md-12">
                                <input id="amount" type="number" class="form-control" name="exp_date" value="" required>
                                @if ($errors->has('exp_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('exp_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-12 col-form-label">Card No.</label>
                            <div class="col-md-12">
                                <input id="phone" type="number" class="form-control" name="card_no" value="" required>
                                @if ($errors->has('card_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('card_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                            <br>
                                <button type="submit" class="btn btn-primary btn-block desabled" id="submitUser">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>
