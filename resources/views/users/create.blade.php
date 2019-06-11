@extends('layout.master')

@section('body')
    <form id="form-user" method="post" action="{{ route('register') }}" class="p-5 mt-3">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <div class="form-group position-relative">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number">
            <div class="invalid-tooltip">
            </div>
        </div>

        <div class="form-group position-relative">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name">
            <div class="invalid-tooltip">
            </div>
        </div>

        <div class="form-group position-relative">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
            <div class="invalid-tooltip">
            </div>
        </div>

        <div class="form-group">
            <label for="">Date of Birth</label>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <select class="form-control" id="month" name="month" onchange="refreshDay()">
                    <option hidden value="">Month</option>
                    <option value=1>January</option>
                    <option value=2>February</option>
                    <option value=3>Macrh</option>
                    <option value=4>April</option>
                    <option value=5>May</option>
                    <option value=6>June</option>
                    <option value=7>July</option>
                    <option value=8>August</option>
                    <option value=9>September</option>
                    <option value=10>October</option>
                    <option value=11>November</option>
                    <option value=12>December</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" id="date" name="date">
                    <option hidden value="">Date</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <select class="form-control" id="year" name="year" onchange="refreshDay()">
                    <option hidden value="">Year</option>
                    @for ($i=2000; $i>=1985; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="m">
                <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="f">
                <label class="form-check-label" for="inlineRadio2">Female</label>
            </div>
        </div>

        <div class="form-group position-relative">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
            <div class="invalid-tooltip">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary mb-2">Register</button>
        </div>
    </form>

    <div id="box-btn-login" class="p-5" style="display:none;">
        <a href="{{ route('login') }}" id="btn-login" type="submit" class="btn btn-block btn-primary mb-2">Login</a>
    </div>
@stop

@section('javascript')
    <script>
        function refreshDay() {
            var year = $('#year').val();
            var month = $('#month').val();
            var date = $('#date').val();
            if (year == "") year=1995;
            if(month == "") {
                // free
            } else {
                var days = new Date(year, month, 0).getDate();
                let optionsDate = '';
                for (i = 1; i <= days; i++) {
                    if (date == i)
                        optionsDate+= "<option selected value='"+i+"'>"+i+"</option>";
                    else
                        optionsDate+= "<option value='"+i+"'>"+i+"</option>";
                }
                $('#date').html(optionsDate);
            }
        }

        function processFormError(errors) {
            $.each(errors, function(key, error){
                $('#'+key).addClass('is-invalid');
                $('#'+key).parent().children('.invalid-tooltip').html(error);
            });
        }

        $(document).ready(function(){
            $('#form-user').on('submit',(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                // block form UI
                $('#form-user').block({
                    message: '',
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        'border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });

                // Reset Error message
                $('.form-control').removeClass('is-invalid');

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        if (data.success) {
                            Swal.fire(
                                'Berhasil',
                                data.message,
                                'success'
                            );
                            $('#form-user').fadeOut();
                            $('#box-btn-login').fadeIn();
                        } else {
                            processFormError(data.errors);
                        }
                    },
                    error: function(data){
                        console.log("error");
                        console.log(data);
                    }
                }).done(function(){
                    $('#form-user').unblock();
                });
            }));

        });
    </script>
@stop
