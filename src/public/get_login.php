<body>

<!--form area start-->
<div class="form">
    <!--login form start-->
    <form class="login-form" action="handle_login.php" method="POST">
        <i class="fas fa-user-circle"></i>
        <input class="user-input" type="text" name="email" placeholder="E-mail" required>
        <label style="color:red">
            <?php if(isset($errors["email"])){
                print_r($errors['email']);} ?>
        </label>
        <input class="user-input" type="password" name="password" placeholder="Password" required>
        <label style="color:red">
            <?php if(isset($errors["password"])){
                print_r($errors['password']);} ?>
        </label>
        <div class="options-01">
            <label class="remember-me"><input type="checkbox" name="">Remember me</label>
            <a href="#">Forgot your password?</a>
        </div>
        <input class="btn" type="submit" name="" value="LOGIN">
        <div class="options-02">
            <p>Not Registered? <a href="#">Create an Account</a></p>
        </div>
    </form>
    <!--login form end-->
    <!--signup form start-->
    <form class="signup-form" action="handle_registration.php" method="POST">
        <i class="fas fa-user-plus"></i>
        <input class="user-input" type="text" name="name" placeholder="Username" required>
        <input class="user-input" type="email" name="email" placeholder="Email Address" required>
        <input class="user-input" type="password" name="psw" placeholder="Password" required>
        <input class="btn" type="submit" name="psw-repeat" value="SIGN UP">
        <div class="options-02">
            <p>Already Registered? <a href="#">Sign In</a></p>
        </div>
    </form>
    <!--signup form end-->

    <br>
    <br>

    <!--form area end-->

</body>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #111;
    }

    .form {
        z-index: 1;
        font-family: "Poppins", sans-serif;
        position: absolute;
        width: 320px;
        text-align: center;
    }

    .form i {
        z-index: 1;
        color: #ccc;
        font-size: 65px;
        margin-bottom: 30px;
    }

    .form .signup-form {
        display: none;
    }

    .form .user-input {
        width: 320px;
        height: 55px;
        margin-bottom: 30px;
        outline: none;
        border: none;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        font-size: 18px;
        text-align: center;
        border-radius: 5px;
        transition: 0.5s;
        transition-property: border-left, border-right, box-shadow;
    }

    .form .user-input:hover,
    .form .user-input:focus,
    .form .user-input:active {
        border-left: solid 8px #4285f4;
        border-right: solid 8px #4285f4;
        box-shadow: 0 0 100px rgba(66, 133, 244, 0.8);
    }

    .form .options-01 {
        margin-bottom: 50px;
    }

    .form .options-01 input {
        width: 15px;
        height: 15px;
        margin-right: 5px;
    }

    .form .options-01 .remember-me {
        color: #bbb;
        font-size: 14px;
        display: flex;
        align-items: center;
        float: left;
        cursor: pointer;
    }

    .form .options-01 a {
        color: #888;
        font-size: 14px;
        font-style: italic;
        float: right;
    }

    .form .btn {
        outline: none;
        border: none;
        width: 320px;
        height: 55px;
        background: #4285f4;
        color: #fff;
        font-size: 18px;
        letter-spacing: 1px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.5s;
        transition-property: border-left, border-right, box-shadow;
    }

    .form .btn:hover {
        border-left: solid 8px rgba(255, 255, 255, 0.5);
        border-right: solid 8px rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 100px rgba(66, 133, 244, 0.8);
    }

    .form .options-02 {
        color: #bbb;
        font-size: 14px;
        margin-top: 30px;
    }

    .form .options-02 a {
        color: #4285f4;
    }
    .b-btn {
        color: white;
    }
    .b-btn.paypal i {
        color: blue;
    }
    .b-btn:hover {
        text-decoration: underline;
    }
    .b-btn i {
        font-size: 20px;
        color: yellow;
        margin-top: 2rem;
    }
    .d-flex {
        display: flex;
        justify-content: space-between;
    }
    /* Responsive CSS */

    @media screen and (max-width: 500px) {
        .form {
            width: 95%;
        }

        .form .user-input {
            width: 100%;
        }

        .form .btn {
            width: 100%;
        }
    }

</style>