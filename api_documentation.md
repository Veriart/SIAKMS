# RESTful API — SIAK LMS

Base URL: `/api`  
Auth: **Laravel Sanctum** (Bearer Token)

---

## 🔐 Authentication

### Login
```
POST /api/login
```
| Body | Type | Required |
|------|------|----------|
| `email` | string | ✅ |
| `password` | string | ✅ |
| `device_name` | string | ❌ |

**Response:**
```json
{
  "message": "Login berhasil",
  "user": { "id": 1, "name": "...", "roles": [...] },
  "token": "1|abc123..."
}
```

### Logout
```
POST /api/logout
Authorization: Bearer {token}
```

### Current User
```
GET /api/me
Authorization: Bearer {token}
```
Returns user + roles + teacher/student relations.

---

## 👨‍🏫 Teachers

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/teachers` | Daftar guru (paginated) |
| GET | `/api/teachers/{id}` | Detail guru |
| GET | `/api/teachers/me` | Data guru sendiri |

**Filters** pada `/api/teachers`:
- `?status=Active` — filter status
- `?search=nama` — cari berdasarkan nama
- `?per_page=20` — jumlah per halaman

**Relations:** user, teachingAssignments (subject, classroom, expertise), additionalDuties, documents

---

## 👨‍🎓 Students

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/students` | Daftar siswa (paginated) |
| GET | `/api/students/{id}` | Detail siswa |
| GET | `/api/students/me` | Data siswa sendiri |

**Filters** pada `/api/students`:
- `?classroom_id=1` — filter kelas
- `?expertise_id=2` — filter jurusan
- `?academic_year_id=3` — filter tahun akademik
- `?status=Active` — filter status
- `?search=nama` — cari berdasarkan nama/NIS

---

## 📚 Subjects (Mata Pelajaran)

| Method | Endpoint |
|--------|----------|
| GET | `/api/subjects` |
| GET | `/api/subjects/{id}` |

---

## 🏫 Classrooms (Kelas)

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/classrooms` | Daftar kelas + jumlah siswa |
| GET | `/api/classrooms/{id}` | Detail kelas + daftar siswa |

---

## 📅 Academic Years

| Method | Endpoint |
|--------|----------|
| GET | `/api/academic-years` |

Returns: `id`, `in`, `out`, `label` (formatted "2025 - 2026")

---

## 🎓 Expertises (Jurusan)

| Method | Endpoint |
|--------|----------|
| GET | `/api/expertises` |

---

## 📝 Schedule Exams (Jadwal Ujian)

| Method | Endpoint |
|--------|----------|
| GET | `/api/schedule-exams` |
| GET | `/api/schedule-exams/{id}` |

**Filters:**
- `?academic_year_id=1`
- `?category=UTS`
- `?today=true` — jadwal hari ini
- `?upcoming=true` — jadwal mendatang

Detail includes: examAttendances + student data

---

## 📢 Activity Informations (Info Kegiatan)

| Method | Endpoint |
|--------|----------|
| GET | `/api/activity-informations` |
| GET | `/api/activity-informations/{id}` |

**Filters:**
- `?target_audience=teachers`
- `?search=nama kegiatan`

---

## 📋 Teaching Assignments (Penugasan Mengajar)

| Method | Endpoint |
|--------|----------|
| GET | `/api/teaching-assignments` |

**Filters:**
- `?teacher_id=1`
- `?subject_id=2`
- `?academic_year_id=3`
- `?classroom_id=4`

---

## Cara Penggunaan

```bash
# 1. Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"password"}'

# 2. Gunakan token dari response
curl http://localhost:8000/api/teachers \
  -H "Authorization: Bearer 1|abc123..."

# 3. Logout
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer 1|abc123..."
```

## Files Created

| File | Deskripsi |
|------|-----------|
| [api.php](file:///c:/laragon/www/AKADEMIK/SIAK2/routes/api.php) | Route definitions |
| [AuthController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/AuthController.php) | Login, logout, me |
| [TeacherApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/TeacherApiController.php) | Teachers CRUD |
| [StudentApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/StudentApiController.php) | Students CRUD |
| [SubjectApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/SubjectApiController.php) | Subjects |
| [ClassroomApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/ClassroomApiController.php) | Classrooms |
| [AcademicYearApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/AcademicYearApiController.php) | Academic years |
| [ExpertiseApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/ExpertiseApiController.php) | Expertises |
| [ScheduleExamApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/ScheduleExamApiController.php) | Schedule exams |
| [ActivityInformationApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/ActivityInformationApiController.php) | Activity info |
| [TeachingAssignmentApiController](file:///c:/laragon/www/AKADEMIK/SIAK2/app/Http/Controllers/Api/TeachingAssignmentApiController.php) | Teaching assignments |
