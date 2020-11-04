<?php
    function setTime(string $time):string{
        $now = getdate();
        $time = getdate(strtotime($time));
        $year = abs($now['year'] - $time['year']);
        $month = abs($now['mon'] - $time['mon']);
        $day = abs($now['mday'] - $time['mday']);
        $week = round($day/7);

        $hour = abs($now['hours'] - $time['hours']);
        $min = abs($now['minutes'] - $time['minutes']);
        $sec = abs($now['seconds'] - $time['seconds']);
        $result = '';
        if($year > 0)
            $result = "hace {$year} año".($year == 1 ?'':'s');
        else if($month > 0 )
            $result = "hace {$month} mes".($month == 1 ?'':'es');
        else if($week > 0)
            $result = "hace {$week} semana".($week == 1 ?'':'s');
        else if($day > 0)
            $result = "hace {$day} dia".($day == 1 ?'':'s');
        else if($hour > 0)
            $result = "hace {$hour} hora".($hour == 1 ?'':'s');
        else if($min > 0)
            $result = "hace {$min} minuto".($min == 1 ?'':'s');
        else if($sec > 0)
            $result = "hace {$sec} segundo".($sec == 1 ?'':'s');
        else 
            $result = 'ahora';

        return $result;
    }

    function getMonth(string $month):string{
        $month = explode('-',$month);
        $month = count($month) == 1?explode('/',$month[0]):$month[1];
        switch($month){
            case '1':
                $month = 'enero';
            break;
            case '2':
                $month = 'febrero';
            break;
            case '3':
                $month = 'marzo';
            break;
            case '4':
                $month = 'abril';
            break;
            case '5':
                $month = 'mayo';
            break;
            case '6':
                $month = 'junio';
            break;
            case '7':
                $month = 'julio';
            break;
            case '8':
                $month = 'agosto';
            break;
            case '9':
                $month = 'septiembre';
            break;
            case '10':
                $month = 'octubre';
            break;
            case '11':
                $month = 'noviembre';
            break;
            case '12':
                $month = 'diciembre';
            break;
        }
        return $month;
    }

    function getServerAddress():string{
        //obteniendo la direccion del servidor 
        $server = explode('/',$_SERVER['HTTP_REFERER']);
        $last = array_key_last($server);
        unset($server[$last]);
        $server = implode('/',$server);
        return $server;
    }
?>