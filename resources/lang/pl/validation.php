<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'Pole :attribute jest wymagane.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_with'        => 'To pole jest wymagane.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'url'                  => 'The :attribute format is invalid.',

    'username'             => 'Nazwa użytkownika może zawierać litery, cyfry oraz znaki ._ -',
    'user_exist'           => 'Użytkownik o podanej nazwie nie istnieje.',
    'user_unique'          => 'Konto o podanej nazwie użytkownika już istnieje.',
    'user_active'          => 'Konto o tym loginie zostało zablokowane.',
    'password'             => 'Podano nieprawidłowe hasło.',
    'reputation'           => 'Potrzebujesz :point punktów reputacji aby zmienić zawartość tego pola.',
    'tag'                  => 'Podany tag zawiera nieprawidłowe znaki.',
    'tag_creation'         => 'Potrzebujesz :point punktów reputacji, aby utworzyć nowy tag. Wybierz już istniejący.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'name' => [
            'unique'        => 'Konto o tym loginie już istnieje'
        ],
        'email' => [
            'unique'        => 'Ten e-mail jest już przypisany do innego konta',
            'exists'        => 'Podany adres e-mail nie istnieje.'
        ],
        'password' => [
            'confirmed'     => 'Hasło w obu polach musi być identyczne'
        ],
        'password_old' => [
            'required'      => 'Wymagane jest podanie obecnego hasła'
        ],
        // m.in. w mikroblogach
        'text' => [
            'required'      => 'Proszę wpisać treść',
            'max'           => 'Maksymalna długość tekstu to :max znaków'
        ],
        // m.in. w wiadomosciach prywatnych
        'author' => [
            'required'      => 'Proszę wpisać nadawcę wiadomości',
            'exists'        => 'Użytkownik o tej nazwie nie istnieje'
        ],
        // uzywany na forum
        'subject' => [
            'required'      => 'Temat musi posiadać minimum 3 znaki długości',
            'min'           => 'Temat musi posiadać minimum 3 znaki długości',
        ],
        'tag' => [
            'required'      => 'Wymagane jest przypisanie minimum jednego tagu do tego wątku'
        ],
        // w formularzu forum
        'user_name' => [
            'required'      => 'Proszę wpisać nazwę użytkownika',
            'unique'        => 'Ta nazwa jest zajęta przez innego użytkownika',
        ],
        // formularz pracy
        'title' => [
            'required'      => 'Tytuł jest wymagany'
        ],
        'recruitment' => [
            'required'      => 'Proszę podać informacje w jaki sposób można składać aplikacje na to stanowisko.'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password'                  => 'hasło',
        'name'                      => 'nazwa użytkownika'
    ],
];
