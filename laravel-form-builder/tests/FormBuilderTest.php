<?php

declare(strict_types=1);

require __DIR__ .'/../src/FormBuilder.php';

use PHPUnit\Framework\TestCase;
use Digitalbit\Forms\FormBuilder as FormBuilder;

class FormBuilderTest extends TestCase
{
    public function setUp()
    {
        $this->form = new FormBuilder();
    }

    public function tearDown()
    {
        $this->form = null;
    }

    public function testBasic()
    {
        $this->assertTrue(true);
    }
}