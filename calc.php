<?php
include __DIR__.'/solve/Solve.php';

if (isset($_POST['submit']))
{
    $solve = new Solve($_POST);
    echo $solve->solvePuzzle() ;
}

