<section class="page-intro">
    <p class="eyebrow">MEMBERSHIP SIGN-UP</p>
    <h1>Join Trailhead Outdoor Club</h1>

    <p>
        This page is for people who want to join Trailhead Outdoor Club. Enter
        your contact information and choose the membership type that best fits
        your outdoor interests.
    </p>

    <p>
        The membership choices support people who are new to camping, people
        interested in hiking and workshops, and families who want to explore
        outdoor activities together.
    </p>

    <p>
        After you submit the form, the program checks your information and
        displays a confirmation page. The account is stored in the PHP session
        for this assignment.
    </p>
</section>

<section class="form-layout">
    <div class="form-card">
        <h2>Your information</h2>
        <p>Fields marked as required must be completed.</p>

        <form method="post" action="index.php">
            <input type="hidden" name="action" value="join">

            <label for="first_name">First name</label>
            <input
                id="first_name"
                name="first_name"
                type="text"
                autocomplete="given-name"
                required
                value="<?= h($_POST['first_name'] ?? '') ?>"
            >

            <label for="last_name">Last name</label>
            <input
                id="last_name"
                name="last_name"
                type="text"
                autocomplete="family-name"
                required
                value="<?= h($_POST['last_name'] ?? '') ?>"
            >

            <label for="email">Email address</label>
            <input
                id="email"
                name="email"
                type="email"
                autocomplete="email"
                required
                value="<?= h($_POST['email'] ?? '') ?>"
            >

            <label for="phone">Phone number <span>(optional)</span></label>
            <input
                id="phone"
                name="phone"
                type="tel"
                autocomplete="tel"
                value="<?= h($_POST['phone'] ?? '') ?>"
            >

            <label for="plan_id">Membership type</label>
            <select id="plan_id" name="plan_id" required>
                <option value="">Choose a membership</option>

                <?php foreach ($plans as $id => $plan): ?>
                    <option
                        value="<?= h($id) ?>"
                        <?= (($_POST['plan_id'] ?? '') == $id) ? 'selected' : '' ?>
                    >
                        <?= h($plan['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                minlength="8"
                required
            >
            <p class="field-help">Use at least 8 characters.</p>

            <button class="button" type="submit">Create membership</button>
        </form>
    </div>

    <aside class="side-note">
        <p class="eyebrow">BEFORE YOU JOIN</p>
        <h2>What happens next?</h2>
        <p>Your information is checked before the membership is created.</p>
        <p>You will see a confirmation page after successful signup.</p>
        <p>This class project does not collect payment information.</p>
    </aside>
</section>