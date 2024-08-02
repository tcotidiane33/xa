<?php

use App\Admin\Forms\Steps;
use App\Http\Controllers\Controller;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Widgets\MultipleSteps;

class FormController extends Controller
{
    public function register(Content $content)
    {
        $steps = [
            'info'     => Steps\Info::class,
            'profile'  => Steps\Profile::class,
            'password' => Steps\Password::class,
        ];

        return $content
            ->title('Register')
            ->body(MultipleSteps::make($steps));
    }
}
