<?php

namespace App\Rules;

use App\Models\Classroom;
use Illuminate\Contracts\Validation\Rule;

class ClassroomTimeOverlap implements Rule
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
        return Classroom::where('start_time', '<=', $value)->where('end_time', '>=', $value)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Class room time overlaps with existing class room';
    }
}
