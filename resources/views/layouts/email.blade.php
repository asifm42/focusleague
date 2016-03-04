<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage">

<?php

    // if (isset($message)){
    //     $src = $message->embed(public_path('assets/img/black_logo_email.png'));
    // } else {
    //     $src = url('assets/img/black_logo_email.png');
    // }

?>

<div class="header" style="background-color: #333; color: #fff;">
    {{-- <img alt="Obsidian Black" src="{{ $src }}" height="60" width="135" style="height:60px; width:135px;"/> --}}
    FOCUS League
</div>



<div class="content" style="color: #000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <p>
        @if (isset($user))
            <?php $name = $user->name ?>
        @endif
        @if (isset($name))
            @if ((strpos($name, ' ')))
                Hi {{ strstr($name, ' ', true) }},
            @else
                Hi {{ $name }},
            @endif
        @else
            Hi,
        @endif
    </p>

@yield('content')

    <p>&ndash;The FOCUS League team</p>
</div>

<div class="footer" style="border-top: 1px solid #ddd; color: #888; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <p>Sent from &ndash; <a href="{!! url('') !!}">FOCUS League</a>.</p>
@yield('unsubscribe')
</div>


</body>
</html>