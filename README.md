# Game of Life

PHP implementation of [Game of Life](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life).

Application read initial word state from XML file defined as 1st parameter in run commnad. After iterations, the state of the world will be saved in an XML file defined as 2nd parameter.

## Prerequisites

Make sure you have the following installed:

1. [Docker](https://www.docker.com/get-started)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. **Make** (Included by default on Linux/macOS; for Windows, install via [Make for Windows](http://gnuwin32.sourceforge.net/packages/make.htm)).

## How to run application

1. Clone the repo and go to the application folder: ```git clone https://github.com/jendo/game-of-life.git && cd game-of-life```
2. Run the setup command to start Docker containers and install dependencies ```make setup```
3. Run the game: ```make input=samples/input.xml output=samples/output.xml play```
    * both parameters are optional, if not defined, default values are used

## Sample input
```xml
<?xml version="1.0" encoding="UTF­8"?>
<life>
    <world>
        <cells>4</cells> <!-- Dimension of the square "world" -->
        <iterations>10</iterations> <!-- Number of iterations to be calculated -->
    </world>
    <organisms>
        <organism>
            <x_pos>1</x_pos> <!-- x position -->
            <y_pos>2</y_pos> <!-- y position -->
        </organism>
        <organism>
            <x_pos>2</x_pos>
            <y_pos>2</y_pos>
        </organism>
        <organism>
            <x_pos>3</x_pos>
            <y_pos>2</y_pos>
        </organism>
    </organisms>
</life>
```

## Tests
Tests are written in [PHPUNIT package from Sebastian Bergmann](https://packagist.org/packages/phpunit/phpunit)

```
make phpunit 
```

## Static Analysis
Source code is fully valid with max level of PHPSTAN

```
make phpstan 
```

## Code style
Source code is written under standard PSR12

```
make phpcs
```

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
