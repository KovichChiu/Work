<?php
include __DIR__ . '/config/db_config.php';

class orderTicket
{
    private $t_id;
    private $t_name;
    private $t_price;
    private $t_content;
    private $t_pics;

    function __construct($t_id)
    {
        global $conn;
        $sql = "SELECT * FROM `ticket` WHERE `t_id` =" . $t_id;
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $this->t_id = $row['t_id'];
            $this->t_name = $row['t_name'];
            $this->t_price = $row['t_price'];
            $this->t_content = $row['t_content'];
            $this->t_pics = $row['t_pics'];
        }
    }

    function getID()
    {
        return $this->t_id;
    }

    function getName()
    {
        return $this->t_name;
    }

    function getPrice()
    {
        return $this->t_price;
    }

    function getContent()
    {
        return $this->t_content;
    }

    function getPics()
    {
        return $this->t_pics;
    }
}