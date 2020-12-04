<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;



class ApiController extends Controller
{



    public function mass() {


        return "hello";


    }





    public function sender() {


        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));

//        return var_dump($data);


        echo "Cообщение успешно обработано: телефон — $data->to и cообщение — $data->message";


        echo "<br>";

        echo "<hr>";



        $ch = curl_init("https://sms.ru/sms/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            "api_id" => "6E7AF9BF-8045-ABCE-CCC9-D75FF106BA86",
            "to" => $data->to, // До 100 штук до раз
            "msg" => iconv("windows-1251", "utf-8", $data->message), // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",
            "json" => 1 // Для получения более развернутого ответа от сервера
        )));
        $body = curl_exec($ch);
        curl_close($ch);




        $json = json_decode($body);
        if ($json) { // Получен ответ от сервера
            print_r($json); // Для дебага
            if ($json->status == "OK") { // Запрос выполнился
                foreach ($json->sms as $phone => $data) { // Перебираем массив СМС сообщений
                    if ($data->status == "OK") { // Сообщение отправлено
                        echo "Сообщение на номер $phone успешно отправлено. ";
                        echo "ID сообщения: $data->sms_id. ";
                        echo "";
                    } else { // Ошибка в отправке
                        echo "Сообщение на номер $phone не отправлено. ";
                        echo "Код ошибки: $data->status_code. ";
                        echo "Текст ошибки: $data->status_text. ";
                        echo "";
                    }
                }
                echo "Баланс после отправки: $json->balance руб.";
                echo "";
            } else { // Запрос не выполнился (возможно ошибка авторизации, параметрах, итд...)
                echo "Запрос не выполнился. ";
                echo "Код ошибки: $json->status_code. ";
                echo "Текст ошибки: $json->status_text. ";
            }
        } else {

            echo "Запрос не выполнился. Не удалось установить связь с сервером. ";

        }




    }



}