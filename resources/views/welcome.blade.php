@extends('michael.layout.master')
        @section('content')
        <div class="container">
            <div class="jumbotron jumbotron-welcome">
                <h1>Michael Weaver </h1>
                <p>Over 25 years of professional Software Development experience </p>
                <p>Extensive experience in many languages including Java, PHP and C<p>
                <p>Extensive experience in multiple databases and frameworks </p>
                <p><a href="{{URL::route('storeMain')}}" class="btn btn-success btn-lg">Visit Store App</a></p>
            </div>
        </div>
        @endsection
  
