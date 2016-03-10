<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

<?php

    if (isset($message)){
        $src = $message->embed(public_path('assets/img/logo.png'));
    } else {
        $src = url('assets/img/logo.png');
    }

?>

<div class="header" style="text-align: center; border-bottom: 1px solid #ddd;">
    <img alt="FOCUS League" src="{{ $src }}" height="68" width="190" style="margin:10px; height:68px; width:190px;"/>
</div>

<div class="content" style="color: #000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <p>Hi {{ ucwords($nickname) }},</p>

@yield('content')

    <p>&ndash;The FOCUS League team</p>
</div>

<div class="footer" style="border-top: 1px solid #ddd; color: #888; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <p>Sent from &ndash; <a href="{!! url('') !!}">FOCUS League</a>.</p>
{{-- @yield('unsubscribe') --}}
</div>

</body>
</html>