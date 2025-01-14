
<body id="page-top" class="bg-light">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form method="POST" action="/app/sql/page_sql.php">
                                        <input type="hidden" name="select_type" value="Login">
                                    <div class="form-group">
                                        <label>USERNAME:</label>
                                        <input type="text" class="form-control bg-light" name="rk_user_id" placeholder="..." required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label>PASSWORD:</label>
                                        <input type="password" class="form-control bg-light" name="rk_user_pass" placeholder="..." required>
                                    </div>
                                        <button type="submit" class="btn btn-success btn-block">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small btn btn-sm btn-defalut" href="">Forgot Password?</a>
                                        <a class="small btn btn-sm btn-defalut" href="">Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>
</html>
