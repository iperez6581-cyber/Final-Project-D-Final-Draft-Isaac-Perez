<section class="confirmation-card">
    <p class="eyebrow">SIGN-UP STATUS</p>
    <h1>Membership confirmation</h1>

    <?php if ($confirmed_member && $confirmed_plan): ?>
        <p>
            Thank you, <?= h($confirmed_member['first_name']) ?>.
            Your Trailhead Outdoor Club signup was recorded.
        </p>

        <p>
            <strong>Name:</strong>
            <?= h($confirmed_member['first_name'] . ' ' . $confirmed_member['last_name']) ?><br>
            <strong>Membership:</strong>
            <?= h($confirmed_plan['name']) ?><br>
            <strong>Signup date:</strong>
            <?= h(date('F j, Y', strtotime($confirmed_member['joined_date']))) ?>
        </p>

        <p>
            Your membership information is available during this PHP session.
            This assignment version does not process payments or permanently
            save accounts.
        </p>

        <a class="button" href="index.php?action=home">Return home</a>
    <?php else: ?>
        <p>
            This page shows the result after a visitor submits the membership
            signup form.
        </p>

        <p>
            No recent signup was found in this browser session. You can return
            to the home page to review the membership choices.
        </p>

        <p>
            When you are ready, open the signup page and complete the form to
            create a membership.
        </p>

        <a class="button" href="index.php?action=show_join">Go to signup</a>
    <?php endif; ?>
</section>