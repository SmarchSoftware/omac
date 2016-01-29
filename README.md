This is probably only of use to me, but I have need of it in multiple apps so I packaged it up in case you want it too. :)

***

# OMAC
A simple trait to allow _basic_ authorization checks using whatever authorization package is desired. Currently supports Laravel Default, Shinobi, Sentinel and Entrust.

## Installation

Installation is performed with composer.

#### :black_square_button: Composer

    composer require "smarch/omac"

## Usage


Where you want to use OMAC to check access, add the trait.

    class YourController extends Controller
    {
        use \Smarch\Omac\OmacTrait;

Once you have the <kbd>OmacTrait</kbd> in use, and you are happy with the authorization driver you are using _(see parameters below)_, you can use the `checkAccess()` method of Omac by passing in the required permission to allow access.

#### Example of using OMAC to permit viewing an index of resources

    /**
     * Display a listing of the resources.
     *
     * @return Response
     */
    public function index()
    {
        if ( $this->checkAccess('view.index') ) {
            $resources = Model::all();
            return view("index", compact($resources) );
        }

        return view("unauthorized", ['message' => 'Not authorized to view Index'] );
        // OR
        return false;
        // OR
        abort(401, 'Unauthorized action.');

    }

#### Arguments
The `checkAccess()` method accepts both the $permission and an $arguments variable. So if your preferred authorization package accepts a second argument to its method, you can use it.

        if ( $this->checkAccess('update.post', $post) ) {

> :hand: NOTE : Sentinel **only** accepts a $permission argument so you will not be able to pass in a second argument.

> :hand: NOTE : Entrust only accepts a boolean (true/false) as it second argument.


### Parameters (optional)

By default, OMAC is set to _enabled_ and to use _Laravel_'s built-in authorization can method. _(Gate)_ If you wish to use a different authorization method, or to disable OMAC, you can change the parameters. You can do it in your class or method somewhere for a one-off usage, or you can set it on the constructor of your class to make the change for all the methods.

    /**
     * constructor
     * 
     * @param boolean acl Whether or not ACL is enabled
     * @param string $driver Which ACL package to use
     */
    public function __construct() {
        $this->acl = false;
        $this->driver = "sentinel";
    }

## :trident: Why "OMAC"?
I've been a DC geek for over 30 years now. While OMAC in DC is more of a "big brother is watching" type of thing, it still fits nicely with **O**bject **M**anaged **A**ccess **C**ontrol. :smile:   