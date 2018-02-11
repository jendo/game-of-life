# Game of Life

PHP implementation of [Game of Life](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life).

This implementation is able to work with more than one speices of organism.

Application read initial word state from XML file defined as 1st parameter in run commnad. After iterations, the state of the world will be saved in an XML file defined as 2nd parameter in run commnad of application.

## How to run application

Clone the repo and install dependencies via composer: ```composer install```  

In console run this commnad:

```
php index.php game:run <input.xml> <output.xml>
```

First parameter is required.
Second parameter is optional, default values is ```output.xml```

## Sample input
```xml
<?xml version="1.0" encoding="UTF­8"?>
<life>
    <world>
        <cells>4</cells> <!-- Dimension of the square "world" -->
        <species>1</species> <!-- Number of distinct species -->
        <iterations>10</iterations> <!-- Number of iterations to be calculated -->
    </world>
    <organisms>
        <organism>
            <x_pos>1</x_pos> <!-- x position -->
            <y_pos>2</y_pos> <!-- y position -->
            <species>X</species> <!-- Species type -->
        </organism>
        <organism>
            <x_pos>2</x_pos>
            <y_pos>2</y_pos>
            <species>X</species>
        </organism>
        <organism>
            <x_pos>3</x_pos>
            <y_pos>2</y_pos>
            <species>X</species>
        </organism>
    </organisms>
</life>
```

## How to run tests

Tests are written in [PHPUNIT package from Sebastian Bergmann](https://packagist.org/packages/phpunit/phpunit)

```
./vendor/bin/phpunit -c tests 
```
