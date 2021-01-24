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
       return $this->controller->getFleet('1456');
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {

        $vehicle = [
            'registration' => 'A5677',
            'type' => 'car',
            'fleetUser' => 'me',
            'parkLocation' => '',
        ];
        $this->controller->registerVehicle($vehicle);
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $vehicleRegistration = "A5677";
        $this->controller->isRegistered($vehicleRegistration);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $location = '40.999999, 34.00000';
        $this->controller->registerLocation();
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->controller->parkVehicle();

    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
      $this->controller->checkLocation();
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {

        $this->controller->checkLocation();

    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation($location)
    {
       if(true === $this->controller->locationAlreadyUsed($location));

    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        return $this->controller->onPark();

    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->controller->registerVehicleIntoFleet();
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        $this->controller->isPartOfMyFleet();
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {


    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {

    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {

    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet($vehicle)
    {

    }

    /**
     * @Then this vehicle should be part of my vehicle flee
     */
    public function thisVehicleShouldBePartOfMyVehicleFlee(Vehicle $vehicle)
    {

    }
}
