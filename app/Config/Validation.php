<?php

namespace Config;

use App\Validation\CustomRules;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $newUser = [
        'name' => [
            'label'     => 'Name',
            'rules'     => [
                'required',
                'max_length[100]',
            ],
        ],
        'email' => [
            'label'     => 'Email',
            'rules'     => [
                'required',
                'max_length[150]',
                'valid_email',
            ],
        ],
        'password' => [
            'label'     => 'Password',
            'rules'     => [
                'required',
                'max_length[20]',
                'strong_password',
            ],
            'errors' => [
                'strong_password' => 'Password must be at least 8 characters and include an uppercase letter, lowercase letter, number, and symbol.',
            ],
        ],
        'confirm_password' => [
            'label'     => 'Confirm Password',
            'rules'     => 'required|matches[password]',
        ],
    ];

    public $productRule = [
        'name'          => 'required|max_length[180]',
        'category_id'   => 'required',
        'description'   => 'required',
        'price'         => 'required',
    ];
}
