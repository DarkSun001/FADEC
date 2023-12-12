<?php
namespace App\Forms;

use App\Core\Validator;

class Login extends Validator
{
    public $method = "POST";
    protected array $config = [];

    public function getConfig(): array
    {
        $this->config = [
            "config"=>[
                "method"=>$this->method,
                "action"=>"",
                "id"=>"login-form",
                "class"=>"space-y-6",
                "submit"=>"Login",
                "reset"=>"Reset",
                "submit_class"=>"flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600",
            ],
            "inputs"=>[
                "email"=>[
                    "id"=>"login-form-email",
                    "class"=>"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6",
                    "placeholder"=>"Your email",
                    "type"=>"email",
                    "error"=>"Your email is incorrect",
                    "required"=>true
                ],
                "password"=>[
                    "id"=>"login-form-pwd",
                    "class"=>"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6",
                    "placeholder"=>"Your password",
                    "type"=>"password",
                    "error"=>"Your password is required",
                    "required"=>true
                ],
            ]
        ];
        return $this->config;
    }

    public function getFields(): array
    {
        return [
            'email' => htmlspecialchars($_POST['email']) ?? null,
            'pwd' => htmlspecialchars($_POST['password'])  ?? null,
        ];
    }
}
