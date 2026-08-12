# Changelog PresensiSiswa App

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.0] - 2026-08-12

### Added
- **Validation & Error Handling:** Added row-level error validation feedback when importing teacher or student Excel files with invalid data.
- **Dynamic User Creation:** Admin can now select existing teachers from a dropdown (auto-filling full name and username) and generate random passwords during user creation.
- **Attendance Recaps:** Introduced monthly attendance recap views for Admin, BK, and Teachers, with support for filtering by month, class, and student status.
- **Attendance Filters:** Added student status filters to attendance data and recap views.

### Changed
- **Replaced Hard Delete Actions with Status-Based Records:**
  - Removed delete actions for teachers, students, and users to preserve historical attendance data.
  - Admin can now set User/Teacher status to Active or Inactive.
  - Admin can change Student status to *Graduated (Lulus)*, *Transferred (Mutasi)*, or *Dropped Out (Keluar/DO)*.
- **Session & Class-Based Attendance Flow:**
  - Teachers can now only record attendance for a specific class assigned via QR Code scan or by selecting from their authorized class list.
  - Teachers can only edit attendance records on the same day. Subsequent days require creating a new attendance log.
- **Teacher Assignment Constraint:** Admin can only assign active teachers when creating or updating class data.
- **User Editing Restrictions & Self-Protection:**
  - For user accounts with the Teacher role, Admin is restricted to password updates only.
  - Added backend protection to prevent logged-in Admins from deactivating or modifying their own account.
- **Admin Dashboard Overhaul:** Replaced global yearly analytics charts with real-time stats showing student counts per class and today's class attendance completion status.
- **BK Dashboard Simplification:** Streamlined the counselor dashboard to display a welcome card, current date, and student distribution per class.

[1.2.0]: https://github.com/andraadev/PresensiSiswa/releases/tag/v1.2.0

---

## [1.1.1] - 2025-09-03

### Fixed
- The data filter no longer errors when there are missing inputs.

### Changed
- The save button in the attendance data filter form can only be used after filling in one of the inputs.
- If the filter result does not match, the table now displays a custom message for clarity.

[1.1.1]: https://github.com/andraadev/PresensiSiswa/releases/tag/v1.1.1

---

## [1.1.0] - 2025-08-20

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

[1.1.0]: https://github.com/andraadev/PresensiSiswa/releases/tag/v1.1.0

---

## [1.0.0] - 2025-07-13

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
