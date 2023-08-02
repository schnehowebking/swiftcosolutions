// CustomChatify.php

<?php

//...
use Chatify\ChatifyMessenger;

class CustomChatify extends ChatifyMessenger{

    // Here, override the methods you want. 
    // For example:
    public function fetchMessage($id, $index = null)
    {
        //...
    }
}