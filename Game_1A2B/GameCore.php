<?php

class GameCore
{

    protected $answerBOT = null;
    protected $answerPLAYER = null;
    protected $answerLength = 4;
    protected $counterA = 0;
    protected $counterB = 0;
    protected $times = 0;
    protected $history = null;

    function newGame()
    {
        $this->__setAnswer();
    }

    //設定答案
    function __setAnswer()
    {

        $rndRange = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9); //建立亂數區間
        shuffle($rndRange); //打亂區間
        $this->answerBOT = array_slice($rndRange, 0, $this->answerLength); //取前n位

    }

    //設定玩家輸入值
    public function setAnswerPLAYER($answer)
    {
        $this->answerPLAYER = preg_split('//', $answer, -1, PREG_SPLIT_NO_EMPTY);
    }

    //確認玩家輸入值是否有重複(利用總數量與種類數量區分，若不同則為TRUE)
    public function checkRepeat()
    {
        return count($this->answerPLAYER) != count(array_unique($this->answerPLAYER));
    }

    //確認玩家答案
    public function checkAnswer()
    {
        $this->countTimes();
        $this->setCounterA(0);
        $this->setCounterB(0);
        $tmpAnsBot = $this->answerBOT;
        $tmpAnsPLY = $this->answerPLAYER;
        $tmpInput = "";
        for ($i = 0; $i < $this->answerLength; $i++) {
            $tmpInput .= $tmpAnsPLY[$i];
            if (in_array((int)$tmpAnsPLY[$i], $tmpAnsBot, false)) {
                $this->counterA += ((int)$tmpAnsPLY[$i] == $tmpAnsBot[$i]) ? (1) : (0);
                $this->counterB += ((int)$tmpAnsPLY[$i] != $tmpAnsBot[$i]) ? (1) : (0);
            }
        }
        $this->addHistory($this->times . ". " . $tmpInput . " " . $this->counterA . "A" . $this->counterB . "B");
    }

    //增加次數

    public function countTimes()
    {
        $this->times++;
    }

    //取得次數

    public function addHistory($history)
    {
        $this->history .= $history . "\\n";
    }

    //增加紀錄

    public function getTimes()
    {
        return $this->times;
    }

    //取得紀錄

    public function getHistory()
    {
        return $this->history;
    }

    //取得A數

    public function getCounterA()
    {
        return $this->counterA;
    }

    //設定A數

    public function setCounterA($counterA)
    {
        $this->counterA = $counterA;
    }

    //取得B數

    public function getCounterB()
    {
        return $this->counterB;
    }

    //設定B數

    public function setCounterB($counterB)
    {
        $this->counterB = $counterB;
    }

}
