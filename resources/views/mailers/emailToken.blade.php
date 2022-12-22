
  @extends('layouts.mailTemplate')
  @section('pageTitle', 'Email verification')
  @section('content')
  <div class="container">
    <div>
      <h2 class="">{{$title}}.</h2>
      <p class="mt-3">Dear, <span class="text-capitalize">{{$name}}.</span> </p>  
      <p>A request to verify your account ({{$email}}) password was made. if this request was made by you, use the reset link below to continue your password reset.
      The link will expire in 2 hours if not used.
      </p>
    </div>
  <!--  -->
    <div>
      <p>Reset link: <a href="{{url($link)}}">Click here to continue</a> </p>
    </div>
  <!--  -->
    <div>
    <p>If you didn't make this request, It may be that an authorized person has accessed your account, please contact our <a href="{{url('contactus')}}">Support team</a>.</p>
    <p>Please do not reply to this email with your password or any other personal details. We will never ask for your password, and we strongly discourage you from sharing it with anyone.</p>
  </div>

  <br/>
  <br/>
  <!--  -->
    <div>
      <h4>{{$fromName}} - Support.</h4>
  </div>

    <div style="border-top: 1px solid #ccc; padding-top: 1px;">
    <ul>
      <li> <a href="{{url('')}}" style="color:#ffffff">{{$fromName}}</a> </li>
      <li> <a href="{{url('contactus')}}" style="color:#ffffff">Contact us</a> </li>
    </ul>
    <p style="padding-top:0px;"><small>  Copyright &copy; {{$copyright}} </small></p>
    </div>

  </div>

  @endsection('content')
  