<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TCKN implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->check($value) === true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    private function check($tckn=null)
    {
        if(!ctype_digit($tckn))
            return false;

        $tckn=trim($tckn);
        $tckn=trim($tckn,"0");

        if(strlen($tckn)!=11)
            return false;

        $singularDigits=0;
        $pluralDigits=0;

        for($i=0; $i<=8; $i+=2)
            $singularDigits+=$tckn[$i];

        for($i=1; $i<=7; $i+=2)
            $pluralDigits+=$tckn[$i];

        if( ((7*$singularDigits)-$pluralDigits)%10!=$tckn[9] )
            return false;

        $total=0;
        for($i=0; $i<=9; $i++)
            $total+=$tckn[$i];

        if($total%10!=$tckn[10])
            return false;
        else
            return true;
    }
}
