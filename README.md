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

### Managing stations
Stations are managed through artisan cli interface. The basic CRUD
operations for stations are:
- `php artisan meteobridge:add` Add a new station
- `php artisan meteobridge:list` List stations
- `php artisan meteobridge:set` Set station parameters
- `php artisan meteobridge:del` Delete station (with or without
  observations)

See the individual command's help for further documentation.

When creating new stations it's recommended to also add an
authentication hash to it:
```shell
php artisan meteobridge:add --hash
```

It is strongly recommended that your site runs over https, as this
hash is sent on all requests.

### Set up Meteobridge periodical HTTP request events

To feed your Laravel site with observations from a Meteobridge
station, set up a periodical HTTP Request event under Services →
Events.  The URL to your Laravel installation has the form:

```
<scheme>://<host>/meteobridge/observation/<station-id>/<authentication-hash>?[param1=value1][&param2=value2]...
```
To help building this URL, use the following command:
```shell
php artisan meteobridge:http-template <station-id>
```

This generated URL can be used verbatim in the Meteobridge event URL
input field, or save it on your pro/nano device under
/tmp/mnt/data/templates as a *.url file.  Using a .url file will make
this file selectable during event creation/editing.

**Note** If using .url file, it must NOT contain newlines.

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
