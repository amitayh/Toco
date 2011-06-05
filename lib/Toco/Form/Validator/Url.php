<?php

class Toco_Form_Validator_Url extends Toco_Form_Validator_Regex
{

    protected $_pattern = '/^(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]$/i';

    protected $_message = 'Enter a valid URL';

}