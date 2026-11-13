<?php
require_once 'functions.php';

/* Start a session so the site can remember a member while they use it. */
$session_lifetime = 60 * 60 * 24 * 14;
session_set_cookie_params($session_lifetime, '/');
session_start();

/* These membership choices are stored in an array. */
$plans = [
    1 => [
        'name' => 'Starter Camper',
        'description' => 'A good choice for people who are new to camping.',
        'detail' => 'Get beginner tips and information about club activities.'
    ],
    2 => [
        'name' => 'Trail Explorer',
        'description' => 'For people interested in hiking and outdoor workshops.',
        'detail' => 'Learn about trails, outdoor skills, and club workshops.'
    ],
    3 => [
        'name' => 'Family Outdoors',
        'description' => 'For families who want to learn and explore together.',
        'detail' => 'Find outdoor activities that families can enjoy together.'
    ]
];

/* Create the members array if it does not exist yet. */
if (!isset($_SESSION['members'])) {
    $_SESSION['members'] = [];
}

/* Find out which action the user selected. */
$action = filter_input(INPUT_POST, 'action');

if ($action === null || $action === false) {
    $action = filter_input(INPUT_GET, 'action');
}

if ($action === null || $action === false || $action === '') {
    $action = 'home';
}

$errors = [];
$view_file = 'home_view.php';

/* Use a switch statement to select the page or process a form. */
switch ($action) {
    case 'home':
        $view_file = 'home_view.php';
        break;

    case 'show_join':
        $view_file = 'join_view.php';
        break;

    case 'show_login':
        $view_file = 'login_view.php';
        break;

    case 'confirmation':
        $view_file = 'confirmation_view.php';
        break;

    case 'join':
        $view_file = 'join_view.php';

        $first_name = trim(filter_input(INPUT_POST, 'first_name') ?? '');
        $last_name = trim(filter_input(INPUT_POST, 'last_name') ?? '');
        $email = strtolower(trim(filter_input(INPUT_POST, 'email') ?? ''));
        $phone = trim(filter_input(INPUT_POST, 'phone') ?? '');
        $password = filter_input(INPUT_POST, 'password') ?? '';
        $plan_id = filter_input(INPUT_POST, 'plan_id');

        $selected_plan = get_plan($plans, $plan_id);

        if ($first_name === '' || $last_name === '') {
            $errors[] = 'Please enter your first and last name.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }

        if (strlen($password) < 8) {
            $errors[] = 'Your password must be at least 8 characters.';
        }

        if (!$selected_plan) {
            $errors[] = 'Please choose a membership type.';
        }

        if (isset($_SESSION['members'][$email])) {
            $errors[] = 'That email already has an account. Please log in.';
        }

        if (count($errors) === 0) {
            $_SESSION['members'][$email] = [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
                'plan_id' => (int) $plan_id,
                'joined_date' => date('Y-m-d'),
                'password_hash' => password_hash($password, PASSWORD_DEFAULT)
            ];

            $_SESSION['member_email'] = $email;
            $_SESSION['member_name'] = $first_name;
            $_SESSION['last_joined_email'] = $email;

            header('Location: index.php?action=confirmation');
            exit;
        }
        break;

    case 'login':
        $view_file = 'login_view.php';

        $email = strtolower(trim(filter_input(INPUT_POST, 'email') ?? ''));
        $password = filter_input(INPUT_POST, 'password') ?? '';

        if (isset($_SESSION['members'][$email])) {
            $member = $_SESSION['members'][$email];

            if (password_verify($password, $member['password_hash'])) {
                $_SESSION['member_email'] = $email;
                $_SESSION['member_name'] = $member['first_name'];

                header('Location: index.php?action=home');
                exit;
            }
        }

        $errors[] = 'The email or password was not correct.';
        break;

    case 'logout':
        unset($_SESSION['member_email']);
        unset($_SESSION['member_name']);
        unset($_SESSION['last_joined_email']);

        header('Location: index.php?action=home');
        exit;

    case 'accept_cookies':
        $return_action = filter_input(INPUT_POST, 'return_action');

        $allowed_actions = [
            'home',
            'show_join',
            'show_login',
            'confirmation'
        ];

        if (!in_array($return_action, $allowed_actions, true)) {
            $return_action = 'home';
        }

        setcookie(
            'club_cookie_choice',
            'accepted',
            time() + (60 * 60 * 24 * 30),
            '/'
        );

        header('Location: index.php?action=' . rawurlencode($return_action));
        exit;

    default:
        $view_file = 'home_view.php';
        break;
}

/* Find the member and plan for the confirmation page. */
$confirmed_member = null;
$confirmed_plan = null;

if (isset($_SESSION['last_joined_email'])) {
    $joined_email = $_SESSION['last_joined_email'];

    if (isset($_SESSION['members'][$joined_email])) {
        $confirmed_member = $_SESSION['members'][$joined_email];
        $confirmed_plan = get_plan($plans, $confirmed_member['plan_id']);
    }
}

/* Choose where the cookie form will return after it is submitted. */
$return_action = 'home';

if ($view_file === 'join_view.php') {
    $return_action = 'show_join';
} elseif ($view_file === 'login_view.php') {
    $return_action = 'show_login';
} elseif ($view_file === 'confirmation_view.php') {
    $return_action = 'confirmation';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trailhead Outdoor Club</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <div class="header-content">
        <a class="brand" href="index.php?action=home">
            <span class="brand-mark">T</span>
            <span>Trailhead <small>Outdoor Club</small></span>
        </a>

        <nav>
            <a href="index.php?action=home">Home</a>
            <a href="index.php?action=show_join">Join the club</a>

            <?php if (isset($_SESSION['member_email'])): ?>
                <span class="welcome">
                    Welcome, <?= h($_SESSION['member_name']) ?>
                </span>

                <form class="inline-form" method="post" action="index.php">
                    <input type="hidden" name="action" value="logout">
                    <button class="button button-small button-outline" type="submit">
                        Log out
                    </button>
                </form>
            <?php else: ?>
                <a href="index.php?action=show_login">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="page-content">
    <?php if (count($errors) > 0): ?>
        <div class="errors" role="alert">
            <strong>Please check the following:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php include $view_file; ?>
</main>

<footer class="site-footer">
    <p>Trailhead Outdoor Club</p>
    <p>Learn outside. Explore together.</p>
</footer>

<?php if (!isset($_COOKIE['club_cookie_choice'])): ?>
    <aside class="cookie-box">
        <div>
            <strong>Cookie notice</strong>
            <p>This site uses a cookie to remember that you accepted this notice.</p>
        </div>

        <form method="post" action="index.php">
            <input type="hidden" name="action" value="accept_cookies">
            <input type="hidden" name="return_action" value="<?= h($return_action) ?>">
            <button class="button button-small" type="submit">
                Accept
            </button>
        </form>
    </aside>
<?php endif; ?>

</body>
</html>