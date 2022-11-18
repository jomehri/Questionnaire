<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTest extends TestCase
{
    use RefreshDatabase, WithFaker;
}
