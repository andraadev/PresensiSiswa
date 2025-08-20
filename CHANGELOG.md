# Changelog PresensiSiswa App

## [1.0.0] - 13 July 2025

### Added
- Initial version of the application with data management of teachers, students, classes, users, & attendance.
- Import teacher & student data via Excel file.
- Daily attendance feature (not yet specific per class).
- Multi-role access (Admin, Teacher, Counselor(BK)) with different access rights.
  - **Admin**: manage and export teacher, class, student, and user data.
  - **Teacher**: record and update student attendance.
  - **Counselor(BK)**: access attendance statistics (present/permission/sick/absent).
- Attendance report with filters & Excel export support.

[1.0.0]: https://github.com/andraadev/PresensiSiswa/releases/tag/v1.0.0

[Unreleased]
## [1.1.0] - 20 August 2025
### Added
- Added a reset filter button on the attendance data page.

### Changed
- Added data formatting requirements on Excel templates to prevent input errors.
- The login form cannot now be sent empty from the interface side.

### Fixed
- Resolved processing time constraints when importing Excel files with more than 30 rows.
- The date display on the homepage of the BK role is now in Bahasa Indonesia.
- All view password buttons (represented by the “eye” icon) now adjust to the screen size.
- Cleaned up the data imported by users on the teacher data page so that there are no excess spaces.

### Security
- Improved the security of the logout process to protect user sessions.

Translated with DeepL.com (free version)
