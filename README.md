# Laravel Meteobridge

Feed laravel with weather data from meteobridge devices using HTTP GET
requests.

## Install

Add repository to your `composer.json`
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/TromsFylkestrafikk/laravel-meteobridge"
        }
    ]
}
```

Add require entry:
```shell
composer require tromsfylkestrafikk/laravel-meteobridge
```

Run migrations and import configuration.
```shell
php artisan migrate
php artisan vendor:publish --provider=TromsFylkestrafikk\\Meteobridge\\MeteobridgeServiceprovider --tag=config
```

## Usage

Stations are managed through artisan cli interface. The basic CRUD
operations for stations are:
- `php artisan meteobridge:add` Add a new station
- `php artisan meteobridge:list` List stations
- `php artisan meteobridge:set` Set station parameters
- `php artisan meteobridge:del` Delete station (with or without
  observations)
  
Create the Meteobridge HTTP template used to feed your site with
```shell
php artisan meteobridge:http-template
```

Then set up a periodical HTTP GET event in Meteobridge under
Services/Events. The created URL can either be used verbatim in the
URL input field, or save it on your pro/nano device under
/tmp/mnt/data/templates as a *.url file. This saved file will then be
selectable during HTTP GET event creation.

The interval between requests must match the `--interval=` option, as
this aggregates min, max and avg values between sent observations.
It's recommended to use one of these intervals:

- on every started minute
- every full 5 minutes
- every full 10 minutes
- every full 15 minutes

This asserts aggregations not to overlap or miss data between requests.

## Copying

Laravel Meteobridge is free software: you can redistribute it and/or
modify it under the terms of the GNU General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
