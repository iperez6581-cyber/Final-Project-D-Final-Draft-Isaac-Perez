<section class="hero">
    <div class="hero-text">
        <p class="eyebrow">WELCOME TO THE OUTDOORS</p>
        <h1>Make room for your next adventure.</h1>

        <p>
            Trailhead Outdoor Club helps people spend more time outside and
            learn practical camping skills. Visitors can explore the membership
            choices and sign up for the one that fits them.
        </p>

        <p>
            Our target audience is beginner and intermediate outdoor enthusiasts,
            including individuals and families interested in hiking, camping,
            and outdoor workshops.
        </p>

        <p>
            Members can read about club activities, learn basic outdoor skills,
            and connect with other people who enjoy exploring nature.
        </p>

        <a class="button" href="index.php?action=show_join">
            Explore membership
        </a>
    </div>

    <div class="hero-panel">
        <span class="hero-icon">✦</span>
        <h2>Find your trail</h2>
        <p>Start with a membership and choose the outdoor activities that interest you.</p>
    </div>
</section>

<section class="section-heading">
    <p class="eyebrow">MEMBERSHIP OPTIONS</p>
    <h2>Choose your starting point</h2>
    <p>Each option is designed for a different kind of outdoor enthusiast.</p>
</section>

<section class="plan-grid">
    <?php foreach ($plans as $id => $plan): ?>
        <article class="plan-card">
            <p class="plan-number">0<?= h($id) ?></p>
            <h3><?= h($plan['name']) ?></h3>
            <p><?= h($plan['description']) ?></p>
            <p class="plan-detail"><?= h($plan['detail']) ?></p>
            <a class="text-link" href="index.php?action=show_join">
                Choose this membership
                <span aria-hidden="true">→</span>
            </a>
        </article>
    <?php endforeach; ?>
</section>

<section class="info-panel">
    <div>
        <p class="eyebrow">A SIMPLE WAY TO GET STARTED</p>
        <h2>Outdoor learning for real life</h2>
    </div>

    <p>
        This assignment website demonstrates PHP forms, arrays, functions,
        loops, strings, sessions, and cookies. Member information is held in
        the current session; it is not permanently stored in a database.
    </p>
</section>