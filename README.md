# SDK for [POSTRADAR.RU](http://postradar.ru/) API

This open-source library allows you to integrate [postradar.ru](http://postradar.ru/) into your application.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

php ( >=5.6 ), curl


### Installing

1. Add sdk repository to the composer.json file of your project. 

url - https://github.com/postradar/sdk-php 

type - vcs

```
 "repositories": [
        {
            "url": "https://github.com/postradar/sdk-php",
            "type": "vcs"
        }
    ],
```

2. Add postradar/api-sdk package to the require section of composer.json file

```
"require": {
        "postradar/api-sdk": "dev-master",
    },
```

3. Run composer update command in command line in project directory

```
~/your/project/directory$ composer update

```

4. Clear cache of your application


## Using

1. Get api key in postradar.ru cabinet

2. Create instance of ApiClient with url http://postradar.ru and your api key
```
$postradarApiClient = new ApiClient('http://postradar.ru', $apiKey);

```
3. Call ApiClient object methods
```
$result = $postradarApiClient->getProfile();

```
```
$result = $postradarApiClient->getAssembler();

```
4. Call ApiResponse class object (result of ApiClient) methods to get the data from postradar.ru API
```
$result->getFullResponse()

```


## Contributing

Don't push to the master branch

## Authors

* **Anton Novopashin** - *Initial work* - [antonnovopashin](https://github.com/antonnovopashin)

See also the list of [contributors](https://github.com/postradar/sdk-php/graphs/contributors) who participated in this project.

## License

This project is licensed under the GPL-3.0 License

