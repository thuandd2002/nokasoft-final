<style="width:600px; magrgin:0 auto">

<div style="text-align:center">
    <h2>Hello {{ $user->name }}</h2>
    <p>This email helps you retrieve your password</p>
    <p>Please click the link below to reset your password</p>
    <p>
        <a style="display:inline-block; background: green; color:#fff;padding: 7px 25px; font-weight: bold" href="{{route('route.customer.changePassword',['id'=>$user->id, 'remember_token'=>$user->remember_token])}}">ResetPassWord</a>
    </p>
</div>
