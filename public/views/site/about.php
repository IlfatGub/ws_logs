
<pre>
   <?php
   $myvkreq = file_get_contents('http://logs.snhrs.ru/web/index.php/api?search=%D0%91%D0%B0%D1%81%D0%B8%D0%BC%D0%BE%D0%B2');
   $i =json_decode($myvkreq);
   print_r($i->data);


   foreach(json_decode($myvkreq)->data as $item){
       echo $item->datehost;
       echo '<br>';
       echo $item->host;
       echo '<br>';

       echo $item->login;
       echo '<br>';

       echo $item->name;
       echo '<br>';

       echo $item->ip;
   }
   ?>
</pre>
