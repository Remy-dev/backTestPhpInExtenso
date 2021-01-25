<?php


use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use PHPUnit\Framework\TestCase;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends TestCase implements Context
{
    private $app;
    private $controller;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct();
        $this->app = new Application();
        $this->controller = $this->app->getController();

//
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {

        $this->controller =  $this->controller->initialiseFleet('1');
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {

        $vehicleDatas = [
            'registration' => 'A5677',
            'type' => 'car',
            'fleetId' => '',
            'parkLocation' => '',
            'isParked' => false
        ];
        $vehicle = new Vehicle($vehicleDatas);
        $this->controller->setVehicle($vehicle);
        $this->controller = $this->controller->registerVehicle($this->controller);
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {

        $this->controller = $this->controller->isRegistered($this->controller);

    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $location = '40.999999, 34.00000';
        $this->controller = $this->controller->registerLocation($location);
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->controller = $this->controller->parkVehicle($this->controller);

    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
      $this->controller =  $this->controller->checkLocation($this->controller);
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {

        $this->controller = $this->controller->isParked($this->controller);

    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
       $this->controller = $this->controller->islocationAlreadyUsed($this->controller);

    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        $this->controller->getErrorMessage();

    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->controller = $this->controller->registerVehicleIntoFleet($this->controller);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $this->controller->isPartOfMyFleet($this->controller);
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        $this->controller = $this->controller->registerVehicle($this->controller);

    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        $this->controller->getErrorMessage();
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {

        $this->controller = $this->controller->initialiseFleet('2');
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->controller = $this->controller->registerVehicleIntoFleet($this->controller);
    }

    /**
     * @Then this vehicle should be part of my vehicle flee
     */
    public function thisVehicleShouldBePartOfMyVehicleFlee()
    {
        $this->controller->isPartOfMyFleet($this->controller);
    }
}
