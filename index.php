<?php
//禁用错误报告
error_reporting(0);
?>
 <html>
  <head>
    <title>Title</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>  
    <div id = "app">
    <h2>即時匯率轉換器</h2>
    幣別：
    <select name="currency">
      <option value="USD">美金</option>
      <option value="TWD">台幣</option>
      <option value="JPY">日幣</option>
    </select>
    金額：<input v-model="price"  type="number" step="0.01" name="price"/> - 折扣： <input type="number" step="0.01" name="discount" v-model="discount" /> = 台幣結果： {{result}}
    <br/>
    <br/>
    <button v-on:click="calculate()">計算</button>
    <button id="listBtn"  onclick="javascript:location.href='./conn.php'">查看紀錄</button>
        <!--<div id="textlistn" style="display:none;">
            hello
        </div>
       <script>  
           function listBtn() {
               localStorage.getItem('uid');
               console.log(localStorage.getItem('uid'));
               var listBtn = document.getElementById('listBtn');
               var textlistn = document.getElementById('textlistn');
               if (textlistn.style.display === 'none' & uid==1) {
                   textlistn.style.display = 'block';
                   listBtn.innerText = "隱藏";
               } else {
                   textlistn.style.display = 'none';
                   listBtn.innerText = "秀出來";
               }
               localStorage.removeItem('uid');
}
</script>-->

       <?php
        session_start();
            foreach( $_SESSION['data'] as $i){
            ?>
        <table>
            <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['id'];
} ?><td></tr>
            <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['currency'];
} ?><td></tr>
      <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['rate'];
} ?><td></tr>
      <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['price'];
} ?><td></tr>
            <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['discount'];
} ?><td></tr>
            <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['result'];
} ?><td></tr>
            <tr><td><?php session_start(); if ($_SESSION['check']==1){
    echo $i['record_time'];
} ?><td></tr>
       <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
            <tr><td></td></tr>
        </table>
               <?php
            }
            ?>
    <?php
    unset($_SESSION['check']);
    unset($_SESSION['data']); 
?>
    <ul>
      <li style="color:red">注意：幣別為美金或日幣時，折扣功能無效.</li>
      <li style="color:red">注意：幣別為台幣時，需有折扣功能.</li>
    </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <script>
      var app = new Vue({
        el: '#app',
        data: {
            price: 0.0,
            discount: 0.0,
            currency: "",
            result: 0.0,
        },
        methods: {
            calculate: async function() {
              let that = this;
              var myHeaders = new Headers();
              myHeaders.append("Content-Type", "application/json");

              var raw = JSON.stringify({
                "price": parseFloat(that.price),
                "discount": parseFloat(that.discount),
                "currency": that.currency
            });

            var requestOptions = {
              method: 'POST',
              headers: myHeaders,
              body: raw,
              redirect: 'follow'
            };
            
            fetch("https://www.myurl.com:8080/calculate", requestOptions)
              .then(response => response.text())
              .then(function(resp){
                let res = JSON.parse(resp)
                that.result = res.result_price;
              })
          },      
        }
      })
    </script>
  </body>
</html>