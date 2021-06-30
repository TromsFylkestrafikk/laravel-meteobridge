# Changelog

## [Unreleased]

### Added
- Database migration with station and weather tables.
- CRUD CLI interface for managing stations.
- Artisan command for creating Meteobridge HTTP GET URL template.
- Submitted observations is stored to database.
- Wind observations are special (erratic), so min/max/avg values
  between intervals are aggregated and submitted along with latest
  observation.
- Added station authentication hash for weather observation requests.
