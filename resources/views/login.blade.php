@extends('layout.login')
@section('body')
    <div class="d-flex w-100 h-100">
        <div class="m-auto">
            <form id="form-login" method="post" action="{{ route('login') }}" style="min-width:400px;">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mb-2">Login</button>
                </div>
            </form>
        </div>
    </div>
@stop
