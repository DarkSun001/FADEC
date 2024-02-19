<?php

Class GenId
{
    function generateRandomId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomId = '';
        for ($i = 0; $i < 10; $i++) {
            $randomId .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomId;
    }
}