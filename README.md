# Laravel Meteobridge

Feed laravel with weather data from meteobridge devices.

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

Run migrations:
```shell
php artisan migrate
```

## Usage

Stations are managed through artisan cli interface. The basic CRUD
operations for stations are:
- `php artisan meteobridge:add` Add a new station
- `php artisan meteobridge:list` List stations
- `php artisan meteobridge:set` Set station parameters
- `php artisan meteobridge:del` Delete station (with or without
  observations)

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
