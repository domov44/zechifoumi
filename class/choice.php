<?php

class Choice{
    public string $value;
    public string $label;
    public string $nemesisValue;

    public function __construct( string $value, string $label, string $nemesisValue){
        $this->value = $value;
        $this->label = $label;
        $this->nemesisValue = $nemesisValue;
    }
}
?>