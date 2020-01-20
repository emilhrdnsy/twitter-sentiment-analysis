<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Cache-Control" content="no-cache">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="Lang" content="en">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.0/css/bulma.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="style.css">
   <title>Twitter Sentiment Analysis</title>
</head>

<body>
   <div class="container mt-5">
      <div class="shadow p-3 mb-5 bg-white rounded">
      <h1 class="title justify-content-center">Twitter Sentiment Analysis</h1>
      <p>Type your keyword below to perform Sentiment Analysis on Twitter Results:</p>
      <form method="GET">
         <div class="row mt-2 text-center">
            <div class="col">
               <input type="text" name="q" class="input is-info" style="width: 50%" placeholder="Keyword" /> 
               <input type="submit" class="button is-info" />       
            </div>
         </div> 
      </form>
   </div>

   <?php
      
      if(isset($_GET['q']) && $_GET['q']!='') {
         include_once(dirname(__FILE__).'/config.php');
         include_once(dirname(__FILE__).'/lib/TwitterSentimentAnalysis.php');

         $TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY,TWITTER_CONSUMER_KEY,TWITTER_CONSUMER_SECRET,TWITTER_ACCESS_KEY,TWITTER_ACCESS_SECRET);

         //Search Tweets parameters as described at https://dev.twitter.com/docs/api/1.1/get/search/tweets
         $twitterSearchParams=array(
            'q'=>$_GET['q'],
            'lang'=>'en',
            'count'=>100,
         );
         $results=$TwitterSentimentAnalysis->sentimentAnalysis($twitterSearchParams);
   ?>
      <div class="shadow p-3 mb-5 bg-white rounded">
         <h1>Hasil untuk "<?php echo $_GET['q']; ?>"</h1>
         <br>
         <table border="1">
            <tr>
                  <td>Id</td>
                  <td>User</td>
                  <td>Text</td>
                  <td>Twitter Link</td>
                  <td>Sentiment</td>
            </tr>
            <?php
               foreach($results as $tweet) {
                  
                  $color=NULL;
                  if($tweet['sentiment']=='positive') {
                     $color='#00FF00';
                  }
                  else if($tweet['sentiment']=='negative') {
                     $color='#FF0000';
                  }
                  else if($tweet['sentiment']=='neutral') {
                     $color='#FFFFFF';
                  }
                  ?>
                  <tr style="background:<?php echo $color; ?>;">
                     <td><?php echo $tweet['id']; ?></td>
                     <td><?php echo $tweet['user']; ?></td>
                     <td><?php echo $tweet['text']; ?></td>
                     <td><a href="<?php echo $tweet['url']; ?>" target="_blank">View</a></td>
                     <td><?php echo $tweet['sentiment']; ?></td>
                  </tr>
            <?php  }  ?>    
         </table>
      </div>
      <?php
      }
   ?>

   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
