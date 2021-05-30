<?php
    function render($path, $data){
        $str = file_get_contents($path);
        $str = strtr($str, $data);
        return $str;
    }

    function get_data(){
        $main = file_get_contents('./templates/main.html');
        $header = file_get_contents('./templates/header.html');
        $footer = file_get_contents('./templates/footer.html');

        $games_str = file_get_contents('./src/data.json');
        $games_array = (array) json_decode($games_str);
    
        $body = $header;

        if(isset($_REQUEST['i']) == false || $_REQUEST['i'] == '' || $_REQUEST['i'] == '⬅ назад'){$i = 'main';}
        else{$i = $_REQUEST['i'];}

        if ($i == 'main'){$body .= $main;}
        else{
            if(array_key_exists($i, $games_array)){
                $game = (array) $games_array[$i];
                foreach ($game as $key => $value){
                    $game += ['{'.$key.'}' => $value];  
                }
                $body .= render('./templates/game.html', $game);
            }
            else{
                $body .= '<main style="display: flex; align-items: center; justify-content: center;"><img class="error404" src="/src/6536.jpg"></main>';
            }
        }

        $body .= $footer;

        $data = array(
            '{style}' => './src/style.css',
            '{body}' => $body
        );

        return $data;
    }

    $data = get_data();

    echo render('./templates/template.html', $data)
?>