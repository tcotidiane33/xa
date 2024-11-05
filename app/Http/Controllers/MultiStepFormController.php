<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BayAreaWebPro\MultiStepForms\MultiStepForm;
use App\Forms\ClientForm;

class MultiStepFormController extends Controller
{
    public function create(MultiStepForm $form)
    {
        $form = $form->make(ClientForm::class);
        return view('multistep.create', ['form' => $form]);
    }

    public function store(Request $request, MultiStepForm $form)
    {
        $form = $form->make(ClientForm::class);
        $form->validateStep($request);

        if ($form->isComplete()) {
            // Handle the final submission
            // Save the data to the database or perform other actions
            return redirect()->route('form.success');
        }

        return redirect()->route('form.create');
    }
}
