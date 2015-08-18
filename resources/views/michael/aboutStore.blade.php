<?php
?>
@extends('michael.layout.master')
        @section('content')
        <h2>Application components</h2>
 <UL>
	<LI><P STYLE="margin-bottom: 0in">Application code 
	</P>
	<UL>
		<LI><P STYLE="margin-bottom: 0in">Laravel 5 (PHP Framework) 
		</P>
		<LI><P STYLE="margin-bottom: 0in">Bootstrap</P>
		<LI><P STYLE="margin-bottom: 0in">Jquery.</P>
	</UL>
	
	<LI><P STYLE="margin-bottom: 0in">Database: MySql</P>
	
	<LI><P STYLE="margin-bottom: 0in">Web Server: Apache</P>
	
	<LI><P STYLE="margin-bottom: 0in">Hardware: Linux running on Amazon
	Web Services platform (AWS)</P>
	
	<LI><P STYLE="margin-bottom: 0in">Development platform: Windows
	running xamp and Netbeans</P>
	
	<LI><P STYLE="margin-bottom: 0in">Source control: git.</P>
</UL>
        <H2>Disclaimer</h2>
<P STYLE="margin-bottom: 0in">I need to make a disclaimer here. I am
not a web designer so the look and feel of the website is not what a
high end web designer would come up with. I am a web developer and
that is what I am trying to demonstrate. I also admit that none of
the images on this site are mine and in fact I took the product
images from a commercial store site. Hopefully nobody is going to
care that I took the product images since I am not competing with
them and just wanted to make my demo a little more realistic. The
images are generally provided to the store by the manufacture anyway.
</P>

<H2>Some interesting points about this app</h2>

<UL>
<li>
    This is a bootstrap application therefore it is a responsive app. It will 
    display differently on different sized views ports.
</li>

<li>It uses Ajax when appropriate. The
entire checkout process for instance is based on Ajax calls so that
the site itself never stores or even receives the credit card
information. This is actually a requirement of credit card issuers in
many cases so we keep the information local to the browser where it
is assumed it would be  passed of to a commercial payment service at
some point. Either way we never store it the session. Please note the
checkout process is currently stubbed and no payment service is
actually called.
</li>

<li>The database holds the cart. The cart
cookie simply keeps the id of the cart instance and the actual cart
contents is stored in the database as a pending order. This means we
know when an order was abandoned and can detect trends. It also means
we can and do keep the cart active across multiple user sessions.
Currently the cart times out a week from creation if the order is
never upgraded form pending by the user submitting the checkout. 
</li>

<li>No state is saved to the
session. This was an experiment to see if I could do this store
without session storage and I could. I am not against session
storage but we want to keep it minimized. 
</li>
</ul>
<H2>Miscellaneous notes on this app.</H2>

<P STYLE="margin-bottom: 0in"> If you know Laravel you may be
disappointed that this was not created as a service. Really this is
an application and not a service. I did look at creating this as a
package but decided against it at least for now. The database is
MySql and consists of around 15 tables including some of Laravel's
authentication tables. Everything is currently running as a single
application including the Michael website front end web code. This is
not ideal but running on a micro instance of AWS I did not want to
create multiple application code bases. It may not be all that much
extra burden on the system and I will consider breaking out the 2
sites as virtual hosts running on the same AWS instance. Are there
any bugs? You bet. I am not proud of bugs but I would rather
concentrate on doing more demo code then working on perfecting code
that won't actually be used. Once I have a wider code base to demo I
will circle back and do some additional clean up. One known issue is
using the back button in the browser where the cart may not have
correct contents count This is fixable and is a known class of bugs
associated with using the browsers back button to navigate. I will
get to it sometime soon 
</P>
@endsection

