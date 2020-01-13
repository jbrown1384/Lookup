@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Customer Search Container -->
    <form action="/" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-8 offset-md-2 offset-sm-0">
            <div class="row">
                <h1>Search Records</h1>
            </div>
            <div class="form-group row">
                <div class="input-group">
                    <span class="input-group-addon p-2 font-weight-bold">Customer ID: </span>
                    <input id="title" type="text" class="form-control mr-5 @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autofocus>
                </div>
            </div>

            <div class="row pt-4 text-right">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- Customer Results Container -->
    <div id="customer-details" class="row" style="display:none">

        <!-- Basic Customer Details -->
        <div class="col-md-8 offset-md-2 offset-sm-0 mt-4">
            <div class="card">
                <h5 class="card-header">Customer Details</h5>
                <div class="card-body">
                    <ul id="details" class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Customer #:</strong> <span id="customerInsert"></span></li>
                        <li class="list-group-item"><strong>Full Name:</strong> <span id="nameInsert"></span></li>
                        <li class="list-group-item"><strong>Gender:</strong> <span id="genderInsert"></span></li>
                        <li class="list-group-item"><strong>dob:</strong> <span id="dobInsert"></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Customer Addresses -->
        <div class="col-md-8 offset-md-2 offset-sm-0 mt-4">
            <div class="card">
                <h5 class="card-header">Addresses</h5>
                <div class="card-body">
                    <ul id="addresses" class="list-group list-group-flush">
                        <li class="list-group-item" style="display:none">Cras justo odio</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Roles associated to the Customer -->
        <div class="col-md-8 offset-md-2 offset-sm-0 mt-4">
            <div class="card">
                <h5 class="card-header">Roles</h5>
                <div class="card-body">
                    <ul id="roles" class="list-group list-group-flush">
                        <li class="list-group-item" style="display:none">Cras justo odio</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="search-error" class="col-md-8 offset-md-2 offset-sm-0 mt-5" style="display:none">
        <div class="alert alert-danger" role="alert">
            Customer: <span id="customer-alert"></span> not found.
        </div>
    </div>
</div>
@endsection


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $('document').ready(function(){
        $('form').submit(function(e){
            e.preventDefault();
            searchRecords($('#title').val());
        });
    });

    /*
        send a request for the customer's details
    */
    function searchRecords(customer) {
        cleardetails();

        $.ajax({
            url: '/customers/'+customer,
            method: 'GET'
        })
        .done(function(response) {
            parseCustomerDetails(response.customer);
            parseAddresses(response.addresses);
            parseRoles(response.roles);
            $('#customer-details').toggle();
        })
        .fail(function() {
            $('#customer-alert').html(customer);
            $('#search-error').toggle();

            setTimeout(function(){
                $('#search-error').toggle();
            }, 4000);
        })
    }

    /*
        add the data for the customer's details
    */
    function parseCustomerDetails(customer)
    {
        $('#customerInsert').text(customer.id);
        $('#nameInsert').text(customer.name);
        $('#genderInsert').text(customer.gender);
        $('#dobInsert').text(customer.dob);
    }

    /*
        Cycle through the customer's addresses and add them to the address list
    */
    function parseAddresses(addresses)
    {
        for(var index in addresses) {
            let address = addresses[index].address+ " "+addresses[index].city+ ", "+ addresses[index].state+ " "+ addresses[index].postal_code;
            let item = $('#addresses > li').first().clone();
            $(item).appendTo('#addresses').text(address).show();
        }
    }

    /*
        Cycle through the customer's roles and add them to the roles list
    */
    function parseRoles(roles)
    {
        for(var index in roles) {
            let role = roles[index].name;
            let item = $('#roles > li').first().clone();
            $(item).appendTo('#roles').text(role).show();
        }
    }

    function cleardetails() {
        $('#customer-details').hide();
        $('#addresses > li').not(':first').remove();
        $('#roles > li').not(':first').remove();

        return;
    }
</script>
