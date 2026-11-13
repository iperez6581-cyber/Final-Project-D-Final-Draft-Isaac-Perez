<section class="page-intro">
    <p class="eyebrow">MEMBER ACCESS</p>
    <h1>Welcome back</h1>

    <p>
        Members use this page to sign in with the email address and password
        they entered on the signup form.
    </p>

    <p>
        The program checks the login information against member details stored
        in the current PHP session.
    </p>

    <p>
        If you have not joined the club yet, use the membership signup page
        first. This assignment version stores information temporarily in a
        session and does not use a database.
    </p>
</section>

<section class="form-layout">
    <div class="form-card login-card">
        <h2>Member login</h2>

        <form method="post" action="index.php">
            <input type="hidden" name="action" value="login">

            <label for="email">Email address</label>
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                value="<?= h($_POST['email'] ?? '') ?>"
            >

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
            >

            <button class="button" type="submit">Log in</button>
        </form>

        <p class="form-footer">
            New to the club?
            <a class="text-link" href="index.php?action=show_join">
                Create a membership
            </a>
        </p>
    </div>
</section>