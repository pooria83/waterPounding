<?php

class Solve
{
    private $fistVolume;
    private $secondVolume;
    private $goal;
    private $maxNumber = 100000;

    public function __construct($params)
    {
        $this->fistVolume = $params['firstVolume'];
        $this->secondVolume = $params['secondVolume'];
        $this->goal = $params['goal'];
    }

    public function solvePuzzle()
    {
        $checkResult = $this->isPossibleToSolve();
        if ($checkResult['state'] == false) {
            return $checkResult['result'];
        }
        return $this->pourUnilaterally();
    }

    protected function isPossibleToSolve()
    {
        if ($this->fistVolume == $this->secondVolume) {
            return [
                'state' => false,
                'result' => 'THE CONTAINERS VOLUME ARE EQUAL!'
            ];
        }
        //impossible to solve if goal is greater than both of volumes
        if ($this->goal > $this->fistVolume && $this->goal > $this->secondVolume) {
            return [
                'state' => false,
                'result' => 'THE GOAL IS BIGGER THAN NUMBERS.......'
            ];
        }
        if ($this->checkPythagorean() == false) {
            return [
                'state' => false,
                'result' => 'THE NUMBERS ARE NOT PYTHAGOREAN! '
            ];
        }
        return [
            'state' => true,
            'result' => ''
        ];
    }

    protected function checkPythagorean()
    {
        if (pow($this->fistVolume, 2) + (pow($this->goal, 2)) == pow($this->secondVolume, 2)
            || pow($this->secondVolume, 2) + (pow($this->goal, 2)) == pow($this->fistVolume, 2))
            return true;
        else
            return false;
    }

    protected function pourUnilaterally()
    {
        if ($this->fistVolume > $this->secondVolume) {
            $fromVolume = $this->fistVolume;
            $toVolume = $this->secondVolume;
        } else {
            $fromVolume = $this->secondVolume;
            $toVolume = $this->fistVolume;
        }

        $fromCurrentState = 0;
        $toCurrentState = 0;
        $goal = $this->goal;
        $returnText = "First Container Value : {$fromVolume} , Second Container Value : {$toVolume} , Goal : {$goal}<br><br>";


        for ($i = 0; $i <= $this->maxNumber; $i++) {
            // Return steps if goal found
            if ($goal == $fromCurrentState || $goal === $toCurrentState) {
                $returnText .= "<br>GOAL ACHIEVED!...............";
                return $returnText;
            }

            // If source vessel is empty, fill it
            if ($fromCurrentState == 0) {
                $fromCurrentState = $fromVolume;

                // If target vessel is full, empty it
            } elseif ($toCurrentState == $toVolume) {
                $toCurrentState = 0;
            } else {
                // Otherwise pour water from source vessel to target vessel
                $toCurrentState += $fromCurrentState;
                $fromCurrentState = 0;

                // If target vessel is overfilled, keep some water in source vessel
                if ($toCurrentState > $toVolume) {
                    $fromCurrentState = $toCurrentState - $toVolume;
                    $toCurrentState = $toVolume;
                }
            }
            $step = $i + 1;
            $returnText .= "STEP {$step} => From Current State : {$fromCurrentState} , To Current State : {$toCurrentState} <br>";

        }

        throw new Exception('Reached maximum depth, could not find solution');
    }

}