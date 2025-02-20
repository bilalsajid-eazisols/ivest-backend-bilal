@extends('layouts.admin')
@section('content')

    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h4 class="title nk-block-title">App Settings</h4>
                <div class="nk-block-des">
                    <p>Update or view your application setting.</p>
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-12">
                <div class="card card-bordered h-100">
                    <div class="card-inner pb-0">
                        <div class="card-head">
                            <h5 class="card-title">Setting</h5>
                        </div>
                        <form action="{{url('setting/store')}}" method="POST" class="row">
                            @csrf
                            <div class="form-group col-lg-3"><label class="form-label" for="full-name">Email Address</label>
                                <div class="form-control-wrap"><input type="email" class="form-control" id="email" name="smtp_username" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-3"><label class="form-label" for="email-address">Email
                                    Password</label>
                                <div class="form-control-wrap"><input type="text" class="form-control" id="password" name="smtp_password" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-3"><label class="form-label" for="host">SMTP Host</label>
                                <div class="form-control-wrap"><input type="text" class="form-control" id="host" name="smtp_host" required>
                                </div>
                            </div>
                            <div class="form-group col-lg-2"><label class="form-label" for="port">SMTP Port</label>
                                <div class="form-control-wrap"><input type="text" class="form-control" id="port" name="smtp_port">
                                </div>
                            </div>

                            <div class="form-group col-lg-3"><label class="form-label" for="fromaddress">From Address</label>
                                <div class="form-control-wrap"><input type="text" class="form-control" id="fromaddress" name="smtp_fromname">
                                </div>
                            </div>
                            <div class="form-group col-lg-3"><label class="form-label"
                                for="fromemail">From Email</label>
                            <div class="form-control-wrap"><input type="text"
                                    class="form-control" id="fromemail" name="smtp_fromaddress"></div>
                            </div>
                            <div class="form-group col-lg-3"><label class="form-label"
                                for="reciver">Reciver</label>
                            <div class="form-control-wrap"><input type="text"
                                    class="form-control" id="reciver" name="reciver"></div>
                            </div>
                            <div class="form-group col-lg-2"><label class="form-label" for="port">Encryption</label>
                                <div class="form-control-wrap">
                                    <div class="custom-control custom-radio">
                                            <input type="radio" id="SSL"  value="SSL" class="custom-control-input" name="smtp_encryption">    <label class="custom-control-label" for="SSL">SSL</label></div><div class="ms-2 custom-control  custom-radio">    <input type="radio" id="tls" value="tls"  name="smtp_encryption" class="custom-control-input">    <label class="custom-control-label" for="tls">TLS</label></div>

                                </div>
                            </div>
                            @can('setting_update')
                            <div class="form-group col-lg-11 mb-3 text-end"><button type="submit" class="btn  btn-warning">Save
                                Informations</button>
                            </div>
                            @endcan

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('extra-script')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            console.log("DOM fully loaded and parsed");
            let url = "{{url('setting')}}";
            // URL of the API


// Fetching data using GET request
fetch(url)
  .then(response => {
    // Check if the request was successful
    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }
    return response.json(); // Parse the JSON data from the response
  })
  .then(data => {
    // Handle the data you get from the API
    console.log('Data fetched:', data);
    document.getElementById('email').value = data.smtp_username;
    document.getElementById('password').value=data.smtp_password;
    document.getElementById('host').value =data.smtp_host;
    document.getElementById('port').value=data.smtp_port;
    document.getElementById('fromaddress').value=data.smtp_fromname;
    document.getElementById('fromemail').value=data.smtp_fromaddress;

    document.getElementById('reciver').value=data.reciver;
    if(data.smtp_encryption == 'tls'){
        document.getElementById('tls').checked=true;
    }else{
        document.getElementById('SSL').checked=true;
    }

  })
  .catch(error => {
    // Handle any errors that occurred during the fetch
    console.error('There was a problem with the fetch operation:', error);
  });

          });

    </script>
@endsection
