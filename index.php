<?php
    require_once('libraries/Steam_api.php');

    $steam = new Steam_api();
    $steam->setAPIKey('STEAM-API-KEY-HERE');
    $steam->setUserID('76561198049980139');
    $steam->setFormat('json');
    $response = $steam->makeRequest();
    $response = $steam->sortAPIResults($response, 'playtime');

    $percentage_ceiling = $response->response->games[0]->playtime_forever;
?>

<html class="no-js" lang="en">
    <head>   
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Steam API</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script.js"></script>
    </head>

    <body>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header"></div>
            </div>
        </div>

        <div class="container">
            <p>Below you can find my top 15 played games on Steam, accessed via the Steam API.</p>
            <hr>
            <div class="games_container">

                <?php $counter = 0; ?>
                <?php foreach($response->response->games as $game) : ?>
                    <?php
                        if($counter >= 15){
                            break;
                        }

                        $hours_played = round($game->playtime_forever / 60);

                        if(round($game->playtime_forever / 60) == 1){
                            $hours_text = 'hour';
                        } else {
                            $hours_text = 'hours';
                        }

                        if($game->playtime_forever <= 0){
                            $percentage = 0;
                        } else {
                           $percentage = ($game->playtime_forever / $percentage_ceiling) * 100; 
                        }
                    ?>

                    <p class="game_title"><?php echo $game->name; ?></p>
                    <p class="hours_played"><?php echo $hours_played; ?> <?php echo $hours_text; ?></p>
                    <div class="game" data-percentage="<?php echo $percentage; ?>%">
                        <img class="game_icon" src="http://media.steampowered.com/steamcommunity/public/images/apps/<?php echo $game->appid; ?>/<?php echo $game->img_icon_url; ?>.jpg">
                    </div>

                    <?php $counter++; ?>
                <?php endforeach; ?>

            </div>
        </div>
    </body>
</html>