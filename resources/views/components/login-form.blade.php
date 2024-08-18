<div class="widget-shadow">
    <div class="login-body">
        <form action="{{ $action ?? route('login') }}" method="post">
            @csrf
            <input type="email" class="user" name="email" placeholder="Enter Your Email" required="">
            <input type="password" name="password" class="lock" placeholder="Password" required="">
            <div class="forgot-grid">
                <label class="checkbox"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}><i></i>Remember me</label>
                <div class="forgot">
                    <a href="{{ route('password.request') }}">forgot password?</a>
                </div>
                <div class="clearfix"> </div>
            </div>
            <input type="submit" name="Sign In" value="Sign In">
            <div class="registration">
                Don't have an account ?
                <a class="" href="{{ route('register') }}">
                    Create an account
                </a>
            </div>
        </form>
    </div>
</div>
