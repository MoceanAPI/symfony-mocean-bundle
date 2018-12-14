Symfony Mocean
===============
Symfony Mocean API Integration

## Installation

To install the library, run this command in terminal:
```bash
composer require mocean/symfony-mocean-bundle
```

Add this to config.yml
```yaml
mocean:
  defaults: main    # define the account to use here
  accounts:         # here is where you define multiple accounts
    main:
      api_key: mainAccountApiKey
      api_secret: mainAccountApiSecret
      from: David
    secondary:
      api_key: secondaryAccountApiKey
      api_secret: secondaryAccountApiSecret
      from: John
```

### Symfony 4

Add the bundle to `config/bundles.php`
```php
return [
    //... framework bundles
    MoceanSymBundle\MoceanBundle::class => ['all' => true],
];
```

### Symfony 3 

Add the bundle to `app/AppKernel.php`
```php
$bundles = array(
    //... framework bundles
    new MoceanSymBundle\MoceanBundle(),
);
```

## Usage

Usage through dependency injection (symfony 4 and above)

Bind mocean manager class in service yaml
```yaml
# config/services.yaml

services:
  App\Controller\YourController:
    bind:
      $mocean: '@mocean_manager'
```

In controller

```php
class YourController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(MoceanSymBundle\Services\MoceanManager $mocean)
    {
        $res = $mocean->message('60123456789', 'Simple Text');
    }
}
```

Usage through container
```php
class YourController extends Controller
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $mocean = $this->container->get('mocean_manager');
        $res = $mocean->message('60123456789', 'Simple Text');
    }
}
```

The above example will be using the account define in defaults.  
If you have multiple account defined in config, you can use like this

```php
$mocean->using('secondary')->message('60123456789', 'Simple Text');
$mocean->using('third')->message('60123456789', 'Simple Text');
```

Get the configured [Mocean SDK](https://github.com/MoceanAPI/mocean-sdk-php) Object
```php
$sdk = $mocean->getMocean();
$accBalance = $sdk->account()->getBalance(['mocean-resp-format' => 'JSON']);
```

## License

Laravel Mocean is licensed under the [MIT License](LICENSE)
