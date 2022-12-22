
  @extends('layouts.mailTemplate')
  @section('pageTitle', 'Password')
  @section('content')
  <div class="container">
 <div class="content">
  <div>
    <h2 class="">{{$title}}.</h2>
    <p class="mt-3">Hi, <span class="text-capitalize">{{$name}}!</span> </p>  
    <p>A request to reset password for your {{$fromName}} account ({{$email}}) was made. if this request was made by you, use the reset link below to continue your password reset.
    The link will expire in 2 hours if not used.
    </p>
  </div>
<!--  -->
  <div>
    <p>Reset link: <a href="{{url($link)}}">Click here to continue.</a> </p>
    <p>To reset your account's password, please click on the link: <br> <a href="{{url($link)}}">{{url($link)}}</a> </p>
  </div>
<!--  -->
  <div>
  <p>If you didn't initiate this request, please contact our <a href="{{$site_link}}/contactus">Support team</a>.</p>
  <p>Please do not reply to this email with your password or any other personal details. We will never ask for your password, and we strongly discourage you from sharing it with anyone.</p>
</div>

<br/>
<br/>
<!--  -->
  <div>
    <h2>{{$fromName}}</h2>
</div>

 </div>

 <div class="containerFooter">
  <div style="border-top: 1px solid #ccc; padding-top: 1px;">
    <p><small> Copyright &copy; {{$copyright}} </small></p>
    </div>
</div>

</div>




  @endsection('content')
  