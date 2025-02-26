<form action="/registration" method=POST>
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <label style="color: red;">
            <?php echo $errors['name']??"";?></label>
        <input type="text" placeholder="Enter Name" name="name" id="name" required>

        <label for="email"><b>Email</b></label>
        <label style="color: red;">
            <?php echo $errors['email']??"";?></label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="psw"><b>Password</b></label>
        <label style="color: red;">
            <?php echo $errors['password']??"";?></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <label style="color: red;">
            <?php echo $errors['password-repeat']??"";?></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="/login">Sign in</a>.</p>
    </div>
</form>


<style>
    * {box-sizing: border-box}

    form {
        border: 3px solid #f1f1f1;
    }


    .container {
        padding: 16px;
    }

    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }


    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }


    a {
        color: dodgerblue;
    }

    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
