<?php
include 'functions.php';
$sql = "SELECT `u`.`u_name` as `name`,`o`.`o_no` as `no`,`o`.`o_time` as `time`,`t`.`t_name` as `ticketName`,`o`.`o_tpics` as `pics` FROM `order` as `o` INNER JOIN `u_account` as `u` ON `o`.`o_uid` = `u`.`u_id` INNER JOIN `ticket` as `t` ON `o`.`o_tid` = `t`.`t_id` WHERE `o`.`o_uid` = '{$_SESSION['u_id']}'";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
    <?php
    headinc();
    ?>
    <title>OrderTickets</title>

    <!-- DataTables -->
    <!-- MDBootstrap Datatables  -->
    <link href="css/datatables.min.css" rel="stylesheet">
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="js/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#dt').DataTable({
                "language": {
                    "processing":   "處理中...",
                    "loadingRecords": "載入中...",
                    "lengthMenu":   "顯示 _MENU_ 項結果",
                    "zeroRecords":  "沒有符合的結果",
                    "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                    "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
                    "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                    "infoPostFix":  "",
                    "search":       "搜尋:",
                    "paginate": {
                        "first":    "第一頁",
                        "previous": "上一頁",
                        "next":     "下一頁",
                        "last":     "最後一頁"
                    },
                    "aria": {
                        "sortAscending":  ": 升冪排列",
                        "sortDescending": ": 降冪排列"
                    }
                }
            });
            $('.dataTables_length').addClass('bs-select');
        });

    </script>


</head>
<body>
<div class="container">
    <?php
    navBar();
    ?>
    <h1>
        訂購清單
    </h1>
    <hr>
    <table id="dt" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="th-sm">訂購人</th>
                <th class="th-sm">訂購編號</th>
                <th class="th-sm">訂購時間</th>
                <th class="th-sm">訂購場次</th>
                <th class="th-sm">訂購數量</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            $row['no'] = substr($row['no'], 0, 8);
            echo "<td>{$row['no']}</td>";
            $row['time'] = date("Y-m-d H:i", $row['time']);
            echo "<td>{$row['time']}</td>";
            echo "<td>{$row['ticketName']}</td>";
            echo "<td>{$row['pics']}</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
