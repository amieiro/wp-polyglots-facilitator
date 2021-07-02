<?php


namespace App\Http\Helpers;


class TranslationBlock
{
    protected $comment;
    protected $msgctxt;
    protected $msgid;
    protected $msgid_plural;
    protected $msgstr;
    protected $msgstr0;
    protected $msgstr1;

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * Create a new instance
     *
     * @return void
     */
    public function __construct()
    {

    }
}
