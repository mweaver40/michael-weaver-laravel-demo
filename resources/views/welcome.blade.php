@extends('michael.layout.master')
@section('content')
<div class="container">
    <div class="jumbotron jumbotron-welcome">

        <h1>Michael Weaver </h1>
        <ul>
            <li>10+ years of professional Software Development experience</li>
            <li>Extensive experience in many languages including Java, PHP and C</li>
            <li>Extensive experience in multiple databases and frameworks</li>
        </ul>
        <p><a href="{{URL::route('storeMain')}}" class="btn btn-success btn-lg">Visit Store App</a></p>

    </div>
</div>
@endsection

