<?php
?>
@extends('michael.layout.master')
        @section('content')
        <h2>About this site</h2>
<P STYLE="margin-bottom: 0in">This is my demo site where I show
what I can do. Currently the site runs on an Amazon AWS micro Linux
instance. I only have the one instance because while Amazon
generously provides one year of free micro instance usage, they
restrict the free time to one instance running continuously. As a
consequence of one instance there is no load balance nor faillover. I
set up this instance myself just for the practice which involved
taking the basic AWS Linux instance and adding all the packages I
needed. This is perhaps not the optimal way since Amazon has some
preconfigured instances that you can clone but I feel you need to
learn things from the ground up sometimes if you want to understand
them. If you want to know exactly what is being used in the
application click <a href="{{URL::route('aboutStore')}}">here</a>.  
The database is currently running on the
same instance as the application which again is not optimal
and could be changed to run on one of the AWS database servers. I
may do that in the near future. 
</P>
<P STYLE="margin-bottom: 0in"><BR>
</P>
<P STYLE="margin-bottom: 0in"><BR>
</P>
<P STYLE="margin-bottom: 0in">Nearly all the application code here is
my own. I certainly am indebted to many other developers the world over for
help I received in solving problems. That is how the development
world works now and it is a good thing. 
</P>
@endsection

