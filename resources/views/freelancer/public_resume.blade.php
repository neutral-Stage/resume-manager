<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{$freelancer->username}} resume</title>

  @include('layouts.includes.styles')
</head>
<body>

  <div id="freelancerResumeLongV2" class="d-flex justify-content-center">
    <freelancer-resume-long-v2 :freelancer="{{$freelancer}}"></freelancer-resume-long-v2>
  </div>

  @include('layouts.includes.scripts')
</body>
</html>
