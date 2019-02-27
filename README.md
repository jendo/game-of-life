# Game of Life

PHP implementation of [Game of Life](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life).

This implementation is able to work with more than one speices of organism.

Application read initial word state from XML file defined as 1st parameter in run commnad. After iterations, the state of the world will be saved in an XML file defined as 2nd parameter.

## How to run application

1. Clone the repo 
2. Start docker: ```docker-compose up -d```
3. Go to docker php container 
4. Install dependencies via composer: ```composer install --no-dev```
5. Run the game: ```php index.php game:run <input.xml> <output.xml>```
    * first parameter is required
    * second parameter is optional, default values is ```output.xml```

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
composer tests 
```

## Static Analysis 
Source code is fully valid with max level of PHPSTAN


```
composer phpstan 
```


