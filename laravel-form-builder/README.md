# Form Builder package for Laravel 5.5

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

<!-- **Note:** Replace ```Sanket Raut``` ```sanketraut``` ```https://digitalbit.in``` ```sanket@digitalbit.in``` ```Digitalbit``` ```Forms``` ```Form Builder package for Laravel 5.5``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line. You can run `$ php prefill.php` in the command line to make all replacements at once. Delete the file prefill.php as well. -->

Form Builder package for Laravel 5.5 with an API to build bootstrap forms easily with or without panel body.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
src/

```


## Install

Via Composer

``` bash
$ composer require digitalbit/forms
```

## Usage

``` php
use \Digitalbit\Forms\FormBuilder;


class AppController extends Controller {

    protected $form;
    protected $formRules;

    public function __construct() 
    {
        $this->form = new FormBuilder();
        $this->form->setParameters(['action'=>'/app/save-preferences', 'method'=> 'POST', 'class'=>'ajax-form', 'enctype'=> 'multipart/formdata']);
        $this->form->addElement([
            'weight' => 1,
            'type'=>'text', 
            'attributes'=>[
                'name'=>'apptype',
                'value'=> \Request::segment(3),
                'readonly'=> 'readonly'
            ]
        ]);     

        $this->form->addElement([
            'type'=>'submit', 
            'label'=>'Create',
            'attributes'=>[
                'name'=>'submit',
                'class'=>'btn btn-primary',
            ]
        ]);             
    }
    
    public function view()
    {
        $data['form'] = $this->form->renderForm(['withPanel'=>true,'panelTitle'=>'Save data']);
        return view('app::form', $data);
    }

    public function store(Request $request) 
    {
        $this->formRules = $this->form->getValidationRules();        
        $this->form->validateForm($request->all(), $this->formRules);

        //Code to save data after validation
    }

```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

<!-- ## Testing

``` bash
$ composer test
``` -->

<!-- ## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details. -->

## Security

If you discover any security related issues, please email sanket@digitalbit.in instead of using the issue tracker.

## Credits

- [Sanket Raut][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Digitalbit/Forms.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/sanketraut/formbuilder/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Digitalbit/Forms.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Digitalbit/Forms.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Digitalbit/Forms.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Digitalbit/Forms
[link-travis]: https://travis-ci.org/sanketraut/formbuilder
[link-scrutinizer]: https://scrutinizer-ci.com/g/Digitalbit/Forms/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Digitalbit/Forms
[link-downloads]: https://packagist.org/packages/Digitalbit/Forms
[link-author]: https://github.com/sanketraut
[link-contributors]: ../../contributors
