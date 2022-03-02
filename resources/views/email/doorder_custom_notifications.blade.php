<html>
<body>
@if($client == 'DoOrder')
    <img style='width:125px' src='{{asset('images/doorder-logo.png')}}' alt="DoOrder logo">
@else
    <img style='width:125px' src='{{asset('images/gardenhelp/Garden-help-new-logo.png')}}' alt="GardenHelp logo">
@endif

<p>Hi {{$client}} administration, <br/>
    {{$content}}
</p>
</body>
</html>
