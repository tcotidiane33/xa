<div class="sign-up-row widget-shadow">
    <h5>Personal Information :</h5>
    <form action="{{ $action ?? route('register') }}" method="post">
        @csrf
        <div class="sign-u">
            <input type="text" name="firstname" placeholder="First Name" required="">
            <div class="clearfix"> </div>
        </div>
        <div class="sign-u">
            <input type="text" name="lastname" placeholder="Last Name" required="">
            <div class="clearfix"> </div>
        </div>
        <div class="sign-u">
            <input type="email" name="email" placeholder="Email Address" required="">
            <div class="clearfix"> </div>
        </div>
        <div class="sign-u">
            <div class="sign-up1">
                <h4>Gender* :</h4>
            </div>
            <div class="sign-up2">
                <label>
                    <input type="radio" name="gender" value="male" required="">
                    Male
                </label>
                <label>
                    <input type="radio" name="gender" value="female" required="">
                    Female
                </label>
            </div>
            <div class="clearfix"> </div>
        </div>
        <h6>Login Information :</h6>
        <div class="sign-u">
            <input type="password" name="password" placeholder="Password" required="">
            <div class="clearfix"> </div>
        </div>
        <div class="sign-u">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required="">
        </div>
        <div class="clearfix"> </div>
        <div class="sub_home">
            <input type="submit" value="Submit">
            <div class="clearfix"> </div>
        </div>
        <div class="registration">
            Already Registered.
            <a class="" href="{{ route('login') }}">
                Login
            </a>
        </div>
    </form>
</div>
