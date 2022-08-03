# Changelog

## [Unreleased]
### Added
- Enforce coding style on commit
- Support Laravel 9.x

## [0.1.0] 2021-11-17

### Added
- Database migration with station and weather tables.
- CRUD CLI interface for managing stations.
- Artisan command for creating Meteobridge HTTP GET URL template.
- Submitted observations is stored to database.
- Wind observations are special (erratic), so min/max/avg values
  between intervals are aggregated and submitted along with latest
  observation.
- Added station authentication hash for weather observation requests.
- Observation events are broadcasted using model broadcasting.
