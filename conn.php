<?php
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=tony1006";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      session_start();
      $_SESSION['check']=1;
   }


   $sql =<<<EOF
      SELECT * from calculate_record;
EOF;

   $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 
  $_SESSION['data']=array();
   while($row = pg_fetch_row($ret)){
      $_SESSION['data'][]=array(
          'id'=>$row[0],
          'currency'=>$row[1],
          'rate'=>$row[2],
          'price'=>$row[3],
          'discount'=>$row[4],
          'result'=>$row[5],
          'record_time'=>$row[6]
      );
   }
   pg_close($db);
   header("Location: ./index.php"); 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body >
        <!--<script>
            function post() {
                localStorage.setItem('uid','1');
};
                window.onload = post;
        </script>-->
    </body>
</html>
