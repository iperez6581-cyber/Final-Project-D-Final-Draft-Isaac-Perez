<?php
/* Safely display text in the HTML page. */
function h($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

/* Find a membership plan in the plans array. */
function get_plan($plans, $plan_id)
{
    foreach ($plans as $id => $plan) {
        if ((string) $id === (string) $plan_id) {
            return $plan;
        }
    }

    return false;
}