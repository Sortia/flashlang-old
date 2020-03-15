<?php

function percent(float $progress, float $total): float {
    return ($progress / ($total == 0 ? 1 : $total)) * 100;
}

