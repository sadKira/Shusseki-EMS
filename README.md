## Shusseki EMS (Shusseki Events Management System)

Capstone project for Academic Year 2024-2025, developed to automate and streamline attendance for school activities at Mindanao Kokusai Daigaku (MKD). Built on the TALL stack to provide a responsive, real-time experience for students, administrators, and the MKD Tsuushin student publication.

### Project Overview
- Automates attendance tracking for MKD school events using QR codes and administrator oversight.
- Centralizes event creation, notifications, and reporting to reduce manual processes.
- Serves students, admins, and MKD Tsuushin with role-tailored interfaces and permissions.

### System Architecture
- **Stack:** Tailwind CSS (styling), Alpine.js (lightweight interactivity), Laravel (API, services, routing), Livewire (real-time UI bindings).
- **Layers:** Presentation (Livewire views, Tailwind/Alpine components), Application (Laravel controllers, policies, jobs), Domain/Services (attendance, events, notifications), Persistence (Eloquent models, MySQL).
- **Modules:** Account & Attendance, Event Management, MKD Tsuushin, Reports; shared auth/authorization, notifications, and PDF export services.

### Key Features
- **Account Management & Attendance**
  - Student self-registration; admin review and approval.
  - QR code generation and scanning for attendance check-in.
  - Profile management for students (details, credentials, QR).
- **Event Management**
  - Admin creation, editing, and scheduling of events.
  - Notifications to students and MKD Tsuushin upon event updates.
- **MKD Tsuushin**
  - Access for student publication to view events.
  - Handling of media coverage requests tied to events.
- **Reports**
  - Student on-screen attendance history.
  - Exportable PDF virtual stamp cards.
  - Admin dashboard with summaries: total events, monthly events, overall attendance rates, pending account approvals.

### Project Status
- System complete and tested for deployment in AY 2024-2025.
- Capstone research paper is being prepared for publication. The link to the published paper will be provided when available.

### Technologies Used
- Tailwind CSS, Alpine.js, Laravel, Livewire
- MySQL
- PHP, Composer, Node.js, npm
- Optional: Redis/Queue for notifications, PHPUnit/Pest for testing

### License & Acknowledgements
- License: To be defined by project owners.
- Acknowledgements: Mindanao Kokusai Daigaku administration, faculty advisors, student publication (MKD Tsuushin), and contributors to the capstone effort.