<?php

namespace App\Rules;

use Auth;
use Illuminate\Contracts\Validation\ImplicitRule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

class OnePerDayRule implements ImplicitRule
{
    /**
     * @var string
     */
    private $modelName;
    /**
     * @var Carbon
     */
    private $date;

    /**
     * Create a new rule instance.
     *
     * @param string $modelName
     */
    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Auth::getUser();
        /* @var Model $model */
        $model = $this->modelName::where(['user_id' => $user->id])
            ->orderByDesc($attribute)
            ->first();
        
        if (is_null($model)) {
            return true;
        }

        if ($model->{$attribute} instanceof Carbon) {
            $this->date = $model->{$attribute};
            $yesterday = Date::now()->subDay();

            return $yesterday->gt($model->{$attribute});
        }

        throw new \LogicException('Attribute is not instance of Carbon class.');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->date) {
            $tomorrow = $this->date->addDay();
        } else {
            $tomorrow = Date::now()->addDay();
        }

        return "You will be able to create new application after $tomorrow.";
    }
}
