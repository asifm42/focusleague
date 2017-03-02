<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Helpers\DatabaseSetup;

class ExampleTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setup()
    {
        parent::setup();
        // $this->setupDatabase();
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample2()
    {
        factory(\App\Models\User::class)->create();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit('/cycles/current')
                    ->assertSee('Sign in');
        });
    }
}
