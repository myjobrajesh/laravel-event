<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\EventBooking;

class EventTest extends TestCase
{
    
    protected $eventId = 1;
    protected $standId = 2;
    protected $testEmail = 'contact@test.com';
    
    public function testDatabase() {
        printf("Database Entry\n");
        
        $this->seeInDatabase('users', [
            'email' => 'myjob.rajesh@gmail.com'
        ]);
        
        $this->seeInDatabase('users', [
            'name' => 'rajesh'
        ]);
        
        $this->seeInDatabase('events', [
            'status' => 'active'
        ]);
        //TODO :: we can add more test here....
    }
      
    /**
     * Home page test
     *
     * @return void
     */
    public function testVisitHome()
    {
        printf("Visit Home\n");
        $this->call('GET', '/');
        $this->assertResponseOk();
        $this->see("map");
        
        $this->see("eventLocation");
        $this->see("marker");
    }
    
    /* test home controller and check events returning?
     *
    */
    public function testHomeController() {
        printf("Home controller method\n");
        $response = $this->action('GET', 'HomeController@home');
        $this->assertResponseOk();
        $this->assertViewHas('events');
        
        $view = $response->original;
        $count = count($view['events']);
        $this->assertTrue(($count ? true : 'No event present'));
    }
    
    /**
     * Event page test
     *
     * @return void
     */
    public function testVisitEvent()
    {
        printf("Visit Event detail\n");
        $this->visit('/event/'.$this->eventId)
             ->see('hallMap');
        //do some more test
        $this->see('standModal');
        $this->see('Reserve');
        
    }
    
    /* test event controller  and view event method
     *
    */
    public function testEventController() {
        printf("Event controller method \n");
        $response = $this->action('GET', 'EventController@viewEvent', ['eventId' => $this->eventId]);
        $this->assertResponseOk();
        $this->assertViewHas('event');
        $view = $response->original;
        $count = count($view['event']);
        $this->assertTrue(($count ? true : 'No event present'));
    }
    
    /* test event controller  and event over method check
     *
    */
    public function testEventControllerForEventOver() {
        printf("Event controller for event Over method \n");
        $response = $this->action('GET', 'EventController@eventOver', ['eventId' => $this->eventId]);
        $this->assertResponseOk();
    }
    
    /**
     * Register page test
     *
     * @return void
     */
    public function testVisitRegister()
    {
        printf("Visit Register\n");
        $this->visit('/register/'.$this->standId)
             ->see('frmRegister');
        //do some more test
        $this->see('companyName');
        $this->see('contactName');
        $this->see('Register');
    }
    /* test event controller and check event returning?
     *
    */
    public function testUserControllerToRegister() {
        printf("User controller to registerStandShow method \n");
        $response = $this->action('GET', 'UserController@registerStandShow', ['standId' => $this->standId]);
        $this->assertResponseOk();
        $this->assertViewHas('stand');
        $view = $response->original;
        $count = count($view['stand']);
        $this->assertTrue(($count ? true : 'No stand present'));
    }
    
    
    /* Check register form
     * @return void
     */
    public function testRegisterFormFields() {
        printf("Register page form fields \n");
        $this->visit('/register/'.$this->standId)
         ->type($this->standId, 'standId')
         ->type($this->eventId, 'eventId')
         ->type('Rajesh', 'companyName')
         ->type('Rajesh', 'companyEmail')
         ->type('Rajesh', 'companyAdminName')
         ->type('Rajesh', 'companyAddress')
         ->type('Rajesh', 'contactName')
         ->type('Rajesh', 'contactEmail');
        $this->assertResponseOk(); 
    }
    
    
    /* Check register form
     * @return void
     */
     public function testRegisterFormSubmit() {
        printf("Register form submit\n");
        $this->json('POST', '/register',
                            ['postedData'=>
                                          json_encode(['companyName'         =>  'test',
                                          'companyEmail'        =>  'test@test.com',
                                          'companyAdminName'    =>  'test',
                                          'companyAddress'      =>  'test address',
                                          'contactName'         =>  'test',
                                          'contactEmail'        =>  $this->testEmail,
                                          'standId'             =>  $this->standId,
                                          'eventId'             =>  $this->eventId
                                          ])
                              ]
                    )
             ->seeJsonEquals([
                 'success' => true
             ]);
     }
     
     /* view booked on evene detail page
      */
     public function testViewBookedOnEvent() {
        printf("\nView Booked on event page\n");
        $this->visit('/event/'.$this->eventId)
             ->see('BOOKED');
     }
    
    /* remove dummy test data from dataase first
     */
     public function testCleanBooking() {
            printf("Remove Booked event by test\n");
            $exist = EventBooking::where('contact_email', $this->testEmail)->first();
            if($exist) {
                $exist->delete();    
            }

      }
      
     
     
}
