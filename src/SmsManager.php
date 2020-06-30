<?php

namespace Farshad\Sms;

use Illuminate\Support\Manager;
use Farshad\Sms\Drivers\Ravisms;
use Farshad\Sms\Drivers\Pejvak;
use Farshad\Sms\Drivers\MeliPayamak;
use Farshad\Sms\Drivers\Saharsms;
use Farshad\Sms\Drivers\Raygansms;
use Farshad\Sms\Drivers\Parsegreen;
use Farshad\Sms\Drivers\Rahyab;
use Farshad\Sms\Drivers\Ghasedaksms;
use Farshad\Sms\Drivers\NullDriver;

class SmsManager extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return mixed
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }

    public function createRavismsDriver()
    {
        return new Ravisms(
            (object) $this->app['config']['sms.ravisms']
        );
    }

    public function createPejvakDriver()
    {
        return new Pejvak(
            (object) $this->app['config']['sms.pejvak']
        );
    }

    public function createGhasedaksmsDriver()
    {
        return new Ghasedaksms(
            (object) $this->app['config']['sms.ghasedaksms']
        );
    }

    public function createMeliPayamakDriver()
    {
        return new MeliPayamak(
            (object) $this->app['config']['sms.melipayamak']
        );
    }

    public function createSaharsmsDriver()
    {
        return new Saharsms(
            (object) $this->app['config']['sms.saharsms']
        );
    }

    public function createRaygansmsDriver()
    {
        return new Raygansms(
            (object) $this->app['config']['sms.raygansms']
        );
    }

    public function createSmsirDriver()
    {
        return new Smsir(
            (object) $this->app['config']['sms.smsir']
        );
    }

    public function createParsgreenDriver(){
        return new Parsegreen(
            (object) $this->app['config']['sms.parsgreen']
        );
    }

    public function createRahyabDriver()
    {
        return new Rahyab(
            (object) $this->app['config']['sms.rahyab']
        );
    }

    public function createNullDriver()
    {
        return new NullDriver;
    }

    /**
     * Get the default SMS driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.default'] ?? 'null';
    }
}