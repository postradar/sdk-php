# SDK for [POSTRADAR.RU](http://postradar.ru/) API

This open-source library allows you to integrate [postradar.ru](http://postradar.ru/) into your application.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

php ( >=5.6 ), curl


### Installing

1. Run composer require command in command line in project directory

```
~/your/project/directory$ composer require postradar/php-sdk dev-master

```

2. Clear cache of your application


## Using

1. Get apiKey in https://office.postradar.ru

2. Create instance of ApiClient with url http://postradar.ru and your api key
```
$client = new new \PostRadar\ApiClient($apiKey);

```
3. Call ApiClient object methods
```
$result = $client->profile();

```

## License

This project is licensed under the GPL-3.0 License

